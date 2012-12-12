<?php
    class Customers extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('my_model');
            
        }
        
        public function index()
        {
            getAcl($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'));
            $this->template->view('html/index');
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
        
        public function addnew()
        {
            getAcl($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'));
            
            $noKtp = $this->security->xss_clean(strip_image_tags($this->input->post('ktp')));
            $nama = $this->security->xss_clean(strip_image_tags($this->input->post('nama')));
            $alamat = $this->security->xss_clean(strip_image_tags($this->input->post('alamat')));
            $gender = $this->security->xss_clean(strip_image_tags($this->input->post('gender')));
            $telfon = $this->security->xss_clean(strip_image_tags($this->input->post('telfon')));
            $email = $this->security->xss_clean(strip_image_tags($this->input->post('email')));
            
            $cekKtp = $this->my_model->cekKtp($noKtp);
            if($cekKtp > 0){
                echo "{success: false, errors : {reason : 'Nomor KTP sudah terdaftar..!!'}}";
            } else {
                $arr = array(
                    'id'=>'',
                    'no_ktp'=>$noKtp,
                    'nama'=>$nama,
                    'alamat'=>$alamat,
                    'gender'=>$gender,
                    'no_telfon'=>$telfon,
                    'email'=>$email,
                    'created'=>date("Y-m-d H:i:s")
                );
                $this->db->insert('customers',$arr);
            }
        }
        
        public function delete($id)
        {
            getAcl($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'));
            $this->db->query("DELETE FROM customers WHERE id='$id'");
        }
        
        public function edit($id)
        {
            getAcl($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'));
            $data['data'] = $this->my_model->getDataEdit($id);
            
            $this->template->view('html/editdata',$data);
        }
        
        public function proses_update()
        {
            $noKtp = $this->security->xss_clean(strip_image_tags($this->input->post('ktp')));
            $nama = $this->security->xss_clean(strip_image_tags($this->input->post('nama')));
            $alamat = $this->security->xss_clean(strip_image_tags($this->input->post('alamat')));
            $gender = $this->security->xss_clean(strip_image_tags($this->input->post('gender')));
            $telfon = $this->security->xss_clean(strip_image_tags($this->input->post('telfon')));
            $email = $this->security->xss_clean(strip_image_tags($this->input->post('email')));
            
            $id = $this->input->post('id');
            $ktpHidden = $this->input->post('ktpnya');
            
            $cekKtp = $this->my_model->cekKtp($noKtp);
            if($ktpHidden == $noKtp){
                $arr = array(
                    
                    'no_ktp'=>$noKtp,
                    'nama'=>$nama,
                    'alamat'=>$alamat,
                    'gender'=>$gender,
                    'no_telfon'=>$telfon,
                    'email'=>$email,
                );
                $this->db->where('id',$id);
                $this->db->update('customers',$arr);    
            } elseif($cekKtp > 0) {
                echo "{success: false, errors : {reason : 'Nomor KTP sudah terdaftar..!!'}}";
            } else {
                 $arr = array(
                    
                    'no_ktp'=>$noKtp,
                    'nama'=>$nama,
                    'alamat'=>$alamat,
                    'gender'=>$gender,
                    'no_telfon'=>$telfon,
                    'email'=>$email,
                );
                $this->db->where('id',$id);
                $this->db->update('customers',$arr);
            }
            
            
        }
    }
?>