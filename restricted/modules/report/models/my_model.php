<?php 
    class My_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }
        
        public function getDataLapangan()
        {
            $q =  $this->db->query("SELECT * FROM lapangan");
            return $q->result_array();
        }
        
        public function getCustomerReport($limit,$start)
        {
            $q= $this->db->query("SELECT * FROM customers ORDER BY id DESC LIMIT $start,$limit");
            
            return array('total'=>$q->num_rows(),'data'=>$q->result_array());
            
        }
        
        public function Getshowreport_daily($idLapangan,$date)
        {
             list($tgl,$jam) = explode('T',$date);
            
            $q = $this->db->query("
                SELECT t1.*,t2.id as booking_id,t2.id_lapangan,t2.time_start,t2.time_end,t2.duration,t2.keterangan,getStatusBayar(t2.status_bayar) as status_bayar,t2.tanggal_booking,t2.total,discount FROM
                        (SELECT id,no_ktp,nama,gender FROM customers) as t1
                        INNER JOIN bookings as t2
                        ON
                        t1.id = t2.id_customer
                        WHERE t2.id_lapangan='$idLapangan' AND t2.tanggal_booking LIKE '%$tgl%'
                 ORDER BY t2.tanggal_booking ASC
            ");
            return array('row'=>$q->num_rows(),'data'=>$q->result_array());
        }
        
        public function Getshowreport_monthly($idLapangan,$date,$tahun)
        {
            $gabung = "$tahun-$date";
            $q = $this->db->query("
                SELECT t1.*,t2.id as booking_id,t2.id_lapangan,t2.time_start,t2.time_end,t2.duration,t2.keterangan,getStatusBayar(t2.status_bayar) as status_bayar,t2.tanggal_booking,t2.total,discount FROM
                        (SELECT id,no_ktp,nama,gender FROM customers) as t1
                        INNER JOIN bookings as t2
                        ON
                        t1.id = t2.id_customer
                WHERE t2.id_lapangan='$idLapangan' AND t2.tanggal_booking LIKE '%$gabung%' ORDER BY t2.tanggal_booking DESC
            ");
            return array('row'=>$q->num_rows(),'data'=>$q->result_array());
        }
        
    }
?>