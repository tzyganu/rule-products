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
 * Rule Product admin edit tabs
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
/**
 * @method Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Edit_Tabs setTitle()
 */
class Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs {
    /**
     * Initialize Tabs
     * @access public
     * @author Marius Strajeru
     */
    public function __construct() {
        parent::__construct();
        $this->setId('ruleproduct_info_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('easylife_ruleproducts')->__('Rule Product Information'));
    }
    /**
     * prepare the layout
     * @access protected
     * @return Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Edit_Tabs
     * @author Marius Strajeru
     */
    protected function _prepareLayout(){
        $ruleproduct = $this->getRuleproduct();
        /** @var Mage_Eav_Model_Entity_Type $entity */
        $entity = Mage::getModel('eav/entity_type')->load('easylife_ruleproducts_ruleproduct', 'entity_type_code');
        /** @var Mage_Eav_Model_Resource_Entity_Attribute_Collection $attributes */
        $attributes = Mage::getResourceModel('eav/entity_attribute_collection')
                ->setEntityTypeFilter($entity->getEntityTypeId());
        $attributes->addFieldToFilter('attribute_code', array('nin'=>array('meta_title', 'meta_description', 'meta_keywords', 'available_sort_by', 'default_sort_by')));
        $attributes->getSelect()->order('additional_table.position', 'ASC');

        /** @var Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Edit_Tab_Attributes $block */
        $block = $this->getLayout()->createBlock('easylife_ruleproducts/adminhtml_ruleproduct_edit_tab_attributes');
        $this->addTab('info', array(
            'label'     => Mage::helper('easylife_ruleproducts')->__('Rule Product Information'),
            'content'   => $block->setAttributes($attributes)->toHtml(),
        ));

        /** @var Mage_Eav_Model_Resource_Entity_Attribute_Collection $attributes */
        $designAttributes = Mage::getResourceModel('eav/entity_attribute_collection')
            ->setEntityTypeFilter($entity->getEntityTypeId());
        $designAttributes->addFieldToFilter('attribute_code', array('in'=>array('available_sort_by', 'default_sort_by')));
        $designAttributes->getSelect()->order('additional_table.position', 'ASC');

        /** @var Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Edit_Tab_Attributes $block */
        $block = $this->getLayout()->createBlock('easylife_ruleproducts/adminhtml_ruleproduct_edit_tab_attributes');
        $this->addTab('display', array(
            'label'     => Mage::helper('easylife_ruleproducts')->__('Display Settings'),
            'content'   => $block->setAttributes($designAttributes)->toHtml(),
        ));

        /** @var Mage_Eav_Model_Resource_Entity_Attribute_Collection $seoAttributes */
        $seoAttributes = Mage::getResourceModel('eav/entity_attribute_collection')
                ->setEntityTypeFilter($entity->getEntityTypeId())
                ->addFieldToFilter('attribute_code', array('in'=>array('meta_title', 'meta_description', 'meta_keywords')));
        $seoAttributes->getSelect()->order('additional_table.position', 'ASC');

        /** @var Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Edit_Tab_Attributes $block */
        $block = $this->getLayout()->createBlock('easylife_ruleproducts/adminhtml_ruleproduct_edit_tab_attributes');
        $this->addTab('meta', array(
            'label'     => Mage::helper('easylife_ruleproducts')->__('Meta'),
            'title'     => Mage::helper('easylife_ruleproducts')->__('Meta'),
            'content'   => $block->setAttributes($seoAttributes)->toHtml(),
        ));
        if (!$ruleproduct->getStoreId()) {
            $this->addTab('conditions', array(
                'label'     => Mage::helper('easylife_ruleproducts')->__('conditions'),
                'title'     => Mage::helper('easylife_ruleproducts')->__('conditions'),
                'content'   => $this->getLayout()->createBlock('easylife_ruleproducts/adminhtml_ruleproduct_edit_tab_conditions')->toHtml()
            ));
        }

        return parent::_beforeToHtml();
    }
    /**
     * Retrieve rule product entity
     * @access public
     * @return Easylife_RuleProducts_Model_Ruleproduct
     * @author Marius Strajeru
     */
    public function getRuleproduct(){
        return Mage::registry('current_ruleproduct');
    }
}
