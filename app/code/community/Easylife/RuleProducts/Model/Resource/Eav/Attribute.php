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
 * Attribute resource model
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Model_Resource_Eav_Attribute
    extends Mage_Eav_Model_Entity_Attribute {
    const MODULE_NAME   = 'Easylife_RuleProducts';
    const ENTITY        = 'easylife_ruleproducts_eav_attribute';

    protected $_eventPrefix = 'easylife_ruleproducts_entity_attribute';
    protected $_eventObject = 'attribute';

    /**
     * Array with labels
     * @var array
     */
    static protected $_labels = null;
    /**
     * constructor
     * @access protected
     * @return void
     * @author Marius Strajeru
     */
    protected function _construct() {
        $this->_init('easylife_ruleproducts/attribute');
    }
    /**
     * check if scope is store view
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    public function isScopeStore() {
        return $this->getIsGlobal() == Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE;
    }
    /**
     * check if scope is website
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    public function isScopeWebsite() {
        return $this->getIsGlobal() == Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE;
    }
    /**
     * check if scope is global
     * @access public
     * @return void
     * @author Marius Strajeru
     */
    public function isScopeGlobal() {
        return (!$this->isScopeStore() && !$this->isScopeWebsite());
    }
    /**
     * get backend input type
     * @access public
     * @param string $type
     * @return string
     * @author Marius Strajeru
     */
    public function getBackendTypeByInput($type) {
        switch ($type){
            case 'file':
                //intentional fallthrough
            case 'image':
                return 'varchar';
                break;
            default:
                return parent::getBackendTypeByInput($type);
            break;
        }
    }
    /**
     * @access protected
     * @return Mage_Core_Model_Abstract
     * @throws Mage_Core_Exception
     * @author Marius Strajeru
     */
    protected function _beforeDelete(){
        if (!$this->getIsUserDefined()){
            throw new Mage_Core_Exception(Mage::helper('easylife_ruleproducts')->__('This attribute is not deletable'));
        }
        return parent::_beforeDelete();
    }
}
