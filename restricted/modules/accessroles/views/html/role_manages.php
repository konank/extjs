<script type="text/javascript">
    Ext.Loader.setConfig({
        enabled: true
    });
    
    Ext.Loader.setPath('Ext.ux', '<?php echo base_url() ?>public/extjs/ux');
    Ext.require(['*','Ext.ux.IFrame',]);

    Ext.onReady(function() {
    Ext.QuickTips.init(); //untuk tooltip
    Ext.define('DataRoles', {
        extend: 'Ext.data.Model',
        fields: ['id', 'name'],
        idProperty: 'threadid'
    });
    
    var panelDetailWindow;
	var store = Ext.create('Ext.data.Store', {
        pageSize: 50,autoLoad: true,

        model: 'DataRoles',
        proxy: {
            
            type: 'ajax',
            url: '<?php echo base_url() ?>accessroles/getdataroles',
            reader: {
                root: 'roles',
                successProperty:'success',
            },
        },
        
        autoLoad: true,
        autoSync: true,
    });
	// create the grid
	var grid = new Ext.create('Ext.grid.Panel', {
		store: store,
        width:'auto',
        
        tbar : [{
            text:'Add Roles',
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
			{header: 'Id',  dataIndex: 'id',  flex: 0.5},
            {header: 'Name', dataIndex: 'name', flex: 1},
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
                                    hidden:<?php echo getAclAdd($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'),array('setgroup'=>'setgroup')) ?>,
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
                                    
                                },
                                {
                                    menuDisabled: true,
                                    sortable: false,
                                    xtype: 'actioncolumn',
                                    width: 50,
                                    hidden:<?php echo getAclAdd($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'),array('setgrant'=>'setgrant')) ?>,
                                    align:'center',
                                    items: [
                                    {
                                        iconCls : 'user_grant',
                                        tooltip : 'Grant Access rules',
                                        handler: function(grid, rowIndex, colIndex) {
                                            //var id = record.get('id');
                                            var rec = grid.getStore().getAt(rowIndex);
                                            var id = rec.get('id');
                                            var name = rec.get('name');
                                            openGrantAccess(id,name);  
                                        }
                                    },
                                    ]
                                    
                                }
                        ]  
            
            }
		],
		stripeRows: true,
		renderTo: 'grid-example',
		title:'Accessroles',
        id : 'gridData',
	});
    
    function openPrivilege(id,name)
    {
        
         var winPrivilege = new Ext.Window({
               title: 'Set roles by group',
               width: 640,
               id : 'WinPrivilege',
               height: 380,
               scroll:true,
               modal: 'true',
               resizable : false,
               layout: 'fit' ,
               items: [new Ext.create('Ext.ux.IFrame',{
                      src:'<?php echo base_url() ?>accessroles/setgroup/'+id+'/'+name,
                        id :'roles_edit',
                        itemId: 'roles_edit',                   
                        layout: 'fit',
                        closable: true,
                        loadMask: true,
                    })
                     ]
               });
        winPrivilege.show(); 
    }
    
    function openGrantAccess(id,name)
    {
        var winPrivilege = new Ext.Window({
               title: 'Set Grant rules',
               width: 640,
               id : 'GrantPrivilege',
               height: 380,
               scroll:true,
               modal: 'true',
               resizable : false,
               layout: 'fit' ,
               items: [new Ext.create('Ext.ux.IFrame',{
                      src:'<?php echo base_url() ?>accessroles/setgrant/'+id+'/'+name,
                        id :'roles_edit',
                        itemId: 'roles_edit',                   
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
                   title: 'Roles Edit',
                   width: 500,
                   id : 'RolesWindow',
                   height: 110,
                   modal: 'true',
                   resizable : false,
                   layout: 'fit' ,
                   items: [new Ext.create('Ext.ux.IFrame',{
                          src:'<?php echo base_url() ?>accessroles/edit/'+id,
                            id :'roles_edit',
                            itemId: 'roles_edit',                   
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
                       url: '<?php echo base_url() ?>accessroles/delete/'+id+'',
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
                url:'<?php echo base_url() ?>accessroles/addnew',
                frame:true,
                id : 'userform',
                bodyStyle:'padding:5px 5px 0',
                items: [
                        {
                			xtype: 'textfield',
                			fieldLabel: 'Role name',
                			name: 'name',
                			id: 'name',
                			allowBlank: false,
                            width:500  
                		},
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
    		title: 'Add new user',
            
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