<?php 
    class My_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }
        
        public function getBillingData($idLapangan,$tanggal)
        {
            if($tanggal == ''){
                $tgl = date('Y-m-d');
            } else {
                list($tgl,$jam) = explode('T',$tanggal);
            }
            if($idLapangan != 0){
                $condition = 'WHERE id="'.$idLapangan.'"';
            } else {
                $condition = '';
            }
            $q =  $this->db->query("
            
            select t1.*,t4.* FROM 
            (SELECT * FROM lapangan ".$condition." ) as t1
            INNER JOIN 
            (SELECT lessPaid(t2.total,t2.jumlah_yang_dibayar) as lesspaid ,t2.jumlah_yang_dibayar,t2.total,t2.id as bookid,t2.duration,t2.id_lapangan,t2.time_start,t2.time_end,t2.tanggal_booking,t3.nama,getStatusBayar(t2.status_bayar) as status_bayar FROM bookings as t2
            LEFT JOIN customers as t3 ON t3.id = t2.id_customer WHERE time_start LIKE '%$tgl%'
            )
            as t4
            ON t1.id = t4.id_lapangan
            ORDER BY t4.tanggal_booking DESC
            
            ");
            return array('total'=>$q->num_rows(),'data'=>$q->result_array());
        }
        
        public function getPrint($idBooking)
        {
            $q =  $this->db->query("
            
            SELECT t1.*,t2.*,t3.nama,t3.no_ktp,t3.no_telfon,t3.email,t3.alamat FROM 
            (SELECT getStatusBayar(status_bayar) as statusbayar,lessPaid(total,jumlah_yang_dibayar) as lesspaid, id as bookid,jumlah_yang_dibayar, id_customer,id_lapangan,time_start,time_end,duration,total,tanggal_booking,keterangan,discount FROM bookings WHERE id='$idBooking') 
             as t1
             INNER JOIN 
             (SELECT id,kode_lapangan,nama_lapangan,harga_sewa_pagi,harga_sewa_siang,harga_sewa_malem FROM lapangan) as t2 
             ON t1.id_lapangan = t2.id
             INNER JOIN customers as t3
             ON t1.id_customer = t3.id
            ");
            return array('row'=>$q->num_rows(),'data'=>$q->result_array());
        }
        
        public function cek_data($code)
        {
            $q= $this->db->query("SELECT * FROM lapangan WHERE kode_lapangan='$code'");
            return $q->num_rows();
        }
        public function getDataEdit($idBooking)
        {
            $q = $this->db->query(
            "
            SELECT t1.*,t2.*,t3.nama,t3.no_ktp,t3.no_telfon,t3.email,t3.alamat FROM 
            (SELECT getStatusBayar(status_bayar) as statusbayar,status_bayar,lessPaid(total,jumlah_yang_dibayar) as lesspaid, id as bookid,jumlah_yang_dibayar, id_customer,id_lapangan,time_start,time_end,duration,total,tanggal_booking,keterangan,discount FROM bookings WHERE id='$idBooking') 
             as t1
             INNER JOIN 
             (SELECT id,kode_lapangan,nama_lapangan,harga_sewa_pagi,harga_sewa_siang,harga_sewa_malem FROM lapangan) as t2 
             ON t1.id_lapangan = t2.id
             INNER JOIN customers as t3
             ON t1.id_customer = t3.id
            "
            );
            return array('row'=>$q->num_rows(),'data'=>$q->result_array());
        }
        
    }
?>