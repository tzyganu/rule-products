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
 * Rule Product model
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
/**
 * @method int getStoreId ()
 * @method Easylife_RuleProducts_Model_Ruleproduct setStoreId()
 * @method Easylife_RuleProducts_Model_Ruleproduct setTitle()
 * @method Easylife_RuleProducts_Model_Ruleproduct setMetaTitle()
 * @method Easylife_RuleProducts_Model_Ruleproduct setDescription()
 * @method string getTitle()
 * @method Easylife_RuleProducts_Model_Ruleproduct setAttributeSetId
 * @method Easylife_RuleProducts_Model_Ruleproduct setStatus()
 * @method bool hasConditionsSerialized()
 * @method Easylife_RuleProducts_Model_Ruleproduct setCreatedAt()
 * @method Easylife_RuleProducts_Model_Ruleproduct setUpdatedAt()
 * @method Easylife_RuleProducts_Model_Ruleproduct setConditionsSerialized()
 * @method string getConditionsSerialized()
 * @method Easylife_RuleProducts_Model_Ruleproduct unsConditions()
 * @method Easylife_RuleProducts_Model_Ruleproduct unsConditionsSerialized()
 * @method string getUrlKey()
 * @method Easylife_RuleProducts_Model_Ruleproduct setCollectedAttributes()
 * @method array getCollectedAttributes()
 * @method int getResizeX()
 * @method int getResizeY()
 * @method string getImage()
 */
