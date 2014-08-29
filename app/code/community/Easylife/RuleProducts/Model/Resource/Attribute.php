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
 * Attribute model
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Model_Resource_Attribute
    extends Mage_Eav_Model_Resource_Entity_Attribute {
    /**
     * after saving the attribute
     * @access protected
     * @param Mage_Core_Model_Abstract $object
     * @return  Easylife_RuleProducts_Model_Resource_Attribute
     * @author Marius Strajeru
     */
    protected  function _afterSave(Mage_Core_Model_Abstract $object){
        $setup       = Mage::getModel('eav/entity_setup', 'core_write');
        $entityType  = $object->getEntityTypeId();
        $setId       = $setup->getDefaultAttributeSetId($entityType);
        $groupId     = $setup->getDefaultAttributeGroupId($entityType);
        $attributeId = $object->getId();
        $sortOrder   = $object->getPosition();

        $setup->addAttributeToGroup($entityType, $setId, $groupId, $attributeId, $sortOrder);
        return parent::_afterSave($object);
    }
}