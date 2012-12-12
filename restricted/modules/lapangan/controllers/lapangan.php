<?php
    class Lapangan extends MX_Controller
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
                        
            $this->template->view('html/lapangan');
        }
        
        public function getdata()
        {
            $arr = $this->my_model->getDataLapangan();
            //echo '{"username":"andrey","name":"Andrey Derma Putra"}';
            $summaryArray = array(
                'success'=>true,
                'lapangan'=>$arr
            );
            echo json_encode($summaryArray);
        }
        
        public function addnew()
        {
            //print_r($_POST);
            getAcl($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'));
            
            $code = $this->security->xss_clean(strip_image_tags($this->input->post('kode_lapangan')));
            $keterangan = $this->security->xss_clean(strip_image_tags($this->input->post('keterangan')));
            $name = $this->security->xss_clean($this->input->post('name'));
            
            /************************ HARGA PAGI*************************/
            $pagiHarga = $this->security->xss_clean(strip_image_tags($this->input->post('harga_pagi')));
            $jamPagi = $this->security->xss_clean(strip_image_tags($this->input->post('jam_start_pagi')));
            $jamPagiEnd = $this->security->xss_clean(strip_image_tags($this->input->post('jam_end_pagi')));
            
            /************************ HARGA SIANG*************************/
            $siangHarga = $this->security->xss_clean(strip_image_tags($this->input->post('harga_siang')));
            $jamSiang = $this->security->xss_clean(strip_image_tags($this->input->post('jam_start_siang')));
            $jamSiangEnd = $this->security->xss_clean(strip_image_tags($this->input->post('jam_end_siang')));
            
            /************************ HARGA MALAM*************************/
            $hargaMalemNya = $this->security->xss_clean(strip_image_tags($this->input->post('harga_malam')));
            $jamMalem = $this->security->xss_clean(strip_image_tags($this->input->post('jam_start_malam')));
            $jamMalemEnd = $this->security->xss_clean(strip_image_tags($this->input->post('jam_end_malam')));
            
            $hargaPagi = $pagiHarga.'|'.$jamPagi.'|'.$jamPagiEnd;
            $hargaSiang = $siangHarga.'|'.$jamSiang.'|'.$jamSiangEnd;
            $hargaMalem = $hargaMalemNya.'|'.$jamMalem.'|'.$jamMalemEnd;
            
            $Cek = $this->my_model->cek_data($code);
            if($Cek > 0){
                echo "{success:false, errors: { reason: 'Code lapangan Sudah ada.. !' }}";
            } else {
                $arr = array(
                    'kode_lapangan'=>$code,
                    'nama_lapangan'=>$name,
                    'harga_sewa_pagi'=>$hargaPagi,
                    'harga_sewa_siang'=>$hargaSiang,
                    'harga_sewa_malem'=>$hargaMalem,
                    'keterangan'=>$keterangan
                );
                $a = $this->db->insert('lapangan',$arr);    
            }
        }
        
        public function delete($id)
        {
            getAcl($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'));
            
            $this->db->query("DELETE FROM lapangan WHERE id='$id'");
        }
        
        public function edit($id)
        {
            getAcl($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'));
            
            $data['data'] = $this->my_model->getDataEdit($id);
            $this->template->view('html/edit',$data);
            
        }
        
        public function update_proses()
        {   
            $code = $this->security->xss_clean(strip_image_tags($this->input->post('kode_lapangan')));
            $keterangan = $this->security->xss_clean(strip_image_tags($this->input->post('keterangan')));
            $name = $this->security->xss_clean($this->input->post('name'));
            $harga = $this->security->xss_clean($this->input->post('harga'));
            
            /************************ HARGA PAGI*************************/
            $pagiHarga = $this->security->xss_clean(strip_image_tags($this->input->post('harga_pagi')));
            $jamPagi = $this->security->xss_clean(strip_image_tags($this->input->post('jam_start_pagi')));
            $jamPagiEnd = $this->security->xss_clean(strip_image_tags($this->input->post('jam_end_pagi')));
            
            /************************ HARGA SIANG*************************/
            $siangHarga = $this->security->xss_clean(strip_image_tags($this->input->post('harga_siang')));
            $jamSiang = $this->security->xss_clean(strip_image_tags($this->input->post('jam_start_siang')));
            $jamSiangEnd = $this->security->xss_clean(strip_image_tags($this->input->post('jam_end_siang')));
            
            /************************ HARGA MALAM*************************/
            $hargaMalemNya = $this->security->xss_clean(strip_image_tags($this->input->post('harga_malam')));
            $jamMalem = $this->security->xss_clean(strip_image_tags($this->input->post('jam_start_malam')));
            $jamMalemEnd = $this->security->xss_clean(strip_image_tags($this->input->post('jam_end_malam')));
            
            $hargaPagi = $pagiHarga.'|'.$jamPagi.'|'.$jamPagiEnd;
            $hargaSiang = $siangHarga.'|'.$jamSiang.'|'.$jamSiangEnd;
            $hargaMalem = $hargaMalemNya.'|'.$jamMalem.'|'.$jamMalemEnd;
            
            $hidden = $this->input->post('id');
            $name_hidden = $this->input->post('name_hidden');
            
            $Cek = $this->db->query("SELECT * FROM lapangan WHERE kode_lapangan='$code'");
            $total = $Cek->num_rows();
            $data = $Cek->result_array();
            
            if($name_hidden == $code){
                $arr = array(
                        'kode_lapangan'=>$code,
                        'nama_lapangan'=>$name,
                        'harga_sewa_pagi'=>$hargaPagi,
                        'harga_sewa_siang'=>$hargaSiang,
                        'harga_sewa_malem'=>$hargaMalem,
                        'keterangan'=>$keterangan,
                );      
                
                $this->db->where('id',$hidden);
                $this->db->update('lapangan',$arr);
            } else if($total >0 ){
                echo "{success:false, errors: { reason: 'Code lapangan Sudah ada.. !' }}";
            
            } else {
                $arr = array(
                        'kode_lapangan'=>$code,
                        'nama_lapangan'=>$name,
                        'harga_sewa_pagi'=>$hargaPagi,
                        'harga_sewa_siang'=>$hargaSiang,
                        'harga_sewa_malem'=>$hargaMalem,
                        'keterangan'=>$keterangan,
                );      
                
                $this->db->where('id',$hidden);
                $this->db->update('lapangan',$arr);
            }
            
        }
        
    }
?>