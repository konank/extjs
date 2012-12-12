<?php 
    class My_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }
        
        public function getDatagroup()
        {
            $q =  $this->db->query("SELECT * FROM groups");
            return $q->result_array();
        }
        
        public function cek_group($code)
        {
            $q= $this->db->query("SELECT * FROM groups WHERE code='$code'");
            return $q->num_rows();
        }
        public function getDataEdit($id)
        {
            $this->db->where('id',$id);
            $this->db->from('groups');
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
    }
?>