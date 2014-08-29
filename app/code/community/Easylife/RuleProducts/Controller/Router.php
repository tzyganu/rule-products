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
 * Router
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Controller_Router
    extends Mage_Core_Controller_Varien_Router_Abstract {
    /**
     * init routes
     * @access public
     * @param Varien_Event_Observer $observer
     * @return Easylife_RuleProducts_Controller_Router
     * @author Marius Strajeru
     */
    public function initControllerRouters($observer){
        /** @var Mage_Core_Controller_Varien_Front $front */
        $front = $observer->getEvent()->getFront();
        $front->addRouter('easylife_ruleproducts', $this);
        return $this;
    }
    /**
     * Validate and match entities and modify request
     * @access public
     * @param Zend_Controller_Request_Http $request
     * @return bool
     * @author Marius Strajeru
     */
    public function match(Zend_Controller_Request_Http $request){
        if (!Mage::isInstalled()) {
            Mage::app()->getFrontController()->getResponse()
                ->setRedirect(Mage::getUrl('install'))
                ->sendResponse();
            exit;
        }
        $urlKey = trim($request->getPathInfo(), '/');
        $prefix = Mage::getStoreConfig('easylife_ruleproducts/ruleproduct/url_prefix');
        $suffix = Mage::getStoreConfig('easylife_ruleproducts/ruleproduct/url_suffix');
        if ($prefix){
            $parts = explode('/', $urlKey);
            if ($parts[0] != $prefix || count($parts) != 2){
                return false;
            }
            $urlKey = $parts[1];
        }
        if ($suffix){
            $urlKey = substr($urlKey, 0 , -strlen($suffix) - 1);
        }
        /** @var Easylife_RuleProducts_Model_Ruleproduct $model */
        $model = Mage::getModel('easylife_ruleproducts/ruleproduct');
        $id = $model->checkUrlKey($urlKey, Mage::app()->getStore()->getId());
        if (!$model->setStoreId(Mage::app()->getStore()->getId())->load($id)->getStatus()) {
            return false;
        }
        if ($id){
            $request->setModuleName('ruleproducts')
                ->setControllerName('ruleproduct')
                ->setActionName('view')
                ->setParam('id', $id);
            $request->setAlias(
                Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
                $urlKey
            );
            return true;
        }
        return false;
    }
}
