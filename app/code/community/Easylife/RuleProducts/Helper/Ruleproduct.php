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
 * Rule Product helper
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Helper_Ruleproduct
    extends Mage_Core_Helper_Abstract {
    /**
     * check if breadcrumbs can be used
     * @access public
     * @return bool
     * @author Marius Strajeru
     */
    public function getUseBreadcrumbs(){
        return Mage::getStoreConfigFlag('easylife_ruleproducts/ruleproduct/breadcrumbs');
    }
    /**
     * get base files dir
     * @access public
     * @return string
     * @author Marius Strajeru
     */
    public function getFileBaseDir(){
        return Mage::getBaseDir('media').DS.'ruleproduct'.DS.'file';
    }
    /**
     * get base file url
     * @access public
     * @return string
     * @author Marius Strajeru
     */
    public function getFileBaseUrl(){
        return Mage::getBaseUrl('media').'ruleproduct'.'/'.'file';
    }
    /**
	 * get ruleproduct attribute source model
	 * @access public
	 * @param string $inputType
	 * @return mixed (string|null)
	 * @author Marius Strajeru
	 */
 	public function getAttributeSourceModelByInputType($inputType){
        $inputTypes = $this->getAttributeInputTypes();
        if (!empty($inputTypes[$inputType]['source_model'])) {
            return $inputTypes[$inputType]['source_model'];
        }
        return null;
    }
    /**
	 * get attribute input types
	 * @access public
	 * @param string $inputType
	 * @return array()
	 * @author Marius Strajeru
	 */
	public function getAttributeInputTypes($inputType = null){
        $inputTypes = array(
            'multiselect'   => array(
                'backend_model'     => 'eav/entity_attribute_backend_array'
            ),
            'boolean'       => array(
                'source_model'      => 'eav/entity_attribute_source_boolean'
            ),
            'file'			=> array(
            	'backend_model'		=> 'easylife_ruleproducts/ruleproduct_attribute_backend_file'
            ),
            'image'			=> array(
            	'backend_model'		=> 'easylife_ruleproducts/ruleproduct_attribute_backend_image'
            ),
        );

        if (is_null($inputType)) {
            return $inputTypes;
        } else if (isset($inputTypes[$inputType])) {
            return $inputTypes[$inputType];
        }
        return array();
    }
    /**
	 * get ruleproduct attribute backend model
	 * @access public
	 * @param string $inputType
	 * @return mixed (string|null)
	 * @author Marius Strajeru
	 */
 	public function getAttributeBackendModelByInputType($inputType){
        $inputTypes = $this->getAttributeInputTypes();
        if (!empty($inputTypes[$inputType]['backend_model'])) {
            return $inputTypes[$inputType]['backend_model'];
        }
        return null;
    }
    /**
     * filter attribute content
     * @access public
     * @param Easylife_RuleProducts_Model_Ruleproduct $ruleproduct
     * @param string $attributeHtml
     * @param string @attributeName
     * @return string
     * @author Marius Strajeru
     */
	public function ruleproductAttribute($ruleproduct, $attributeHtml, $attributeName){
        $attribute = Mage::getSingleton('eav/config')->getAttribute(Easylife_RuleProducts_Model_Ruleproduct::ENTITY, $attributeName);
        if ($attribute && $attribute->getId() && !$attribute->getIsWysiwygEnabled()) {
			if ($attribute->getFrontendInput() == 'textarea') {
            	$attributeHtml = nl2br($attributeHtml);
            }
        }
        if ($attribute->getIsWysiwygEnabled()) {
            $attributeHtml = $this->_getTemplateProcessor()->filter($attributeHtml);
        }
        return $attributeHtml;
    }
    /**
     * get the template processor
     * @access protected
     * @return Mage_Catalog_Model_Template_Filter
     * @author Marius Strajeru
     */
	protected function _getTemplateProcessor(){
        if (null === $this->_templateProcessor) {
            $this->_templateProcessor = Mage::helper('catalog')->getPageTemplateProcessor();
        }
        return $this->_templateProcessor;
    }
}
