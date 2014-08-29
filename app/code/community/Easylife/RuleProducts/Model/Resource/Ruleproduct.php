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
 * Rule Product resource model
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Model_Resource_Ruleproduct
    extends Mage_Catalog_Model_Resource_Abstract {
    /**
     * cached product tables
     * @var string
     */
    protected $_cachedProductsTable = 'easylife_ruleproducts/ruleproduct_product';
    /**
     * constructor
     * @access public
     * @author Marius Strajeru
     */
    public function __construct() {
        $resource = Mage::getSingleton('core/resource');
        $this->setType('easylife_ruleproducts_ruleproduct')
            ->setConnection(
                $resource->getConnection('ruleproduct_read'),
                $resource->getConnection('ruleproduct_write')
            );

    }
    /**
     * wrapper for main table getter
     * @access public
     * @return string
     * @author Marius Strajeru
     */
    public function getMainTable() {
        return $this->getEntityTable();
    }

    /**
     * @param $urlKey
     * @param $storeId
     * @param bool $active
     * @return bool|string
     * @author Marius Strajeru
     */
    public function checkUrlKey($urlKey, $storeId, $active = true){
        $stores = array(Mage_Core_Model_App::ADMIN_STORE_ID, $storeId);
        $select = $this->_initCheckUrlKeySelect($urlKey, $stores);
        if (!$select){
            return false;
        }
        $select->reset(Zend_Db_Select::COLUMNS)
            ->columns('e.entity_id')
            ->limit(1);
        return $this->_getReadAdapter()->fetchOne($select);
    }
    /**
     * init the check select
     * @access protected
     * @param string $urlKey
     * @param array $store
     * @return Zend_Db_Select
     * @author Marius Strajeru
     */
    protected function _initCheckUrlKeySelect($urlKey, $store){
        $urlRewrite = Mage::getModel('eav/config')->getAttribute('easylife_ruleproducts_ruleproduct', 'url_key');
        if (!$urlRewrite || !$urlRewrite->getId()){
            return false;
        }
        $table = $urlRewrite->getBackend()->getTable();
        $select = $this->_getReadAdapter()->select()
            ->from(array('e' => $table))
            ->where('e.attribute_id = ?', $urlRewrite->getId())
            ->where('e.value = ?', $urlKey)
            ->where('e.store_id IN (?)', $store)
            ->order('e.store_id DESC');
        return $select;
    }
    /**
     * Check for unique URL key
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return bool
     * @author Marius Strajeru
     */
    public function getIsUniqueUrlKey(Mage_Core_Model_Abstract $object){
        if (Mage::app()->isSingleStoreMode() || !$object->hasStores()) {
            $stores = array(Mage_Core_Model_App::ADMIN_STORE_ID);
        }
        else {
            $stores = (array)$object->getData('stores');
        }
        $select = $this->_initCheckUrlKeySelect($object->getData('url_key'), $stores);
        if ($object->getId()) {
            $select->where('e.entity_id <> ?', $object->getId());
        }
        if ($this->_getWriteAdapter()->fetchRow($select)) {
            return false;
        }
        return true;
    }
    /**
     * Check if the URL key is numeric
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return bool
     * @author Marius Strajeru
     */
    protected function isNumericUrlKey(Mage_Core_Model_Abstract $object){
        return preg_match('/^[0-9]+$/', $object->getData('url_key'));
    }
    /**
     * Checkif the URL key is valid
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return bool
     * @author Marius Strajeru
     */
    protected function isValidUrlKey(Mage_Core_Model_Abstract $object){
        return preg_match('/^[a-z0-9][a-z0-9_\/-]+(\.[a-z0-9_-]+)?$/', $object->getData('url_key'));
    }

    /**
     * get cached product ids
     * @access public
     * @param Easylife_RuleProducts_Model_Ruleproduct $rule
     * @return array
     * @author Marius Strajeru
     */
    public function getCachedProductIds(Easylife_RuleProducts_Model_Ruleproduct $rule) {
        /** @var Zend_Db_Select $select */
        $select = $this->_getReadAdapter()->select()
            ->from(array('e' => $this->getTable($this->_cachedProductsTable)), 'product_id')
            ->where('e.rule_id = ?', $rule->getId());
        $result = $this->_getReadAdapter()->fetchAssoc($select);
        return array_keys($result);
    }
    /**
     * set cached product ids
     * @access public
     * @param Easylife_RuleProducts_Model_Ruleproduct $rule
     * @param array $ids
     * @return $this
     * @author Marius Strajeru
     */
    public function setCachedProductIds(Easylife_RuleProducts_Model_Ruleproduct $rule, $ids){
        $values = array();
        foreach ($ids as $id) {
            $values[] = array(
                'rule_id'=>$rule->getId(),
                'product_id'=>$id
            );
        }
        $write = $this->_getWriteAdapter();
        $write->insertOnDuplicate(
            $this->getTable($this->_cachedProductsTable),
            $values,
            array('product_id')
        );
        return $this;
    }

    /**
     * @access public
     * @param Easylife_RuleProducts_Model_Ruleproduct $rule
     * @return $this
     * @author Marius Strajeru
     */
    public function clearProductIds(Easylife_RuleProducts_Model_Ruleproduct $rule) {
        $write = $this->_getWriteAdapter();
        $write->delete($this->getTable($this->_cachedProductsTable), array('rule_id = ?' => $rule->getId()));
        return $this;
    }

    /**
     * @param $rule
     * @param Mage_Catalog_Model_Product $product
     * @return $this
     * @author Marius Strajeru
     */
    public function applyToProduct(Easylife_RuleProducts_Model_Ruleproduct $rule, Mage_Catalog_Model_Product $product) {
        if (!$rule->getStatus()) {
            return $this;
        }
        $ruleId    = $rule->getId();
        $productId = $product->getId();
        $write = $this->_getWriteAdapter();
        $write->beginTransaction();
        if (!$rule->getConditions()->validate($product)) {
            $write->delete($this->getTable($this->_cachedProductsTable), array(
                $write->quoteInto('rule_id=?', $ruleId),
                $write->quoteInto('product_id=?', $productId),
            ));
        }
        else {
            $values = array(
                'rule_id'=>$rule->getId(),
                'product_id'=>$productId
            );
            $write->insertOnDuplicate(
                $this->getTable($this->_cachedProductsTable),
                $values,
                array('product_id')
            );
        }
        $write->commit();
        return $this;
    }
}
