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
 * layer view block
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Block_Layer_View extends Mage_Catalog_Block_Layer_View {
    /**
     * init blocks
     * @access protected
     * @author Marius Strajeru
     */
    protected function _initBlocks() {
        parent::_initBlocks();
        $this->_stateBlockName              = 'easylife_ruleproducts/layer_state';
        $this->_categoryBlockName           = 'easylife_ruleproducts/layer_filter_category';
        $this->_attributeFilterBlockName    = 'easylife_ruleproducts/layer_filter_attribute';
        $this->_priceFilterBlockName        = 'easylife_ruleproducts/layer_filter_price';
        $this->_decimalFilterBlockName      = 'easylife_ruleproducts/layer_filter_decimal';
    }
    /**
     * get layer
     * @access public
     * @return Easylife_RuleProducts_Model_Layer
     * @author Marius Strajeru
     */
    public function getLayer() {
        return Mage::getSingleton('easylife_ruleproducts/layer');
    }
}
