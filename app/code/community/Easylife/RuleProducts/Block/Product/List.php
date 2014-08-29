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
 * product list block
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Block_Product_List extends Mage_Catalog_Block_Product_List {
    /**
     * @access public
     * @return Easylife_RuleProducts_Model_Ruleproduct
     * @author Marius Strajeru
     */
    public function getCurrentRule() {
        return Mage::registry('current_ruleproduct');
    }

    /**
     * get the product collection
     * @access protected
     * @return Mage_Catalog_Model_Resource_Product_Collection
     * @author Marius Strajeru
     */
    protected function _getProductCollection() {
        if (is_null($this->_productCollection)) {
            $ruleCollection = $this->getCurrentRule();
            /** @var Easylife_RuleProducts_Model_Layer $layer */
            $layer = $this->getLayer();
            $layer->setCurrentRule($ruleCollection);
            $this->_productCollection = $layer->getProductCollection();
        }
        return $this->_productCollection;
    }

    /**
     * @access public
     * @return Easylife_RuleProducts_Model_Layer
     * @author Marius Strajeru
     */
    public function getLayer() {
        $layer = Mage::registry('current_layer');
        if ($layer) {
            return $layer;
        }
        return Mage::getSingleton('easylife_ruleproducts/layer');
    }
}
