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
    public function salesOrderPlaceAfter(Varien_Event_Observer $observer) {
        $order = $observer->getEvent()->getOrder();
        if ($order->getId()) {
            $productIds = array();
            foreach ($order->getAllVisibleItems() as $product) {
                $productIds[] = $product->getProductId();
            }
            $timestamp = Mage::getSingleton('core/date')->timestamp(time()) + 10;
            $schedule = Mage::getModel('cron/schedule')
                      ->setJobCode('meanbee_runrate_reindex')
                      ->setStatus(Mage_Cron_Model_Schedule::STATUS_PENDING)
                      ->setMessages(json_encode($productIds))
                      ->setCreatedAt($timestamp)
                      ->setScheduledAt($timestamp)
                      ->save();
        }
    }
    public function reindex($productIds) {
        if (empty($productIds)) {
            Mage::getSingleton('index/indexer')
                ->getProcessByCode('meanbee_runrate')
                ->reindexAll();
            return;
        }
        $indexEvent = Mage::getModel('index/event')
                    ->setEntity(Mage_CatalogInventory_Model_Stock_Item::ENTITY)
                    ->setType(Mage_Index_Model_Event::TYPE_MASS_ACTION)
                    ->setProductIds($productIds);

        Mage::getSingleton('index/indexer')
            ->getProcessByCode('meanbee_runrate')
            ->processEvent($indexEvent);
    }
}
