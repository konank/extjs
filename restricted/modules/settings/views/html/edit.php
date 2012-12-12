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
                          url: '<?php echo base_url()?>settings/update_proses',
            			  frame : true,
    				      border:false,
        				  buttonAlign: 'right',
        				  style: 'font-family:arial;',
                          items : [
                            {
                              	xtype: 'timefield',
                    			fieldLabel: 'Min time',
                    			name: 'min_time',
                                id: 'jamedit',
                                value: '<?php 
                                if($data[0]['min_time'] == '24:00:00'){
                                    echo '00:00:00';
                                } else {
                                    echo $data[0]['min_time'];
                                }
                                 ?>',
                    			allowBlank: false,
                    			format:"H:i:s",
                                increment: 60,
                        
                            },
                            {
                              	xtype: 'timefield',
                    			fieldLabel: 'Max time',
                    			name: 'max_time',
                                id: 'jam_endedit',
                                value: '<?php 
                                if($data[0]['max_time'] == '24:00:00'){
                                    echo '00:00:00';
                                } else {
                                    echo $data[0]['max_time'];
                                }
                                 ?>',
                                format:"H:i:s",
                                increment: 60,
                    			allowBlank: false,
                    			
                            },
                            {
                                xtype : 'hidden',
                                name : 'id',
                                value : '<?php echo $data[0]['id'] ?>'
                            }
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