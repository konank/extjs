<script type="text/javascript">
    Ext.Loader.setConfig({
        enabled: true
    });
    
    Ext.Loader.setPath('Ext.ux', '<?php echo base_url() ?>public/extjs/ux');
    Ext.require(['*','Ext.ux.IFrame',]);

    Ext.onReady(function() {
    Ext.QuickTips.init(); //untuk tooltip
    Ext.define('DataLapangan', {
        extend: 'Ext.data.Model',
        fields: ['id','kode_lapangan', 'nama_lapangan','harga_sewa_pagi','harga_sewa_siang','harga_sewa_malem','keterangan'],
        idProperty: 'threadid'
    });
    
	var store = Ext.create('Ext.data.Store', {
        pageSize: 50,autoLoad: true,
        model: 'DataLapangan',
        proxy: {
            
            type: 'ajax',
            url: '<?php echo base_url() ?>lapangan/getdata',
            reader: {
                root: 'lapangan',
                successProperty:'success',
            },
        },
        
        autoLoad: true,
        autoSync: true,
    });
	// create the grid
    function changeRupiah(angkaValue){
        if(angkaValue != '' && angkaValue != null){
        var nyeplit = angkaValue.split('|');
        var angkaRupiah = nyeplit[0];
        var rupiah = '';		
    	var angkarev = angkaRupiah.toString().split('').reverse().join('');
    	for(var i = 0; i < angkarev.length; i++) {
    	   if(i%3 == 0){
    	       rupiah += angkarev.substr(i,3)+'.';     
    	   }  
    	} 
    	return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');   
        } else {
            return '';
        }
    }
    
	var grid = new Ext.create('Ext.grid.Panel', {
		store: store,
        width:'auto',
        
        tbar : [{
            text:'Add Lapangan',
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
			{header: 'Code',  dataIndex: 'kode_lapangan',  flex: 0.5},
            {header: 'Nama lapangan', dataIndex: 'nama_lapangan', flex: 1},
            {header: 'Harga sewa Pagi', dataIndex: 'harga_sewa_pagi', flex: 1,renderer : changeRupiah},
            {header: 'Harga sewa Siang', dataIndex: 'harga_sewa_siang', flex: 1,renderer : changeRupiah},
            {header: 'Harga sewa Malem', dataIndex: 'harga_sewa_malem', flex: 1,renderer : changeRupiah},
            {header: 'Keterangan', dataIndex: 'keterangan', flex: 1},
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
                                    
                                },
                               
                        ]
                }  
                
		],
		stripeRows: true,
		renderTo: 'grid-example',
		title:'Manage lapangan',
        id : 'gridData',
	});
    
    
    function lakukanEdit(id)
    {
        if(id == 0){
            alert('ss');
        } else { 
             var win = new Ext.Window({
                   title: 'Edit nama lapangan',
                   width: 640,
                   id : 'winLap',
                   height: 530,
                   modal: 'true',
                   resizable : false,
                   layout: 'fit' ,
                   items: [new Ext.create('Ext.ux.IFrame',{
                          src:'<?php echo base_url() ?>lapangan/edit/'+id,                   
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
                       url: '<?php echo base_url() ?>lapangan/delete/'+id+'',
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
                
                border:false,
                url:'<?php echo base_url() ?>lapangan/addnew',
                fieldDefaults: {
                    labelAlign: 'top',
                    msgTarget: 'side'
                },
                items : [
                {
                    xtype : 'form',
                    frame : true,
                    url:'<?php echo base_url() ?>lapangan/addnew',
                    defaults: {
                        anchor: '100%'
                    },
                    id : 'userform',
                    border : false,
                    items: [
                {
                    layout:'column',
                    border:false,
                    items:[{
                        columnWidth:.5,
                        border:false,
                        layout: 'anchor',
                        defaultType: 'textfield',
                        items: [
                        {
                			xtype: 'textfield',
                			fieldLabel: 'Kode lapangan',
                			name: 'kode_lapangan',
                			anchor : '95%',
                			allowBlank: false,
                            
                		}, {
                			xtype: 'textfield',
                			fieldLabel: 'Nama lapangan',
                			name: 'name',
                            id: 'name',
                			allowBlank: false,
                			inputType: 'text',
                            anchor : '95%'
                		},
                        ]
                    },{
                        columnWidth:.5,
                        border:false,
                        layout: 'anchor',
                        defaultType: 'textfield',
                        items: [
                        {
                            xtype : 'textareafield',
                            fieldLabel : 'Keterangan',
                            name : 'keterangan',
                            anchor : '100%'
                        }
                        ]
                    }]
                },
                {
                            xtype:'tabpanel',
                            plain:true,
                            activeTab: 0,
                            
                            defaults:{bodyStyle:'padding:10px'},
                            items:[{
                                title:'Pagi',
                                defaults: {width: 600},
                                defaultType: 'textfield',
                
                                items: [
                                {
                                    xtype :'component',
                                    html :'Harga sewa pagi',
                                    style : 'margin-left:0px; margin-bottom:5px; text-decoration: underline;'
                                },
                                {
                        			xtype: 'textfield',
                        			fieldLabel: 'Harga sewa',
                        			name: 'harga_pagi',
                                    id: 'harga_pagi',
                        			allowBlank: false,
                        			inputType: 'text',
                                  
                                },
                                {
                                  	xtype: 'timefield',
                        			fieldLabel: 'Jam sewa start',
                        			name: 'jam_start_pagi',
                                    id: 'jam',
                        			allowBlank: false,
                        			format:"H:i:s",
                                    increment: 30,
                            
                                },
                                {
                                  	xtype: 'timefield',
                        			fieldLabel: 'Jam sewa end',
                        			name: 'jam_end_pagi',
                                    id: 'jam_end',
                                    format:"H:i:s",
                                    increment: 30,
                        			allowBlank: false,
                        			
                                },
                                ]
                            },{
                                title:'Siang',
                                defaults: {width: 600},
                                defaultType: 'textfield',
                
                                items: [
                                {
                                    xtype :'component',
                                    html :'Harga sewa siang',
                                    style : 'margin-left:0px; margin-bottom:5px; text-decoration: underline;'
                                },
                                {
                        			xtype: 'textfield',
                        			fieldLabel: 'Harga sewa',
                        			name: 'harga_siang',
                                    id: 'harga-siang',
                        			allowBlank: false,
                        			inputType: 'text',
                                  
                                },
                                {
                                  	xtype: 'timefield',
                        			fieldLabel: 'Jam sewa start',
                        			name: 'jam_start_siang',
                                    id: 'jam_start_siang',
                        			allowBlank: false,
                        			format:"H:i:s",
                                    increment: 30,
                            
                                },
                                {
                                  	xtype: 'timefield',
                        			fieldLabel: 'Jam sewa end',
                        			name: 'jam_end_siang',
                                    id: 'jam_end_siang',
                                    format:"H:i:s",
                                    increment: 30,
                        			allowBlank: false,
                        			
                                },
                                
                                ]
                            },
                            {
                                title:'Malam',
                                defaults: {width: 600},
                                defaultType: 'textfield',
                
                                items: [
                                {
                                    xtype :'component',
                                    html :'Harga sewa malam',
                                    style : 'margin-left:0px; margin-bottom:5px; text-decoration: underline;' 
                                },
                                {
                        			xtype: 'textfield',
                        			fieldLabel: 'Harga sewa',
                        			name: 'harga_malam',
                                    id: 'harga_malam',
                        			allowBlank: false,
                        			inputType: 'text',
                                  
                                },
                                {
                                  	xtype: 'timefield',
                        			fieldLabel: 'Jam sewa start',
                        			name: 'jam_start_malam',
                                    id: 'jam_start_malam',
                        			allowBlank: false,
                        			format:"H:i:s",
                                    increment: 30,
                            
                                },
                                {
                                  	xtype: 'timefield',
                        			fieldLabel: 'Jam sewa end',
                        			name: 'jam_end_malam',
                                    id: 'jam_end_malam',
                                    format:"H:i:s",
                                    increment: 30,
                        			allowBlank: false,
                        			
                                },
                                
                                ]
                            }
                            ]
                        },
                        {
                            xtype :'component',
                            html :'Format penulisan : 100000 jangan pakai Rp ataupun titik (.)',
                            style : 'margin-left:0px; color:red;' 
                        },
                ],
                }
                ],

              buttons: [{
                    text: 'Submit',
                    handler: function(){
                        eventForm.getForm().submit({
                            waitMsg:'Saving ...', 
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
    		
            modal:true,
            width: 645,
                
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