<script type="text/javascript">
    Ext.Loader.setConfig({
        enabled:true
    })
    
    Ext.Loader.setPath('Ext.ux', '<?php echo base_url() ?>public/extjs/ux'); 
    Ext.onReady(function(){
        
        var g = [
            ['Laki-laki'],
            ['Perempuan']
        ]
        
        var genderStore = Ext.create('Ext.data.ArrayStore',{
            fields : ['gender'],
            data : g
        })
         var editPort =  Ext.create('Ext.Viewport', {
            layout: {
                type: 'fit',
                padding: 5
            },
            items: [{
                id: 'formedit',
				xtype: 'form', 
				waitMsgTarget: true,
				method: 'POST',
				frame : true,
				border:false,
                url: '<?php echo base_url()?>customers/proses_update',
                items: [{
                  xtype: 'panel',
                  
                  items : [
                        {
                                
                                xtype : 'textfield',
                                name : 'ktp',
                                fieldLabel : 'Nomor KTP',
                                allowBlank : false,
                                value : '<?php echo $data[0]['no_ktp'] ?>',
                                width : 500 
                            },
                            {
                                xtype : 'textfield',
                                name : 'nama',
                                fieldLabel : 'Nama customer',
                                value : '<?php echo $data[0]['nama'] ?>',
                                allowBlank : false,
                                width : 500 
                            },
                            {
                                fieldLabel: 'Email',
                                name: 'email',
                                xtype:'textfield',
                                width : 500,
                                value : '<?php echo $data[0]['email']; ?>'
                            },
                            {
                                xtype : 'textareafield',
                                name : 'alamat',
                                fieldLabel : 'Alamat',
                                value : '<?php echo $data[0]['alamat'] ?>',
                                allowBlank : false,
                                width : 500 
                            },
                            {
                                xtype : 'combo',
                                width : 500,
                                fieldLabel : 'Gender',
                                store : genderStore,
                                id:'gender',
                                value : '<?php echo $data[0]['gender'] ?>',
                                name : 'gender',
                                displayField: 'gender',
                                allowBlank : false
                            },
                            {
                                xtype : 'textfield',
                                name : 'telfon',
                                fieldLabel : 'No Telfon',
                                value : '<?php echo $data[0]['no_telfon'] ?>',
                                allowBlank : true,
                                width : 500 
                            },
                            {
                                xtype : 'hiddenfield',
                                name : 'id',
                                value : '<?php echo $data[0]['id']; ?>'
                            },
                            {
                                xtype : 'hiddenfield',
                                name : 'ktpnya',
                                value : '<?php echo $data[0]['no_ktp']; ?>'
                            },
              		]
                }],
                buttons : [
                            {
                                text : 'Save',
                                handler : function(){
                                    var submit = Ext.getCmp('formedit');
                                    submit.getForm().submit({
                                        waitMsg:'Saving ...', 
                                        success : function(form,action){
                                            parent.Ext.getCmp('gridData').store.load(); //reload gridnya
                                            var tutup = window.parent.Ext.getCmp('JendelaEdit');
                                            tutup.close();
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
                                text: 'Cancel',
                                handler : function(){
                                    var tutup = window.parent.Ext.getCmp('JendelaEdit');
                                    tutup.close();
                                }
                            }
                        ]
            }
            
            ]
        });
        
        Ext.EventManager.onWindowResize(function () {
            editPort.setSize(undefined, undefined);
        });
    })
</script>