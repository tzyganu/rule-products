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
 * fieldset element renderer
 * @category   Easylife
 * @package    Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Block_Adminhtml_RuleProducts_Renderer_Fieldset_Element
    extends Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset_Element {
    /**
     * Initialize block template
     * @access protected
     * @author Marius Strajeru
     */
    protected function _construct() {
        $this->setTemplate('easylife_ruleproducts/form/renderer/fieldset/element.phtml');
    }

    /**
     * Retrieve data object related with form
     * @access public
     * @return mixed
     * @author Marius Strajeru
     */
    public function getDataObject() {
        return $this->getElement()->getForm()->getDataObject();
    }

    /**
     * Retrieve associated with element attribute object
     * @access public
     * @return Easylife_RuleProducts_Model_Resource_Eav_Attribute
     * @author Marius Strajeru
     */
    public function getAttribute() {
        return $this->getElement()->getEntityAttribute();
    }

    /**
     * Retrieve associated attribute code
     * @access public
     * @return string
     * @author Marius Strajeru
     */
    public function getAttributeCode(){
        return $this->getAttribute()->getAttributeCode();
    }

    /**
     * Check "Use default" checkbox display availability
     * @access public
     * @return bool
     * @author Marius Strajeru
     */
    public function canDisplayUseDefault(){
        if ($attribute = $this->getAttribute()) {
            if (!$this->isScopeGlobal($attribute)
                && $this->getDataObject()
                && $this->getDataObject()->getId()
                && $this->getDataObject()->getStoreId()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check default value usage fact
     * @access public
     * @return bool
     * @author Marius Strajeru
     */
    public function usedDefault(){
        $defaultValue = $this->getDataObject()->getAttributeDefaultValue($this->getAttribute()->getAttributeCode());
        return !$defaultValue;
    }

    /**
     * Disable field in default value using case
     * @access public
     * @return Easylife_RuleProducts_Block_Adminhtml_RuleProducts_Renderer_Fieldset_Element
     * @author Marius Strajeru
     */
    public function checkFieldDisable(){
        if ($this->canDisplayUseDefault() && $this->usedDefault()) {
            $this->getElement()->setDisabled(true);
        }
        return $this;
    }

    /**
     * Retrieve label of attribute scope
     * GLOBAL | WEBSITE | STORE
     * @access public
     * @return string
     * @author Marius Strajeru
     */
    public function getScopeLabel(){
        $html = '';
        $attribute = $this->getElement()->getEntityAttribute();
        if (!$attribute || Mage::app()->isSingleStoreMode()) {
            return $html;
        }
        if ($this->isScopeGlobal($attribute)) {
            $html.= Mage::helper('easylife_ruleproducts')->__('[GLOBAL]');
        }
        elseif ($this->isScopeWebsite($attribute)) {
            $html.= Mage::helper('easylife_ruleproducts')->__('[WEBSITE]');
        }
        elseif ($this->isScopeStore($attribute)) {
            $html.= Mage::helper('easylife_ruleproducts')->__('[STORE VIEW]');
        }
        return $html;
    }

    /**
     * Retrieve element label html
     * @access public
     * @return string
     * @author Marius Strajeru
     */
    public function getElementLabelHtml(){
        return $this->getElement()->getLabelHtml();
    }

    /**
     * Retrieve element html
     * @access public
     * @return string
     * @author Marius Strajeru
     */
    public function getElementHtml(){
        return $this->getElement()->getElementHtml();
    }
    /**
     * check if an attribute is global
     * @access public
     * @param Mage_Eav_Model_Entity_Attribute $attribute
     * @return bool
     * @author Marius Strajeru
     */
    public function isScopeGlobal($attribute){
        return $attribute->getIsGlobal() == 1;
    }
    /**
     * check if an attribute has website scope
     * @access public
     * @param Mage_Eav_Model_Entity_Attribute $attribute
     * @return bool
     * @author Marius Strajeru
     */
    public function isScopeWebsite($attribute){
        return $attribute->getIsGlobal() == 2;
    }
    /**
     * check if an attribute has store view scope
     * @access public
     * @param Mage_Eav_Model_Entity_Attribute $attribute
     * @return bool
     * @author Marius Strajeru
     */
    public function isScopeStore($attribute){
        return !$this->isScopeGlobal($attribute) && !$this->isScopeWebsite($attribute);
    }
}
