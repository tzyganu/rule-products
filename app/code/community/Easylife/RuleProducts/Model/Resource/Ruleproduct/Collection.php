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
 * Rule Product collection resource model
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Model_Resource_Ruleproduct_Collection
    extends Mage_Catalog_Model_Resource_Collection_Abstract {
    protected $_joinedFields = array();
    /**
     * constructor
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    protected function _construct(){
        parent::_construct();
        $this->_init('easylife_ruleproducts/ruleproduct');
    }
    /**
     * get ruleproducts as array
     * @access protected
     * @param string $valueField
     * @param string $labelField
     * @param array $additional
     * @return array
     * @author Marius Strajeru
     */
    protected function _toOptionArray($valueField='entity_id', $labelField='title', $additional=array()){
        $this->addAttributeToSelect('title');
        return parent::_toOptionArray($valueField, $labelField, $additional);
    }
    /**
     * get options hash
     * @access protected
     * @param string $valueField
     * @param string $labelField
     * @return array
     * @author Marius Strajeru
     */
    protected function _toOptionHash($valueField='entity_id', $labelField='title'){
        $this->addAttributeToSelect('title');
        return parent::_toOptionHash($valueField, $labelField);
    }
    /**
     * Get SQL for get record count.
     * Extra GROUP BY strip added.
     * @access public
     * @return Varien_Db_Select
     * @author Marius Strajeru
     */
    public function getSelectCountSql(){
        $countSelect = parent::getSelectCountSql();
        $countSelect->reset(Zend_Db_Select::GROUP);
        return $countSelect;
    }

    /**
     * @access public
     * @param $attributeCode
     * @return $this
     * @author Marius Strajeru
     */
    public function addAttributeInConditionFilter($attributeCode) {
        $match = sprintf('%%%s%%', substr(serialize(array('attribute' => $attributeCode)), 5, -1));
        $this->addFieldToFilter('conditions_serialized', array('like' => $match));
        return $this;
    }
}
