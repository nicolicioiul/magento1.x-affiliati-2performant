<?php

class Enode_2performant_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Check if is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return Mage::getStoreConfig('sales/e2performant/enabled') ? true : false;
    }

    /**
     * Get campaign unique.
     *
     * @return string
     */
    public function getCampaignUnique()
    {
        return (string)Mage::getStoreConfig('sales/e2performant/campaign_unique');
    }

    /**
     * Get confirm.
     *
     * @return string
     */
    public function getConfirm()
    {
        return (string)Mage::getStoreConfig('sales/e2performant/confirm');
    }
}


