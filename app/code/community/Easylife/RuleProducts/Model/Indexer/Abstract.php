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
 * Indexer model
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
abstract class Easylife_RuleProducts_Model_Indexer_Abstract
    extends Mage_Index_Model_Indexer_Abstract {


    /**
     * register event
     * @access public
     * @param Mage_Index_Model_Event $event
     * @return $this
     * @author Marius Strajeru
     */
    protected function _registerEvent(Mage_Index_Model_Event $event) {
        return $this;
    }

    /**
     * @access public
     * @param Mage_Index_Model_Event $event
     * @return $this
     * @author Marius Strajeru
     */
    protected function _processEvent(Mage_Index_Model_Event $event) {
        return $this;
    }

    /**
     * @access protected
     * @return Easylife_RuleProducts_Model_Resource_Ruleproduct_Collection
     * @author Marius Strajeru
     */
    protected function _getRuleCollection() {
        /** @var Easylife_RuleProducts_Model_Resource_Ruleproduct_Collection $collection */
        $collection = Mage::getModel('easylife_ruleproducts/ruleproduct')->getCollection();
        $collection->addAttributeToFilter('status', 1);
        return $collection;
    }
}