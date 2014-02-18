<?php
class Meanbee_RunRate_Model_Resource_Runrate_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('meanbee_runrate/runrate');
    }
}
