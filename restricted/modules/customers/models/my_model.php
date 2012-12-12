<?php
    class My_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }
        
        public function getDataall($limit,$start)
        {
            $q = $this->db->query("SELECT * FROM customers ORDER BY id DESC LIMIT $start,$limit");
            return array('rows'=>$q->num_rows(),'data'=>$q->result_array());
        }
        
        public function cekKtp($noKtp)
        {
            $this->db->select('*');
            $this->db->where('no_ktp',$noKtp);
            $b = $this->db->get('customers');
            return $b->num_rows();
        }
        
        public function getDataEdit($id)
        {
            $q = $this->db->query("SELECT * FROM customers WHERE id='$id'");
            return $q->result_array();
        }
    }
?>