class Easylife_RuleProducts_Model_Ruleproduct
    extends Mage_Catalog_Model_Abstract {
    /**
     * @var array
     */
    protected $_productIds = null;
    /**
     * @var null|bool
     */
    protected $_productsFilter;
    /**
     * @var Mage_Catalog_Model_Resource_Product_Collection
     */
    protected $_productCollection;
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'easylife_ruleproducts_ruleproduct';
    const CACHE_TAG = 'easylife_ruleproducts_ruleproduct';
    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'easylife_ruleproducts_ruleproduct';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'ruleproduct';
    /**
     * Store rule combine conditions model
     *
     * @var Mage_Rule_Model_Condition_Combine
     */
    protected $_conditions;
    /**
     * Store rule form instance
     *
     * @var Varien_Data_Form
     */
    protected $_form;
    /**
     * constructor
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    public function _construct(){
        parent::_construct();
        $this->_init('easylife_ruleproducts/ruleproduct');
    }
    /**
     * before save rule product
     * @access protected
     * @return Easylife_RuleProducts_Model_Ruleproduct
     * @author Marius Strajeru
     */
    protected function _beforeSave(){
        parent::_beforeSave();
        /** @var Mage_Core_Model_Date $dateModel */
        $dateModel = Mage::getSingleton('core/date');
        $now = $dateModel->gmtDate();
        if ($this->isObjectNew()){
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        if ($this->getConditions()) {
            $this->setConditionsSerialized(serialize($this->getConditions()->asArray()));
            $this->unsConditions();
        }
        return $this;
    }

    /**
     * @access public
     * @return Easylife_RuleProducts_Model_Resource_Ruleproduct
     * @author Marius Strajeru
     */
    public function getResource() {
        return parent::getResource();
    }
    /**
     * clean rule after save
     * @access protected
     * @return Easylife_RuleProducts_Model_Ruleproduct
     * @author Marius Strajeru
     */
    public function _afterSave() {
        if (!$this->getStoreId()) {
            $this->getResource()->clearProductIds($this);
        }
        return parent::_afterSave();
    }
    /**
     * get the url to the rule product details page
     * @access public
     * @return string
     * @author Marius Strajeru
     */
    public function getRuleproductUrl(){
        if ($this->getUrlKey()){
            $urlKey = '';
            if ($prefix = Mage::getStoreConfig('easylife_ruleproducts/ruleproduct/url_prefix')){
                $urlKey .= $prefix.'/';
            }
            $urlKey .= $this->getUrlKey();
            if ($suffix = Mage::getStoreConfig('easylife_ruleproducts/ruleproduct/url_suffix')){
                $urlKey .= '.'.$suffix;
            }
            return Mage::getUrl('', array('_direct'=>$urlKey));
        }
        return Mage::getUrl('easylife_ruleproducts/ruleproduct/view', array('id'=>$this->getId()));
    }
    /**
     * check URL key
     * @access public
     * @param string $urlKey
     * @param bool $active
     * @return mixed
     * @author Marius Strajeru
     */
    public function checkUrlKey($urlKey, $active = true){
        return $this->getResource()->checkUrlKey($urlKey, $active);
    }

    /**
     * get the rule product Description
     * @access public
     * @return string
     * @author Marius Strajeru
     */
    public function getDescription(){
        $description = $this->getData('description');
        /** @var Mage_Cms_Helper_Data $helper */
        $helper = Mage::helper('cms');
        $processor = $helper->getBlockTemplateProcessor();
        $html = $processor->filter($description);
        return $html;
    }
    /**
     * Retrieve default attribute set id
     * @access public
     * @return int
     * @author Marius Strajeru
     */
    public function getDefaultAttributeSetId() {
        return $this->getResource()->getEntityType()->getDefaultAttributeSetId();
    }
    /**
     * get attribute text value
     * @access public
     * @param $attributeCode
     * @return string
     * @author Marius Strajeru
     */
    public function getAttributeText($attributeCode) {
        $text = $this->getResource()
            ->getAttribute($attributeCode)
            ->getSource()
            ->getOptionText($this->getData($attributeCode));
        if (is_array($text)){
            return implode(', ',$text);
        }
        return $text;
    }
    /**
     * get default values
     * @access public
     * @return array
     * @author Marius Strajeru
     */
    public function getDefaultValues() {
        $values = array();
        $values['status'] = 1;
        return $values;
    }

    /**
     * @access public
     * @return bool|Mage_CatalogRule_Model_Rule_Condition_Combine
     * @author Marius Strajeru
     */
    public function getConditionsInstance() {
        return Mage::getModel('catalogrule/rule_condition_combine');
    }
    /**
     * Set rule combine conditions model
     * @access public
     * @param Mage_Rule_Model_Condition_Combine $conditions
     * @return Easylife_RuleProducts_Model_Ruleproduct
     * @author Marius Strajeru
     */
    public function setConditions($conditions) {
        $this->_conditions = $conditions;
        return $this;
    }

    /**
     * Retrieve rule combine conditions model
     * @access public
     * @return Mage_Rule_Model_Condition_Combine
     * @author Marius Strajeru
     */
    public function getConditions() {
        if (empty($this->_conditions)) {
            $this->_resetConditions();
        }
        // Load rule conditions if it is applicable
        if ($this->hasConditionsSerialized()) {
            $conditions = $this->getConditionsSerialized();
            if (!empty($conditions)) {
                $conditions = unserialize($conditions);
                if (is_array($conditions) && !empty($conditions)) {
                    $this->_conditions->loadArray($conditions);
                }
            }
            $this->unsConditionsSerialized();
        }

        return $this->_conditions;
    }
    /**
     * Reset rule combine conditions
     * @access protected
     * @param null|Mage_Rule_Model_Condition_Combine $conditions
     * @return Easylife_RuleProducts_Model_Ruleproduct
     * @author Marius Strajeru
     */
    protected function _resetConditions($conditions = null) {
        if (is_null($conditions)) {
            $conditions = $this->getConditionsInstance();
        }
        $conditions->setRule($this)->setId('1')->setPrefix('conditions');
        $this->setConditions($conditions);

        return $this;
    }
    /**
     * Rule form getter
     * @access public
     * @return Varien_Data_Form
     * @author Marius Strajeru
     */
    public function getForm() {
        if (!$this->_form) {
            $this->_form = new Varien_Data_Form();
        }
        return $this->_form;
    }
    /**
     * Initialize rule model data from array
     * @access public
     * @param array $data
     * @return Easylife_RuleProducts_Model_Ruleproduct
     * @author Marius Strajeru
     */
    public function loadPost(array $data) {
        $arr = $this->_convertFlatToRecursive($data);
        if (isset($arr['conditions'])) {
            $this->getConditions()->setConditions(array())->loadArray($arr['conditions'][1]);
        }
        return $this;
    }

    /**
     * Set specified data to current rule.
     * Set conditions and actions recursively.
     * @access protected
     * @param array $data
     * @return array
     * @author Marius Strajeru
     */
    protected function _convertFlatToRecursive(array $data) {
        $arr = array();
        foreach ($data as $key => $value) {
            if (($key === 'conditions') && is_array($value)) {
                foreach ($value as $id=>$data) {
                    $path = explode('--', $id);
                    $node =& $arr;
                    for ($i=0, $l=sizeof($path); $i<$l; $i++) {
                        if (!isset($node[$key][$path[$i]])) {
                            $node[$key][$path[$i]] = array();
                        }
                        $node =& $node[$key][$path[$i]];
                    }
                    foreach ($data as $k => $v) {
                        $node[$k] = $v;
                    }
                }
            } else {
                $this->setData($key, $value);
            }
        }
        return $arr;
    }

    /**
     * Validate rule conditions to determine if rule can run
     * @access public
     * @param Varien_Object $object
     * @return bool
     * @author Marius Strajeru
     */
    public function validate(Varien_Object $object) {
        return $this->getConditions()->validate($object);
    }

    /**
     * Validate rule data
     * @access public
     * @param Varien_Object $object
     * @return bool
     * @author Marius Strajeru
     */
    public function validateData(Varien_Object $object) {
        return true;
    }

    /**
     * get matching product collection
     * @access public
     * @return Mage_Catalog_Model_Resource_Product_Collection
     * @author Marius Strajeru
     */
    public function getProductCollection() {
        if (is_null($this->_productCollection)) {
            $productIds = $this->getMatchingProductIds();
            $productCollection = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToFilter('entity_id', array('in'=>$productIds));
            $this->_productCollection = $productCollection;
        }
        return $this->_productCollection;
    }

    /**
     * get matching product ids
     * @access public
     * @param bool $force
     * @return array
     * @author Marius Strajeru
     */
    public function getMatchingProductIds($force = false) {
        if (is_null($this->_productIds)) {
            $productIds = array();
            if (!$force) {
                $productIds = $this->getResource()->getCachedProductIds($this);
            }
            if (count($productIds)) {
                $this->_productIds = $productIds;
            }
            else {
                $this->_productIds = array();
                $this->setCollectedAttributes(array());
                /** @var $productCollection Mage_Catalog_Model_Resource_Product_Collection */
                $productCollection = Mage::getModel('catalog/product')->getCollection();
                //$productCollection->addWebsiteFilter($this->getWebsiteIds());
                if ($this->_productsFilter) {
                    $productCollection->addIdFilter($this->_productsFilter);
                }
                $this->getConditions()->collectValidatedAttributes($productCollection);

                Mage::getSingleton('core/resource_iterator')->walk(
                    $productCollection->getSelect(),
                    array(array($this, 'callbackValidateProduct')),
                    array(
                        'attributes' => $this->getCollectedAttributes(),
                        'product'    => Mage::getModel('catalog/product'),
                    )
                );
                $this->getResource()->setCachedProductIds($this, $this->_productIds);
            }
        }

        return $this->_productIds;
    }

    /**
     * callback for product validation
     * @access public
     * @param array $args
     * @author Marius Strajeru
     */
    public function callbackValidateProduct($args) {
        /** @var Mage_Catalog_Model_Product $product */
        $product = clone $args['product'];
        $product->setData($args['row']);
        if ($this->getConditions()->validate($product)) {
            $this->_productIds[] = $product->getId();
        }
    }

    /**
     * apply rule to product
     * @access public
     * @author Marius Strajeru
     * @param int|Mage_Catalog_Model_Product $product
     * @return $this
     */
    public function applyToProduct($product) {
        if (is_numeric($product)) {
            $product = Mage::getModel('catalog/product')->load($product);
        }
        $this->getResource()->applyToProduct($this, $product);
        return $this;
    }

    /**
     * get available sort options
     * @access public
     * @return array
     * @author Marius Strajeru
     */
    public function getAvailableSortByOptions() {
        $availableSortBy = array();
        $defaultSortBy   = Mage::getSingleton('catalog/config')
            ->getAttributeUsedForSortByArray();
        if ($this->getAvailableSortBy()) {
            foreach ($this->getAvailableSortBy() as $sortBy) {
                if (isset($defaultSortBy[$sortBy])) {
                    $availableSortBy[$sortBy] = $defaultSortBy[$sortBy];
                }
            }
        }

        if (!$availableSortBy) {
            $availableSortBy = $defaultSortBy;
        }

        return $availableSortBy;
    }
    /**
     * Retrieve Product Listing Default Sort By
     * @access public
     * @return string
     * @author Marius Strajeru
     */
    public function getDefaultSortBy() {
        if (!$sortBy = $this->getData('default_sort_by')) {
            $sortBy = Mage::getSingleton('catalog/config')
                ->getProductListDefaultSortBy($this->getStoreId());
        }
        $available = $this->getAvailableSortByOptions();
        if (!isset($available[$sortBy])) {
            $sortBy = array_keys($available);
            $sortBy = $sortBy[0];
        }
        return $sortBy;
    }
}
