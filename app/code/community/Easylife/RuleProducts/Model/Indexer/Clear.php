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
 * Clear Indexer model
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Model_Indexer_Clear
    extends Easylife_RuleProducts_Model_Indexer_Abstract {
    /**
     * Get Indexer name
     * @access public
     * @return string
     * @authod Marius Strajeru
     */
    public function getName() {
        return Mage::helper('catalog')->__('Clear Product rule pages');
    }

    /**
     * Get Indexer description
     * @access public
     * @return string
     * @author Marius Strajeru
     */
    public function getDescription() {
        return Mage::helper('catalog')->__('Clear the product rules product associations');
    }


    /**
     * reindex everything
     * @access public
     * @return $this|void
     * @author Marius Strajeru
     */
    public function reindexAll() {
        foreach ($this->_getRuleCollection() as $rule) {
            /** @var Easylife_RuleProducts_Model_Ruleproduct $rule */
            Mage::getResourceSingleton('easylife_ruleproducts/ruleproduct')->clearProductIds($rule);
        }
        return $this;
    }
}