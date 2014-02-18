<?php
class Meanbee_RunRate_Model_Resource_Runrate extends Mage_Core_Model_Resource_Db_Abstract
{
    protected $_isPkAutoIncrement = false;

    protected function _construct() {
        $this->_init('meanbee_runrate/runrate', 'product_id');
    }
}
