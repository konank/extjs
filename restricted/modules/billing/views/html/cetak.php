<html>
<head>
	<title>:: Bukti Pembayaran ::</title>
	<style>
    .style1 {
		font-family: Tahoma;
		font-size:12;
		font-weight: bold;
	}
	.style2 {
		font-family: Tahoma;
		font-size:12;
	}
	.style3 {
		font-family:Tahoma;
		font-size: 11px;
		font-weight:bold;
	}
	.style4 {
		font-family:Tahoma;
		font-size: 11px;
	}
	.style5 {
		font-family:Tahoma;
		font-size: 10px;
		font-weight:bold;
	}
	.style6 {
		font-family:Tahoma;
		font-size: 10px;
	}
    </style>
</head>

<body>
	<table width="750" border="1" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<th height="25" class="style3"> 
				BUKTI PEMBAYARAN			
			</th>
	  	</tr>
	  	<tr>
			<td>
		  		<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
			  			<td width="17%" valign="top">&nbsp;</td>
			  			<td valign="top">&nbsp;</td>
			  			<td valign="top" align="right" class="style4">&nbsp;</td>
					</tr>
					<tr>
					  	<td height="30" valign="top" class="style3">[ LOGO ]</td>
					  	<td valign="top">&nbsp;</td>
					  	<td valign="top" class="style4">&nbsp;</td>
				  	</tr>
					<tr>
					  	<td colspan="3" valign="top" class="style5">
							<u>Jl. Alamat Pengelola. Telp. (0000) 111111. Fax. (0000) 222222. </u>
						</td>
				  	</tr>
					<tr>
			  			<td width="17%" valign="top">&nbsp;</td>
			  			<td valign="top">&nbsp;</td>
			  			<td valign="top" class="style4">&nbsp;</td>
					</tr>
					<tr>
			  			<td width="17%" height="25" valign="top" class="style3"> Nama / Instansi </td>
			  			<td width="3%" height="25" valign="top" class="style3">:</td>
			  			<td width="80%" height="25" valign="top" class="style4"> 
							<?php echo $cetak['data'][0]['nama']; ?>.						
						</td>
					</tr>
					<!--<tr>
					  	<td height="25" valign="top" class="style3">Tipe Tarif</td>
					  	<td height="25" valign="top" class="style3">:</td>
					  	<td height="25" valign="top" class="style4">
							.
						</td>
				  	</tr>-->
                    
                    <tr>
					  	<td height="25" valign="top" class="style3">Tanggal sewa</td>
					  	<td height="25" valign="top" class="style3">:</td>
					  	<td height="25" valign="top" class="style4">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
				  					<td width="20%" class="style4">
										 <?php 
                                         list($tanggalStart,$jamStart) = explode(' ', $cetak['data'][0]['time_start']);
                                         echo $tanggalStart;
                                         ?>
									</td>
				  					<td width="17%" class="style3">Jam Mulai</td>
				  					<td width="3%" class="style3">:</td>
				  					<td width="20%" class="style4">
										 <?php echo $jamStart; ?>&nbsp; WIB.
									</td>
								</tr>
			  				</table>
						</td>
				  	</tr>
					<tr>
			  			<td width="17%" height="25" valign="top" class="style3">Tanggal Sewa  </td>
			  			<td width="3%" height="25" valign="top" class="style3">:</td>
			  			<td width="80%" height="25" valign="top" class="style4">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
				  					<td width="20%" class="style4">
										 <?php 
                                         list($tanggalEnd,$jamEnd) = explode(' ', $cetak['data'][0]['time_end']);
                                         echo $tanggalEnd;
                                         ?>
									</td>
				  					<td width="17%" class="style3">Jam Berakhir</td>
				  					<td width="3%" class="style3">:</td>
				  					<td width="20%" class="style4">
										 <?php echo $jamEnd; ?>&nbsp; WIB.
									</td>
								</tr>
			  				</table>
						</td>
					</tr>
                    
                    <tr>
					  	<td height="25" valign="top" class="style3">Durasi</td>
					  	<td height="25" valign="top" class="style3">:</td>
					  	<td height="25" valign="top" class="style4">
							<?php echo trim($cetak['data'][0]['duration']); ?>.
						</td>
				  	</tr>
                    
					<tr>
			  			<td width="17%" height="25" valign="top" class="style3">Lapangan </td>
			  			<td width="3%" height="25" valign="top" class="style3">:</td>
			  			<td width="80%" height="25" valign="top" class="style4"> 
							[ <?php echo $cetak['data'][0]['kode_lapangan'] ?> ]/ <?php echo $cetak['data'][0]['nama_lapangan']; ?>.
						</td>
					</tr>
					<tr>
			  			<td width="17%" height="25" valign="top" class="style3">Keterangan</td>
			  			<td width="3%" height="25" valign="top" class="style3">:</td>
			  			<td width="80%" height="25" valign="top" class="style4"> 
							<?php echo $cetak['data'][0]['keterangan'] ?>.
						</td>
					</tr>
					<tr>
                      <td height="25" valign="top" class="style3">Total Tarif </td>
					  <td height="25" valign="top" class="style3">:</td>
					  <td height="25" valign="top" class="style4">
					  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                        	<tr>
								<td width="20%" class="style4">
									<?php echo rupiah($cetak['data'][0]['total']); ?> </td>
								<td width="17%" class="style3">Discount</td>
								<td width="3%" class="style3">:</td>
								<td width="20%" class="style4">
									 <?php echo $cetak['data'][0]['discount']; ?>%.
								</td>
                          	</tr>
                      	</table>
					</td>
				  	</tr>
                    <tr>
                      <td height="25" valign="top" class="style3">DP/Uang muka</td>
					  <td height="25" valign="top" class="style3">:</td>
					  <td height="25" valign="top" class="style4">
					  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                        	<tr>
								<td width="20%" class="style4">
										 
                                    <?php echo rupiah($cetak['data'][0]['jumlah_yang_dibayar']); ?>
                                    </td>
								<td width="17%" class="style3">Tarif bayar</td>
								<td width="3%" class="style3">:</td>
								<td width="20%" class="style4">
									 <?php
                                        if($cetak['data'][0]['discount'] != 0){
                                            if($cetak['data'][0]['jumlah_yang_dibayar'] != 0){
                                                $dikurangJumlahygdibayar = $cetak['data'][0]['jumlah_yang_dibayar'];
                                            } else {
                                                $dikurangJumlahygdibayar = 0;
                                            }
                                            $dis = $cetak['data'][0]['total'] - ($cetak['data'][0]['total'] * $cetak['data'][0]['discount']/100) - $dikurangJumlahygdibayar; 
                                        } else {
                                            $dis = $cetak['data'][0]['total'];
                                        }
                                        echo rupiah($dis);
                                    ?>
								</td>
                          	</tr>
                      	</table>
					</td>
				  	</tr>
					<tr>
                      	<td height="25" valign="top" class="style3">Terbilang</td>
					  	<td height="25" valign="top" class="style3">:</td>
					  	<td height="25" valign="top" class="style4">
							<?php echo Terbilang($dis); ?>.
						</td>
				  	</tr>
					<tr>
			  			<td width="17%" height="25" valign="top" class="style3">Tanggal Pembayaran  </td>
			  			<td height="25" valign="top" class="style3">:</td>
			  			<td height="25" valign="top" class="style4">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
				  					<td width="20%" class="style4">
										 <?php echo date('Y-m-d'); ?>
									</td>
				  					<td width="17%" class="style3">Jam Bayar </td>
				  					<td width="3%" class="style3">:</td>
				  					<td width="20%" class="style4">
										 <?php echo date('H:i:s'); ?> WIB.
									</td>
				  					<td width="17%" class="style3">Petugas</td>
				  					<td width="3%" class="style3">:</td>
				  					<td width="20%" class="style4">
										<?php echo $this->session->userdata('name') ?>.
									</td>
								</tr>
			  				</table>
						</td>
					</tr>
	  		  	</table>
		  		<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
			  			<td valign="top"><img src="../images/line_hor.gif" width="100%" height="6"></td>
					</tr>
					<tr>
			  			<td height="30" valign="top" class="style3">
							<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: 9px;
	font-weight: bold;
}
-->
</style>

<table width="100%" height="30" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
    	<td height="20" align="center" class="style5 style1">
			Copyright &copy;   Futsal Management System [Andrey derma].	All Right Reserved.	<br />
			Powered by Andrey derma
		</td>
  	</tr>
</table>			  			</td>
					</tr>
				</table>
			</td>
	  	</tr>
	</table>
	<script type="text/javascript">
        window.print();
    </script>
    <meta http-equiv="refresh" content="1 URL=<?php echo base_url() ?>billing/close"/>
    
</body>
</html>

