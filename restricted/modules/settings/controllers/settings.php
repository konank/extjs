<?php
    class Settings extends MX_Controller
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
                        
            $this->template->view('html/setting');
        }
        
        public function getsetting()
        {
            $arr = $this->my_model->getDataSetting();
            //echo '{"username":"andrey","name":"Andrey Derma Putra"}';
            $summaryArray = array(
                'success'=>true,
                'setting'=>$arr
            );
            echo json_encode($summaryArray);
        }
        
        
        public function edit($id)
        {
           // getAcl($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'));
            
            $data['data'] = $this->my_model->getDataEdit($id);
            $this->template->view('html/edit',$data);
            
        }
        
        public function update_proses()
        {   
            $minTime = $this->security->xss_clean(strip_image_tags($this->input->post('min_time')));
            $maxTime = $this->security->xss_clean(strip_image_tags($this->input->post('max_time')));
            
            
            $hidden = $this->input->post('id');
            $arr = array(
                    'min_time'=>$minTime,
                    'max_time'=>$maxTime,
            );      
            
            $this->db->where('id',$hidden);
            $this->db->update('setting',$arr);
            
        }
        
    }
?>