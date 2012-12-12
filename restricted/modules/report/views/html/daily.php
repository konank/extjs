<script type="text/javascript">
   var grid;
    var DataStore;
    var row_per_page = 30;
    var tanggal = '';
   	Ext.Loader.setConfig({
        enabled :true
    })
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
    					title: 'Daily Report',
    					collapsible: true,
    					border: false,
    					frame: true,
    					buttonAlign: 'left',
    					items: 
    					[
                            {
                                padding : '5px 5px 5px 5px',
                                xtype : 'datefield',
                                name : 'tanggal',
                                id : 'tanggal',
                                format : "Y-m-d",
                                fieldLabel : 'Tanggal',
                                allowBlank : false
                            },
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
                            }
                            
                        ]
                      ,buttons: [
                        { text: 'Submit',handler : loadDatareportDaily },
                        
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
    
    Ext.define('DataGrid', {
                    extend: 'Ext.data.Model',
                    fields: ['booking_id','nama', 'no_ktp','time_start','total','discount','time_end','duration','status_bayar','keterangan','tanggal_booking'],
                    idProperty: 'threadid'
        });
        DataStore = new Ext.data.Store({
              
              model: 'DataGrid',
              proxy: {
                    
                    type: 'ajax',
                    url: '<?php echo base_url()?>report/showreport_daily',
                    reader: {
                        root: 'results',
                        totalProperty:'total',
                    },
                },
              
        	});
        grid = new Ext.create('Ext.grid.Panel',{
            id : 'grid_report',
            border: false,
            stateful: true,
            height : 480,
            store: DataStore,
            tbar   : [
    			{
    			    xtype: 'exporterbutton',//exportbutton
    			    text: 'Export Grid Data',
    			    store: DataStore
    			}
            ],
            renderTo : 'tes',
            loadMask: {showMask:true},
    		autoWidth: true,
            columns: [	
                {
    				xtype: 'gridcolumn',
    				dataIndex: 'booking_id',
    				sortable: true,
    				flex:0.3,
    				header: 'Booking ID'
    			},
    			{
    				xtype: 'gridcolumn',
    				dataIndex: 'nama',
    				sortable: true,
    				flex:0.5,
    				header: 'Name'
    			},{
    				xtype: 'gridcolumn',
    				dataIndex: 'no_ktp',
    				sortable: true,
                    flex:0.5,
    				header: 'Nomor Identitas'
    			},{
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
    				header: 'Time End'
    			},{
    				xtype: 'gridcolumn',
    				dataIndex: 'duration',
    				sortable: true,
    				flex:0.5,
    				header: 'Durasi'
    			},{
    				xtype: 'gridcolumn',
    				dataIndex: 'status_bayar',
    				sortable: true,
    			    flex:0.5,
    				header: 'Status pembayaran'
    			},
                {
    				xtype: 'gridcolumn',
    				dataIndex: 'keterangan',
    				sortable: true,
    			    flex:0.5,
    				header: 'Keterangan'
    			},
                {
    				xtype: 'gridcolumn',
    				dataIndex: 'tanggal_booking',
    				sortable: true,
    				flex:0.5,
    				header: 'Tanggal booking'
    			},
                {
    				xtype: 'gridcolumn',
    				dataIndex: 'total',
    				sortable: true,
    				flex:0.5,
                    renderer : changeRupiah,
    				header: 'Total tagihan'
    			},
                {
    				xtype: 'gridcolumn',
    				dataIndex: 'discount',
    				sortable: true,
    				flex:0.5,
                    renderer : getDiscountPersen,
    				header: 'Discount'
    			},
     			
                ],
    			  viewConfig: { forceFit: true},
                  
                  region: 'center'
        });
            
        var cmp1 = new MyViewportUi({
    		renderTo: Ext.getBody()
    	});
        //viewportNya.show();
        loadData();
	    cmp1.show();
    });
    function getDiscountPersen(value){
        return ''+value+'%';
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
    
    function statusBayar(value){
        if(value == 0){
            return '<span style="color:red">Belum bayar</span>'
        } else if(value == 1){
            return '<span style="color:orange">Masih kurang</span>'
        } else {
            return '<span style="color:green">Lunas</span>'    
        }
    }
    function loadData()
    {
        
        DataStore.load({params: 
		 {
			start: 0, 
			limit: row_per_page,
			dateDaily: Ext.getCmp('tanggal').getValue(),
			lapanganId : 0
		 }
		});
    }
    
    function loadDatareportDaily()
    {
        
        DataStore.load({params: 
            		 {
            			start: 0, 
            			limit: row_per_page,
            			dateDaily: Ext.getCmp('tanggal').getValue(),
                        lapanganId : Ext.getCmp('DropdownLapangan').getValue()
            		 }
        		});   
        
    }
    </script>
   <div id="tes"></div>
   <div id="loaddata"></div>