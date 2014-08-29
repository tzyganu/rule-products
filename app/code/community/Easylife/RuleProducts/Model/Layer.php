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
 * Layer model
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
/**
 * @method Easylife_RuleProducts_Model_Layer setCurrentRule()
 */
class Easylife_RuleProducts_Model_Layer extends Mage_Catalog_Model_Layer {
    /**
     * @access public
     * @return string
     * @author Marius Strajeru
     */
    public function getStateKey() {
        if ($this->_stateKey === null) {
            $this->_stateKey = 'STORE_'.Mage::app()->getStore()->getId()
                . '_RULE_PRODUCT_' . $this->getCurrentRule()->getId()
                . '_CUSTGROUP_' . Mage::getSingleton('customer/session')->getCustomerGroupId();
        }
        return $this->_stateKey;
    }

    /**
     * @access public
     * @param array $additionalTags
     * @return array
     * @author Marius Strajeru
     */
    public function getStateTags(array $additionalTags = array()) {
        $additionalTags = array_merge($additionalTags, array(
            Easylife_RuleProducts_Model_Ruleproduct::CACHE_TAG.$this->getCurrentRule()->getId()
        ));

        return $additionalTags;
    }

    /**
     * @access public
     * @return Mage_Catalog_Model_Resource_Product_Collection
     * @author Marius Strajeru
     */
    public function getProductCollection() {
        if (isset($this->_productCollections[$this->getCurrentRule()->getId()])) {
            $collection = $this->_productCollections[$this->getCurrentRule()->getId()];
        } else {
            $collection = $this->getCurrentRule()->getProductCollection();
            $this->prepareProductCollection($collection);
            $this->_productCollections[$this->getCurrentRule()->getId()] = $collection;
        }
        return $collection;
    }

    /**
     * @access public
     * @return Easylife_RuleProducts_Model_Ruleproduct
     * @author Marius Strajeru
     */
    public function getCurrentRule() {
        $rule = $this->getData('current_rule');
        if (is_null($rule)) {
            if ($rule = Mage::registry('current_ruleproduct')) {
                $this->setData('current_rule', $rule);
            }
        }
        return $rule;
    }

    /**
     * @access public
     * @param Mage_Catalog_Model_Resource_Product_Collection $collection
     * @return $this
     * @author Marius Strajeru
     */
    public function prepareProductCollection($collection) {
        $collection
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addUrlRewrite();

        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);

        return $this;
    }

    /**
     * @access protected
     * @param Mage_Eav_Model_Entity_Attribute $attribute
     * @return Mage_Eav_Model_Entity_Attribute
     * @author Marius Strajeru
     */
    protected function _prepareAttribute($attribute) {
        $attribute = parent::_prepareAttribute($attribute);
        $attribute->setIsFilterable(Easylife_RuleProduct_Model_Layer_Filter_Attribute::OPTIONS_ONLY_WITH_RESULTS);
        return $attribute;
    }
}