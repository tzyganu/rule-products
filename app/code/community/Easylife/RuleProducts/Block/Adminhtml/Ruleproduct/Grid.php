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
 * Rule Product admin grid block
 *
 * @category    Easylife
 * @package     Easylife_RuleProducts
 * @author      Marius Strajeru
 */
/**
 * @method Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Grid setUseAjax()
 */
class Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Grid
    extends Mage_Adminhtml_Block_Widget_Grid {
    /**
     * constructor
     * @access public
     * @author Marius Strajeru
     */
    public function __construct(){
        parent::__construct();
        $this->setId('ruleproductGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    /**
     * prepare collection
     * @access protected
     * @return Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Grid
     * @author Marius Strajeru
     */
    protected function _prepareCollection(){
        /** @var Easylife_RuleProducts_Model_Resource_Ruleproduct_Collection $collection */
        $collection = Mage::getModel('easylife_ruleproducts/ruleproduct')->getCollection();
        $collection->addAttributeToSelect('include_in_menu')
            ->addAttributeToSelect('menu_position')
            ->addAttributeToSelect('status')
            ->addAttributeToSelect('url_key');
        $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
        $store = $this->_getStore();
        $collection->joinAttribute('title', 'easylife_ruleproducts_ruleproduct/title', 'entity_id', null, 'inner', $adminStore);
        if ($store->getId()) {
            $collection->joinAttribute('easylife_ruleproducts_ruleproduct_title', 'easylife_ruleproducts_ruleproduct/title', 'entity_id', null, 'inner', $store->getId());
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * prepare grid collection
     * @access protected
     * @return Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Grid
     * @author Marius Strajeru
     */
    protected function _prepareColumns(){
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('easylife_ruleproducts')->__('Id'),
            'index'        => 'entity_id',
            'type'        => 'number'
        ));
        $this->addColumn('title', array(
            'header'    => Mage::helper('easylife_ruleproducts')->__('Title'),
            'align'     => 'left',
            'index'     => 'title',
        ));
        if ($this->_getStore()->getId()){
            $this->addColumn('easylife_ruleproducts_ruleproduct_title', array(
                'header'    => Mage::helper('easylife_ruleproducts')->__('Title in %s', $this->_getStore()->getName()),
                'align'     => 'left',
                'index'     => 'easylife_ruleproducts_ruleproduct_title',
            ));
        }

        $this->addColumn('status', array(
            'header'    => Mage::helper('easylife_ruleproducts')->__('Status'),
            'index'        => 'status',
            'type'        => 'options',
            'options'    => array(
                '1' => Mage::helper('easylife_ruleproducts')->__('Enabled'),
                '0' => Mage::helper('easylife_ruleproducts')->__('Disabled'),
            )
        ));
        $this->addColumn('include_in_menu', array(
            'header'=> Mage::helper('easylife_ruleproducts')->__('Include in main menu'),
            'index' => 'include_in_menu',
            'type'    => 'options',
            'options'    => array(
                '1' => Mage::helper('easylife_ruleproducts')->__('Yes'),
                '0' => Mage::helper('easylife_ruleproducts')->__('No'),
            )
        ));
        $this->addColumn('menu_position', array(
            'header'=> Mage::helper('easylife_ruleproducts')->__('Position in menu'),
            'index' => 'menu_position',
            'type'=> 'number',

        ));
        $this->addColumn('url_key', array(
            'header' => Mage::helper('easylife_ruleproducts')->__('URL key'),
            'index'  => 'url_key',
        ));
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('easylife_ruleproducts')->__('Created at'),
            'index'     => 'created_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('easylife_ruleproducts')->__('Updated at'),
            'index'     => 'updated_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('action',
            array(
                'header'=>  Mage::helper('easylife_ruleproducts')->__('Action'),
                'width' => '100',
                'type'  => 'action',
                'getter'=> 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('easylife_ruleproducts')->__('Edit'),
                        'url'   => array('base'=> '*/*/edit'),
                        'field' => 'id'
                    )
                ),
                'filter'=> false,
                'is_system'    => true,
                'sortable'  => false,
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('easylife_ruleproducts')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('easylife_ruleproducts')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('easylife_ruleproducts')->__('XML'));
        return parent::_prepareColumns();
    }
    /**
     * get the selected store
     * @access protected
     * @return Mage_Core_Model_Store
     * @author Marius Strajeru
     */
    protected function _getStore(){
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }
    /**
     * prepare mass action
     * @access protected
     * @return Easylife_RuleProducts_Block_Adminhtml_Ruleproduct_Grid
     * @author Marius Strajeru
     */
    protected function _prepareMassaction(){
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('ruleproduct');
        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('easylife_ruleproducts')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('easylife_ruleproducts')->__('Are you sure?')
        ));
        $this->getMassactionBlock()->addItem('status', array(
            'label'=> Mage::helper('easylife_ruleproducts')->__('Change status'),
            'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
            'additional' => array(
                'status' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('easylife_ruleproducts')->__('Status'),
                        'values' => array(
                                '1' => Mage::helper('easylife_ruleproducts')->__('Enabled'),
                                '0' => Mage::helper('easylife_ruleproducts')->__('Disabled'),
                        )
                )
            )
        ));
        $this->getMassactionBlock()->addItem('include_in_menu', array(
            'label'=> Mage::helper('easylife_ruleproducts')->__('Change Include in main menu'),
            'url'  => $this->getUrl('*/*/massIncludeInMenu', array('_current'=>true)),
            'additional' => array(
                'flag_include_in_menu' => array(
                        'name' => 'flag_include_in_menu',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('easylife_ruleproducts')->__('Include in main menu'),
                        'values' => array(
                                '1' => Mage::helper('easylife_ruleproducts')->__('Yes'),
                                '0' => Mage::helper('easylife_ruleproducts')->__('No'),
                            )

                )
            )
        ));
        return $this;
    }
    /**
     * get the row url
     * @access public
     * @param Easylife_RuleProducts_Model_Ruleproduct
     * @return string
     * @author Marius Strajeru
     */
    public function getRowUrl($row){
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    /**
     * get the grid url
     * @access public
     * @return string
     * @author Marius Strajeru
     */
    public function getGridUrl(){
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}
