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
 * Dummy block to add a button to the form block.
 * Used this to avoid observing a general block.
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Block_Adminhtml_Button
    extends Mage_Adminhtml_Block_Template {
    /**
     * add button to parent block
     * @access public
     * @return Easylife_RuleProducts_Block_Adminhtml_Button
     * @author Marius Strajeru
     */
    public function addButtonToParent() {
        $catalogRule = Mage::registry('current_promo_catalog_rule');
        if (!$catalogRule || !$catalogRule->getId()) {
            return $this;
        }
        /** @var Mage_Adminhtml_Block_Widget_Form_Container $parentBlock */
        $parentBlock = $this->getParentBlock();
        if (!$parentBlock) {
            return $this;
        }
        /** @var Mage_Adminhtml_Helper_Data $helper */
        $helper = Mage::helper('adminhtml');
        $parentBlock->addButton('create_product_rule', array(
            'class'   => 'save',
            'label'   => Mage::helper('easylife_ruleproducts')->__('Create Products Rule'),
            'onclick' => "window.open('".$helper->getUrl('adminhtml/ruleproducts_ruleproduct/new', array('catalogrule'=>$catalogRule->getId()))."')",
        ));
        return $this;
    }
}