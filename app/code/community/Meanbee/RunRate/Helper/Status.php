<?php
class Meanbee_RunRate_Helper_Status extends Mage_Core_Helper_Abstract
{
    const STATUS_SAFE       = 'safe';
    const STATUS_ORDER_SOON = 'order_soon';
    const STATUS_WARNING    = 'warning';

    protected $status_labels = array(
        self::STATUS_SAFE       => 'Safe',
        self::STATUS_ORDER_SOON => 'Order Soon',
        self::STATUS_WARNING    => 'Warning'
    );

    public function getGridOptions()
    {
        return $this->status_labels;
    }

    public function getStatuses()
    {
        return array(
            self::STATUS_SAFE,
            self::STATUS_WARNING,
            self::STATUS_ORDER_SOON
        );
    }

    public function getStatusLabel($status)
    {
        if ($this->isValidStatus($status)) {
            if (isset($this->status_labels[$status])) {
                return $this->status_labels[$status];
            } else {
                return 'No Label';
            }
        } else {
            return 'Unknown';
        }
    }

    public function isValidStatus($status)
    {
        return in_array($status, $this->getStatuses());
    }
}
