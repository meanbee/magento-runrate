<?php
class Meanbee_RunRate_Model_Indexer extends Mage_Index_Model_Indexer_Abstract
{
    const INDEXER_CODE = 'meanbee_runrate';

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

    protected function _registerEvent(Mage_Index_Model_Event $event) {
        // TODO: Implement _registerEvent() method.
    }

    protected function _processEvent(Mage_Index_Model_Event $event) {
        // TODO: Implement _processEvent() method.
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
