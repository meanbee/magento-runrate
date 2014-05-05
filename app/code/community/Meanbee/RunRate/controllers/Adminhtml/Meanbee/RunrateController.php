<?php
class Meanbee_RunRate_Adminhtml_Meanbee_RunrateController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::helper('meanbee_runrate/acl')->isAllowedViewReport();
    }

    public function viewAction()
    {
        $this->_title('Run Rate');

        $this->loadLayout();
        $this->renderLayout();
    }

    public function exportCsvAction()
    {
        $filename = 'runrate.csv';
        $data = $this->getGridBlock()->getCsv();

        return $this->setDownloadHeaders($filename, $data);
    }

    public function exportXmlAction()
    {
        $filename = 'runrate.xml';
        $data = $this->getGridBlock()->getXml();

        return $this->setDownloadHeaders($filename, $data);
    }

    /**
     * @return Meanbee_RunRate_Block_Adminhtml_Runrate_Grid
     */
    protected function getGridBlock()
    {
        return $this->getLayout()->createBlock('meanbee_runrate/adminhtml_runrate_grid');
    }

    protected function setDownloadHeaders($filename, $data)
    {
        $response = $this->getResponse();

        $response->setHeader('Content-Type', 'application/octet-stream');
        $response->setHeader('Content-Transfer-Encoding', 'binary');
        $response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');

        $response->setBody($data);

        return $response;
    }
}
