<script type="text/javascript">
    Ext.Loader.setConfig({
        enabled: true
    });
    
    Ext.Loader.setPath('Ext.ux', '<?php echo base_url() ?>public/extjs/ux');
    Ext.require(['*','Ext.ux.IFrame',]);

    Ext.onReady(function() {
    Ext.QuickTips.init(); //untuk tooltip
    Ext.define('DataSetting', {
        extend: 'Ext.data.Model',
        fields: ['id','min_time', 'max_time'],
        idProperty: 'threadid'
    });
    
	var store = Ext.create('Ext.data.Store', {
        pageSize: 50,autoLoad: true,
        model: 'DataSetting',
        proxy: {
            
            type: 'ajax',
            url: '<?php echo base_url() ?>settings/getsetting',
            reader: {
                root: 'setting',
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
        
		columns: [
			{header: 'Id',  dataIndex: 'id',  flex: 0.5},
            {header: 'Min time', dataIndex: 'min_time', flex: 1},
            {header: 'Max time', dataIndex: 'max_time', flex: 1},
            {
                    text: 'Action',
                    columns: [ {
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
                               
                        ]
                }  
                
		],
		stripeRows: true,
		renderTo: 'grid-example',
		title:'Settings',
        id : 'gridData',
	});
    
    
    function lakukanEdit(id)
    {
        if(id == 0){
            alert('ss');
        } else { 
             var win = new Ext.Window({
                   title: 'Edit Setting',
                   width: 400,
                   id : 'winLap',
                   
                   
                   modal: 'true',
                   resizable : false,
                   layout: 'fit' ,
                   items: [new Ext.create('Ext.ux.IFrame',{
                          src:'<?php echo base_url() ?>settings/edit/'+id,                   
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
    
    
        
        
    //resize grid 
    Ext.EventManager.onWindowResize(function () {
        grid.setSize(undefined, undefined);
    });

});
    </script>
    <div id="grid-example"></div>