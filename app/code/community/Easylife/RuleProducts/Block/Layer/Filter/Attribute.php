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
 * attribute layer block
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Block_Layer_Filter_Attribute
    extends Mage_Catalog_Block_Layer_Filter_Attribute {
    /**
     * constructor
     * @access public
     * @author Marius Strajeru
     */
    public function __construct() {
        parent::__construct();
        $this->_filterModelName = 'easylife_ruleproducts/layer_filter_attribute';
    }
}