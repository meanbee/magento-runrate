<?php
class Meanbee_RunRate_Adminhtml_Meanbee_RunrateController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @TODO Implement ACL.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }

    public function viewAction()
    {
        $this->_title('Run Rate');

        $this->loadLayout();
        $this->renderLayout();
    }
}
