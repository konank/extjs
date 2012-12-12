<script type="text/javascript">
Ext.onReady(function(){
     
     var editPort =  Ext.create('Ext.Viewport', {
            layout: {
                type: 'column',
                padding: 0
            },
            items: [{
                id:'form_setmember',
                xtype: 'form', 
				autoScroll:true,
				buttonAlign: 'center',
				waitMsgTarget: true,
				method: 'POST',
				labelWidth: 100,
				frame:true,
				border:false,
                url: '<?php echo base_url()?>groups/set_member',
                items: [
					{
						xtype: 'label',
						style: 'font-size:12px',
						id: 'group_name',
						text : 'Group Name: <?php echo $nameGroup; ?>'
					},
					{
						//xtype: 'textfield',
						xtype: 'hidden',
                        style: 'font-size:12px',
						id: 'group_id',
                        name : 'group_id',
						
						value :  '<?php echo $groupId; ?>'
					},
                    
                    {
						xtype:'panel',
						style: 'font-size:12px',
						layout:'column',
						width:500,
						frame:false,
                        
						defaults: {layout:'form'},
						items:[
								{
									columnWidth: .4,
                                    border:false,
                                    
									items: [{
										xtype: 'fieldset',
										autoHeight:true,
										
										title:'Available users ',
										items:[{
												style	:'text-align:center',
                                                
												html	:'<select id="available_user" style="border:1px solid #FFFFFF; width:190px ; height:230px"    class="formpk"   size="8" multiple="MULTIPLE">'+' <?php echo $available_user; ?>'
										}]
									}]
								},
								{
									columnWidth: .1,
                                    border:false,
									style : 'text-align:center',
									items:[
										
										{
											xtype  	: 'button',
											icon	: '<?php echo base_url();?>public/icons/right.png',
											
											style	: 'margin-left:auto ; margin-right:auto',
											handler : setRight
										},
										
										{
											xtype  	: 'button',
											icon	: '<?php echo base_url();?>public/icons/left.png',
											style	: 'margin-left:auto ; margin-right:auto',
											handler	: setLeft
										}
									]
								},
								{
									columnWidth: .4,
                                    border:false,
									items: [{
										xtype: 'fieldset',
										autoHeight:true,
										
										title:'Authorized users ',
										items:[{
											style	:'text-align:center',
											html	:'<select id="authorized_user" style="border:1px solid #FFFFFF; width:190px; height:230px"   class="formpk"  size="8" multiple="MULTIPLE">'+'<?php echo $authuser; ?>'
										}]
									}]
								}
							],
						buttonAlign:'center',
						
                    }
                ],
                buttons: [{
                    text: 'Save',
                    handler: function(){
                        var submitForm = Ext.getCmp('form_setmember');
                        
                        submitForm.getForm().submit({
                            waitMsg:'Saving ...', 
                            params : { user_get_autorhized : getAuthorizedUser() },
			
                            success : function(form,action){
                                //grid.store.load();   
                                parent.Ext.getCmp('gridData').store.load(); //reload gridnya
                                  
                                var win = window.parent.Ext.getCmp('WinPrivilege');
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
                        var win = window.parent.Ext.getCmp('WinPrivilege');
                        
                        //Ext.getCmp('form_user').getForm().reset();
                        win.close();
                        
        
                    }
                }]
            }
            
            ]
        });
     function getAuthorizedUser()
     {
    	var desired = document.getElementById("authorized_user");
    	var ret = '';
    	Ext.each(desired.options,function(items) {
    		ret = ret + items.value + "|";
    	});
    	return ret;
     }
     
     function setRight()
     {
        
        	var list = document.getElementById("available_user");
        	var long = list.length;
        	var desired = document.getElementById("authorized_user");
        	var tail = desired.length;
        	for(i=0;i< long; i++) {
        		if(list.options[i].selected)	{	
        			desired.options[tail] = new Option(list.options[i].innerHTML,list.options[i].value);
        			tail++;
        			list.remove(i);i--;long--;
        		}
        	}
        
     }
     
     function setLeft()
    {
    	var list = document.getElementById("available_user");
    	var long = list.length;
    	var desired = document.getElementById("authorized_user");
    	var tail = desired.length;
    	for(i=0;i< tail; i++) {
    		if(desired.options[i].selected)	{	
    			list.options[long] = new Option(desired.options[i].innerHTML,desired.options[i].value);
    			long++;
    			desired.remove(i);i--;tail--;
    		}
    	}
    }
})
</script>
