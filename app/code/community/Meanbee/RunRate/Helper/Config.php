<?php
class Meanbee_RunRate_Helper_Config extends Mage_Core_Helper_Abstract
{
    const XML_AVERAGE_RUN_WEEKS       = 'cataloginventory/meanbee_runrate/average_run_weeks';
    const XML_LEADTIME_ATTRIBUTE_CODE = 'cataloginventory/meanbee_runrate/lead_time_attribute';

    public function getWeeksForAverage()
    {
        return (int) Mage::getStoreConfig(self::XML_AVERAGE_RUN_WEEKS);
    }

    public function getLeadTimeAttributeCode()
    {
        return Mage::getStoreConfig(self::XML_LEADTIME_ATTRIBUTE_CODE);
    }
}
