<?php
    class Dashboard extends MX_Controller
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
            getAcl($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'));
            $this->template->view('html/viewport');
        }
        
        public function logout()
        {
            $arr = array(
                'id'=>$this->session->userdata('id'),
                'username'=>$this->session->userdata('username'),
                'password'=>$this->session->userdata('password'),
                'sess_class'=>$this->session->userdata('sess_class'),
                'sess_class_method'=>$this->session->userdata('sess_class_method'),
                
            );
            $this->session->unset_userdata($arr);
            $this->session->sess_destroy();
            redirect('login');
        
        }
        
        public function getalldata()
        {
            $getData = $this->db->query("SELECT * FROM customers")->num_rows();
            $start = isset($_GET['start']) ? $_GET['start'] : 0;
            $limit = $getData;
                
            $getdata = $this->my_model->getDataall($limit,$start);
            //$summary = array(
//            
//                'success'=>true,
//                'customer'=>$getdata['data'],
//                'total'=>$getdata['rows']
//            );
            header('content-type: application/json; charset=utf-8'); 
            echo '{"totalCount":"'. $getdata['rows'] .'","customer":'.json_encode($getdata['data']).'}';

        }
        
        public function homepage()
        {
            getAcl($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'));
            //$ipLite = new iplocation;
//            $ipLite->setKey(config_item('api_ip_location'));             
//            $locations = $ipLite->getCity(config_item('getcity'));
//            $errors = $ipLite->getError();
//            if (!empty($locations) && is_array($locations)) {
//              $data['lokasi'] =  $locations['cityName'].', '.$locations['regionName'];
//            }
            $this->load->view('welcome_page');
        }
        
        public function aksesditolak()
        {
            $this->template->view('html/akses-ditolak');
        }
        
        public function sample()
        {
            $this->load->view('sample');
        }
        
        public function jsondatachart()
        {
            $getData = $this->my_model->getChartdata();
            echo '{"rows" : '.json_encode($getData['data']).',"success" : true}';
            
        }
    }
?>