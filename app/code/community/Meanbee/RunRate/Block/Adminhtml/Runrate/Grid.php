<?php
class Meanbee_RunRate_Block_Adminhtml_Runrate_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('meanbee_runrate_grid');
        $this->setSaveParametersInSession(false);

        $index = Mage::getModel('meanbee_runrate/indexer');
        $reindex_url = $this->getUrl('adminhtml/process/reindexProcess', array(
            'process' => $index->getIndexProcessId()
        ));

        $this->_emptyText = 'No records found. You may need to <a href="' . $reindex_url . '">reindex</a>.';

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
            'width'     => '150px',
            'frame_callback' => array($this, 'decorateSku')
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

    /**
     * Wrap SKU in tag to give Meanbee_BarcodeAnnotator a target for adding a
     * barcode popup, if Meanbee_BarcodeAnnotator is installed.
     * @param  string                                  $value    SKU
     * @param  Meanbee_RunRate_Model_Runrate           $row      Grid row
     * @param  Mage_Adminhtml_Block_Widget_Grid_Column $column   Grid column
     * @param  boolean                                 $isExport
     * @return string                                            Wrapped content
     */
    public function decorateSku($value, $row, $column, $isExport) {
        if (Mage::helper('core')->isModuleEnabled('Meanbee_BarcodeAnnotator')) {
            return sprintf(
                '<div title class="barcode" data-barcode-symbology="%s">%s</div>',
                Mage::helper('meanbee_barcodeannotator/config')->getProductSkuBarcodeSymbology(),
                $value
            );
        }
        return $value;
    }
}
