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
 * Rule Product admin controller
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Adminhtml_Ruleproducts_RuleproductController
    extends Mage_Adminhtml_Controller_Action {
    /**
     * constructor - set the used module name
     * @access protected
     * @return void
     * @see Mage_Core_Controller_Varien_Action::_construct()
     * @author Marius Strajeru
     */
    protected function _construct(){
        $this->setUsedModuleName('Easylife_RuleProducts');
    }
    /**
     * init the product rule
     * @access protected 
     * @return Easylife_RuleProducts_Model_Ruleproduct
     * @author Marius Strajeru
     */
    protected function _initRuleproduct(){
        $this->_title($this->__('Rule Products'))
             ->_title($this->__('Manage Rule Products'));

        $ruleproductId  = (int) $this->getRequest()->getParam('id');
        /** @var Easylife_RuleProducts_Model_Ruleproduct $ruleproduct */
        $ruleproduct = Mage::getModel('easylife_ruleproducts/ruleproduct');
        $ruleproduct->setStoreId($this->getRequest()->getParam('store', 0));

        if ($ruleproductId) {
            $ruleproduct->load($ruleproductId);
        }
        elseif ($catalogRuleId = $this->getRequest()->getParam('catalogrule')) {
            $catalogRule = Mage::getModel('catalogrule/rule')->load($catalogRuleId);
            $ruleproduct->setConditions($catalogRule->getConditions());
            $ruleproduct->setTitle($catalogRule->getName());
            $ruleproduct->setMetaTitle($catalogRule->getName());
            $ruleproduct->setDescription($catalogRule->getDescription());
        }
        Mage::register('current_ruleproduct', $ruleproduct);
        return $ruleproduct;
    }
    /**
     * default action for product rule controller
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    public function indexAction(){
        $this->_title($this->__('Rule Products'))
             ->_title($this->__('Manage Rule Products'));
        $this->loadLayout();
        $this->renderLayout();
    }
    /**
     * new ruleproduct action
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    public function newAction(){
        $this->_forward('edit');
    }
    /**
     * edit ruleproduct action
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    public function editAction(){
        $ruleproductId  = (int) $this->getRequest()->getParam('id');

        $ruleproduct = $this->_initRuleproduct();
        if ($ruleproductId && !$ruleproduct->getId()) {
            $this->_getSession()->addError(Mage::helper('easylife_ruleproducts')->__('This rule product no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }
        if ($data = Mage::getSingleton('adminhtml/session')->getRuleproductData(true)){
            $ruleproduct->setData($data);
        }
        $this->_title($ruleproduct->getTitle());
        Mage::dispatchEvent('easylife_ruleproducts_ruleproduct_edit_action', array('ruleproduct' => $ruleproduct));
        $this->loadLayout();
        if ($ruleproduct->getId()){
            /** @var Mage_Adminhtml_Block_Store_Switcher $switchBlock */
            if (!Mage::app()->isSingleStoreMode() && ($switchBlock = $this->getLayout()->getBlock('store_switcher'))) {
                $switchBlock->setDefaultStoreName(Mage::helper('easylife_ruleproducts')->__('Default Values'))
                    ->setWebsiteIds($ruleproduct->getWebsiteIds())
                    ->setSwitchUrl($this->getUrl('*/*/*', array('_current'=>true, 'active_tab'=>null, 'tab' => null, 'store'=>null)));
            }
        }
        else{
            $this->getLayout()->getBlock('left')->unsetChild('store_switcher');
        }
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();
    }
    /**
     * save rule product action
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    public function saveAction(){
        $storeId        = $this->getRequest()->getParam('store');
        $redirectBack   = $this->getRequest()->getParam('back', false);
        $ruleproductId      = $this->getRequest()->getParam('id');
        $isEdit         = (int)($this->getRequest()->getParam('id') != null);
        $data = $this->getRequest()->getPost();
        if ($data) {
            $ruleproduct    = $this->_initRuleproduct();
            $ruleproductData = $this->getRequest()->getPost('ruleproduct', array());
            $ruleproduct->addData($ruleproductData);
            $ruleproduct->setAttributeSetId($ruleproduct->getDefaultAttributeSetId());
            if ($useDefaults = $this->getRequest()->getPost('use_default')) {
                foreach ($useDefaults as $attributeCode) {
                    $ruleproduct->setData($attributeCode, false);
                }
            }
            try {
                if (isset($data['rule']['conditions'])) {
                    $data['conditions'] = $data['rule']['conditions'];
                    unset($data['rule']);
                }
                $ruleproduct->loadPost($data);
                $ruleproduct->save();
                $ruleproductId = $ruleproduct->getId();
                $this->_getSession()->addSuccess(Mage::helper('easylife_ruleproducts')->__('Rule Product was saved'));
            }
            catch (Mage_Core_Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage())
                    ->setRuleproductData($ruleproductData);
                $redirectBack = true;
            }
            catch (Exception $e){
                Mage::logException($e);
                $this->_getSession()->addError(Mage::helper('easylife_ruleproducts')->__('Error saving rule product'))
                    ->setRuleproductData($ruleproductData);
                $redirectBack = true;
            }
        }
        if ($redirectBack) {
            $this->_redirect('*/*/edit', array(
                'id'    => $ruleproductId,
                '_current'=>true
            ));
        }
        else {
            $this->_redirect('*/*/', array('store'=>$storeId));
        }
    }
    /**
     * delete rule product
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    public function deleteAction(){
        if ($id = $this->getRequest()->getParam('id')) {
            $ruleproduct = Mage::getModel('easylife_ruleproducts/ruleproduct')->load($id);
            try {
                $ruleproduct->delete();
                $this->_getSession()->addSuccess(Mage::helper('easylife_ruleproducts')->__('The rule products has been deleted.'));
            }
            catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->getResponse()->setRedirect($this->getUrl('*/*/', array('store'=>$this->getRequest()->getParam('store'))));
    }
    /**
     * mass delete rule products
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    public function massDeleteAction() {
        $ruleproductIds = $this->getRequest()->getParam('ruleproduct');
        if (!is_array($ruleproductIds)) {
            $this->_getSession()->addError($this->__('Please select rule products.'));
        }
        else {
            try {
                foreach ($ruleproductIds as $ruleproductId) {
                    $ruleproduct = Mage::getSingleton('easylife_ruleproducts/ruleproduct')->load($ruleproductId);
                    Mage::dispatchEvent('easylife_ruleproducts_controller_ruleproduct_delete', array('ruleproduct' => $ruleproduct));
                    $ruleproduct->delete();
                }
                $this->_getSession()->addSuccess(
                    Mage::helper('easylife_ruleproducts')->__('Total of %d record(s) have been deleted.', count($ruleproductIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass status change - action
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    public function massStatusAction(){
        $ruleproductIds = $this->getRequest()->getParam('ruleproduct');
        if(!is_array($ruleproductIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('easylife_ruleproducts')->__('Please select rule products.'));
        }
        else {
            try {
                foreach ($ruleproductIds as $ruleproductId) {
                    /** @var Easylife_RuleProducts_Model_Ruleproduct $ruleproduct */
                    $ruleproduct = Mage::getSingleton('easylife_ruleproducts/ruleproduct');
                    $ruleproduct->load($ruleproductId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d rule products were successfully updated.', count($ruleproductIds)));
            }
            catch (Mage_Core_Exception $e){
                $this->_getSession()->addError($e->getMessage());
            }
            catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('easylife_ruleproducts')->__('There was an error updating rule products.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * grid action
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    public function gridAction(){
        $this->loadLayout();
        $this->renderLayout();
    }
    /**
     * restrict access
     * @access protected
     * @return bool
     * @see Mage_Adminhtml_Controller_Action::_isAllowed()
     * @author Marius Strajeru
     */
     protected function _isAllowed(){
        return Mage::getSingleton('admin/session')->isAllowed('catalog/easylife_ruleproducts');
    }
    /**
     * Export ruleproducts in CSV format
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    public function exportCsvAction(){
        $fileName   = 'ruleproducts.csv';
        $content    = $this->getLayout()->createBlock('easylife_ruleproducts/adminhtml_ruleproduct_grid')
            ->getCsvFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Export ruleproducts in Excel format
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    public function exportExcelAction(){
        $fileName   = 'ruleproduct.xls';
        $content    = $this->getLayout()->createBlock('easylife_ruleproducts/adminhtml_ruleproduct_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * Export ruleproducts in XML format
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    public function exportXmlAction(){
        $fileName   = 'ruleproduct.xml';
        $content    = $this->getLayout()->createBlock('easylife_ruleproducts/adminhtml_ruleproduct_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * wysiwyg editor action
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    public function wysiwygAction() {
        $elementId = $this->getRequest()->getParam('element_id', md5(microtime()));
        $storeId = $this->getRequest()->getParam('store_id', 0);
        $storeMediaUrl = Mage::app()->getStore($storeId)->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);

        $content = $this->getLayout()->createBlock('easylife_ruleproducts/adminhtml_ruleproducts_helper_form_wysiwyg_content', '', array(
            'editor_element_id' => $elementId,
            'store_id'          => $storeId,
            'store_media_url'   => $storeMediaUrl,
        ));
        $this->getResponse()->setBody($content->toHtml());
    }
    /**
     * mass Include in main menu change
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    public function massIncludeInMenuAction(){
        $ruleproductIds = (array)$this->getRequest()->getParam('ruleproduct');
        $storeId    = (int)$this->getRequest()->getParam('store', 0);
        $flag     = (int)$this->getRequest()->getParam('flag_include_in_menu');
        if ($flag == 2){
            $flag = 0;
        }
        try {
            foreach ($ruleproductIds as $ruleproductId) {
                $ruleproduct = Mage::getSingleton('easylife_ruleproducts/ruleproduct')->setStoreId($storeId)->load($ruleproductId);
                $ruleproduct->setIncludeInMenu($flag)->save();
            }
            $this->_getSession()->addSuccess(
                Mage::helper('easylife_ruleproducts')->__('Total of %d record(s) have been updated.', count($ruleproductIds))
            );
        }
        catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
        catch (Exception $e) {
            $this->_getSession()->addException($e, Mage::helper('easylife_ruleproducts')->__('An error occurred while updating the rule products.'));
        }

        $this->_redirect('*/*/', array('store'=> $storeId));
    }
    public function newConditionHtmlAction() {
        $id = $this->getRequest()->getParam('id');
        $typeArr = explode('|', str_replace('-', '/', $this->getRequest()->getParam('type')));
        $type = $typeArr[0];

        $model = Mage::getModel($type)
            ->setId($id)
            ->setType($type)
            ->setRule(Mage::getModel('catalogrule/rule'))
            ->setPrefix('conditions');
        if (!empty($typeArr[1])) {
            $model->setAttribute($typeArr[1]);
        }

        if ($model instanceof Mage_Rule_Model_Condition_Abstract) {
            $model->setJsFormObject($this->getRequest()->getParam('form'));
            $html = $model->asHtmlRecursive();
        } else {
            $html = '';
        }
        $this->getResponse()->setBody($html);
    }
}
