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
 * Rule Product front contrller
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_RuleproductController
    extends Mage_Core_Controller_Front_Action {
    /**
     * init Rule Product
     * @access protected
     * @return Easylife_RuleProducts_Model_RuleProduct
     * @author Marius Strajeru
     */
    protected function _initRuleproduct(){
        $ruleproductId   = $this->getRequest()->getParam('id', 0);
        $ruleproduct     = Mage::getModel('easylife_ruleproducts/ruleproduct')
                        ->setStoreId(Mage::app()->getStore()->getId())
                        ->load($ruleproductId);
        if (!$ruleproduct->getId()){
            return false;
        }
        elseif (!$ruleproduct->getStatus()){
            return false;
        }
        return $ruleproduct;
    }
    /**
      * view rule product action
      * @access public
      * @return void
      * @author Marius Strajeru
      */
    public function viewAction(){
        $ruleproduct = $this->_initRuleproduct();
        if (!$ruleproduct) {
            $this->_forward('no-route');
            return;
        }
        Mage::register('current_ruleproduct', $ruleproduct);
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('ruleproducts-ruleproduct ruleproducts-ruleproduct-' . $ruleproduct->getId());
        }
        if (Mage::helper('easylife_ruleproducts/ruleproduct')->getUseBreadcrumbs()){
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
                $breadcrumbBlock->addCrumb('home', array(
                            'label'    => Mage::helper('easylife_ruleproducts')->__('Home'),
                            'link'     => Mage::getUrl(),
                        )
                );
                $breadcrumbBlock->addCrumb('ruleproduct', array(
                            'label'    => $ruleproduct->getTitle(),
                            'link'    => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            if ($ruleproduct->getMetaTitle()){
                $headBlock->setTitle($ruleproduct->getMetaTitle());
            }
            else{
                $headBlock->setTitle($ruleproduct->getTitle());
            }
            $headBlock->setKeywords($ruleproduct->getMetaKeywords());
            $headBlock->setDescription($ruleproduct->getMetaDescription());
        }
        $this->renderLayout();
    }
}
