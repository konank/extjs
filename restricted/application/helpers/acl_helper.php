<?php
    function getAcl($class,$method,$userId)
    {
        $ci =& get_instance();
        $ci->load->database();
        $sql = "
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
        ";
        $access = $ci->db->query($sql)->result_array();
        
        $gabungClassMethod = $class.'.'.$method;
        $classMethods = array();
        
        $stringAdd = '';
        foreach($access as $acL)
        {
            $stringAdd .= $acL['class_name'].'.'.$acL['method'];
            $classMethods[] = $acL['class_name'].'.'.$acL['method'];    
        }
        
        $strPos = strpos(in_array($gabungClassMethod,$classMethods),'add');
        if(in_array($gabungClassMethod,$classMethods)){
                    
        } else {
            redirect('dashboard/aksesditolak');
        }
    }
    
    function getAclAdd($class,$method,$userId,$params = array())
    {
        $ci =& get_instance();
        $ci->load->database();
        $sql = "
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
        ";
        $access = $ci->db->query($sql)->result_array();
        
        $gabungClassMethod = $class.'.'.$method;
        $classMethods = array();
        
        $stringAdd = '';
        foreach($access as $acL)
        {
            $stringAdd .= $acL['class_name'].'.'.$acL['method'];
            $classMethods[] = $acL['class_name'].'.'.$acL['method'];    
        }
        
        foreach($params as $key=> $paramater)
        {
            if(strpos($stringAdd,$class.'.'.$paramater.'') !== false){
               return 'false'; //kalao ketemu maka disabled adalah false
            } else {
                return 'true';
            } 
        }        
    }
?>