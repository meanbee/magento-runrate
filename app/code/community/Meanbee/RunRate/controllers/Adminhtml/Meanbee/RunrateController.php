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
        $data = $this->getLayout()->createBlock('meanbee_runrate/adminhtml_runrate_grid')->getCsv();

        return $this->setDownloadHeaders($filename, $data);
    }

    public function exportXmlAction()
    {
        $filename = 'runrate.xml';
        $data = $this->getLayout()->createBlock('meanbee_runrate/adminhtml_runrate_grid')->getXml();

        return $this->setDownloadHeaders($filename, $data);
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
