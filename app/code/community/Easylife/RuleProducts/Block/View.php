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
 * Rule Product view block
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Block_View
    extends Mage_Core_Block_Template {
    /**
     * get the current rule product
     * @access public
     * @return Easylife_RuleProducts_Model_Ruleproduct
     * @author Marius Strajeru
     */
    public function getCurrentRuleproduct(){
        return Mage::registry('current_ruleproduct');
    }
}
