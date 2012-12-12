<?php 
    class My_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }
        
        public function cekLogin($username,$password)
        {
            $query = $this->db->query("SELECT * FROM users WHERE username='$username' AND password='".$password."' AND is_active=1");
            $total = $query->num_rows();
            return array('total'=>$total,'rows'=>$query->result_array());
        }
        
        public function dapatkanAkses($userId)
        {
            $q = $this->db->query("
            SELECT t1.*,t5.id as id_access,t5.class_name,t5.method FROM 
            (select * from users WHERE id='$userId') as t1
            LEFT JOIN user_groups as t2
            ON t1.id = t2.id_user
            
            LEFT JOIN 
            (SELECT id_role,id_group FROM role_groups) as t3
            ON t2.id_group = t3.id_group
            
            LEFT JOIN roles_rules as t4
            ON t3.id_role = t4.role_id
            
            INNER JOIN access_rules as t5
            ON t4.rule_id = t5.id
            
            GROUP BY t5.id
            ");
            return $q->result_array();
        }
    }
?>