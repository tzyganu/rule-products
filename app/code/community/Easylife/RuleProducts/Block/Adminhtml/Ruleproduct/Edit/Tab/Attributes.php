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
 * Ruleproduct admin edit tab attributes block
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
*/
/**
 * @method Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Edit_Tab_Attributes setAttributes()
 * @method getAttributes()
 */
class Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Edit_Tab_Attributes
    extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * prepare the attributes for the form
     * @access protected
     * @return void
     * @see Mage_Adminhtml_Block_Widget_Form::_prepareForm()
     * @author Marius Strajeru
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $form->setDataObject(Mage::registry('current_ruleproduct'));
        $fieldset = $form->addFieldset('info',
            array(
                'legend'=>Mage::helper('easylife_ruleproducts')->__('Products Rule Information'),
                 'class'=>'fieldset-wide',
            )
        );
        $attributes = $this->getAttributes();
        foreach ($attributes as $attribute){
            /** @var Easylife_RuleProducts_Model_Resource_Ruleproduct $entity */
            $entity = Mage::getResourceModel('easylife_ruleproducts/ruleproduct');
            /** @var Mage_Eav_Model_Entity_Attribute $attribute */
            $attribute->setEntity($entity);
        }
        $this->_setFieldset($attributes, $fieldset, array());
        $formValues = Mage::registry('current_ruleproduct')->getData();
        if (!Mage::registry('current_ruleproduct')->getId()) {
            foreach ($attributes as $attribute) {
                if (!isset($formValues[$attribute->getAttributeCode()])) {
                    $formValues[$attribute->getAttributeCode()] = $attribute->getDefaultValue();
                }
            }
        }
        $form->addValues($formValues);
        $form->setFieldNameSuffix('ruleproduct');
        $this->setForm($form);
    }
    /**
     * prepare layout
     * @access protected
     * @return void
     * @see Mage_Adminhtml_Block_Widget_Form::_prepareLayout()
     * @author Marius Strajeru
     */
    protected function _prepareLayout() {
        /** @var Mage_Adminhtml_Block_Widget_Form_Renderer_Element $elementRenderer */
        $elementRenderer = $this->getLayout()->createBlock('adminhtml/widget_form_renderer_element');
        Varien_Data_Form::setElementRenderer($elementRenderer);

        /** @var Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset $fieldsetRenderer */
        $fieldsetRenderer = $this->getLayout()->createBlock('adminhtml/widget_form_renderer_fieldset');
        Varien_Data_Form::setFieldsetRenderer($fieldsetRenderer);

        /** @var Easylife_RuleProducts_Block_Adminhtml_Ruleproducts_Renderer_Fieldset_Element $fieldsetElementRenderer */
        $fieldsetElementRenderer = $this->getLayout()->createBlock('easylife_ruleproducts/adminhtml_ruleproducts_renderer_fieldset_element');
        Varien_Data_Form::setFieldsetElementRenderer($fieldsetElementRenderer);
    }
    /**
     * get the additional element types for form
     * @access protected
     * @return array()
     * @see Mage_Adminhtml_Block_Widget_Form::_getAdditionalElementTypes()
     * @author Marius Strajeru
     */
    protected function _getAdditionalElementTypes(){
        return array(
            'file'    => Mage::getConfig()->getBlockClassName('easylife_ruleproducts/adminhtml_ruleproduct_helper_file'),
            'image' => Mage::getConfig()->getBlockClassName('easylife_ruleproducts/adminhtml_ruleproduct_helper_image'),
            'textarea' => Mage::getConfig()->getBlockClassName('adminhtml/catalog_helper_form_wysiwyg')
        );
    }
    /**
     * get current entity
     * @access protected
     * @return Easylife_RuleProducts_Model_Ruleproduct
     * @author Marius Strajeru
     */
    public function getRuleproduct() {
        return Mage::registry('current_ruleproduct');
    }

}
