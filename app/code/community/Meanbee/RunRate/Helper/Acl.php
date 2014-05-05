<?php
class Meanbee_RunRate_Helper_Acl extends Mage_Core_Helper_Abstract
{
    const RESOURCE_ALL = 'meanbee_runrate';

    /**
     * @return bool
     */
    public function isAllowedViewReport()
    {
        return $this->isAllowed(self::RESOURCE_ALL);
    }

    /**
     * @param $resource_name
     *
     * @return bool
     */
    public function isAllowed($resource_name)
    {
        return Mage::getSingleton('admin/session')->isAllowed($resource_name);
    }
}
