<?php
if($detail['statusbayar'] == 'Belum membayar')
{
    $stat =  '<span style="color: red;">Belum membayar</span>';
} elseif($detail['statusbayar'] == 'Uang muka')
{
    $stat = '<span style="color: orange;">Masih kurang</span>';
} else {
    $stat = '<span style="color:green;">Lunas</span>';
}
?>

<script type="text/javascript">
    Ext.onReady(function(){
        var waitMask = new Ext.LoadMask(Ext.getBody(), {msg:"Please wait..."});
        waitMask.show();
        var viewport = new Ext.create('Ext.Viewport', {
            layout : 'fit',
            loadMask: true,
            items : [
                {
                    xtype : 'panel',
                    id : 'formpanelss',
                    frame : true,
                    width : 1000,
                    
                    layout:'column',
                    items:[{
                        xtype: 'container',
                        columnWidth:.5,
                        layout: 'anchor',
                        
                        items: [
                        {
                            xtype : 'component',
                            padding : '5px 5px 5px 5px',
                            html : '<span style="color:black; font-weight:bold;">Tanggal booking:</span> <?php echo $detail['tanggal_booking']; ?>'  
                        },
                        {
                            xtype : 'component',
                            padding : '5px 5px 5px 5px',
                            html : '<span style="color:black; font-weight:bold;">Booking ID :</span> <?php echo $detail['bookid']; ?>'  
                        },
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : '<span style="color:black; font-weight:bold;">Name :</span> <?php echo $detail['nama']; ?>' 
                            
                        },
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : '<span style="color:black; font-weight:bold;">Nomor KTP/Identitas :</span> <?php echo $detail['no_ktp']; ?>' 
                            
                        },
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : '<span style="color:black; font-weight:bold;">Lapangan :</span> <?php echo $detail['nama_lapangan']; ?>' 
                            
                        },
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : '<span style="color:black; font-weight:bold;">Alamat :</span> <?php echo $detail['alamat']; ?>' 
                            
                        },
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : '<span style="color:black; font-weight:bold;">Nomor telfon :</span> <?php echo $detail['no_telfon']; ?>' 
                            
                        },
                        
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : '<span style="color:black; font-weight:bold;">Email :</span> <?php echo $detail['email']; ?>' 
                            
                        },
                        ]
                    },{
                        xtype: 'container',
                        columnWidth:.5,
                        layout: 'anchor',
                        
                        items: [
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : '<span style="color:black; font-weight:bold;">Time start:</span> <?php echo $detail['time_start']; ?>'    
                        },
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : '<span style="color:black; font-weight:bold;">Time end</span>:</span> <?php echo $detail['time_end']; ?>'    
                        },
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : '<span style="color:black; font-weight:bold;">Durasi :</span> <?php echo $detail['duration']; ?>' 
                            
                        },
                        
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : '<span style="color:black; font-weight:bold;">Total tagihan :</span> <?php echo rupiah($detail['total']); ?>' 
                            
                        },
                        
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : '<span style="color:black; font-weight:bold;">Uang muka :</span> <?php echo rupiah($detail['jumlah_yang_dibayar']); ?>' 
                            
                        },
                        
                        <?php if($detail['statusbayar'] == "Uang muka"){ ?>
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : '<span style="color:black; font-weight:bold;">Pembayaran yang kurang :</span> <?php echo rupiah($detail['lesspaid']); ?>' 
                            
                        },
                        <?php } ?>
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : '<span style="color:black; font-weight:bold;">Discount: <?php  echo $detail['discount']; ?> %</span>'
                            
                        },
                        
                        {
                            padding : '5px 5px 5px 5px',
                            xtype : 'component',
                            html : '<span style="color:black; font-weight:bold;">Status: <?php  echo $stat; ?></span>'
                            
                        },
                        
                        ]
                    }],
                 renderTo : 'tampil'   
                }
                
                
            ]
        })
    waitMask.hide();
    })
</script>
<div id="tampil">
</div>