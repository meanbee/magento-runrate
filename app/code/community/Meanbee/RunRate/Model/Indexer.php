<?php
class Meanbee_RunRate_Model_Indexer extends Mage_Index_Model_Indexer_Abstract
{
    const INDEXER_CODE = 'meanbee_runrate';

    protected $_matchedEntities = array(
        Mage_Catalog_Model_Product::ENTITY => array(
            Mage_Index_Model_Event::TYPE_SAVE,
            Mage_Index_Model_Event::TYPE_MASS_ACTION
        ),
        Mage_CatalogInventory_Model_Stock_Item::ENTITY => array(
            Mage_Index_Model_Event::TYPE_SAVE,
            Mage_Index_Model_Event::TYPE_MASS_ACTION,
            Mage_Index_Model_Event::TYPE_DELETE
        )
    );

    protected function _construct()
    {
        $this->_init('meanbee_runrate/runrate_indexer');
    }

    public function getName()
    {
        return 'Run Rate Report';
    }

    public function getDescription()
    {
        return 'Extract product and stock data for a quicker report';
    }

    /**
     * @param Mage_Index_Model_Event $event
     */
    protected function _registerEvent(Mage_Index_Model_Event $event) {
        $data_object = $event->getDataObject();
        $product_ids = array();

        if ($data_object instanceof Mage_CatalogInventory_Model_Stock_Item) {
            if ($data_object->hasProductId()) {
                $product_ids[] = $data_object->getProductId();
            }
        } else if ($data_object instanceof Mage_Catalog_Model_Product) {
            if ($data_object->hasEntityId()) {
                $product_ids[] = $data_object->getEntityId();
            }
        } else if ($data_object->hasProductIds()) {
            $product_ids += $data_object->getProductIds();
        }

        $event->setData('product_ids', $product_ids);
    }

    protected function _processEvent(Mage_Index_Model_Event $event) {
        if ($event->hasData('product_ids')) {
            $this->_getResource()->reindexProducts($event->getProductIds());
        }
    }

    public function getLastRunAt()
    {
        return $this->getIndexProcess()->getEndedAt();
    }

    public function getIndexerCode()
    {
        return self::INDEXER_CODE;
    }

    public function getIndexProcess()
    {
        return Mage::getModel('index/process')->load($this->getIndexerCode(), 'indexer_code');
    }

    public function getIndexProcessId()
    {
        return $this->getIndexProcess()->getId();
    }
}
