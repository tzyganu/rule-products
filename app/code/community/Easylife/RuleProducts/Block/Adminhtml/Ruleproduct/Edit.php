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
 * Rule Product admin edit form
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container {
    /**
     * constructor
     * @access public
     * @author Marius Strajeru
     */
    public function __construct(){
        parent::__construct();
        $this->_blockGroup = 'easylife_ruleproducts';
        $this->_controller = 'adminhtml_ruleproduct';
        $this->_updateButton('save', 'label', Mage::helper('easylife_ruleproducts')->__('Save Products Rule'));
        $this->_updateButton('delete', 'label', Mage::helper('easylife_ruleproducts')->__('Delete Products Rule'));
        $this->_addButton('saveandcontinue', array(
            'label'        => Mage::helper('easylife_ruleproducts')->__('Save And Continue Edit'),
            'onclick'    => 'saveAndContinueEdit()',
            'class'        => 'save',
        ), -100);
        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
    /**
     * get the edit form header
     * @access public
     * @return string
     * @author Marius Strajeru
     */
    public function getHeaderText(){
        if( Mage::registry('current_ruleproduct') && Mage::registry('current_ruleproduct')->getId() ) {
            return Mage::helper('easylife_ruleproducts')->__("Edit Products Rule '%s'", $this->escapeHtml(Mage::registry('current_ruleproduct')->getTitle()));
        }
        else {
            return Mage::helper('easylife_ruleproducts')->__('Add Products Rule');
        }
    }
}
