<?php 
    class My_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }
        
        public function cekLogin($username,$password)
        {
            $query = $this->db->query("SELECT * FROM admin WHERE username='$username' AND password='".$password."'");
            $total = $query->num_rows();
            return array('total'=>$total,'rows'=>$query->result_array());
        }
        
        public function getDataall($limit,$start)
        {
            $q = $this->db->query("
            select t1.*,t2.* FROM customers as t1
            LEFT JOIN 
            (select count(id_customer) as total_booking,id_customer FROM bookings GROUP BY id_customer) as t2
            ON t1.id = t2.id_customer
            ORDER BY t2.total_booking DESC LIMIT 10
            ");
            return array('rows'=>$q->num_rows(),'data'=>$q->result_array());
        }
        
        public function getChartdata()
        {
            $q = $this->db->query("
            select t1.*,t2.* FROM 
            (SELECT id,nama_lapangan FROM lapangan)
             as t1
            LEFT JOIN 
            (SELECT COUNT(*) as jumlah,id_lapangan,((COUNT( * ) / ( SELECT COUNT( * ) FROM bookings)) * 100 ) AS percentage FROM bookings GROUP BY id_lapangan) as t2
            ON t1.id = t2.id_lapangan
            ");
            return array('row'=>$q->num_rows(),'data'=>$q->result_array());
        }
    }
?>