<?php
    class Accessroles extends MX_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('my_model');
            if(!$this->session->userdata('logged_in') == TRUE){
                redirect('login');
            }
            
            
        }
        
        public function index()
        {
            //echo json_encode($summaryArray);
            getAcl($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'));
                                
            $this->template->view('html/role_manages');
        }
        
        public function getdataroles()
        {
            $arr = $this->my_model->getDataroles();
            //echo '{"username":"andrey","name":"Andrey Derma Putra"}';
            $summaryArray = array(
                'success'=>true,
                'roles'=>$arr
            );
            echo json_encode($summaryArray);
        }
        
        public function addnew()
        {
            //print_r($_POST);
            
            $name = $this->input->post('name');
            
            $Cek = $this->my_model->cek_roles($name);
            if($Cek > 0){
                echo "{success:false, errors: { reason: 'Sudah ada.. !' }}";
            } else {
                $arr = array(
                    'name'=>$name,
                );
                
                 $a = $this->db->insert('roles',$arr);    
            }
        }
        
        public function delete($id)
        {
            $this->db->query("DELETE FROM roles WHERE id='$id'");
        }
        
        public function edit($id)
        {
            $data['data'] = $this->my_model->getDataEdit($id);
            $this->template->view('html/edit_roles',$data);
            
        }
        
        public function update_proses()
        {
            
            $name = $this->input->post('name');
            $hidden = $this->input->post('id');
            $name_hidden = $this->input->post('name_hidden');
            
            $Cek = $this->db->query("SELECT * FROM roles WHERE name='$name'");
            $total = $Cek->num_rows();
            $data = $Cek->result_array();
            
            if($name_hidden == $name){
                $arr = array(
                        'name'=>$name,
                );      
                
                $this->db->where('id',$hidden);
                $this->db->update('roles',$arr);
            } else if($total >0 ){
                echo "{success:false, errors: { reason: 'Sudah ada.. !' }}";
            } else {
                $arr = array(
                        'name'=>$name,
                );      
                $this->db->where('id',$hidden);
                $this->db->update('roles',$arr);
            }
            
        }
        
        public function setgroup()
        {
            $idrole = $this->uri->segment(3);
            $namerol = $this->uri->segment(4);
            $data['nameRoles'] = str_replace('%20',' ',$namerol);
            $data['roleId'] = $idrole;
            $getDataAvailable = $this->my_model->getAvailableGroup($idrole);
            $data['available_user'] = '';
            foreach($getDataAvailable['data'] as $available){
                $data['available_user'] .= '<option value="'.$available['id'].'">'.$available['name'].'</option>';   
            }
            $getAuthuserGroup = $this->my_model->getAuthorizedusergroup($idrole);
            $data['authuser'] = '';
            foreach($getAuthuserGroup['data'] as $usrGroup)
            {
                $data['authuser'] .= '<option value="'.$usrGroup['id'].'">'.$usrGroup['name'].'</option>';    
            }
            $this->template->view('html/set_group_roles',$data);   
        }
        
        public function setgrant()
        {
            $idrole = $this->uri->segment(3);
            $namerol = $this->uri->segment(4);
            $data['nameRoles'] = str_replace('%20',' ',$namerol);
            $data['roleId'] = $idrole;
            $getDataAvailable = $this->my_model->getAvailableRules($idrole);
            $data['available_user'] = '';
            foreach($getDataAvailable['data'] as $available){
                $data['available_user'] .= '<option value="'.$available['id'].'">'.$available['class_name'].'.'.$available['method'].'</option>';   
            }
            $getAuthPrivilege = $this->my_model->getAuthRulesPrivilege($idrole);
            $data['authuser'] = '';
            foreach($getAuthPrivilege['data'] as $usrGroup)
            {
                $data['authuser'] .= '<option value="'.$usrGroup['id'].'">'.$usrGroup['class_name'].'.'.$usrGroup['method'].'</option>';    
            }
            $this->template->view('html/set_grant_rules',$data); 
        }
        
        public function set_prosess()
        {
            $roles_get_autorhized = $this->input->post('roles_get_autorhized');
            $roleId = $this->input->post('role_id');
            $kuranginArray = substr($roles_get_autorhized,0,strlen($roles_get_autorhized)-1);
            $expl = explode('|',$kuranginArray);
            
            $this->db->where('id_role',$roleId);
            $this->db->delete('role_groups');
            foreach($expl as $role)
            {
                $q = $this->db->query("INSERT INTO role_groups VALUES('$role','$roleId')");
            }
        }
        
        public function set_grant_proses()
        {
            $roles_get_autorhized = $this->input->post('roles_get_autorhized');
            $roleId = $this->input->post('role_id');
            $kuranginArray = substr($roles_get_autorhized,0,strlen($roles_get_autorhized)-1);
            $expl = explode('|',$kuranginArray);
            
            $this->db->where('role_id',$roleId);
            $this->db->delete('roles_rules');
            foreach($expl as $role)
            {
                $q = $this->db->query("INSERT INTO roles_rules VALUES('$roleId','$role')");
            }
        }
        
    }
?>