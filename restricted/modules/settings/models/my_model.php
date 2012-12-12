<?php 
    class My_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }
        
        public function getDataSetting()
        {
            $q =  $this->db->query("SELECT * FROM setting");
            return $q->result_array();
        }
        
        public function getDataEdit($id)
        {
            $this->db->where('id',$id);
            $this->db->from('setting');
            $query = $this->db->get();
            return $query->result_array();
        }
        
    }
?>