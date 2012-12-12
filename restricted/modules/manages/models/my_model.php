<?php 
    class My_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }
        
        public function getDataUser()
        {
            $q =  $this->db->query("SELECT id,username,name,created,is_active, getUsertype(user_type) as tipe_user FROM users");
            return $q->result_array();
        }
        
        public function cek_user($username)
        {
            $q= $this->db->query("SELECT * FROM users WHERE username='$username'");
            return $q->num_rows();
        }
        public function getDataEdit($id)
        {
            $this->db->where('id',$id);
            $this->db->from('users');
            $query = $this->db->get();
            return $query->result_array();
        }
    }
?>