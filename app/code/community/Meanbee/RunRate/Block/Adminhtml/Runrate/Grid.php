<?php
class Meanbee_RunRate_Block_Adminhtml_Runrate_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('meanbee_runrate_grid');
        $this->setSaveParametersInSession(false);

        $this->_emptyText = 'No records found. You may need to reindex.';

        $this->addExportType('*/*/exportCsv', 'CSV');
        $this->addExportType('*/*/exportXml', 'XML');

        // Removed Excel as the implementation throws a warning
        // $this->addExportType('*/*/exportExcel', 'Excel');
    }

    protected function _prepareCollection() {
        $this->setCollection(Mage::getModel('meanbee_runrate/runrate')->getCollection());

        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {

        $this->addColumn('status', array(
            'header'  => 'Status',
            'align'   =>'left',
            'index'   => 'status',
            'type'    => 'options',
            'width'   => '100px',
            'options' => Mage::helper('meanbee_runrate/status')->getGridOptions(),
            'frame_callback' => array($this, 'decorateStatus')
        ));

        $this->addColumn('name', array(
            'header'    => 'Name',
            'align'     =>'left',
            'index'     => 'name',
        ));

        $this->addColumn('sku', array(
            'header'    => 'Sku',
            'align'     =>'left',
            'index'     => 'sku',
            'width'     => '150px'
        ));

        $this->addColumn('current_stock', array(
            'header'    => 'Current Stock',
            'align'     =>'left',
            'type'      => 'number',
            'index'     => 'current_stock',
        ));

        $this->addColumn('average_run', array(
            'header'    => $this->getAverageRunColumnHeading(),
            'align'     =>'left',
            'type'      => 'number',
            'index'     => 'average_run'
        ));

        $this->addColumn('lead_time', array(
            'header'    => 'Lead Time Required (days)',
            'align'     =>'left',
            'type'      => 'number',
            'index'     => 'lead_time',
        ));

        $this->addColumn('weeks_remaining_at_average_run', array(
            'header'    => 'Weeks Remaining',
            'align'     =>'left',
            'type'      => 'number',
            'index'     => 'weeks_remaining_at_average_run',
        ));

        return parent::_prepareColumns();
    }

    public function getAverageRunColumnHeading()
    {
        $weeks_for_average = Mage::helper('meanbee_runrate/config')->getWeeksForAverage();
        return sprintf("Weekly Sales (%d week avg.)", $weeks_for_average, (($weeks_for_average == 1) ? '' : 's'));
    }

    public function decorateStatus($value, $row, $column, $isExport) {

        if ($isExport) {
            return $value;
        }

        switch ($row->getStatus()) {
            case Meanbee_RunRate_Helper_Status::STATUS_SAFE:
                $severity = 'notice';
                break;
            case Meanbee_RunRate_Helper_Status::STATUS_ORDER_SOON:
                $severity = 'minor';
                break;
            case Meanbee_RunRate_Helper_Status::STATUS_WARNING:
                $severity = 'critical';
                break;
            default:
                $severity = '';
        }

        $label = Mage::helper('meanbee_runrate/status')->getStatusLabel($row->getStatus());

        return '<span class="grid-severity-' . $severity . '"><span>' . $label . '</span></span>';
    }
}
