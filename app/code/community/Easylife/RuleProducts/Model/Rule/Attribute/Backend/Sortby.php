<?php
/**
 * Easylife_RuleProducts extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category       Easylife
 * @package        Easylife_RuleProducts
 * @copyright      Copyright (c) 2014
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * sortby backend model
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Model_Rule_Attribute_Backend_Sortby
    extends Mage_Catalog_Model_Category_Attribute_Backend_Sortby {
    /**
     * before save
     * @param Varien_Object $object
     * @return $this|Mage_Catalog_Model_Category_Attribute_Backend_Sortby
     * @author Marius Strajeru
     */
    public function beforeSave($object) {
        $useConfig = $object->getData('use_config');

        $attributeCode = $this->getAttribute()->getName();
        if (in_array($attributeCode, $useConfig)) {
            $object->setData($attributeCode, '');
        }

        if ($attributeCode == 'available_sort_by') {
            $data = $object->getData($attributeCode);
            if (!is_array($data)) {
                $data = array();
            }
            $object->setData($attributeCode, join(',', $data));
        }
        if (is_null($object->getData($attributeCode))) {
            $object->setData($attributeCode, false);
        }
        return $this;
    }
}