<?php
/**
 * Easylife_RuleProduct extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE_RULE_COLLECTION.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category       Easylife
 * @package        Easylife_RuleProduct
 * @copyright      Copyright (c) 2014
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Product Rules edit conditions
 *
 * @category    Easylife
 * @package     Easylife_RuleProduct
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Edit_Tab_Conditions
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Prepare content for tab
     * @access public
     * @return string
     * @author Marius Strajeru
     */
    public function getTabLabel() {
        return Mage::helper('easylife_ruleproducts')->__('Conditions');
    }

    /**
     * Prepare title for tab
     * @access public
     * @return string
     * @author Marius Strajeru
     */
    public function getTabTitle() {
        return Mage::helper('easylife_ruleproducts')->__('Conditions');
    }

    /**
     * Returns status flag about this tab can be shown or not
     * @access public
     * @return bool
     * @author Marius Strajeru
     */
    public function canShowTab() {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     * @access public
     * @return bool
     * @author Marius Strajeru
     */
    public function isHidden() {
        return false;
    }

    /**
     * prepare the form
     * @access protected
     * @return Mage_Adminhtml_Block_Widget_Form
     * @author Marius Strajeru
     */
    protected function _prepareForm() {
        /** @var Easylife_RuleProducts_Model_Ruleproduct $model */
        $model = Mage::registry('current_ruleproduct');
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('rule_');
        $form->setFieldNameSuffix('rule');
        $renderer = Mage::getBlockSingleton('adminhtml/widget_form_renderer_fieldset')
            ->setTemplate('easylife_ruleproducts/fieldset.phtml')
            ->setNewChildUrl($this->getUrl('*/*/newConditionHtml/form/rule_conditions_fieldset'));
        $fieldset = $form->addFieldset('conditions_fieldset', array(
            'legend'=>Mage::helper('easylife_ruleproducts')->__('Conditions (leave blank for all products)'))
        )->setRenderer($renderer);
        $fieldset->addField('conditions', 'text', array(
            'name' => 'conditions',
            'label' => Mage::helper('easylife_ruleproducts')->__('Conditions'),
            'title' => Mage::helper('easylife_ruleproducts')->__('Conditions'),
            'required' => true,
        ))->setRule($model)->setRenderer(Mage::getBlockSingleton('rule/conditions'));
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
