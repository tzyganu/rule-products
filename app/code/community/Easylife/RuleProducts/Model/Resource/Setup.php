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
 * RuleProducts setup
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
class Easylife_RuleProducts_Model_Resource_Setup
    extends Mage_Catalog_Model_Resource_Setup {
    /**
	 * get the default entities for rule products module - used at installation
	 * @access public
	 * @return array()
	 * @author Marius Strajeru
	 */
	public function getDefaultEntities(){
		$entities = array();
        $entities['easylife_ruleproducts_ruleproduct'] = array(
            'entity_model'                  => 'easylife_ruleproducts/ruleproduct',
            'attribute_model'               => 'easylife_ruleproducts/resource_eav_attribute',
            'table'                         => 'easylife_ruleproducts/ruleproduct',
            'additional_attribute_table'    => 'easylife_ruleproducts/eav_attribute',
            'entity_attribute_collection'   => 'easylife_ruleproducts/ruleproduct_attribute_collection',
            'attributes'        => array(
                'title' => array(
                    'group'          => 'General',
                    'type'           => 'varchar',
                    'backend'        => '',
                    'frontend'       => '',
                    'label'          => 'Title',
                    'input'          => 'text',
                    'source'         => '',
                    'global'         => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    'required'       => '1',
                    'user_defined'   => false,
                    'default'        => '',
                    'unique'         => false,
                    'position'       => '10',
                    'note'           => '',
                    'visible'        => '1',
                    'wysiwyg_enabled'=> '0',
                ),
                'description' => array(
                    'group'          => 'General',
                    'type'           => 'text',
                    'backend'        => '',
                    'frontend'       => '',
                    'label'          => 'Description',
                    'input'          => 'textarea',
                    'source'         => '',
                    'global'         => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    'required'       => '0',
                    'user_defined'   => true,
                    'default'        => '',
                    'unique'         => false,
                    'position'       => '20',
                    'note'           => '',
                    'visible'        => '1',
                    'wysiwyg_enabled'=> '1',
                ),
                'image' => array(
                    'group'          => 'General',
                    'type'           => 'varchar',
                    'backend'        => 'easylife_ruleproducts/ruleproduct_attribute_backend_image',
                    'frontend'       => '',
                    'label'          => 'Image',
                    'input'          => 'image',
                    'source'         => '',
                    'global'         => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    'required'       => '',
                    'user_defined'   => true,
                    'default'        => '',
                    'unique'         => false,
                    'position'       => '30',
                    'note'           => '',
                    'visible'        => '1',
                    'wysiwyg_enabled'=> '0',
                ),
                'include_in_menu' => array(
                    'group'          => 'General',
                    'type'           => 'int',
                    'backend'        => '',
                    'frontend'       => '',
                    'label'          => 'Include in main menu',
                    'input'          => 'select',
                    'source'         => 'eav/entity_attribute_source_boolean',
                    'global'         => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    'required'       => '1',
                    'user_defined'   => true,
                    'default'        => '',
                    'unique'         => false,
                    'position'       => '40',
                    'note'           => '',
                    'visible'        => '1',
                    'wysiwyg_enabled'=> '0',
                ),
                'menu_position' => array(
                    'group'          => 'General',
                    'type'           => 'int',
                    'backend'        => '',
                    'frontend'       => '',
                    'label'          => 'Position in menu',
                    'input'          => 'text',
                    'source'         => '',
                    'global'         => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    'required'       => '0',
                    'user_defined'   => true,
                    'default'        => '',
                    'unique'         => false,
                    'position'       => '50',
                    'note'           => '',
                    'visible'        => '1',
                    'wysiwyg_enabled'=> '0',
                ),
                'status' => array(
                    'group'          => 'General',
                    'type'           => 'int',
                    'backend'        => '',
                    'frontend'       => '',
                    'label'          => 'Enabled',
                    'input'          => 'select',
                    'source'         => 'eav/entity_attribute_source_boolean',
                    'global'         => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    'required'       => '',
                    'user_defined'   => false,
                    'default'        => '1',
                    'unique'         => false,
                    'position'       => '60',
                    'note'           => '',
                    'visible'        => '1',
                    'wysiwyg_enabled'=> '0',
                ),
                'url_key' => array(
                    'group'          => 'General',
                    'type'           => 'varchar',
                    'backend'        => 'easylife_ruleproducts/ruleproduct_attribute_backend_urlkey',
                    'frontend'       => '',
                    'label'          => 'URL key',
                    'input'          => 'text',
                    'source'         => '',
                    'global'         => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    'required'       => '',
                    'user_defined'   => false,
                    'default'        => '',
                    'unique'         => false,
                    'position'       => '70',
                    'note'           => '',
                    'visible'        => '1',
                    'wysiwyg_enabled'=> '0',
                ),
                'meta_title' => array(
                    'group'          => 'General',
                    'type'           => 'varchar',
                    'backend'        => '',
                    'frontend'       => '',
                    'label'          => 'Meta title',
                    'input'          => 'text',
                    'source'         => '',
                    'global'         => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    'required'       => '',
                    'user_defined'   => false,
                    'default'        => '',
                    'unique'         => false,
                    'position'       => '80',
                    'note'           => '',
                    'visible'        => '1',
                    'wysiwyg_enabled'=> '0',
                ),
                'meta_keywords' => array(
                    'group'          => 'General',
                    'type'           => 'text',
                    'backend'        => '',
                    'frontend'       => '',
                    'label'          => 'Meta keywords',
                    'input'          => 'textarea',
                    'source'         => '',
                    'global'         => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    'required'       => '',
                    'user_defined'   => false,
                    'default'        => '',
                    'unique'         => false,
                    'position'       => '90',
                    'note'           => '',
                    'visible'        => '1',
                    'wysiwyg_enabled'=> '0',
                ),
                'meta_description' => array(
                    'group'          => 'General',
                    'type'           => 'text',
                    'backend'        => '',
                    'frontend'       => '',
                    'label'          => 'Meta description',
                    'input'          => 'textarea',
                    'source'         => '',
                    'global'         => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                    'required'       => '',
                    'user_defined'   => false,
                    'default'        => '',
                    'unique'         => false,
                    'position'       => '100',
                    'note'           => '',
                    'visible'        => '1',
                    'wysiwyg_enabled'=> '0',
                ),
                'conditions_serialized' => array(
                    'type'           => 'static',
                    'backend'        => '',
                    'frontend'       => '',
                    'source'         => '',
                    'global'         => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    'user_defined'   => false,
                    'unique'         => false,
                    'visible'        => '0',
                ),

                )
	 	);
        return $entities;
    }
}
