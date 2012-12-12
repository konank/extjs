<script type="text/javascript">
   Ext.onReady(function(){
    var grid;
    var DataStore;
    
    DataStore = new Ext.data.Store({
		id: 'DataStore',
        autoLoad :true,
		proxy: new Ext.data.HttpProxy({
			url: '<?php echo base_url()?>booking/show', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader
		( 
			{	 root: 'results',
				 totalProperty: 'total',
				 id: 'id'
			},
			[
                 { name: 'waktu'},
				 { name: 'minggu'},
				 { name: 'senin'},
                 { name: 'selasa'},
                 { name: 'rabu'},
                 
			]
	   )
	  });
      
      grid = new Ext.grid.GridPanel({
        id : 'grid_report',
        border: false,
        store: DataStore,
        loadMask: {showMask:true},
		autoWidth: true,
        columns: [	
			{
				xtype: 'gridcolumn',
				dataIndex: 'waktu',
				sortable: true,
				width: 100,
				header: 'Time'
			},
            {
				xtype: 'gridcolumn',
				dataIndex: 'minggu',
				sortable: true,
				width: 100,
				header: 'Minggu'
			},
            {
				xtype: 'gridcolumn',
				dataIndex: 'senin',
				sortable: true,
				width: 100,
				header: 'Senin'
			},
            {
				xtype: 'gridcolumn',
				dataIndex: 'selasa',
				sortable: true,
				width: 100,
				header: 'Selasa'
			},
            {
				xtype: 'gridcolumn',
				dataIndex: 'rabu',
				sortable: true,
				width: 100,
				header: 'rabu'
			},
 			
        ],
        viewConfig: {forceFit: true},
        region: 'center'
    });
    
        var viewportNya = new Ext.create('Ext.Viewport',{
            layout : 'border',
            
            items : [
                {
                    xtype : 'panel',
                    frame : true,
				    border:false,
                    region:'north',
                    collapsible:true,
                    buttonAlign : 'left',
                    items : 
                    [
                        {
                            xtype : 'form',
                            id : 'formbook',
                            method : 'POST',
                            frame:true,
                            
                            border:false,
                            
                            url : '<?php echo base_url() ?>booking/cek_ktp',
                            items : [
                                {
                                    padding : '5px 5px 5px 5px',
                                    xtype : 'datefield',
                                    name : 'date',
                                    fieldLabel : 'Tanggal',
                                    allowBlank : false
                                },
                                {
                                    xtype : 'hidden',
                                    name : 'id_lapangan',
                                    value : '<?php echo $id_lapangan ?>'
                                },
                                
                            ],
                            
                         }
                    ],
                    buttons : [
                            {
                                text : 'Search',
                                handler : function(){
                                    alert('ss');
                                }
                            }
                        ]
                    
                },
                {
                    xtype : 'panel',
                    region: 'center',
                    frame : true,
				    border:false,
                    items : grid
                    
                }
                
            ]
        })
        //viewportNya.show();
        
       
    })
    </script>
   <div id="tes"></div>