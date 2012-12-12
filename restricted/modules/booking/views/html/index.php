<div class="header-booking"><h1>Booking lapangan</h1></div>
<script type="text/javascript">

        //function openWindow(id,title){
//             Ext.create('Ext.window.Window', {
//                title: title,
//                height: 100,
//                width: 400,
//                layout: 'fit',
//                id: 'jendelaBooking',
//                modal :true,
//                items : [ {
//                    xtype : 'form',
//                    id : 'formbook',
//                    method : 'POST',
//                    url : '<?php echo base_url() ?>booking/cek_ktp',
//                    items : [
//                        {
//                            padding : '5px 5px 5px 5px',
//                            xtype : 'textfield',
//                            name : 'ktp',
//                            fieldLabel : 'Nomor KTP',
//                            allowBlank : false
//                        },
//                        {
//                            xtype : 'hidden',
//                            name : 'id_lapangan',
//                            value : id
//                        },
//                        {
//                            xtype : 'hidden',
//                            name : 'nama_lapangan',
//                            value : title
//                        }
//                        
//                    ],
//                    buttons : [
//                        {
//                            text:'Next',
//                            handler : function(){
//                                var submitCek = Ext.getCmp('formbook');
//                                submitCek.getForm().submit({
//                                    waitMsg:'Saving ...', 
//                                    success : function(form,action){
//                                        Ext.getCmp('formbook').hide();
//                                    },
//                                    failure : function(form,action){
//                                        if(action.failureType == 'server'){
//                                            alert(action.response.responseText);
//                                       // Ext.getCmp('jendelaBooking').close();
//                                        } else {
//                                            alert('kosong');
//                                        }
//                                    }
//                                })
//                            }
//                        },
//                    ]
//                }]
//            }).show();
//        }
    function openWindow(id,title){
        window.loacation='<?php echo base_url() ?>booking/display_lapangan/'+id+'/'+title+'';
    }
    
</script>
<div class="booking-box">

<ul>
	<?php 
        foreach($data as $val){
             ?>
                 <li class="first-child"><div class="curve-down">
                 <a href="javascript:void(0);" onclick="window.location='<?php echo base_url() ?>booking/getlapangan/<?php echo $val['id'] ?>'" id="pop">
                 <div class="title-box">
                    <?php echo $val['nama_lapangan'] ?> 
                 </div>
                 <img width="237" height="155" alt="" src="<?php echo base_url() ?>assets/field.png"/><span class="play"></span></a></div>
                 </li>
             <?php
        }
    ?>
	
</ul>
<br style="clear: both;" />
</div>