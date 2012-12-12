<?php 
    class My_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }
        
        public function getDataroles()
        {
            $q =  $this->db->query("SELECT * FROM roles");
            return $q->result_array();
        }
        
        public function cek_roles($name)
        {
            $q= $this->db->query("SELECT * FROM roles WHERE name='$name'");
            return $q->num_rows();
        }
        public function getDataEdit($id)
        {
            $this->db->where('id',$id);
            $this->db->from('roles');
            $query = $this->db->get();
            return $query->result_array();
        }
        public function getAvailableGroup($idRole)
        {
            $q = $this->db->query("
            SELECT t1.*,t2.* FROM 
            (select * from groups) as t1
            LEFT JOIN
            (select * from role_groups WHERE id_role='$idRole') as t2
            ON t1.id = t2.id_group
            WHERE t2.id_role IS NULL
            ");
            return array('row'=>$q->num_rows(),'data'=>$q->result_array());
        }
        
        public function getAuthorizedusergroup($idRole)
        {
            $q = $this->db->query("
            SELECT * from groups WHERE id IN 
            (select id_group from role_groups WHERE id_role='$idRole')
            ");
            return array('row'=>$q->num_rows(),'data'=>$q->result_array());
        }
        
        public function getAuthRulesPrivilege($idRole)
        {
            $q = $this->db->query("
            SELECT * FROM access_rules WHERE id IN (SELECT rule_id FROM roles_rules WHERE role_id='$idRole' ) ORDER BY class_name ASC
            ");
            return array('row'=>$q->num_rows(),'data'=>$q->result_array());
        }
        
        public function getAvailableRules($idrole)
        {
            $q = $this->db->query("
            SELECT t1.*,t2.* FROM
            (SELECT * FROM access_rules) as t1
            LEFT JOIN 
            (SELECT * FROM roles_rules WHERE role_id='$idrole') as t2
            ON t1.id = t2.rule_id
            WHERE t2.rule_id IS NULL
            ORDER BY t1.class_name ASC
            ");
            return array('row'=>$q->num_rows(),'data'=>$q->result_array());
        }
    }
?>