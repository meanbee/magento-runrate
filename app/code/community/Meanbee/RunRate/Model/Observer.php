<?php

class Meanbee_RunRate_Model_Observer {

    public function adminhtmlControllerActionPredispatchStart(Varien_Event_Observer $observer) {
        if(Mage::app()->getRequest()->getParam('section') == 'cataloginventory' && !Mage::registry('meanbee_runrate_average_run')){
            Mage::register('meanbee_runrate_average_run', Mage::getStoreConfig('cataloginventory/meanbee_runrate/average_run_weeks'));
        }
    }
    public function adminSystemConfigChangedSectionCataloginventory(Varien_Event_Observer $observer) {
        $groups = Mage::app()->getRequest()->getPost('groups');

        if($groups['meanbee_runrate']['fields']['average_run_weeks'] !== Mage::registry('meanbee_runrate_average_run')) {
            Mage::getSingleton('index/indexer')
                ->getProcessByCode('meanbee_runrate')
                ->changeStatus(Mage_Index_Model_Process::STATUS_REQUIRE_REINDEX);
        }
        Mage::unregister('meanbee_runrate_average_run');
    }
    public function salesOrderShipmentSaveAfter(Varien_Event_Observer $observer) {
        Mage::getSingleton('index/indexer')
            ->getProcessByCode('meanbee_runrate')
            ->reindexAll();
    }
}
