<?php
class Meanbee_RunRate_Model_System_Config_Source_ProductAttribute
{
    public function toOptionArray()
    {
        $entity_type = Mage::getModel('eav/config')->getEntityType(Mage_Catalog_Model_Product::ENTITY);
        $entity_type_id = $entity_type->getEntityTypeId();

        $attributes = Mage::getResourceModel('eav/entity_attribute_collection')
            ->setEntityTypeFilter($entity_type_id);

        $attributes_array = array();

        foreach ($attributes as $attribute) {
            /** @var Mage_Eav_Model_Entity_Attribute $attribute */
            $attributes_array[] = array(
                'label' => $attribute->getFrontendLabel(),
                'value' => $attribute->getAttributeCode()
            );
        }

        return $attributes_array;
    }
}
