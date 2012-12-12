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
        
        public function getDataLapanganbyId($idLapangan)
        {
            $this->db->select('id, harga_sewa_pagi,harga_sewa_siang,harga_sewa_malem');
            $this->db->where('id',$idLapangan);
            return $this->db->get('lapangan')->result_array();
        }
        
        public function getdatabooking()
        {
            $q = $this->db->query("
                select t1.lapangan_id,t2.nama_lapangan, t1.jam,t1.duration,t3.nama FROM
                (select * FROM temp_booking ) as t1
                LEFT JOIN lapangan as t2
                ON t1.lapangan_id = t2.id
                
                LEFT JOIN (select id,nama from customers) as t3
                ON t1.customer_id = t3.id
                WHERE t1.lapangan_id=3

            ");
            return $q->result_array();
        }
        
        public function cekcustomer($get)
        {
            $q= $this->db->query("SELECT * FROM customers WHERE no_ktp LIKE '%$get%'");
            return array('row'=>$q->num_rows(),'data'=>$q->result_array());
        }
        
        public function getCustomer($custnameKtp)
        {
            $q = $this->db->query("SELECT * FROM customers WHERE no_ktp='$custnameKtp'");
            return array('rows'=>$q->num_rows(),'data'=>$q->result_array());
        }
        
        public function ambilSelisih($tanggalFrom,$tanggalThru)
        {
            $q = $this->db->query("SELECT datediff('$tanggalFrom','$tanggalThru') as selisih");
            return $q->result_array();   
        }
        
        public function ambilSelisihDua($tanggalFrom,$tanggalThru)
        {
            $q = $this->db->query("SELECT datediff('$tanggalThru','$tanggalFrom') as selisih");
            return $q->result_array();   
        }
        
        public function cekLapanganYa($gabungTimeStart,$gabungTimeEnd,$id)
        {
            $strtoTimeEnd = strtotime($gabungTimeEnd);
            $timeEnd = $strtoTimeEnd-1800;
            
            $q = $this->db->query("
            SELECT t1.*, t2.*
            FROM 
            (SELECT id,id_lapangan FROM bookings WHERE id_lapangan='$id') as t1
            INNER JOIN (SELECT booking_id,time_interval FROM booking_time WHERE time_interval BETWEEN '$gabungTimeStart' AND '".date("Y-m-d H:i:s",$timeEnd)."') as t2
            ON t1.id = t2.booking_id

            ");
            return $q->num_rows();   
        }
        
        public function getDataEdit($id)
        {
            $this->db->where('id',$id);
            $this->db->from('lapangan');
            $query = $this->db->get();
            return $query->result_array();
        }
        public function getAvailableUser($idGroup)
        {
            $q = $this->db->query("
            SELECT t1.*,t2.* FROM 
            (select * from users) as t1
            LEFT JOIN
            (select * from user_groups WHERE id_group='$idGroup') as t2
            ON t1.id = t2.id_user
            WHERE t2.id_group IS NULL
            ");
            return array('row'=>$q->num_rows(),'data'=>$q->result_array());
        }
        
        public function getAuthorizedusergroup($idGroup)
        {
            $q = $this->db->query("
            SELECT * from users WHERE id IN 
            (select id_user from user_groups WHERE id_group='$idGroup')
            ");
            return array('row'=>$q->num_rows(),'data'=>$q->result_array());
            
        }
        public function getDataSetting()
        {
            $q =  $this->db->query("SELECT * FROM setting");
            return $q->result_array();
        }
        
    }
?>