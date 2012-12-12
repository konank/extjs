<script type="text/javascript">
    Ext.Loader.setConfig({
        enabled: true
    });
    var grid;
    var store;
    var row_per_page = 10;
    Ext.Loader.setPath('Ext.ux', '<?php echo base_url() ?>public/extjs/ux');
    Ext.require(['*','Ext.ux.IFrame',]);
    Ext.define('Datadropdown', {
                    extend: 'Ext.data.Model',
                    fields: ['id', 'nama_lapangan'],
                    idProperty: 'threadid'
    });
    var dropDownstore = new Ext.data.Store({
              id: 'DataStore',
              model: 'Datadropdown',
              proxy: {
                    
                    type: 'ajax',
                    url: '<?php echo base_url()?>report/getlapangan',
                    reader: {
                        root: 'results',
                    },
                },
              
   	});
        
    MyViewportUi = Ext.extend(Ext.Viewport, {
		//layout: 'fit',
		hideBorders:true,
		initComponent: function() {
			this.items = 
			[
                {
                    xtype: 'panel',
					id:'form_cari',
                    method : 'POST',    
				//	layout: 'border',
					frame: true,
                    items : [
                    {
    					xtype: 'panel',
    					region: 'north',
    					layout: 'column',
    					title: 'Billing information',
    					collapsible: true,
    					border: false,
    					frame: true,
    					buttonAlign: 'left',
    					items: 
    					[
                            
                            {
                                xtype: 'combo',
                                padding : '5px 5px 5px 5px',
                                id: 'DropdownLapangan',
                                fieldLabel: 'Lapangan',
                                valueField: 'id',
                                displayField: 'nama_lapangan',
                                store: dropDownstore,
                                typeAhead: true,
                                mode: 'local',
                                triggerAction: 'all',
                                emptyText:'Pilih lapangan...',
                                selectOnFocus:true
                            },
                            {
                                padding : '5px 5px 5px 5px',
                                xtype : 'datefield',
                                name : 'tanggal',
                                id : 'tanggal',
                                format : "Y-m-d",
                                fieldLabel : 'Tanggal',
                                allowBlank : false,
                                value : '<?php echo date("Y-m-d"); ?>'
                            },
                            
                        ]
                      ,buttons: [
                        { text: 'Submit',handler : searchData },
                        
                      ]
                    }
                    ,{
                            xtype: 'panel',
        				layout: 'fit',
        				border: false,
        				region: 'center',
        				autoScroll: true,
        				style: '',
        				items: grid
                                                    
                        }
                    ]
                }
                
                
            ]
			 MyViewportUi.superclass.initComponent.call(this);
		 }
	 });
     
    Ext.onReady(function() {
    Ext.QuickTips.init(); //untuk tooltip
    Ext.define('DataBiling', {
        extend: 'Ext.data.Model',
        fields: ['id','kode_lapangan','bookid','jumlah_yang_dibayar','lesspaid', 'total','nama_lapangan','time_start','time_end','tanggal_booking','nama','status_bayar','duration'],
        idProperty: 'threadid'
    });
    
	store = Ext.create('Ext.data.Store', {
        //pageSize: 10,
        
        model: 'DataBiling',
        proxy: {
            
            type: 'ajax',
            url: '<?php echo base_url() ?>billing/getdata',
            reader: {
                root: 'results',
                totalProperty : 'total'
            },
        },
    });
	// create the grid
   
    
	grid = new Ext.create('Ext.grid.Panel', {
		store: store,
        border: false,
        stateful: true,
        id : 'gridData',
		columns: [
        {
            xtype : 'gridcolumn',
            dataIndex : 'bookid',  
			sortable: true,
			flex:0.5,
			header: 'Booking ID'
        },
        {
			xtype: 'gridcolumn',
			dataIndex: 'nama',
			sortable: true,
			flex:0.5,
			header: 'Nama customer'
		},
        {
			xtype: 'gridcolumn',
			dataIndex: 'nama_lapangan',
			sortable: true,
			flex:0.5,
			header: 'Nama lapangan'
		},
        {
			xtype: 'gridcolumn',
			dataIndex: 'time_start',
			sortable: true,
			flex:0.5,
			header: 'Time start'
		},{
			xtype: 'gridcolumn',
			dataIndex: 'time_end',
			sortable: true,
			flex:0.5,
			header: 'Time end'
		},
        {
			xtype: 'gridcolumn',
			dataIndex: 'duration',
			sortable: true,
			flex:0.5,
			header: 'Durasi'
		},
        //{
//			xtype: 'gridcolumn',
//			dataIndex: 'tanggal_booking',
//			sortable: true,
//			flex:0.5,
//			header: 'Tanggal booking'
//		},
        {
			xtype: 'gridcolumn',
			dataIndex: 'status_bayar',
			sortable: true,
			flex:0.5,
			header: 'Status',
            renderer : getstatus
		},
        {
			xtype: 'gridcolumn',
			dataIndex: 'total',
			sortable: true,
			flex:0.5,
			header: 'Jumlah tagihan',
            renderer : changeRupiah
		},
        //{
//            xtype : 'gridcolumn',
//            dataIndex : 'lesspaid',
//            flex : 0.5,
//            header : 'Pembayaran yang kurang',
//            renderer : changeRupiah
//        },
        {
            xtype : 'gridcolumn',
            dataIndex : 'jumlah_yang_dibayar',
            renderer : changeRupiah,
            flex : 0.5,
            header:'Uang muka' 
        },{
            text : 'Action',
            columns : [
                {
                    xtype : 'actioncolumn',
                    menuDisabled : true,
                    width : 50,
                    hidden:<?php echo getAclAdd($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'),array('cetak'=>'cetak')) ?>,
                                
                    align : 'center',
                    items : [
                        {
                            text : 'Print',
                            tooltip : 'Print data',
                            iconCls : 'print',
                            handler : function(grid,rowIndex,colIndex){
                                var getIdPrint = grid.getStore().getAt(rowIndex);
                                printData(getIdPrint.get('bookid'));
                            }
                        }
                    ]
                },
                {
                    xtype : 'actioncolumn',
                    menuDisabled : true,
                    width : 50,
                    align : 'center',
                    items : [
                        {
                            text : 'View',
                            iconCls : 'view',
                            tooltip : 'View data',
                            handler : function(grid,rowIndex,colIndex){
                                var getId = grid.getStore().getAt(rowIndex);
                                tampilData(getId.get('bookid'));
                                
                            }
                        }
                    ]
                },
                {
                    xtype : 'actioncolumn',
                    menuDisabled : true,
                    width : 50,
                    hidden:<?php echo getAclAdd($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'),array('edit'=>'edit')) ?>,
                    
                    align : 'center',
                    items : [
                        {
                            text : 'Edit',
                            tooltip : 'Edit data',
                            iconCls : 'edit',
                            handler : function(grid,rowIndex,colIndex){
                                var getID = grid.getStore().getAt(rowIndex);
                                lakukanEdit(getID.get('bookid'));

                            }
                        }
                    ]
                },
                
                {
                    xtype : 'actioncolumn',
                    menuDisabled : true,
                    width : 50,
                    hidden:<?php echo getAclAdd($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'),array('delete'=>'delete')) ?>,
                    
                    align : 'center',
                    items : [
                        {
                            text : 'Delete',
                            iconCls : 'remove',
                            tooltip : 'Delete data',
                            handler : function(grid,rowIndex,colIndex){
                                var getId = grid.getStore().getAt(rowIndex);
                                lakukanDelete(getId.get('bookid'));
                            }
                        }
                    ]
                },
                
            ]
        }        
		],
		stripeRows: true,
		title:'Billing management',
        id : 'gridData',
        renderTo : 'tes',
        viewConfig: { forceFit: true},
        region: 'center',
        loadMask: {showMask:true},
	});
    function lakukanDelete(id){
        Ext.MessageBox.confirm('Confirm Delete','Apakah anda yakin menghapus data ini..??',function(e){
            if(e == 'yes'){
                var conn = new Ext.data.Connection();
                conn.request({
                   method:'POST',
                   url: '<?php echo base_url() ?>billing/delete/'+id+'',
                   success: function(){
                        searchData();
                   },
                   failure: function(){
                        Ext.Msg.alert("Failed",'Data gagal di delete..');
                        grid.store.load();
                   },
                })   
            }
        })
    }
    
    function lakukanEdit(id){
        var EditWin = new Ext.Window({
            title: 'Edit data',
               width: 643,
               id : 'editbill',
               height: 230,
               scroll:true,
               modal: 'true',
               resizable : false,
               layout: 'fit' ,
               items: [new Ext.create('Ext.ux.IFrame',{
                      src:'<?php echo base_url() ?>billing/edit/'+id+'',
                        layout: 'fit',
                        closable: true,
                    })
                     ]
               });
        
        EditWin.show();
    }
    function tampilData(id){
        
        var win = new Ext.Window({
               title: 'Billing detail',
               width: 600,
               id : 'billdetail',
               height: 300,
               scroll:true,
               modal: 'true',
               resizable : false,
               layout: 'fit' ,
               items: [new Ext.create('Ext.ux.IFrame',{
                      src:'<?php echo base_url() ?>billing/detail/'+id+'',
                        layout: 'fit',
                        closable: true,
                    })
                     ]
               });
        win.show(); 
        
    }
    function printData(id){
        var waitMask = new Ext.LoadMask(Ext.getBody(), {msg:"Please wait..."});
        waitMask.show();
        window.open('<?php echo base_url() ?>billing/cetak/'+id+'','Open','height=420, width=780');
        waitMask.hide();
    }
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
    function getstatus(value){
        if(value == 'Belum membayar'){
            return '<div style="color:red;">Belum membayar</div>';
        } else if(value == 'Uang muka'){
            return '<div style="color:orange;">Uang muka</div>';
        } else if(value == 'Lunas') {
            return '<div style="color:green;">Lunas</div>';
        }
    }
    var cmp1 = new MyViewportUi({
		renderTo: Ext.getBody()
	});
     loadData();
	    cmp1.show(); 
        
    //resize grid 
    Ext.EventManager.onWindowResize(function () {
        grid.setSize(undefined, undefined);
    });
    

});
function loadData()
    {
        
        
        store.load({
            params : {
                start: 0, 
    			limit: row_per_page,
    			dateNya: Ext.getCmp('tanggal').getValue(),
    			lapanganId : 0
            } 
        });
    }
    
    function searchData()
    {
        
        store.load({
            params : {
                start: 0, 
    			limit: row_per_page,
    			dateNya: Ext.getCmp('tanggal').getValue(),
    			lapanganId : Ext.getCmp('DropdownLapangan').getValue()
            } 
        });
    }
    </script>
    <div id="tes"></div>