<script type="text/javascript">
    Ext.Loader.setConfig({
        enabled: true
    });
    
    Ext.Loader.setPath('Ext.ux', '<?php echo base_url() ?>public/extjs/ux');
    Ext.require(['*','Ext.ux.IFrame',]);
    

    Ext.onReady(function() {
    Ext.QuickTips.init(); //untuk tooltip
    Ext.define('DataAcl', {
        extend: 'Ext.data.Model',
        fields: ['id', 'class_name','method'],
        idProperty: 'threadid'
    });
    
    var panelDetailWindow;
    
	var store = Ext.create('Ext.data.Store', {
        pageSize: 10,
        remoteSort: true,
        sorters: ['class_name','method'],
        groupField: 'class_name',
        model: 'DataAcl',
        proxy: {
            
            type: 'ajax',
            url: '<?php echo base_url() ?>acl/getdataacl',
            reader: {
                root: 'results',
                totalProperty: 'total'
            },
            simpleSortMode: true
        },
        
    });
    
    //var store = Ext.create('Ext.data.Store', {
//            pageSize: 10,
//            
//            model: 'DataAcl',
//            remoteSort: true,
//            proxy: {
//                type: 'ajax',
//                url : '<?php echo base_url() ?>acl/getdataacl',
//                reader: {
//                    root: 'results',
//                    totalProperty: 'total'
//                },
//                simpleSortMode: true
//            },
//    });
	// create the grid
    
    var groupingFeature = Ext.create('Ext.grid.feature.Grouping',{
        groupHeaderTpl: '{rows.length} Item{[values.rows.length > 1 ? "s" : ""]}'
    });
    
	var grid = new Ext.create('Ext.grid.Panel', {
		store: store,
        //bbar: Ext.create('Ext.PagingToolbar', {
//            store: store,
//            displayInfo: true,
//            displayMsg: 'Displaying topics {0} - {1} of {2}',
//            emptyMsg: "No data",
//            
//        }),
        features: [groupingFeature],
        tbar : [{
            text:'Add List',
            tooltip:'Add a new record',
            iconCls:'add',
            disabled :<?php echo getAclAdd($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'),array('add'=>'add')); ?>,
            id :'klik',
            handler : function(){
                myWin.show();
            }
        }
        ],
		columns: [
			{header: 'Class name',  dataIndex: 'class_name',  flex: 0.5},
            {header: 'Method', dataIndex: 'method', flex: 1},
            {
                    text: 'Action',
                    columns: [{
                                menuDisabled: true,
                                sortable: false,
                                xtype: 'actioncolumn',
                                width: 50,
                                hidden:<?php echo getAclAdd($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'),array('delete'=>'delete')) ?>,
                                align:'center',
                                items: [
                                {
                                    iconCls:'remove',
                                    tooltip: 'Delete data',
                                    handler: function(grid, rowIndex, colIndex) {
                                        //var id = record.get('id');
                                        var rec = grid.getStore().getAt(rowIndex);
                                        var id = rec.get('id');
                                        lakukanDelete(id);    
                                    }
                                },
                                ]
                            
                                }, {
                                    menuDisabled: true,
                                    sortable: false,
                                    xtype: 'actioncolumn',
                                    width: 50,
                                    hidden:<?php echo getAclAdd($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'),array('edit'=>'edit')) ?>,
                                
                                    align:'center',
                                    items: [
                                    
                                    {
                                        iconCls:'edit',
                                        tooltip: 'Ubah data',
                                        handler: function(grid, rowIndex, colIndex) {
                                            //var id = record.get('id');
                                            var rec = grid.getStore().getAt(rowIndex);
                                            var id = rec.get('id');
                                            lakukanEdit(id);    
                                            
                                        }
                                    },
                                    ]
                                    
                                },
                                {
                                    menuDisabled: true,
                                    sortable: false,
                                    xtype: 'actioncolumn',
                                    width: 50,
                                    hidden:<?php echo getAclAdd($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'),array('setacl'=>'setacl')) ?>,
                                
                                    align:'center',
                                    items: [
                                    {
                                        iconCls:'user',
                                        tooltip : 'Role access group',
                                        handler: function(grid, rowIndex, colIndex) {
                                            //var id = record.get('id');
                                            var rec = grid.getStore().getAt(rowIndex);
                                            var id = rec.get('id');
                                            var name = rec.get('name');
                                            openPrivilege(id,name);    
                                        }
                                    },
                                    ]
                                    
                                }
                        
                        
                        ]
                }  
            
		],
		renderTo: 'grid-example',
		title:'Accessroles',
        id : 'gridData',
	});
    store.load();
    
    function openPrivilege(id,name)
    {
        
         var winPrivilege = new Ext.Window({
               title: 'Set accesscontrol',
               width: 640,
               id : 'WinPrivilege',
               height: 380,
               scroll:true,
               modal: 'true',
               resizable : false,
               layout: 'fit' ,
               items: [new Ext.create('Ext.ux.IFrame',{
                      src:'<?php echo base_url() ?>acl/setacl/'+id+'/'+name,
                        layout: 'fit',
                        closable: true,
                        loadMask: true,
                    })
                     ]
               });
        winPrivilege.show(); 
    }
    
    function lakukanEdit(id)
    {
        if(id == 0){
            alert('ss');
        } else { 
             var win = new Ext.Window({
                   title: 'Access control Edit',
                   width: 500,
                   id : 'editAclWindow',
                   height: 140,
                   modal: 'true',
                   resizable : false,
                   layout: 'fit' ,
                   items: [new Ext.create('Ext.ux.IFrame',{
                          src:'<?php echo base_url() ?>acl/edit/'+id,
                            id :'acl_edit',
                            itemId: 'acl_edit',                   
                            layout: 'fit',
                            closable: true,
                            loadMask: true,
                        })
                         ]
                   });
         
               win.show();
               return win;
        }
            //return myWin;
    
    }
    
    function lakukanDelete(id)
    {
         Ext.MessageBox.confirm('Confirm', 'Are you sure you want to do that?',function(e){
            if(e == 'yes'){
                //untuk post request ajax ke server php
                var conn = new Ext.data.Connection();
                conn.request({
                       method:'POST',
                       url: '<?php echo base_url() ?>acl/delete/'+id+'',
                       success: function(){
                            grid.store.load();
                       },
                       failure: function(){
                            Ext.Msg.alert("Failed",'Data gagal di delete..');
                            grid.store.load();
                       },
                       
                });
                
            } 
        });
    }
    var myWin;
    var eventForm = Ext.create('Ext.form.Panel', {
                url:'<?php echo base_url() ?>acl/addnew',
                frame:true,
                id : 'userform',
                bodyStyle:'padding:5px 5px 0',
                items: [
                        {
                            xtype : 'textfield',
                            fieldLabel : 'Class name',
                            name : 'class_name',
                            allowBlank : false,
                            width :500
                        },
                        {
                            xtype : 'textfield',
                            fieldLabel : 'Method name',
                            name : 'method',
                            allowBlank : true,
                            width :500
                        }
              		],

              buttons: [{
                    text: 'Submit',
                    handler: function(){
                        eventForm.getForm().submit({
                            success : function(form,action){
                                grid.store.load();   
                                myWin.close();
                                eventForm.getForm().reset();
                            },
                            failure : function(form,action){
                                if(action.failureType == 'server'){
                                    var obj = Ext.JSON.decode(action.response.responseText);
                                    Ext.Msg.alert("Failed",obj.errors.reason);
                                    
                                } else {
                                    Ext.Msg.alert("Failed",'Please fill the blank..');
                                    
                                }
                                //Ext.Msg.alert("Failed",'Please fill the blank..');
                            }
                        });
                    }
                     
                }
                
                ,{
                    text: 'Cancel',
                    handler: function(){
                        myWin.hide();
                        eventForm.getForm().reset();
                        
                    },
                }, {
                    text: 'Reset',
                    handler: function()
                    {
                        eventForm.getForm().reset();
                        
                    }
                }]
            });
            
        myWin = new Ext.Window({
    		title: 'Add new data',
            
            id: 'myWin',
    		layout: 'fit',
    		closable: true,
            closeAction: 'hide',
    		y: 200,
            modal:true,
                
    		resizable: false,
    		items: [eventForm],
            
    	});
        myWin.hide();
    
        
        
    //resize grid 
    Ext.EventManager.onWindowResize(function () {
        grid.setSize(undefined, undefined);
    });

});
    </script>
    <div id="grid-example"></div>