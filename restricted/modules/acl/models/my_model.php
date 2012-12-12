<?php 
    class My_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }
        
        public function getDataacl($limit,$start)
        {
            $q =  $this->db->query("SELECT * FROM access_rules ORDER BY class_name ASC LIMIT $start,$limit");
            
            
            return array('rows'=>$q->num_rows(),'data'=>$q->result_array());
        }
        
        public function getDataEdit($id)
        {
            $this->db->where('id',$id);
            $this->db->from('access_rules');
            $query = $this->db->get();
            return $query->result_array();
        }
        public function getAvailableRole($idRole)
        {
            $q = $this->db->query("
            SELECT t1.*,t2.* FROM 
            (select * from roles) as t1
            LEFT JOIN
            (select * from roles_rules WHERE rule_id='$idRole') as t2
            ON t1.id = t2.role_id
            WHERE t2.role_id IS NULL
            ");
            return array('row'=>$q->num_rows(),'data'=>$q->result_array());
        }
        
        public function getAuthorizeduserRules($idRole)
        {
            $q = $this->db->query("
            SELECT * from roles WHERE id IN 
            (select role_id from roles_rules WHERE rule_id='$idRole' ) 
            ");
            return array('row'=>$q->num_rows(),'data'=>$q->result_array());
            
        }
    }
?>