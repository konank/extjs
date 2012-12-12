<script type="text/javascript">
    Ext.Loader.setConfig({
        enabled: true
    });
    
    Ext.Loader.setPath('Ext.ux', '<?php echo base_url() ?>public/extjs/ux');
    Ext.require(['*','Ext.ux.IFrame',]);

    Ext.onReady(function() {
    Ext.QuickTips.init(); //untuk tooltip
    
    Ext.define('DataUser', {
        extend: 'Ext.data.Model',
        fields: ['id','username', 'name','created','tipe_user','is_active'],
        idProperty: 'threadid'
    });
    
     var tes = [
        ['0','customer'],
        ['1','sysadmin'],
    ];
    var statesStore = Ext.create('Ext.data.ArrayStore', {
        fields: ['tipe_index','tipe'],
        data : tes 
    }) 
    
    var panelDetailWindow;
	var store = Ext.create('Ext.data.Store', {
        pageSize: 50,autoLoad: true,

        model: 'DataUser',
        proxy: {
            
            type: 'ajax',
            url: '<?php echo base_url() ?>manages/getdatamanages',
            reader: {
                root: 'users',
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
            text:'Add User',
            tooltip:'Add a new record',
            iconCls:'add',
            id :'klik',
            disabled :<?php echo getAclAdd($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'),array('add'=>'add')); ?>,
            handler : function(){
                myWin.show();
            }
        }
        ],
		columns: [
			{header: 'Usernames',  dataIndex: 'username',  flex: 0.5},
            {header: 'Name', dataIndex: 'name', flex: 1},
            {header: 'Created', dataIndex: 'created', flex: 1},
            {header: 'User type', dataIndex: 'tipe_user', flex: 1},
            {header: 'Is active', dataIndex: 'is_active', flex: 1,renderer : activeUser},
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
                        
                    }]
                }  
            
		],
		stripeRows: true,
		renderTo: 'grid-example',
		title:'Usermanagement',
        id : 'gridData',
	});
    
    function activeUser(val){
        if(val == 0){
            return 'Not active';
        } else {
            return 'Active';
        }
    }
    function lakukanEdit(id,record)
    {
        if(id == 0){
            alert('ss');
        } else { 
             var win = new Ext.Window({
                   title: 'Edit user',
                   width: 525,
                   id : 'winYa',
                   height: 220,
                   modal: 'true',
                   layout: 'fit' ,
                   items: [new Ext.create('Ext.ux.IFrame',{
                          src:'<?php echo base_url() ?>manages/edit/'+id,
                            id :'user_edit',
                            itemId: 'user_edit',                   
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
                       url: '<?php echo base_url() ?>manages/delete/'+id+'',
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
                url:'<?php echo base_url() ?>manages/addnew',
                frame:true,
                id : 'userform',
                bodyStyle:'padding:5px 5px 0',
                items: [
                        {
                			xtype: 'textfield',
                			fieldLabel: 'Username',
                			name: 'username',
                			id: 'logUsername',
                			allowBlank: false,
                            width:500
                            
                		}, {
                			xtype: 'textfield',
                			fieldLabel: 'Password',
                			name: 'password',
                            id: 'logPassword',
                			allowBlank: false,
                			inputType: 'password',
                            width:500
                            
                            
                		},{
                			xtype: 'textfield',
                			fieldLabel: 'name',
                			name: 'name',
                            id: 'name',
                			allowBlank: false,
                			inputType: 'text',
                            width:500
                            
                            
                		},
                        {
                			xtype: 'checkbox',
                			fieldLabel: 'Active',
                			name: 'is_active',
                            id: 'is_active',
                            
                		},
                        {
                            xtype: 'combo',
                            width:500,
                            fieldLabel: 'User type',
                            id:'tipe_index',
                            hiddenName : 'tipe_index',
                            store: statesStore,
                            valueField: 'tipe_index', //kasih valueField untuk ngebaca index array
                            
                            displayField: 'tipe',
                            allowBlank: false,
                            forceSelection: true ,
                                   
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