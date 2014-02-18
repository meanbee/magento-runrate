<?php
class Meanbee_RunRate_Block_Adminhtml_Runrate extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_headerText = 'Run Rate';

        $this->_controller = 'adminhtml_runrate';
        $this->_blockGroup = 'meanbee_runrate';

        $this->_removeButton('add');
    }
}
