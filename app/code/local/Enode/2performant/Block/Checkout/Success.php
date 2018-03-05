<?php

class Enode_2performant_Block_Checkout_Success extends Mage_Core_Block_Template
{

    /** @var Mage_Sales_Model_Order $order */
    private $order;

    /**
     * @return mixed|string
     */
    public function _toHtml()
    {
        if ($this->order) {
            /** @var Mage_Sales_Model_Order $order */
            $orderItems = $this->order->getAllItems();
            $replace['__ADD_SALE_VALUE__'] = $this->order->getSubtotal();
            $replace['__ADD_DESCRIPTION__'] = [];
            if ($orderItems && is_array($orderItems)) {
                foreach ($orderItems as $item) {
                    $replace['__ADD_DESCRIPTION__'][] = trim($item->getSKU() . ',' . $item->getName() . ',' . $item->getQtyOrdered());
                }
            }
            $replace['__ADD_DESCRIPTION__'] = urlencode(implode(';',
              $replace['__ADD_DESCRIPTION__']));
            $replace['__ADD_TRANSACTION_ID__'] = $this->order->getIncrementId();
            $replace['__campaign_unique__'] = Mage::helper('e2performant')
              ->getCampaignUnique();
            $replace['__confirm__'] = Mage::helper('e2performant')
              ->getConfirm();

            return str_replace(array_keys($replace), $replace,
              '<iframe height="1" width="1" scrolling="no" marginheight="0" ' .
              ' marginwidth="0" frameborder="0" ' .
              ' src="//event.2performant.com/events/salecheck?amount=__ADD_SALE_VALUE__&'
              . 'campaign_unique=__campaign_unique__&confirm=__confirm__&description=__ADD_DESCRIPTION__&'
              . 'transaction_id=__ADD_TRANSACTION_ID__"></iframe>');
        }
        return '';
    }

    /**
     * Initialize data and prepare it for output
     */
    protected function _beforeToHtml()
    {
        if (Mage::helper('e2performant')->isEnabled()) {
            $orderId = Mage::getSingleton('checkout/session')->getLastOrderId();
            if ($orderId) {
                /** @var Mage_Sales_Model_Order $order */
                $order = Mage::getModel('sales/order')->load($orderId);
                if ($order->getId()) {
                    $this->order = $order;
                }
            }
        }
        return parent::_beforeToHtml();
    }
}

