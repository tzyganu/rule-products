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
 * Rule Product admin block
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Block_Adminhtml_Ruleproduct
    extends Mage_Adminhtml_Block_Widget_Grid_Container {
    /**
     * constructor
     * @access public
     * @author Marius Strajeru
     */
    public function __construct(){
        $this->_controller         = 'adminhtml_ruleproduct';
        $this->_blockGroup         = 'easylife_ruleproducts';
        parent::__construct();
        $this->_headerText         = Mage::helper('easylife_ruleproducts')->__('Rule Product');
        $this->_updateButton('add', 'label', Mage::helper('easylife_ruleproducts')->__('Add Rule Product'));
        $this->setTemplate('easylife_ruleproducts/grid.phtml');
    }
}
