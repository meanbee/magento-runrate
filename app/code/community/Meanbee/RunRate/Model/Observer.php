<?php

class Meanbee_RunRate_Model_Observer {

    public function adminhtmlControllerActionPredispatchStart(Varien_Event $observer) {
        Mage::register('meanbee_runrate_average_run', Mage::getStoreConfig('cataloginventory/meanbee_runrate/average_run_weeks'));
    }
    public function adminSystemConfigChangedSectionCataloginventory(Varien_Event $observer) {
        $groups = Mage::app()->getRequest()->getPost('groups');
        if($groups['meanbee_runrate']['fields']['average_run_weeks'] !== Mage::registry('meanbee_runrate_average_run')) {
             Mage::getSingleton('index/indexer')
                ->getProcessByCode('meanbee_runrate')
                ->changeStatus(Mage_Index_Model_Process::STATUS_REQUIRE_REINDEX);
        }
    }
}