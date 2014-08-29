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
 * Rule Product image field renderer helper
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
/**
 * @method string getValue()
 */
class Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Helper_Image
    extends Varien_Data_Form_Element_Image {
    /**
     * get the url of the image
     * @access protected
     * @return string
     * @author Marius Strajeru
     */
    protected function _getUrl(){
        $url = false;
        if ($this->getValue()) {
            /** @var Easylife_RuleProducts_Helper_Ruleproduct_Image $helper */
            $helper = Mage::helper('easylife_ruleproducts/ruleproduct_image');
            $url = $helper->getImageBaseUrl().$this->getValue();
        }
        return $url;
    }
}
