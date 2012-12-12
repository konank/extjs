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
        
        public function cek_data($code)
        {
            $q= $this->db->query("SELECT * FROM lapangan WHERE kode_lapangan='$code'");
            return $q->num_rows();
        }
        public function getDataEdit($id)
        {
            $this->db->where('id',$id);
            $this->db->from('lapangan');
            $query = $this->db->get();
            return $query->result_array();
        }
        
    }
?>