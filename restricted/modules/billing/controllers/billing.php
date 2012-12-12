<?php
    class Billing extends MX_Controller
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
            $this->template->view('html/billing');
        }
        
        public function cetak()
        {
            $idBooking = $this->uri->segment(3);
            $data['cetak'] = $this->my_model->getPrint($idBooking);
            $this->load->view('html/cetak',$data);
        }
        
        public function detail()
        {
            $idBooking = $this->uri->segment(3);
            $a = $this->my_model->getPrint($idBooking);
            $data['detail'] = $a['data'][0];
            $this->template->view('html/detail',$data);
        }
        public function getdata()
        {
            $idLpangan = $_GET['lapanganId'];
            $tanggal = $_GET['dateNya'];
            $arr = $this->my_model->getBillingData($idLpangan,$tanggal);
            
                echo '{"total": "'.$arr['total'].'","results": '.json_encode($arr['data']).'}';
                //echo '({"total":"'.$arr['row'].'","results":'.json_encode($arr['data']).'})';
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
            //getAcl($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'));
            
            $this->db->query("DELETE FROM bookings WHERE id='$id'");
            $this->db->query("DELETE FROM booking_time WHERE booking_id='$id'");
            
            //$this->db->query("DELETE FROM lapangan WHERE id='$id'");
        }
        
        public function edit()
        {
            //getAcl($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'));
            $id = $this->uri->segment(3);
            $da = $this->my_model->getDataEdit($id);
            $data['data'] = $da['data'][0];
            
            $this->template->view('html/edit',$data);
        }
        
        public function update_proses()
        {   
            $arr = array();
            foreach($_POST as $va){
                $arr[] = $va;
            }
            list($bookid,$total,$uangmuka,$discount,$status,$ket,$garndtotal) = $arr;
            //$getData = $this->db->query("SELECT * FROM bookings WHERE id='$bookid'")->result_array();
            if($status != 1){
                $st = 0;
            } else {
                $st = $status;
            }
            $updateArr = array(
                'status_bayar'=>$status,
                'jumlah_yang_dibayar'=>$st,
                'discount'=>$discount,
                'keterangan'=>$ket,
            );
            $this->db->where('id',$bookid);
            $this->db->update('bookings',$updateArr);
        }
        
        public function close()
        {
            ?>
            <script type="text/javascript">
                window.close();
            </script>
            <?php
        }
        
    }
?>