<?php
    function ubahJamHarga($var)
    {
        //$data[0]['harga_sewa_pagi'];
        if($var != '' && $var != null){
            list($harga,$timeStart,$timeEnd) = explode('|',$var);
            return array('harga'=>$harga,'time_start'=>$timeStart,'time_end'=>$timeEnd);
            
        } 
    }
    
?>
<script type="text/javascript">
   Ext.onReady(function(){
        var viewportNya = new Ext.create('Ext.Viewport',{
            layout:'fit',
            
            items : [
                    {
                          xtype: 'form',
      				      id: 'formedit',
            			  xtype: 'form', 
            			  waitMsgTarget: true,
            			  method: 'POST',
                          url: '<?php echo base_url()?>lapangan/update_proses',
            			  frame : true,
    				      border:false,
        				  buttonAlign: 'right',
        				  style: 'font-family:arial;',
                          items : [
                                {
                        			xtype: 'textfield',
                        			fieldLabel: 'Kode lapangan',
                        			name: 'kode_lapangan',
                        			value: '<?php echo $data[0]['kode_lapangan'] ?>',
                        			allowBlank: false,
                                    width:485
                                    
                        		}, {
                        			xtype: 'textfield',
                        			fieldLabel: 'Nama lapangan',
                        			name: 'name',
                                    id: 'name',
                                    value: '<?php echo $data[0]['nama_lapangan'] ?>',
                        			allowBlank: false,
                        			inputType: 'text',
                                    width:485
                        		}, 
                                {
                                    xtype : 'textareafield',
                                    fieldLabel : 'Keterangan',
                                    name : 'keterangan',
                                    width:485,
                                    value: '<?php echo $data[0]['keterangan'] ?>'
                                },
                                {
        							xtype: 'hidden',
        							name:'id',
                                    value : '<?php if($data[0]['id'] != ' '){echo $data[0]['id'];} else { echo ' ';} ?>',
        							id: 'id_user'
        						},
                                {
        							xtype: 'hidden',
        							name:'name_hidden',
                                    value : '<?php if($data[0]['kode_lapangan'] != ' '){echo $data[0]['kode_lapangan'];} else { echo ' ';} ?>',
                                    id: 'name_hidden'
        						},
                                {
                                xtype:'tabpanel',
                                plain:true,
                                activeTab: 0,
                                width:490,
                                id:'panelTabnya',
                                defaults:{bodyStyle:'padding:10px'},
                                items:[{
                                    title:'Pagi',
                                    defaults: {width: 475},
                                    defaultType: 'textfield',
                                    id:'tab1',
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
                                        value: '<?php 
                                        $ubah = ubahJamHarga($data[0]['harga_sewa_pagi']);
                                        echo $ubah['harga'];
                                         ?>',
                                        id: 'harga_pagiedit',
                            			allowBlank: false,
                            			inputType: 'text',
                                      
                                    },
                                    {
                                      	xtype: 'timefield',
                            			fieldLabel: 'Jam sewa start',
                            			name: 'jam_start_pagi',
                                        id: 'jamedit',
                                        value: '<?php 
                                        $ubah = ubahJamHarga($data[0]['harga_sewa_pagi']);
                                        echo $ubah['time_start'];
                                         ?>',
                            			allowBlank: false,
                            			format:"H:i:s",
                                        increment: 30,
                                
                                    },
                                    {
                                      	xtype: 'timefield',
                            			fieldLabel: 'Jam sewa end',
                            			name: 'jam_end_pagi',
                                        id: 'jam_endedit',
                                        value: '<?php 
                                        $ubah = ubahJamHarga($data[0]['harga_sewa_pagi']);
                                        echo $ubah['time_end'];
                                         ?>',
                                        format:"H:i:s",
                                        increment: 30,
                            			allowBlank: false,
                            			
                                    },
                                    ]
                                },{
                                    title:'Siang',
                                    defaults: {width: 475},
                                    defaultType: 'textfield',
                                    id:'tab2',
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
                                        id: 'harga_siangedit',
                                        value: '<?php 
                                        $ubahSiang = ubahJamHarga($data[0]['harga_sewa_siang']);
                                        echo $ubahSiang['harga'];
                                         ?>',
                            			allowBlank: false,
                            			inputType: 'text',
                                      
                                    },
                                    {
                                      	xtype: 'timefield',
                            			fieldLabel: 'Jam sewa start',
                            			name: 'jam_start_siang',
                                        id: 'jam_start_siangedit',
                            			allowBlank: false,
                            			format:"H:i:s",
                                        value: '<?php 
                                        $ubahSiang = ubahJamHarga($data[0]['harga_sewa_siang']);
                                        echo $ubahSiang['time_start'];
                                         ?>',
                                        increment: 30,
                                
                                    },
                                    {
                                      	xtype: 'timefield',
                            			fieldLabel: 'Jam sewa end',
                            			name: 'jam_end_siang',
                                        id: 'jam_end_siangedit',
                                        format:"H:i:s",
                                        increment: 30,
                                        value: '<?php 
                                        $ubahSiang = ubahJamHarga($data[0]['harga_sewa_siang']);
                                        echo $ubahSiang['time_end'];
                                         ?>',
                            			allowBlank: false,
                            			
                                    },
                                    
                                    ]
                                },
                                {
                                    title:'Malam',
                                    defaults: {width: 475},
                                    defaultType: 'textfield',
                                    id:'tab3',
                                    
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
                                        id: 'harga_malamedit',
                                        value: '<?php 
                                        $ubahMalem = ubahJamHarga($data[0]['harga_sewa_malem']);
                                        echo $ubahMalem['harga'];
                                         ?>',
                            			allowBlank: false,
                            			inputType: 'text',
                                    },
                                    {
                                      	xtype: 'timefield',
                            			fieldLabel: 'Jam sewa start',
                            			name: 'jam_start_malam',
                                        id: 'jam_start_malamedit',
                                        value: '<?php 
                                        $ubahMalem = ubahJamHarga($data[0]['harga_sewa_malem']);
                                        echo $ubahMalem['time_start'];
                                         ?>',
                            			allowBlank: false,
                            			format:"H:i:s",
                                        increment: 30,
                                
                                    },
                                    {
                                      	xtype: 'timefield',
                            			fieldLabel: 'Jam sewa end',
                            			name: 'jam_end_malam',
                                        id: 'jam_end_malamedit',
                                        format:"H:i:s",
                                        value: '<?php 
                                        $ubahMalem = ubahJamHarga($data[0]['harga_sewa_malem']);
                                        echo $ubahMalem['time_end'];
                                         ?>',
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
                              buttons : [
                              {
                                text: 'Save',
                                handler : function(){
                                    var tombol = Ext.getCmp('formedit');
                                    tombol.getForm().submit({
                                        waitMsg: 'Saving...',
                                        success : function(form,action){
                                            parent.Ext.getCmp('gridData').store.load();
                                            var win = parent.window.Ext.getCmp('winLap');
                                            win.close();
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
                                    var win = parent.window.Ext.getCmp('winLap');
                                    win.close();
                                    
                                }
                              }
                              ]
                        ,renderTo : 'tes',
                    }
                    ]
        })
        //viewportNya.show();
        
       
    })
    </script>
   <div id="tes"></div>