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
 * layer state block
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
/**
 * @method Easylife_RuleProducts_Block_Layer_State setLayer()
 */
class Easylife_RuleProducts_Block_Layer_State extends Mage_Catalog_Block_Layer_State {
    /**
     * get layer
     * @access public
     * @return Easylife_RuleProducts_Model_Layer
     * @author Marius Strajeru
     */
    public function getLayer() {
        if (!$this->hasData('layer')) {
            $this->setLayer(Mage::getSingleton('easylife_ruleproducts/layer'));
        }
        return $this->_getData('layer');
    }
}
