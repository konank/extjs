<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
	<meta name="author" content="lolkittens" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/extjs/resources/css/ext-all.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css') ?>" /> 
    <script type="text/javascript" src="<?php echo base_url('public/extjs/ext-all.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-1.6.4.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.tablesorter.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/js/table-sorter.css" />
    <style type="text/css">
        .book  {
            color: #FFFFFF;
        }
    </style>
    <script type="text/javascript">
    
    //{
//    xtype: 'combo',
//    store: ds,
//    id : 'combonya',
//    hiddenName : 'id',
//    
//    typeAhead: false,
//    fieldLabel:'Customer',
//    hideTrigger:true,
//    
//    listConfig: {
//        loadingText: 'Searching...',
//        emptyText: 'Data customer tidak ada.',
//
//        // Custom rendering template for each item
//        getInnerTpl: function() {
//            return '<div class="search-item">' +
//                '{Nama}' +
//            '</div>';
//        }
//    },
//    pageSize: 10,
//
//    // override default onSelect to do redirect
//    listeners: {
//        select: function(combo, selection) {
//            var post = selection[0];
//              if(post){
//                var as = Ext.getCmp('combonya')
//                var cusT = ''+post.get('ktp')+'|'+post.get('Nama')+'';
//                as.setValue(cusT);
//                //as.setDisabled(as);
//                
//              }
//        }
//    }
//},
    $(document).ready(function(){
        $("#the-table").tablesorter({
             headers: { 
                0: { sorter: false },
                1: { sorter: false },
                 
                2: { sorter: false },
                3: { sorter: false },
                4: { sorter: false },
                5: { sorter: false },
                6: { sorter: false },
                7: { sorter: false },
                
            } 
        }); 
    })
        Ext.onReady(function(){
            Ext.create('Ext.Button', {
                text: 'Add data',
                iconCls: 'add',
                renderTo: 'tombol',
                disabled :<?php echo getAclAdd($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'),array('add'=>'add')); ?>,
            
                style : 'margin-bottom:-8px;',
                handler: function() {
                    openWindow('','',id_lapangan);
                }
            });
            
            Ext.create('Ext.Button', {
                text: 'Back',
                iconCls: 'back',
                renderTo: 'tombol-back',
            
                style : 'margin-bottom:-8px;',
                handler: function() {
                    window.location='<?php echo base_url() ?>booking';
                }
            });
            
            Ext.create('Ext.Button', {
                text: 'Reload',
                iconCls: 'reload',
                renderTo: 'tombol-reload',
            
                style : 'margin-bottom:-8px;',
                handler: function() {
                    
                    document.location.reload(true);
                }
            });
        })
        var URL = '<?php echo base_url() ?>';
        var id_lapangan = '<?php echo $id_lapangan; ?>';
        
        function openWindowDetail(noKtp,gender,alamat,telfon,custId,time_start,time_end,duration,id_lapangan,keterangan,tglBayar,statusBayar,jumlahBayar,bookId,namanya){
            
            var JendelaTampil = new Ext.create('Ext.window.Window',{
                width:565,
                
                items : [
                    
                {
                    xtype : 'form',
                    id : 'formpanelss',
                    frame : true,
                    width : 560,
                     
                    layout:'column',
                    items:[{
                        xtype: 'container',
                        columnWidth:.5,
                        layout: 'anchor',
                        items: [
                        {
                            xtype : 'component',
                            padding : '5px 5px 5px 5px',
                            html : 'Booking ID : '+bookId+''  
                        },
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : 'Name : '+namanya+'' 
                            
                        },
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : 'Nomor KTP : '+noKtp+'' 
                            
                        }, 
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : 'Alamat: '+alamat+'' 
                            
                        }, 
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : 'Gender: '+gender+'' 
                            
                        }, 
                        
                        {
                            xtype : 'hidden',
                            name : 'id_lapangan',
                            value : id_lapangan
                        },
                        
                        ]
                    },{
                        xtype: 'container',
                        columnWidth:.4,
                        layout: 'anchor',
                        
                        items: [
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : 'Time start: '+time_start+''    
                        },
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : 'Time end: '+time_end+''    
                        },
                        {
                            padding: '5px 5px 5px 5px',
                            xtype: 'component',
                            html : 'Duration : '+duration+''
                        },
                        {
                            padding: '5px 5px 5px 5px',
                            xtype: 'component',
                            html : 'Status bayar : '+statuspembayaran(statusBayar)+''
                        },
                        {
                            padding: '5px 5px 5px 5px',
                            xtype: 'button',
                            text : 'Delete',
                            iconCls : 'remove',
                            style : 'margin-left:157px;',
                            listeners : {
                                click : function(){
                                    var conn = new Ext.data.Connection();
                                    conn.request({
                                        method:'POST',
                                        
                                        url: '<?php echo base_url() ?>booking/delete/'+bookId,
                                        success: function(response,options){
                                            window.location='<?php echo base_url(); ?>booking/getlapangan/'+id_lapangan+'';    
                                        },
                                        failure: function(){
                                          Ext.Msg.alert("Failed","data gagal dihapus");  
                                        },
                                    })
                                }
                            }
                        }
                        ]
                    }],
                    
                }
                ],
                modal:true,
                title: 'Booking data',
                padding:'',
            })    
            JendelaTampil.show();
        }
        
        function statuspembayaran(value){
            if(value == 0){
                return '<span style="color: #FFFFFF; background: red; padding: 2px;">Belum membayar</span>';
            } else if(value == 1){
                return '<span style="color: #FFFFFF; background: yellow; padding: 2px;">Uang muka</span>';
            } else {
                return '<span style="color: #FFFFFF; background: green; padding: 2px;">Lunas</span>';
            }
        }
        function openWindow(date,time,id_lapangan){
            
        Ext.define("Post", {
            extend: 'Ext.data.Model',
            proxy: {
                type: 'ajax',
                url : '<?php echo base_url() ?>booking/getdatacustomer',
                reader: {
                    type: 'json',
                    root: 'topics',
                    totalProperty: 'totalCount'
                }
            },
            fields: [
                {name: 'id', mapping: 'id'},
                {name: 'ktp', mapping: 'no_ktp'},
                {name: 'title', mapping: 'nama'},
                {name: 'Alamat', mapping: 'alamat'},
                {name: 'Telpon', mapping: 'no_telfon'}
            ]
        });
    
        var ds = Ext.create('Ext.data.Store', {
            pageSize: 10,
            model: 'Post'
        });
        
        function changeRupiah(angkaValue){
            if(angkaValue != '' && angkaValue != null){

            var angkaRupiah = angkaValue;
            var rupiah = '';		
        	var angkarev = angkaRupiah.toString().split('').reverse().join('');
        	for(var i = 0; i < angkarev.length; i++) {
        	   if(i%3 == 0){
        	       rupiah += angkarev.substr(i,3)+'.';     
        	   }  
        	} 
        	return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');   
            } else {
                return '0';
            }
        }     
         var tes = [
            ['0','Belum bayar'],
            ['1','Uang muka'],
            ['2','Lunas'],
        ];
        var statusStore = Ext.create('Ext.data.ArrayStore', {
            fields: ['tipe_index','tipe'],
            data : tes 
        }) 
        
         Ext.create('Ext.window.Window', {
            title: 'Booking',
            id : 'jendelaBooking',
            
            modal : true,
            items: [{
            xtype: 'form',
            anchor: '100%',
            id : 'formpanelss',
            frame : true,
            width : 560,
            url : '<?php echo base_url() ?>booking/insert_booking',
            method: 'POST',
            
            items : [
                {
                    xtype : 'form',
                    
                    layout:'column',
                    items:[{
                        xtype: 'container',
                        columnWidth:.5,
                        layout: 'anchor',
                        items: [
                        
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'datefield',
                            name : 'date_from',
                            id : 'date_from',
                            
                            fieldLabel : 'Tanggal',
                            allowBlank : false,
                            format:"Y-m-d",
                            
                            value : ''+date+''
                        }, 
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'datefield',
                            name : 'date_dua',
                            id: 'date_dua',
                            
                            format:"Y-m-d",
                            fieldLabel : 'Sampai tanggal',
                            allowBlank : false,
                            
                            value : ''+date+''
                        },
                        {
                            xtype : 'hidden',
                            name : 'id_lapangan',
                            value : id_lapangan
                        },
                        
                        ]
                    },{
                        xtype: 'container',
                        columnWidth:.4,
                        layout: 'anchor',
                        items: [
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'timefield',
                            increment: 30,
                            name : 'time_from',
                            id : 'time_from',
                            fieldLabel : 'Time Start',
                            format:"H:i:s",
                            allowBlank : false,
                            minValue: '<?php echo $time_min; ?>',
                            maxValue : '<?php echo $time_max; ?>',
                            value : ''+time+'',
                        },{
                            padding : '5px 5px 5px 5px',
                            xtype:'timefield',
                            fieldLabel: 'Time End',
                            name: 'time_dua',
                            id: 'time_dua',
                            
                            increment: 30,
                            format:"H:i:s",
                            minValue: '<?php echo $time_min; ?>',
                            maxValue : '<?php echo $time_max; ?>',
                            value : ''+time+'',
                            allowBlank : false,
                            //listeners : {
//                                change : function(f,newval){
//                                    var dateStart = Ext.getCmp('date_from').getValue();
//                                    var dateEnd = Ext.getCmp('date_dua').getValue();
//                                    var timeStart = Ext.getCmp('time_from').getValue();
//                                    var timeEnd = Ext.getCmp('time_dua').getValue();
//                                    
//                                    
//                                    var conn = new Ext.data.Connection();
//                                    conn.request({
//                                        method:'POST',
//                                        
//                                        url: '<?php echo base_url() ?>booking/calculate/'+dateStart+'/'+dateEnd+'/'+timeStart+'/'+timeEnd+'',
//                                       success: function(response,options){
//                                        
//                                        },
//                                        failure: function(){
//                                          Ext.Msg.alert("Failed","data gagal dihapus");  
//                                        },
//                                    })
//                                }  
//                            },
                        }]
                    }
                    ],
                    
                },
                {
                    xtype:'tabpanel',
                    plain:true,
                    activeTab: 0,
                    height:235,
                    defaults:{bodyStyle:'padding:10px'},
                    items:[{
                        title:'Billing',
                        defaults: {width: 527},
                        defaultType: 'textfield',
                        items: [
                        {
                            xtype: 'combo',
                            store: ds,
                            displayField: 'ktp',
                            id : 'combonya',
                            typeAhead: false,
                            valueField: 'ktp',
                            fieldLabel:'Customer',
                            hideTrigger:true,
                            anchor: '100%',
                            
                            listConfig: {
                                loadingText: 'Searching...',
                                emptyText: 'Data customer tidak ada.',                
                                getInnerTpl: function() {
                                    return '<div class="search-item">' +
                                        '{title} | {ktp}' +
                                    '</div>';
                                }
                            },
                            pageSize: 10,
                            //listeners: {
//                                select: function(combo, selection) {
//                                    var post = selection[0];
//                                      if(post){
//                                        var as = Ext.getCmp('combonya')
//                                        var cusT = ''+post.get('ktp')+'|'+post.get('title')+'';
//                                        as.setValue(cusT);
//                                        //as.setDisabled(as);
//                                        
//                                      }
//                                }
//                            }
                        },
                        {
                            xtype: 'component',
                            style: 'margin-left:105px; color:red;',
                            html: 'Cari customer minimal 4 angka dengan KTP'
                        },
                        {
                            xtype : 'hidden',
                            id : 'hargaHidden',
                            name : 'hargaHidden'
                        },
                        
                        {
                            xtype: 'combo',
                            
                            fieldLabel: 'Pembayaran',
                            id:'tipe_index',
                            hiddenName : 'tipe_index',
                            store: statusStore,
                            valueField: 'tipe_index', //kasih valueField untuk ngebaca index array
                            
                            displayField: 'tipe',
                            allowBlank: false,
                            listeners : {
                                change : function(a,b){
                                    if(b == 1){
                                        var jumlahBayar = Ext.getCmp('jumlahBayar');
                                        jumlahBayar.show();    
                                    } else {
                                        var jumlahBayar = Ext.getCmp('jumlahBayar');
                                    jumlahBayar.hide();
                                    }
                                     
                                }  
                            },
                            forceSelection: true ,
                                   
                        },
                        {
                            fieldLabel: 'Total bayar (Jika ada uang muka)',
                            name: 'jumlah_bayar',
                            value : '0',
                            id : 'jumlahBayar',
                            hidden : true,
                            style : 'margin-top:10px;'
                        },
                        {
                            fieldLabel: 'Keterangan',
                            name: 'keterangan',
                            xtype : 'textarea'
                        }
                        ]
                    }]
                }
            ],
            
        }],
        buttons: [{
                text: 'Save',
                handler : function(){
                    var pencet = Ext.getCmp('formpanelss');
                    pencet.getForm().submit({
                        waitMsg : 'Please wait...',
                        success : function(form,action){
                        window.location=''+URL+'booking/getlapangan/'+id_lapangan+'/';
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
            },{
                text: 'Cancel',
                handler : function(){
                    var jendela = Ext.getCmp('jendelaBooking');
                    jendela.close();
                    
                }
            }]
        }).show();
        }
    </script>
    <title>Untitled 1</title>
</head>
<body>
<div id="tombol-back" style="float: left; padding-left: 5px;"></div>
<div id="tombol" style="padding-left: 5px; float: left;"></div>
<div id="tombol-reload" style="padding-left: 5px; float: left;"></div>
<br style="clear: both;" />
<?php echo $table; ?>
</body>
</html>
