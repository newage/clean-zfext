<?php
/**
 * Administrator acl controller
 *
 * @category Application
 * @package Application_Administrator
 * @subpackage Controllers
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://github.com/newage/clean-zfext
 * @since php 5.1 or higher
 */

class Administrator_AclController extends Zend_Controller_Action
{

    /**
     * Initialize default method
     *
     */
    public function init()
    {
        $this->_helper->layout->setLayout('administrator/layout');
    }

    /**
     * Intex action
     * Show all routes
     *
     * @todo show all routes
     */
    public function indexAction()
    {
        $script = "Ext.QuickTips.init();

    var Employee = Ext.data.Record.create([{
        name: 'role',
        type: 'string'
    }, {
        name: 'resource',
        type: 'string'
    }, {
        name: 'action',
        type: 'string',
    },{
        name: 'allow',
        type: 'bool'
    }]);

    Ext.state.Manager.setProvider(new Ext.state.CookieProvider());

    // create the data store
    var store = new Ext.data.ArrayStore({
        fields: [
           {name: 'role', type: 'string'},
           {name: 'resource', type: 'string'},
           {name: 'action', type: 'string'},
           {name: 'allow', type: 'bool'},
        ]
    });

    // manually load local data
    store.loadData(myData);

    var cm = new Ext.grid.ColumnModel({
        defaults: {
            sortable: true // columns are not sortable by default
        },
        columns: [{
                id       :'role',
                header   : 'Role',
                width    : 160,
                dataIndex: 'role',
                editor: {
                    xtype: 'textfield',
                    allowBlank: false
                }
            }, {
                header   : 'Resource',
                width    : 75,
                dataIndex: 'resource',
                editor: {
                    xtype: 'textfield',
                    allowBlank: false
                }
            }, {
                header   : 'Action',
                width    : 75,
                dataIndex: 'action',
                editor: {
                    xtype: 'textfield',
                    allowBlank: false
                }
            }, {
                header   : 'Allow',
                xtype: 'booleancolumn',
                width    : 55,
                dataIndex: 'allow',
                trueText: 'Yes',
                falseText: 'No',
                editor: {
                    xtype: 'checkbox'
                }
            }]
    });

    // create the Grid
    var grid = new Ext.grid.GridPanel({
        store: store,
        cm: cm,
        stripeRows: true,
        autoExpandColumn: 'role',
        plugins: [editor],
        height: 350,
        width: 600,
        title: 'Array Grid',
        // config options for stateful behavior
        stateful: true,
        stateId: 'grid'
    });

    // render the grid to the specified div in the page
    grid.render('grid-acl');";

        $this->view->Extjs()->addScript($script);
    }
}