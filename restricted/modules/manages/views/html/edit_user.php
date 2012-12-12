<script type="text/javascript">
    Ext.Loader.setConfig({
        enabled: true
    });
    
   Ext.Loader.setPath('Ext.ux', '<?php echo base_url() ?>public/extjs/ux');  

    Ext.onReady(function() {
    var tes = [
        ['0','Customer'],
        ['1','Sysadmin'],
    ];
    var statesStore = Ext.create('Ext.data.ArrayStore', {
        fields: ['tipe_index','tipe'],
        data : tes 
    })
    
   var editPort =  Ext.create('Ext.Viewport', {
            layout: {
                type: 'fit',
                padding: 5
            },
            items: [{
                id: 'form_user',
				xtype: 'form', 
				waitMsgTarget: true,
				method: 'POST',
				frame : true,
				border:false,
                url: '<?php echo base_url()?>manages/update_proses',
                items: [{
                  xtype: 'panel',
				  buttonAlign: 'center',
				  style: 'font-family:arial;',
                  items : [
                        {
                			xtype: 'textfield',
                			fieldLabel: 'Username',
                            value : '<?php if($useredit[0]['username'] != ' '){echo $useredit[0]['username'];} else { echo ' ';} ?>',
                			name: 'username',
                			id: 'logUsername',
                			allowBlank: false,
                            width:500
                            
                		}, {
                			xtype: 'textfield',
                			fieldLabel: 'Password',
                			name: 'password',
                            id: 'logPassword',
                			allowBlank: true,
                			inputType: 'password',
                            width:500
                            
                            
                		},{
                			xtype: 'textfield',
                			fieldLabel: 'name',
                			value : '<?php if($useredit[0]['name'] != ' '){echo $useredit[0]['name'];} else { echo ' ';} ?>',
                			
                            name: 'name',
                            id: 'name',
                			allowBlank: false,
                			inputType: 'text',
                            width:500
                            
                            
                		},
                        {
                			xtype: 'checkbox',
                			fieldLabel: 'Active',
                            <?php if($useredit[0]['is_active'] == 1){ ?>
                            checked : true,
                            <?php } else { ?>
                            checked : false,
                            <?php } ?>
                			name: 'is_active',
                            id: 'is_active',
                            
                		},
                        {
                            xtype: 'combo',
                            width:500,
                            fieldLabel: 'User type',
                            id:'tipe_index',
                            hiddenName : 'tipe_index',
                            store: statesStore,
                            valueField: 'tipe_index', //kasih valueField untuk ngebaca index array
                            value : '<?php if($useredit[0]['user_type'] == 0){echo 'Customer';} else { echo 'Sysadmin';} ?>',
                			//value : 'haha',
                            displayField: 'tipe',
                            allowBlank: false,
                                   
                        },
                        {
							xtype: 'hidden',
							name:'id_user',
                            value : '<?php if($useredit[0]['id'] != ' '){echo $useredit[0]['id'];} else { echo ' ';} ?>',
							id: 'id_user'
						},
                        {
							xtype: 'hidden',
							name:'name_hidden',
                            value : '<?php if($useredit[0]['username'] != ' '){echo $useredit[0]['username'];} else { echo ' ';} ?>',
                            id: 'name_hidden'
						}
              		]
                }],
                buttons : [
                {
                    text : 'Save', handler : function(){
                        var getTombol = Ext.getCmp('form_user');
                        getTombol.getForm().submit({
                            waitMsg : 'Please wait...',
                            success : function(){
                                parent.Ext.getCmp('gridData').store.load();
                                var jendela = parent.window.Ext.getCmp('winYa');
                                jendela.close();
                            }
                        })
                    }
                },
                {
                    text : 'Cancel',
                    handler : function(){
                        var jendela = parent.window.Ext.getCmp('winYa');
                                jendela.close();
                    }
                }
                ]
            }
            
            ]
        });
      Ext.EventManager.onWindowResize(function () {
        editPort.setSize(undefined, undefined);
    });

});
    </script>