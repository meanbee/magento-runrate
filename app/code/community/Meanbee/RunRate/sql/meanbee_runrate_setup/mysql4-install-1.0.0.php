<?php

/** @var Mage_Core_Model_Resource_Setup $this */

$this->startSetup();

$table = $this->getTable('meanbee_runrate/runrate');

$sql = <<<SQL
CREATE TABLE `$table` (
    `product_id` int(11) unsigned NOT NULL,
    `status` enum('safe','order_soon','warning') DEFAULT NULL,
    `sku` varchar(256) DEFAULT NULL,
    `name` varchar(256) DEFAULT NULL,
    `current_stock` decimal(12,4) DEFAULT NULL,
    `lead_time` int(11) DEFAULT NULL,
    `average_run` decimal(12,4) DEFAULT NULL,
    `weeks_remaining_at_average_run` decimal(12,4) DEFAULT NULL,
    PRIMARY KEY (`product_id`),
    CONSTRAINT `FK_product_id` FOREIGN KEY (`product_id`) REFERENCES `catalog_product_entity` (`entity_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;

$this->getConnection()->query($sql);

$this->endSetup();
