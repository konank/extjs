<script type="text/javascript">
    Ext.onReady(function(){
        var viewportNya = new Ext.create('Ext.Viewport',{
            layout:'fit',
            
            items : [
                {
                    xtype : 'panel',
                    frame : true,
                    title : " Akses ditolak",
				    border:false,
                    html : '<div style="text-align: left; padding:5px; font-size: 14px; color: red;">Anda tidak di beri akses untuk masuk ke halaman ini.</div>'
                        
                }
            ],
            renderTo : 'tes'
        })
        //viewportNya.show();
        
       
    })
    
     //var Jendela = new Ext.Window({
//            
//        })
//        
//        Jendela.show();
</script>
<div id="tes"> </div>