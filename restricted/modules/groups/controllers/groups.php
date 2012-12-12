<?php
    class Groups extends MX_Controller
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
            $this->template->view('html/group_manages');
        }
        
        public function getdatagroup()
        {
            $arr = $this->my_model->getDatagroup();
            //echo '{"username":"andrey","name":"Andrey Derma Putra"}';
            $summaryArray = array(
                'success'=>true,
                'group'=>$arr
            );
            echo json_encode($summaryArray);
        }
        
        public function addnew()
        {
            //print_r($_POST);
            
            $code = $this->input->post('group_code');
            
            $name = $this->input->post('name');
            
            $Cek = $this->my_model->cek_group($code);
            if($Cek > 0){
                echo "{success:false, errors: { reason: 'Code group Sudah ada.. !' }}";
            } else {
                $arr = array(
                    'code'=>$code,
                    'name'=>$name,
                    'created'=>date("Y-m-d H:i:s"),
                );
                
                 $a = $this->db->insert('groups',$arr);    
            }
        }
        
        public function delete($id)
        {
            $this->db->query("DELETE FROM groups WHERE id='$id'");
        }
        
        public function edit($id)
        {
            $data['data'] = $this->my_model->getDataEdit($id);
            $this->template->view('html/edit_group',$data);
            
        }
        
        public function update_proses()
        {
            
            $code = $this->input->post('group_code');
            
            $name = $this->input->post('name');
            $hidden = $this->input->post('id');
            $name_hidden = $this->input->post('name_hidden');
            
            $Cek = $this->db->query("SELECT * FROM groups WHERE code='$code'");
            $total = $Cek->num_rows();
            $data = $Cek->result_array();
            
            if($name_hidden == $code){
                $arr = array(
                        'code'=>$code,
                        'name'=>$name,
                );      
                
                $this->db->where('id',$hidden);
                $this->db->update('groups',$arr);
            } else if($total >0 ){
                echo "{success:false, errors: { reason: 'Group Sudah ada.. !' }}";
            
            } else {
                $arr = array(
                        'code'=>$code,
                        'name'=>$name,
                );      
                
                $this->db->where('id',$hidden);
                $this->db->update('groups',$arr);
            }
            
        }
        
        public function setmember()
        {
            $idGroup = $this->uri->segment(3);
            $nameGroup = $this->uri->segment(4);
            $data['nameGroup'] = str_replace('%20',' ',$nameGroup);
            $data['groupId'] = $idGroup;
            $getDataAvailable = $this->my_model->getAvailableUser($idGroup);
            $data['available_user'] = '';
            foreach($getDataAvailable['data'] as $available){
                $data['available_user'] .= '<option value="'.$available['id'].'">'.$available['username'].'</option>';   
            }
            $getAuthuserGroup = $this->my_model->getAuthorizedusergroup($idGroup);
            $data['authuser'] = '';
            foreach($getAuthuserGroup['data'] as $usrGroup)
            {
                $data['authuser'] .= '<option value="'.$usrGroup['id'].'">'.$usrGroup['username'].'</option>';    
            }
            $this->template->view('html/set_member',$data);   
        }
        
        public function set_member()
        {
            $user_get_autorhized = $this->input->post('user_get_autorhized');
            $groupId = $this->input->post('group_id');
            $kuranginArray = substr($user_get_autorhized,0,strlen($user_get_autorhized)-1);
            $expl = explode('|',$kuranginArray);
            
            $this->db->where('id_group',$groupId);
            $this->db->delete('user_groups');
            foreach($expl as $user)
            {
                $q = $this->db->query("INSERT INTO user_groups VALUES('$user','$groupId')");
            }
        }
        
    }
?>