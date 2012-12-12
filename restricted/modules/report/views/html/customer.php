<script type="text/javascript">
    var row_page = 15;
    var startPage = 0;
    var EXPRESS_INSTALL_URL = '<?php echo base_url() ?>public/extjs/ux/'
    Ext.Loader.setConfig({
        enabled :true
    })
    //Ext.Loader.setPath('Ext.ux', '<?php echo base_url() ?>public/extjs/ux');
    //Ext.require(['*','Ext.ux.exporter.*']);
   // Ext.Loader.setPath('Ext.ux.exporter','<?php echo base_url() ?>public/extjs/app/lib/components/gridexporter/ux/exporter');
				
    
	Ext.require([
	     'Ext.grid.*',
	     'Ext.data.*',
	     'Ext.util.*',
	     'Ext.form.*',
	     'Ext.state.*',
	     'Ext.ux.exporter.Exporter.*',
	 'Ext.ux.exporter.excelFormatter.*',
	 'Ext.ux.exporter.csvFormatter.*',
	 'Ext.ux.exporter.Button.*'
	 ]);
    
    Ext.onReady(function(){
        Ext.QuickTips.init();
        
        /**************************CREATE MODEL**********************/
        Ext.define('DataModel',{
            extend: 'Ext.data.Model',
            fields : ['no_ktp','nama','alamat','gender','no_telfon','email'],
        })
         /*************************CREATE STORE*********************/
         var DataStore = new Ext.create('Ext.data.Store',{
            pageSize : row_page,
            model:'DataModel',
            remoteSort : true,
            proxy : {
                type : 'ajax',
                url : '<?php echo base_url() ?>report/getcustomer',
                reader : {
                    successProperty : 'success',
                    root : 'results'
                },
                simpleSortMode: true
            }
         })
         DataStore.load({
                params : {
                    start : startPage,
                    limit : row_page    
                }
         });
         /*************************CREATE GRID*********************/
         
         var grid = new Ext.create('Ext.grid.Panel',{
            //tbar : [{
//                text : 'Report Excel',
//                tooltip : 'Add Report excel',
//                iconCls : 'excel',
//                
//                handler : function(){
//                    lakukanRekap('{0}');
//                }
//            }],
           
            
            bbar: Ext.create('Ext.PagingToolbar', {
                store: DataStore,
                displayInfo: true,
                displayMsg: 'Displaying Data {0} - {1} of {2} ',
                emptyMsg: "No data ",
            }),
            store : DataStore,
            tbar   : [
    			{
    			    xtype: 'exporterbutton',//exportbutton
    			    text: 'Export Grid Data',
    			    store: DataStore
    			}
            ],
            columns : [
                {header : 'Nomor Ktp' , dataIndex: 'no_ktp',flex:0.5},
                {header : 'Nama', dataIndex : 'nama',flex: 0.7},
                {header : 'Alamat', dataIndex : 'alamat',flex: 1.3},
                {header : 'Gender', dataIndex : 'gender',flex: 0.6},
                {header : 'Nomor telphone', dataIndex : 'no_telfon',flex: 0.6},
                {header : 'Email', dataIndex : 'email',flex: 0.6}, 
            ],
            renderTo : 'grid-data',
            id : 'gridData',
            title : 'Customer report',
            viewConfig: {
            stripeRows: true
            },
            //dockedItems: [
//            {
//            xtype: 'toolbar',
//            dock: 'bottom',
//            store : DataStore,
//            items: [ { xtype: 'exporterbutton'} ]
//            }
//            ]
         })
         
         
        
         Ext.EventManager.onWindowResize(function () {
            grid.setSize(undefined, undefined);
        });
        
    })
</script>
<div id="btn-div"></div>
<div id="grid-data"></div>