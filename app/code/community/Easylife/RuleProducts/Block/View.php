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

    /**
     * get resize options
     * @access public
     * @return array|null
     * @author Marius Strajeru
     */
    public function getResize() {
        $rule = $this->getCurrentRuleproduct();
        if (!$rule->getResizeX() && !$rule->getResizeY()) {
            return null;
        }

        $resize = array();
        if ($rule->getResizeX()) {
            $resize[] = $rule->getResizeX();
        }
        else {
            $resize[] = null;
        }
        if ($rule->getResizeY()) {
            $resize[] = $rule->getResizeY();
        }
        return $resize;
    }

    /**
     * get the rule image
     * @access public
     * @return Easylife_RuleProducts_Helper_Image_Abstract|null
     * @author Marius Strajeru
     */
    public function getImage() {
        $_rule = $this->getCurrentRuleproduct();
        if (!$_rule->getImage()) {
            return null;
        }
        $resize = $this->getResize();
        /** @var Easylife_RuleProducts_Helper_Ruleproduct_Image $_helper */
        $_helper = Mage::helper('easylife_ruleproducts/ruleproduct_image');
        $_image = $_helper->init($_rule, 'image');
        if ($resize = $this->getResize()) {
            if (count($resize) == 2) {
                $_image->resize($resize[0], $resize[1]);
            }
            else {
                $_image->resize($resize[0]);
            }
        }
        return $_image;
    }
    public function setListOrders() {
        $productList = $this->getChild('product-list');
        if (!$productList) {
            return $this;
        }
        $rule = $productList->getLayer()->getCurrentRule();
        $availableOrders = $rule->getAvailableSortByOptions();
        unset($availableOrders['position']);
        $this->getChild('product-list')->setAvailableOrders($availableOrders);
        return $this;
    }
}
