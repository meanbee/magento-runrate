<?php
class Meanbee_RunRate_Block_Adminhtml_LastBuilt extends Mage_Adminhtml_Block_Template
{
    public function getTemplate()
    {
        if (!$this->hasTemplate()) {
            return 'meanbee/runrate/last_built_message.phtml';
        } else {
            return parent::getTemplate();
        }
    }

    public function getMessage()
    {
        $index = Mage::getModel('meanbee_runrate/indexer');

        $last_generated_date = $index->getLastRunAt();
        $reindex_url = $this->getUrl('adminhtml/process/reindexProcess', array(
            'process' => $index->getIndexProcessId()
        ));

        return sprintf(
            "This report was last generated at %s. <a href='%s'>Click here</a> to rebuild the data.",
            $last_generated_date,
            $reindex_url
        );
    }
}
