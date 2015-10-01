<?php

class Meanbee_RunRate_Model_Cron
{
	/**
	 * Reindexes products; all products if no products specified in the schedule
	 * message.
	 * @param  Mage_Cron_Model_Schedule $schedule
	 */
	public function reindex ($schedule) {
		$productIds = json_decode($schedule->getMessages());
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
