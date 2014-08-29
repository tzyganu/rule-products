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
 * RuleProducts module install script
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('easylife_ruleproducts/ruleproduct'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Entity ID')
    ->addColumn('entity_type_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Entity Type ID')
    ->addColumn('attribute_set_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Attribute Set ID')
    ->addColumn('conditions_serialized', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => false,
    ), 'Conditions')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Creation Time')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Update Time')
    ->addIndex($this->getIdxName('easylife_ruleproducts/ruleproduct', array('entity_type_id')),
        array('entity_type_id'))
    ->addIndex($this->getIdxName('easylife_ruleproducts/ruleproduct', array('attribute_set_id')),
        array('attribute_set_id'))
    ->addForeignKey(
        $this->getFkName(
            'easylife_ruleproducts/ruleproduct',
            'attribute_set_id',
            'eav/attribute_set',
            'attribute_set_id'
        ),
        'attribute_set_id', $this->getTable('eav/attribute_set'), 'attribute_set_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($this->getFkName('easylife_ruleproducts/ruleproduct', 'entity_type_id', 'eav/entity_type', 'entity_type_id'),
        'entity_type_id', $this->getTable('eav/entity_type'), 'entity_type_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Rule Product Table');
$this->getConnection()->createTable($table);

$ruleproductEav = array();
$ruleproductEav['int'] = array(
    'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'length'    => null,
    'comment'   => 'Rule Product Datetime Attribute Backend Table'
);

$ruleproductEav['varchar'] = array(
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length'    => 255,
    'comment'   => 'Rule Product Varchar Attribute Backend Table'
);

$ruleproductEav['text'] = array(
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length'    => '64k',
    'comment'   => 'Rule Product Text Attribute Backend Table'
);

$ruleproductEav['datetime'] = array(
    'type'      => Varien_Db_Ddl_Table::TYPE_DATETIME,
    'length'    => null,
    'comment'   => 'Rule Product Datetime Attribute Backend Table'
);

$ruleproductEav['decimal'] = array(
    'type'      => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length'    => '12,4',
    'comment'   => 'Rule Product Datetime Attribute Backend Table'
);

foreach ($ruleproductEav as $type => $options) {
    $table = $this->getConnection()
        ->newTable($this->getTable(array('easylife_ruleproducts/ruleproduct', $type)))
        ->addColumn('value_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
            ), 'Value ID')
        ->addColumn('entity_type_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
            ), 'Entity Type ID')
        ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
            ), 'Attribute ID')
        ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
            ), 'Store ID')
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
            ), 'Entity ID')
        ->addColumn('value', $options['type'], $options['length'], array(
            ), 'Value')
        ->addIndex(
            $this->getIdxName(
                array('easylife_ruleproducts/ruleproduct', $type),
                array('entity_id', 'attribute_id', 'store_id'),
                Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
            ),
            array('entity_id', 'attribute_id', 'store_id'),
            array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
        ->addIndex($this->getIdxName(array('easylife_ruleproducts/ruleproduct', $type), array('store_id')),
            array('store_id'))
        ->addIndex($this->getIdxName(array('easylife_ruleproducts/ruleproduct', $type), array('entity_id')),
            array('entity_id'))
        ->addIndex($this->getIdxName(array('easylife_ruleproducts/ruleproduct', $type), array('attribute_id')),
            array('attribute_id'))
        ->addForeignKey(
            $this->getFkName(
                array('easylife_ruleproducts/ruleproduct', $type),
                'attribute_id',
                'eav/attribute',
                'attribute_id'
            ),
            'attribute_id', $this->getTable('eav/attribute'), 'attribute_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addForeignKey(
            $this->getFkName(
                array('easylife_ruleproducts/ruleproduct', $type),
                'entity_id',
                'easylife_ruleproducts/ruleproduct',
                'entity_id'
            ),
            'entity_id', $this->getTable('easylife_ruleproducts/ruleproduct'), 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addForeignKey($this->getFkName(array('easylife_ruleproducts/ruleproduct', $type), 'store_id', 'core/store', 'store_id'),
            'store_id', $this->getTable('core/store'), 'store_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment($options['comment']);
    $this->getConnection()->createTable($table);
}
$table = $this->getConnection()
    ->newTable($this->getTable('easylife_ruleproducts/eav_attribute'))
    ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Attribute ID')
    ->addColumn('is_global', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Attribute scope')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Attribute position')
    ->addColumn('is_wysiwyg_enabled', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Attribute uses WYSIWYG')
    ->addColumn('is_visible', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Attribute is visible')
    ->setComment('RuleProducts attribute table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
    ->newTable($this->getTable('easylife_ruleproducts/ruleproduct_product'))
    ->addColumn('rule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Rule Product Id')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Product Id')
    ->addIndex(
        $this->getIdxName(
            'easylife_ruleproducts/ruleproduct_product',
            array('rule_id', 'product_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('rule_id', 'product_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )
    ->addForeignKey(
        $this->getFkName(
            'easylife_ruleproducts/ruleproduct_product',
            'rule_id',
            'easylife_ruleproducts/ruleproduct',
            'entity_id'
        ),
        'rule_id', $this->getTable('easylife_ruleproducts/ruleproduct'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $this->getFkName(
            'easylife_ruleproducts/ruleproduct_product',
            'product_id',
            'catalog/product',
            'entity_id'
        ),
        'product_id', $this->getTable('catalog/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Rule Products - Product Table');
$this->getConnection()->createTable($table);

$this->installEntities();

$this->endSetup();
