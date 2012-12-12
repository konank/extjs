<script type="text/javascript">
    Ext.Loader.setConfig({
        enabled: true
    });
    
   Ext.Loader.setPath('Ext.ux', '<?php echo base_url() ?>public/extjs/ux');  

    Ext.onReady(function() {
    Ext.QuickTips.init(); //untuk tooltip
    
   var editPort =  Ext.create('Ext.Viewport', {
            layout: {
                type: 'fit',
                padding: 5
            },
            items: [{
                id: 'form_acl',
				xtype: 'form', 
				waitMsgTarget: true,
				method: 'POST',
				frame : true,
				border:false,
                url: '<?php echo base_url()?>acl/update_proses',
                items: [{
                  xtype: 'panel',
				  width: 478,
                  
				  buttonAlign: 'center',
				  style: 'font-family:arial;',
                  items : [
                        {
                			xtype: 'textfield',
                			fieldLabel: 'Class name',
                			name: 'class_name',
                			id: 'class_name',
                            value : '<?php if($data[0]['class_name'] != ' '){echo $data[0]['class_name'];} else { echo ' ';} ?>',
                			allowBlank: false,
                            width:500
                		}, {
                			xtype: 'textfield',
                			fieldLabel: 'Method',
                			name: 'method',
                			id: 'method',
                            value : '<?php if($data[0]['method'] != ' '){echo $data[0]['method'];} else { echo ' ';} ?>',
                			allowBlank: true,
                            width:500
                		}, 
                        {
							xtype: 'hidden',
							name:'id',
                            value : '<?php if($data[0]['id'] != ' '){echo $data[0]['id'];} else { echo ' ';} ?>',
							id: 'id'
						},
                        
              		]
                }],
                buttons: [{
                    text: 'Save',
                    handler: function(){
                        var submitForm = Ext.getCmp('form_acl');
                        
                        submitForm.getForm().submit({
                            waitMsg:'Saving ...', 
                            success : function(form,action){
                                //grid.store.load();   
                                parent.Ext.getCmp('gridData').store.load(); //reload gridnya
                                
                                var win = window.parent.Ext.getCmp('editAclWindow');
                                win.close();
                        
                                
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
                
                , {
                    text: 'Cancel',
                    handler: function()
                    {
                        //eventForm.getForm().reset();
                        
                        //ambil parent iframe window, menggunakan getCmp; lalu lakukan hide
                        var win = window.parent.Ext.getCmp('editAclWindow');
                        //Ext.getCmp('form_user').getForm().reset();
                        win.close();
                        
        
                    }
                }]
            }
            
            ]
        });
      Ext.EventManager.onWindowResize(function () {
        editPort.setSize(undefined, undefined);
    });

});
    </script>