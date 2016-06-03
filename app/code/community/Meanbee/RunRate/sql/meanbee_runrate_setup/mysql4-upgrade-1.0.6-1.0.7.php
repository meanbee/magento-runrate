<?php

/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;

$installer->startSetup();

$runrateTable = $installer->getTable('meanbee_runrate/runrate');
$productTable = $installer->getTable('catalog/product');

$sql = <<<SQL

ALTER TABLE `$runrateTable`
DROP FOREIGN KEY `FK_product_id`;

ALTER TABLE `$runrateTable`
ADD CONSTRAINT `FK_product_id` FOREIGN KEY (`product_id`) REFERENCES `$productTable` (`entity_id`) ON DELETE CASCADE;

SQL;

$installer->getConnection()->query($sql);

$installer->endSetup();
