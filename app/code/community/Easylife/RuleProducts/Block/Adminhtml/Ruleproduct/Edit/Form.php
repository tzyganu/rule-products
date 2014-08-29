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
 * Rule Product edit form
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */

class Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * prepare form
     * @access protected
     * @return Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Edit_Form
     * @author Marius Strajeru
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form(array(
            'id'         => 'edit_form',
            'action'     => $this->getUrl('*/*/save', array(
                'id' => $this->getRequest()->getParam('id'),
                'store' => $this->getRequest()->getParam('store'))
            ),
            'method'     => 'post',
            'enctype'    => 'multipart/form-data'
        ));
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
