<?php
    class manages extends MX_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('my_model');
            if(!$this->session->userdata('logged_in') == TRUE){
                redirect('login');
            }
            getAcl($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'));
            //$gabungClassMethod = $class.'.'.$method;
            
        }
        
        public function index()
        {
            //echo json_encode($summaryArray);
                   
            $this->template->view('html/grid_manages');
        }
        
        public function getdatamanages()
        {
            $arr = $this->my_model->getDataUser();
            //echo '{"username":"andrey","name":"Andrey Derma Putra"}';
            $summaryArray = array(
                'success'=>true,
                'users'=>$arr
            );
            echo json_encode($summaryArray);
        }
        
        public function addnew()
        {
            //print_r($_POST);
            
            $username = $this->input->post('username');
            $pass = $this->input->post('password');
            $name = $this->input->post('name');
            $is_active = $this->input->post('is_active');
            $tipe_user = $this->input->post('tipe_index-inputEl');
            
            if($is_active == 'on'){
                $aktif = 1;
            } else {
                $aktif = 0;
            }
            
            $Cek = $this->my_model->cek_user($username);
            if($Cek > 0){
                echo "{success:false, errors: { reason: 'Username Sudah ada.. !' }}";
            } else {
                $arr = array(
                    'username'=>$username,
                    'password'=>$pass,
                    'name'=>$name,
                    'is_active'=>$aktif,
                    'created'=>date("Y-m-d H:i:s"),
                    'user_type'=>$tipe_user
                );
                
                 $a = $this->db->insert('users',$arr);    
            }
            
            //if($a){
//                echo '{"success": "true","message" : "sukses tambah data"}';
//            } else {
//                echo '{"success": "false","message" : "gagal tambah data"}';
//            }
            //echo json_encode($arr);
            //echo 1;
        }
        
        public function delete($id)
        {
            $this->db->query("DELETE FROM users WHERE id='$id'");
            $this->db->query("DELETE FROM user_groups WHERE id_user='$id'");
            
        }
        
        public function edit($id)
        {
            $data['useredit'] = $this->my_model->getDataEdit($id);
            $this->template->view('html/edit_user',$data);
        }
        
        public function update_proses()
        {
            
            $username = $this->input->post('username');
            $pass = $this->input->post('password');
            $name = $this->input->post('name');
            $is_active = $this->input->post('is_active');
            $tipe_user = $this->input->post('tipe_index-inputEl');
            $hidden = $this->input->post('id_user');
            $name_hidden = $this->input->post('name_hidden');
            
            if($is_active == 'on'){
                $aktif = 1;
            } else {
                $aktif = 0;
            }
            
            $Cek = $this->db->query("SELECT * FROM users WHERE username='$username'");
            $total = $Cek->num_rows();
            $data = $Cek->result_array();
            
            if($name_hidden == $username){
                if($pass == ' '){
                $arr = array(
                        'username'=>$username,
                      //  'password'=>$pass,
                        'name'=>$name,
                        'is_active'=>$aktif,
                        'user_type'=>$tipe_user
                    );    
                } else {
                  $arr = array(
                        'username'=>$username,
                        'password'=>$pass,
                        'name'=>$name,
                        'is_active'=>$aktif,
                        'user_type'=>$tipe_user
                    );  
                }    
                $this->db->where('id',$hidden);
                $this->db->update('users',$arr);
            } else if($total >0 ){
                echo "{success:false, errors: { reason: 'Username Sudah ada.. !' }}";
            
            } else {
                if($pass == ' '){
                $arr = array(
                        'username'=>$username,
                      //  'password'=>$pass,
                        'name'=>$name,
                        'is_active'=>$aktif,
                        'user_type'=>$tipe_user
                    );    
                } else {
                  $arr = array(
                        'username'=>$username,
                        'password'=>$pass,
                        'name'=>$name,
                        'is_active'=>$aktif,
                        'user_type'=>$tipe_user
                    );  
                }    
                $this->db->where('id',$hidden);
                $this->db->update('users',$arr);
            }
            
        }
        
    }
?>