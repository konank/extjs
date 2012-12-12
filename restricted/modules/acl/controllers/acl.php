<?php
    class Acl extends MX_Controller
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
            $this->template->view('html/acl_manages');
        }
        
        public function getdataacl()
        {
            $getData = $this->db->query("SELECT * FROM access_rules")->num_rows();
            $page = $_GET['start'];
            $limit = $getData;
            
            $arr = $this->my_model->getDataacl($limit,$page);
            
            //echo '{"username":"andrey","name":"Andrey Derma Putra"}';
            $summaryArray = array(
                'total'=>$arr['rows'],
                'results'=>$arr['data']
            );
            echo json_encode($summaryArray);
            //echo '{"totalCount" : "'. $arr['rows'] .'","acl":'.json_encode($arr['data']).'}';
            
            
            //$getData = $this->db->query("SELECT * FROM customers")->num_rows();    
//            $page = $_GET['start'];
//            $limit = $getData;
//                
//            $query = $this->my_model->getCustomerReport($limit,$page);    
//            $arr = array(
//                'total'=>$query['total'],
//                'results'=>$query['data']
//            );
//            echo json_encode($arr);
        }
        
        public function addnew()
        {
            $name = $this->input->post('class_name');
            $method = $this->input->post('method');
                        
            $arr = array(
                'class_name'=>$name,
                'method'=>$method,
                
            );
            
            $a = $this->db->insert('access_rules',$arr);
            if(!$a){
                echo "{success : false,errors : {reason : 'gagal'}}";
            }
        }
        
        public function delete($id)
        {
            $this->db->query("DELETE FROM access_rules WHERE id='$id'");
        }
        
        public function edit($id)
        {
            $data['data'] = $this->my_model->getDataEdit($id);
            $this->template->view('html/edit_acl',$data);
            
        }
        
        public function update_proses()
        {
            
            $name = $this->input->post('class_name');
            $method = $this->input->post('method');
            $id = $this->input->post('id');
            
            $arr = array(
                'class_name'=>$name,
                'method'=>$method,
                
            );
            
            $this->db->where('id',$id);
            $this->db->update('access_rules',$arr);
        }
        
        public function setacl()
        {
            $idrole = $this->uri->segment(3);
            $namerol = $this->uri->segment(4);
            $data['nameRoles'] = str_replace('%20',' ',$namerol);
            $data['roleId'] = $idrole;
            $getDataAvailable = $this->my_model->getAvailableRole($idrole);
            $data['available_user'] = '';
            foreach($getDataAvailable['data'] as $available){
                $data['available_user'] .= '<option value="'.$available['id'].'">'.$available['name'].'</option>';   
            }
            $getAuthuserGroup = $this->my_model->getAuthorizeduserRules($idrole);
            $data['authuser'] = '';
            foreach($getAuthuserGroup['data'] as $usrGroup)
            {
                $data['authuser'] .= '<option value="'.$usrGroup['id'].'">'.$usrGroup['name'].'</option>';    
            }
            $this->template->view('html/set_acl_roles',$data);   
        }
        
        public function set_prosess()
        {
            $roles_get_autorhized = $this->input->post('roles_get_autorhized');
            $roleId = $this->input->post('role_id');
            $kuranginArray = substr($roles_get_autorhized,0,strlen($roles_get_autorhized)-1);
            $expl = explode('|',$kuranginArray);
            
            $this->db->where('rule_id',$roleId);
            $this->db->delete('roles_rules');
            foreach($expl as $role)
            {
                $q = $this->db->query("INSERT INTO roles_rules VALUES('$role','$roleId')");
            }
        }
        
    }
?>