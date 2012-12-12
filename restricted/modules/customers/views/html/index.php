<script type="text/javascript">
    var row_per_page = 10;
    Ext.Loader.setConfig({
        enabled :true
    })
    
    Ext.Loader.setPath('Ext.ux', '<?php echo base_url() ?>public/extjs/ux');
    //Ext.require(['*','Ext.ux.IFrame']);
    Ext.require([
        'Ext.grid.*',
        'Ext.data.*',
        'Ext.util.*',
        'Ext.toolbar.Paging',
        'Ext.ux.PreviewPlugin',
        'Ext.ModelManager',
        'Ext.tip.QuickTipManager',
        'Ext.ux.IFrame'
    ]);
    var Jendela;
    Ext.onReady(function(){
        Ext.QuickTips.init();
        
        /* -------------------------------CREATE MODEL-------------------------*/
        Ext.define('DataCustomer',{
            extend : 'Ext.data.Model',
            fields : ['id','no_ktp','nama','alamat','gender','no_telfon','email'],
        })
        
        /* -------------------------------CREATE STORE-------------------------*/
        var store = Ext.create('Ext.data.Store', {
            pageSize: 10,
            model: 'DataCustomer',
            remoteSort: true,
            proxy: {
                type: 'ajax',
                url : '<?php echo base_url() ?>customers/getalldata',
                reader: {
                    root: 'customer',
                    totalProperty: 'totalCount'
                },
                // sends single sort as multi parameter
                simpleSortMode: true
            },
        });
        
        /* -------------------------------CREATE GRID -------------------------*/
        
        var grid = Ext.create('Ext.grid.Panel', {
            store : store,
            tbar : [{
                text : 'Add customer',
                tooltip : 'Add data',
                iconCls : 'add',
                disabled :<?php echo getAclAdd($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'),array('add'=>'add')); ?>,
                
                handler : function(){
                    Jendela.show();
                }
            }],
            
            columns : [
                {header : 'Nomor Ktp' , dataIndex: 'no_ktp',flex:0.5},
                {header : 'Nama', dataIndex : 'nama',flex: 0.7},
                {header : 'Alamat', dataIndex : 'alamat',flex: 1.3},
                {header : 'Gender', dataIndex : 'gender',flex: 0.6},
                {header : 'Nomor telphone', dataIndex : 'no_telfon',flex: 0.6},
                {header : 'Email', dataIndex : 'email',flex: 0.6}, 
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
                                    
                                    deleteData(id);    
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
                                updateData(id); 
                                 
                                
                            }
                        },
                        ]
                        
                    }]
                }               
                
            ],
            renderTo : 'grid-customer',
            title: 'Customers',
            id : 'gridData',
             bbar: Ext.create('Ext.PagingToolbar', {
                store: store,
                displayInfo: true,
                displayMsg: 'Displaying topics {0} - {1} of {2}',
                emptyMsg: "No data",
                
            }),
        })
        store.loadPage(1);
       
        /* -------------------------------CREATE FORM PANEL -------------------------*/
        
        var genderNya = [
            ['Laki-laki'],
            ['Perempuan']
        ]
        var genderStore  = Ext.create('Ext.data.ArrayStore', {
            fields : ['gender'],
            
            data : genderNya
        })
        var formPanel = Ext.create('Ext.form.Panel', {
            frame: true,
            url : '<?php echo base_url() ?>customers/addnew',
            id : 'formJendela',
            bodyStyle:'padding:5px 5px 0',
            items : [
            
                {
                    xtype : 'textfield',
                    name : 'ktp',
                    fieldLabel : 'Nomor KTP',
                    allowBlank : false,
                    width : 500 
                },
                {
                    xtype : 'textfield',
                    name : 'nama',
                    fieldLabel : 'Nama customer',
                    allowBlank : false,
                    width : 500 
                },
                {
                    fieldLabel: 'Email',
                    name: 'email',
                    xtype:'textfield',
                    width : 500 
                },
                {
                    xtype : 'textareafield',
                    name : 'alamat',
                    fieldLabel : 'Alamat',
                    allowBlank : false,
                    width : 500 
                
                },
                {
                    xtype : 'combo',
                    width : 500,
                    fieldLabel : 'Gender',
                    store : genderStore,
                    id:'gender',
                    name : 'gender',
                    displayField: 'gender',
                    allowBlank : false
                },
                {
                    xtype : 'textfield',
                    name : 'telfon',
                    fieldLabel : 'No Telfon',
                    allowBlank : true,
                    width : 500 
                },
            
            ],
            buttons : [
                {
                    text : 'Submit',
                    handler : function(){
                        formPanel.getForm().submit({
                            success : function(form,action){
                                grid.store.load();
                                Jendela.close();
                                formPanel.getForm().reset();
                            },
                            failure : function(form,action){
                                if(action.failureType == 'server'){
                                    var obj = Ext.JSON.decode(action.response.responseText);
                                        Ext.Msg.alert("Failed",obj.errors.reason);
                                } else {
                                    Ext.Msg.alert("Failed",'Please fill the blank..');
                                }
                            }
                        })
                    }
                },
                {
                    text : 'Cancel',
                    handler : function(){
                        Jendela.hide();
                    }
                },
                {
                    text : 'Reset',
                    handler : function(){
                        formPanel.getForm().reset();
                    }
                }
            ]
        })
        
         /* -------------------------------CREATE WINDOW -------------------------*/
        
        Jendela = new Ext.Window({
            title: 'Add customer',
            id : 'jendela',
            layout : 'fit',
            closable : true,
            modal:true,
            resizable : false,
            closeAction: 'hide',
            items : [formPanel]
        })
        Jendela.hide();
        
         /* ----------------------------------- ACTION --------------------------*/
        
        function deleteData(id)
        {
            Ext.MessageBox.confirm('Confirm','Are you sure want to do that.??', function(e){
                if(e == 'yes'){
                    var koneksiAjax = new Ext.data.Connection();
                    koneksiAjax.request({
                        method: 'POST',
                        url : '<?php echo base_url() ?>customers/delete/'+id+'',
                        success : function(){
                            grid.store.load();
                        },
                        failure : function(form,action){
                            if(action.failureType == 'server'){
                            Ext.Msg.alert('Data server gagal dihapus..!!');
                            //grid.store.load();
                            
                            } else {
                            Ext.Msg.alert('Data gagal dihapus..!!');
                            grid.store.load();    
                            }
                            
                        }
                    })
                } 
            })
        }
        
        function updateData(id)
        {
            var jendelaEdit = new Ext.Window({
                title: 'Edit customer',
                   
                   width: 527,
                   id : 'JendelaEdit',
                   height: 303,
                   modal: 'true',
                   layout: 'fit' ,
                   items : new Ext.create('Ext.ux.IFrame',{
                            src:'<?php echo base_url() ?>customers/edit/'+id,
                            id :'user_edit',
                            itemId: 'user_edit',     
                            
                            layout: 'fit',
                            closable: true,
                            loadMask: true,
                   })
            })
            jendelaEdit.show();
        }
        Ext.EventManager.onWindowResize(function () {
            grid.setSize(undefined, undefined);
        });
    })
</script>
<div id="panel">
<div id="grid-customer"></div>
</div>
<!--<div id="grid-customer"></div>-->