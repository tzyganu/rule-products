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
 * Rule Product attribute collection model
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Model_Resource_Ruleproduct_Attribute_Collection
    extends Mage_Eav_Model_Resource_Entity_Attribute_Collection {
	/**
	 * init attribute select
	 * @access protected
	 * @return Easylife_RuleProducts_Model_Resource_Ruleproduct_Attribute_Collection
	 * @author Marius Strajeru
	 */
	protected function _initSelect() {
        $this->getSelect()->from(array('main_table' => $this->getResource()->getMainTable()))
            ->where('main_table.entity_type_id=?', Mage::getModel('eav/entity')->setType('easylife_ruleproducts_ruleproduct')->getTypeId())
            ->join(
                array('additional_table' => $this->getTable('easylife_ruleproducts/eav_attribute')),
                'additional_table.attribute_id=main_table.attribute_id'
            );
        return $this;
    }
    /**
     * set entity type filter
     * @access public
     * @param string $typeId
     * @return Easylife_RuleProducts_Model_Resource_Ruleproduct_Attribute_Collection
     * @author Marius Strajeru
     */
 	public function setEntityTypeFilter($typeId) {
        return $this;
    }
	/**
     * Specify filter by "is_visible" field
     * @access public
     * @return Easylife_RuleProducts_Model_Resource_Ruleproduct_Attribute_Collection
     * @author Marius Strajeru
     */
    public function addVisibleFilter() {
        return $this->addFieldToFilter('additional_table.is_visible', 1);
    }
	/**
     * Specify filter by "is_editable" field
     * @access public
     * @return Easylife_RuleProducts_Model_Resource_Ruleproduct_Attribute_Collection
     * @author Marius Strajeru
     */
    public function addEditableFilter() {
        return $this->addFieldToFilter('additional_table.is_editable', 1);
    }
}
