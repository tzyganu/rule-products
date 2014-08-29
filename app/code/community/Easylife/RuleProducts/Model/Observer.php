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
 * Observer
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Model_Observer {
    const XML_GROUP_FLAG_PATH  = 'easylife_ruleproducts/ruleproduct/group_in_menu';
    const XML_GROUP_LABEL_PATH = 'easylife_ruleproducts/ruleproduct/menu_group_label';
    /**
     * add items to main menu
     * @access public
     * @param Varien_Event_Observer $observer
     * @return $this
     * @author Marius Strajeru
     */
    public function addItemsToMenu(Varien_Event_Observer $observer) {
        $collection = Mage::getModel('easylife_ruleproducts/ruleproduct')->getCollection()
            ->addAttributeToSelect('title')
            ->addAttributeToSelect('url_key')
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('include_in_menu', 1)
            ->setOrder('menu_position');
        if ($collection->count() == 0) {
            return $this;
        }
        /** @var Varien_Data_Tree_Node $menu */
        $menu = $observer->getMenu();
        $tree = $menu->getTree();
        $mainNode = $menu;
        $group = Mage::getStoreConfigFlag(self::XML_GROUP_FLAG_PATH);
        /** @var string $action */
        $action = Mage::app()->getFrontController()->getAction()->getFullActionName();
        if ($group) {
            $groupLabel = Mage::getStoreConfig(self::XML_GROUP_LABEL_PATH);
            if ($groupLabel) {
                $data = array(
                    'name' => $groupLabel,
                    'id'   => 'ruleproducts',
                    'url'  => '#',
                    'is_active' => ($action == 'easylife_ruleproducts_ruleproduct_view')
                );
                $node = new Varien_Data_Tree_Node($data, 'id', $tree, $menu);
                $menu->addChild($node);
                $mainNode = $node;
            }
        }
        foreach ($collection as $item) {
            /** @var Easylife_RuleProducts_Model_Ruleproduct $item */
            $nodeId = 'ruleproduct-'.$item->getId();
            $id = Mage::app()->getRequest()->getParam('id');
            //set the node id, label and url
            $data = array(
                'name' => $item->getTitle(),
                'id' => $nodeId,
                'url' => $item->getRuleproductUrl(),
                'is_active' => (($action == 'easylife_ruleproducts_ruleproduct_view') && $id == $item->getId())
            );
            //create a node object
            $node = new Varien_Data_Tree_Node($data, 'id', $tree, $mainNode);
            //add the node to the menu
            $mainNode->addChild($node);
        }
        return $this;
    }

    /**
     * apply rules on product - called on product save
     * @access public
     * @param Varien_Event_Observer $observer
     * @return $this
     * @author Marius Strajeru
     */
    public function applyAllRulesOnProduct(Varien_Event_Observer $observer) {
        /** @var Mage_Catalog_Model_Product $product */
        $product = $observer->getEvent()->getProduct();
        if ($product->getIsMassupdate()) {
            return $this;
        }
        $rules = Mage::getModel('easylife_ruleproducts/ruleproduct')->getCollection()
            ->addAttributeToFilter('status', 1);
        foreach ($rules as $rule) {
            /** @var Easylife_RuleProducts_Model_Ruleproduct $rule */
            $rule->applyToProduct($product);
        }
        return $this;
    }

    /**
     * clean product rules - called after product import ends
     * @access public
     * @param Varien_Event_Observer $observer
     * @return $this;
     * @author Marius Strajeru
     */
    public function cleanProductRulesRelations(Varien_Event_Observer $observer) {
        $adapter = $observer->getEvent()->getAdapter();
        $affectedEntityIds = $adapter->getAffectedEntityIds();

        if (empty($affectedEntityIds)) {
            return $this;
        }
        $rules = Mage::getModel('easylife_ruleproducts/ruleproduct')->getCollection()
            ->addFieldToFilter('status', 1);
        //TODO: find a way not to reset all rules.
        foreach ($rules as $rule) {
            Mage::getResourceSingleton('easylife_ruleproducts/ruleproduct')->clearProductIds($rule);
        }
        return $this;
    }

    /**
     * check rule availability after an attribute is deleted
     * @access public
     * @param Varien_Event_Observer $observer
     * @return $this
     * @author Marius Strajeru
     */
    public function catalogAttributeDeleteAfter(Varien_Event_Observer $observer) {
        $attribute = $observer->getEvent()->getAttribute();
        if ($attribute->getIsUsedForPromoRules()) {
            $this->_checkCatalogRulesAvailability($attribute->getAttributeCode());
        }
        return $this;
    }
    /**
     * check rule availability after an attribute is deleted
     * @access protected
     * @param string $attributeCode
     * @return $this
     * @author Marius Strajeru
     */
    protected function _checkCatalogRulesAvailability($attributeCode) {
        /* @var $collection Easylife_RuleProducts_Model_Resource_Ruleproduct_Collection */
        $collection = Mage::getResourceModel('easylife_ruleproducts/ruleproduct_collection')
            ->addAttributeInConditionFilter($attributeCode);

        $disabledRulesCount = 0;
        foreach ($collection as $rule) {
            /* @var $rule Easylife_RuleProducts_Model_Ruleproduct */
            $rule->setStatus(0);
            $this->_removeAttributeFromConditions($rule->getConditions(), $attributeCode);
            $rule->save();
            $disabledRulesCount++;
        }

        if ($disabledRulesCount) {
            Mage::getSingleton('adminhtml/session')->addWarning(
                Mage::helper('easylife_ruleproducts')->__('%d Product Rules based on "%s" attribute have been disabled.', $disabledRulesCount, $attributeCode)
            );
        }

        return $this;
    }

    /**
     * remove attribute from rules
     * @access protected
     * @param $combine
     * @param string $attributeCode
     * @return $this
     * @author Marius Strajeru
     */
    protected function _removeAttributeFromConditions(Mage_Rule_Model_Condition_Combine $combine, $attributeCode) {
        $conditions = $combine->getConditions();
        foreach ($conditions as $conditionId => $condition) {
            /** @var Mage_CatalogRule_Model_Rule_Condition_Combine|Mage_Rule_Model_Condition_Product_Abstract $condition */
            if ($condition instanceof Mage_CatalogRule_Model_Rule_Condition_Combine) {
                $this->_removeAttributeFromConditions($condition, $attributeCode);
            }
            if ($condition instanceof Mage_Rule_Model_Condition_Product_Abstract) {
                if ($condition->getAttribute() == $attributeCode) {
                    unset($conditions[$conditionId]);
                }
            }
        }
        $combine->setConditions($conditions);
        return $this;
    }

    /**
     * after save attribute
     * @access public
     * @param Varien_Event_Observer $observer
     * @return $this
     * @author Marius Strajeru
     */
    public function catalogAttributeSaveAfter(Varien_Event_Observer $observer) {
        /** @var Mage_Eav_Model_Entity_Attribute $attribute */
        $attribute = $observer->getEvent()->getAttribute();
        if ($attribute->dataHasChangedFor('is_used_for_promo_rules') && !$attribute->getIsUsedForPromoRules()) {
            $this->_checkCatalogRulesAvailability($attribute->getAttributeCode());
        }
        return $this;
    }
}
