<?php
    function ubahJamHarga($var)
    {
        //$data[0]['harga_sewa_pagi'];
        if($var != '' && $var != null){
            list($harga,$timeStart,$timeEnd) = explode('|',$var);
            return array('harga'=>$harga,'time_start'=>$timeStart,'time_end'=>$timeEnd);
            
        } 
    }
    
    $total = $data['total'];
    $uangmuka = $data['jumlah_yang_dibayar'];
    $result = $total-$uangmuka;
    
    if($result != 0){
        $res =  $result;
    } else {
        $res =  '0';
    }
    
?>
<script type="text/javascript">
var tes = [
            ['0','Belum bayar'],
            ['1','Uang muka'],
            ['2','Lunas'],
];
var statusStore = Ext.create('Ext.data.ArrayStore', {
    fields: ['tipe_index','tipe'],
    data : tes 
}) 
   Ext.onReady(function(){
        var viewportNya = new Ext.create('Ext.Viewport',{
            layout:'fit',
            
            items : [
                    {
                    xtype : 'form',
                    id : 'formpanelss',
                    frame : true,
                    
                    method : 'POST',
                    layout:'column',
                    url : '<?php echo base_url() ?>billing/update_proses',
                    items:[{
                        xtype: 'container',
                        columnWidth:.4,
                        layout: 'anchor',
                        items: [
                        {
                            xtype : 'component',
                            padding : '5px 5px 5px 5px',
                            html : 'Booking ID : <?php echo $data['bookid'] ?>'  
                        },
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : 'Name : <?php echo $data['nama'] ?>' 
                            
                        },
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : 'Nomor KTP : <?php echo $data['no_ktp'] ?>' 
                            
                        },
                        {
                            xtype : 'hidden',
                            name : 'bookid',
                            value : '<?php echo $data['bookid'] ?>'
                        },
                        
                        ]
                    },{
                        xtype: 'container',
                        columnWidth:.4,
                        layout: 'anchor',
                        
                        items: [
                        {
                			xtype: 'textfield',
                			fieldLabel: 'Total',
                			value : '<?php echo $data['total']; ?>',
                            name: 'total',
                			id: 'total',
                            allowBlank: false,
                            width:360
                		},
                        {
                			xtype: 'textfield',
                			fieldLabel: 'Uang muka',
                			value : '<?php echo $data['jumlah_yang_dibayar']; ?>',
                            name: 'uangmuka',
                			id: 'uangmuka',
                            hidden :<?php if($data['status_bayar'] == 1){ ?>false<?php } else {?>true<?php } ?>,
                            allowBlank: false,
                            width:360
                		},
                        {
                			xtype: 'textfield',
                			fieldLabel: 'Discount',
                			value : '<?php echo $data['discount']; ?>',
                            name: 'discount',
                			id: 'discount',
                            allowBlank: false,
                            width:360
                		},
                        {
                            xtype: 'combo',
                            
                            fieldLabel: 'Status',
                            id:'tipe_index',
                            hiddenName : 'tipe_index',
                            store: statusStore,
                            valueField: 'tipe_index', //kasih valueField untuk ngebaca index array
                            value : '<?php echo $data['status_bayar'] ?>',
                            displayField: 'tipe',
                            allowBlank: false,
                            forceSelection: true ,
                            listeners : {
                                change : function(a,b){
                                    if(b != 1){
                                        var uangM = Ext.getCmp('uangmuka');
                                        uangM.hide();
                                    } else {
                                        var uangM = Ext.getCmp('uangmuka');
                                        uangM.show();
                                    }
                                }
                            }
                                   
                        },
                        {
                			xtype: 'textfield',
                			fieldLabel: 'Keterangan',
                			value : '<?php echo $data['keterangan']; ?>',
                            name: 'keterangan',
                			id: 'keterangan',
                            allowBlank: false,
                            width:360,
                		},
                        {
                			xtype: 'textfield',
                			fieldLabel: 'Grand total',
                			value : '<?php echo $res; ?>',
                            name: 'grandtotal',
                            allowBlank: false,
                            width:360,
                		},
                        
                        ]
                    }],
                    buttons : [
                        {
                            text : 'Submit',handler : submitData
                        },
                        {
                            text : 'Cancel',handler : closeBill
                        }
                    ]
                   
                }
                
                    ]
        })
        //viewportNya.show();
        
       
    })
    function submitData()
    {
        var getSubmit = Ext.getCmp('formpanelss');
        getSubmit.submit({
            success : function(){
                parent.Ext.getCmp('gridData').store.load({
                    params : {
                        start: 0, 
            			limit: 0,
            			dateNya: parent.Ext.getCmp('tanggal').getValue(),
            			lapanganId : 0
                    }
                });
                var getWindow = window.parent.Ext.getCmp('editbill');
                getWindow.close();    
                    
            }
        })
    }
    function closeBill()
    {
        var getWindow = window.parent.Ext.getCmp('editbill');
        getWindow.close();
    }
    </script>
   <div id="tes"></div>