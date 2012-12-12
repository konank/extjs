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
                id: 'form_roles',
				xtype: 'form', 
				waitMsgTarget: true,
				method: 'POST',
                
				frame : true,
				border:false,
                url: '<?php echo base_url()?>accessroles/update_proses',
                items: [{
                  xtype: 'panel',
				  width: 477,
                  
				  buttonAlign: 'center',
				  style: 'font-family:arial;',
                  items : [
                        {
                			xtype: 'textfield',
                			fieldLabel: 'name',
                			name: 'name',
                			id: 'name',
                            value : '<?php if($data[0]['name'] != ' '){echo $data[0]['name'];} else { echo ' ';} ?>',
                			allowBlank: false,
                            width:470
                		}, 
                        {
							xtype: 'hidden',
							name:'id',
                            value : '<?php if($data[0]['id'] != ' '){echo $data[0]['id'];} else { echo ' ';} ?>',
							id: 'id'
						},
                        {
							xtype: 'hidden',
							name:'name_hidden',
                            value : '<?php if($data[0]['name'] != ' '){echo $data[0]['name'];} else { echo ' ';} ?>',
                            id: 'name_hidden'
						}
              		]
                }],
                buttons: [{
                    text: 'Save',
                    handler: function(){
                        var submitForm = Ext.getCmp('form_roles');
                        
                        submitForm.getForm().submit({
                            waitMsg:'Saving ...', 
                            success : function(form,action){
                                //grid.store.load();   
                                parent.Ext.getCmp('gridData').store.load(); //reload gridnya
                                
                                var win = window.parent.Ext.getCmp('RolesWindow');
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
                        var win = window.parent.Ext.getCmp('RolesWindow');
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