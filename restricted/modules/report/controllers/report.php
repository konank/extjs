<?php
    class Report extends MX_Controller
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
            $this->daily();
        }
        
        public function daily()
        {
            $this->template->view('html/daily');
        }
        
        public function monthly()
        {
            getAcl($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'));
            $this->template->view('html/monthly');
        }
        
        public function customer()
        {
            getAcl($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'));
            $this->template->view('html/customer');
        }
        
        public function getcustomer()
        {
            $getData = $this->db->query("SELECT * FROM customers")->num_rows();    
            $page = $_GET['start'];
            $limit = $getData;
                
            $query = $this->my_model->getCustomerReport($limit,$page);    
            $arr = array(
                'total'=>$query['total'],
                'results'=>$query['data']
            );
            echo json_encode($arr);
            
        }
        
        public function report_customer()
        {
            
            //$this->load->library('excel');
//            $this->excel->setActiveSheetIndex(0);
//            $this->excel->getActiveSheet()->setTitle('Rekap data customer');
//            $report = $this->my_model->getCustomerReport();
//            
//            if($report['total'] > 0){
//                
//                $this->excel->getActiveSheet()->setCellValue('A1', 'Nomor KTP');
//                $this->excel->getActiveSheet()->setCellValue('B1', 'Nama');
//                $this->excel->getActiveSheet()->setCellValue('C1', 'Alamat');
//                $this->excel->getActiveSheet()->setCellValue('D1', 'Gender');
//                $this->excel->getActiveSheet()->setCellValue('E1', 'Nomor telepon');
//                $this->excel->getActiveSheet()->setCellValue('F1', 'Email');
//                $this->excel->getActiveSheet()->setCellValue('G1', 'Created date');
//                
//                $no=2;    
//                
//                foreach($report['data'] as $value){
//                    
//                    $this->excel->getActiveSheet()->setCellValue('A'.$no, $value['no_ktp']);         
//                    $this->excel->getActiveSheet()->setCellValue('B'.$no, $value['nama']);
//                    $this->excel->getActiveSheet()->setCellValue('C'.$no, $value['alamat']);
//                    $this->excel->getActiveSheet()->setCellValue('D'.$no, $value['gender']);
//                    $this->excel->getActiveSheet()->setCellValue('E'.$no, $value['no_telfon']);
//                    $this->excel->getActiveSheet()->setCellValue('F'.$no, $value['email']);
//                    $this->excel->getActiveSheet()->setCellValue('G'.$no, $value['created']);
//                    
//                $no++;
//                }
//            } 
//            $filename='rekapcustomer'.date('Y-m-d').'.xls'; 
//            header('Content-Type: application/vnd.ms-excel'); 
//            header('Content-Disposition: attachment;filename="'.$filename.'"'); 
//            header('Cache-Control: max-age=0'); 
//                         
//            
//            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
//            $objWriter->save('php://output');
        }
        
        public function daily_proses()
        {
            
        }
        
        public function showreport_daily()
        {
            
            $idLapangan = $_GET['lapanganId'];
            $date = $_GET['dateDaily'];
            
            if($date == ''){
                echo '({"total":"0","results":""})';
            } else {
                $arr = $this->my_model->Getshowreport_daily($idLapangan,$date);    
                echo '({"total":"'.$arr['row'].'","results":'.json_encode($arr['data']).'})';
            }
        }
        
        
        public function showreport_monthly()
        {
            $idLapangan = $_GET['lapanganId'];
            
            //echo '{"username":"andrey","name":"Andrey Derma Putra"}';
            $date = $_GET['dateMonthly'];
            $tahun = $_GET['tahun'];
            if($date == '' && $tahun == ' '){
                echo '({"total":"0","results":""})';
            } else {
                $arr = $this->my_model->Getshowreport_monthly($idLapangan,$date,$tahun);    
                echo '({"total":"'.$arr['row'].'","results":'.json_encode($arr['data']).'})';
                
            }
        }
        
        public function getlapangan()
        {
            $arr = $this->my_model->getDataLapangan();
            $arrSummary = array(
                'success'=>true,
                'results'=>$arr
            );
            echo json_encode($arrSummary);
        }
        
    }
?>