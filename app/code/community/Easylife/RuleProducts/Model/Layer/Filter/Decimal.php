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
 * Layer filter decimal
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Model_Layer_Filter_Decimal
    extends Mage_Catalog_Model_Layer_Filter_Decimal {
    /**
     * get layer
     * @access public
     * @return Easylife_RuleProducts_Model_Layer
     * @author Marius Strajeru
     */
    public function getLayer() {
        $layer = $this->_getData('layer');
        if (is_null($layer)) {
            $layer = Mage::getSingleton('easylife_products/layer');
            $this->setData('layer', $layer);
        }
        return $layer;
    }
}