<?php
    class Booking extends MX_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('my_model');
            if(!$this->session->userdata('logged_in') == TRUE){
                redirect('login');
            }
            global $event_row_data;
        }
        
        public function index()
        {
            getAcl($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'));
            $data['data'] = $this->my_model->getDataLapangan();
            $this->template->view('html/index',$data);
        }
        
        public function getdatacustomer()
        {
            $get = $_GET['query'];            
            $cek = $this->my_model->cekcustomer($get);
            $summaryArray = array(
                'totalCount'=>$cek['row'],
                'topics'=>$cek['data']
            );
            echo json_encode($summaryArray);            
            //header('content-type: application/json; charset=utf-8');   
//            $json =  json_encode($summaryArray);
//            echo isset($_GET['callback'])
//            ? "{$_GET['callback']}($json)"
//            : $json;
            
        }
        
        public function calculate()
        {
            $dateStart = $this->uri->segment(3);
            $dateend = $this->uri->segment(4);
            $timeStart = $this->uri->segment(5);
            $timeEnd = $this->uri->segment(5);
            echo $dateStart;
        }
        
        public function insert_booking()
        {
            
            //$statusBayar = $this->input->post('tipe_index-inputEl');
            
            $keterangan = $this->security->xss_clean(strip_image_tags($this->input->post('keterangan')));
            
            $getVal = array();
            foreach($_POST as $val){
                $getVal[] = $val;
            }
            
            list($dateStart,$dateEnd,$idLapangan,$timeStart,$timeEnd,$ktp,$null,$statusBayar,$totalBayar) = $getVal;
                        
            $getCust = $this->my_model->getCustomer($ktp);
            $tanggalFrom = $this->input->post('date_from');
            $time_from = $this->input->post('time_from');
            $idLapangan = $this->input->post('id_lapangan');   
            $tanggalThru = $this->input->post('date_dua');
            $time_Thru = $this->input->post('time_dua');
            $jumlah_bayar = $this->security->xss_clean(strip_image_tags($this->input->post('jumlah_bayar')));
            
            $gabungTimeStart = $tanggalFrom.' '.$time_from;
            $gabungTimeEnd = $tanggalThru.' '.$time_Thru;
            
            //echo $leftTrim.':00';
            if($getCust['rows'] > 0){
                if($gabungTimeStart == $gabungTimeEnd){
                    echo "{success : false, errors : {reason : 'Time start dan time End tidak boleh sama'}}";
                } else {
                    $cekLapanganDiapakeApaKagak = $this->my_model->cekLapanganYa($gabungTimeStart,$gabungTimeEnd,$idLapangan);
                    if($cekLapanganDiapakeApaKagak > 0){
                        echo "{success : false, errors : {reason : 'Tanggal yang anda masukan sudah ada yang memesan..'}}";
                    } else {
                        $retrunPrice = $this->getpriceFunctionPerLapangan($idLapangan,$time_from,$time_Thru,$tanggalFrom,$tanggalThru);
                        //echo $retrunPrice;
                        $custId = $getCust['data'][0]['id'];
                        
                        $interval = 1800; // Interval dalam detik
                        $time_first     = strtotime($gabungTimeStart);
                        $time_second    = strtotime($gabungTimeEnd);
                        $kurangin = $time_second-$time_first;
                        $jam = intval(floor($kurangin/3600));
                        $menit = intval(floor($kurangin%3600)/60);
                        
                        if($jam != 0){
                            $getJam = $jam.' Jam';
                        } else {
                            $getJam = '';
                        }
                        if($menit != 0){
                            $getMinute = $menit.' Menit';
                        } else {
                            $getMinute = '';
                        }
                        
                        $durasi = $getJam.' '.$getMinute;
                        $cekMinus = strpos($durasi,'-');
                        if($cekMinus === false){
                            $arrInsert = array(
                                'id'=>'',
                                'id_customer'=>$custId,
                                'id_lapangan'=>$idLapangan,
                                'time_start'=>$gabungTimeStart,
                                'time_end'=>$gabungTimeEnd,
                                'duration'=>$durasi,
                                'jumlah_yang_dibayar'=>$jumlah_bayar,
                                'status_bayar'=>$statusBayar,
                                'total'=>$retrunPrice,
                                'tanggal_booking'=>date('Y-m-d H:i:s'),
                                'keterangan'=>$keterangan
                            );
                            $this->db->insert('bookings',$arrInsert);
                            $id = $this->db->insert_id();
                            
                            for ($i = $time_first; $i < $time_second; $i += $interval)
                            {
                                
                                $arrInsert2 = array(
                                    'id'=>'',
                                    'booking_id'=>$id,
                                    'time_interval'=>date("Y-m-d H:i:s",$i),
                                );
                                $this->db->insert('booking_time',$arrInsert2);
                            } 
                        } else {
                            echo '{success : false,errors : {reason : "Time end tidak boleh kurang dari Time start"}}';
                        }
                    }
                        
                }
                
            } else {
                echo "{success:false, errors:{reason : 'Customer tidak ketemu..!!'}}";
            }
            
        }
        
        public function getpriceFunctionPerLapangan($idLapangan,$time_from,$time_Thru,$tanggalFrom,$tanggalThru){
                $hardcodeTime = 1800;
                $harcodeTimeJam = 3600;
                //dapatkan lapangan nya untuk menghitung harga pagi,siang malam
                $dapetLapangan = $this->my_model->getDataLapanganbyId($idLapangan);
                $arrPagi = array();
                $arrSiang = array();
                $arrMalem = array();
                $arr1 = array();
                $arr1S = array();
                $arr1M = array();
                /******************************PAGI******************************/
                    list($harga,$mulaiTime,$endTime) = explode('|',$dapetLapangan[0]['harga_sewa_pagi']);
                    for($b=strtotime($mulaiTime); $b <= strtotime($endTime); $b +=$hardcodeTime ){
                        $arrPagi[] = date('H:i:s',$b);
                    }
                
                //range harga time start dan time end
                for($c=strtotime($time_from); $c<strtotime($time_Thru); $c +=$hardcodeTime ){
                        $arr1[] = date('H:i:s',$c);
                }
                
                $hargaanyaPagi = 0;
                //$diffArrpagi = count(array_diff($arrPagi,$arr1));
                $list = array_intersect($arrPagi,$arr1);
                $hitung = count($list);
                //print_r($list);
                
                    if($hitung % 2 == 0){ 
                        //perjam
                        $finalYPagi = ($harga/2) * $hitung;
                        
                    }   else {
                        
                        if($hitung % 2 == 0){
                        // untuk per setengah jam
                        $finalYPagi = ($harga/2) * $hitung; //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam        
                            
                        } else {
                            $finalYPagi = ($harga/2) * ($hitung); //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam        
                        }
                    }
                    $hargaPagi =  $finalYPagi;
                
                /******************************SIANG******************************/
                list($hargaSiang,$mulaiTimes,$endTimes) = explode('|',$dapetLapangan[0]['harga_sewa_siang']);
                for($b=strtotime($mulaiTimes); $b <= strtotime($endTimes); $b +=$hardcodeTime ){
                    $arrSiang[] = date('H:i:s',$b);
                }
                for($c=strtotime($time_from); $c<strtotime($time_Thru); $c +=$hardcodeTime ){
                        $arr1S[] = date('H:i:s',$c);
                }
                //$diffArrsiang = count(array_diff($arrSiang,$arr1S));
                $lists = array_intersect($arrSiang,$arr1S);
                $hitungs = count($lists);
                
                    
                    if($hitungs % 2 == 0){
                        $finalYSiang = ($hargaSiang/2) * $hitungs; //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam
                    }    else {
                        if($hitungs % 2 == 0){
                            $finalYSiang = ($hargaSiang/2) * $hitungs; //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam
                        } else {
                            $finalYSiang = ($hargaSiang/2) * ($hitungs); 
                        }
                    }
                    $hargaanyaSiang =  $finalYSiang;
                
                
                /******************************MALAM******************************/
                list($hargaMalem,$mulaiTimeM,$endTimeM) = explode('|',$dapetLapangan[0]['harga_sewa_malem']);
                if($endTimeM == '00:00:00'){
                    $eTime = '24:00:00';
                } else {
                    $eTime = $endTime;
                }
                for($h=strtotime($mulaiTimeM); $h <= strtotime($eTime); $h +=$hardcodeTime ){
                    $arrMalem[] = date('H:i:s',$h);
                }
                
                
                for($c=strtotime($time_from); $c<strtotime($time_Thru); $c +=$hardcodeTime ){
                    $arr1M[] = date('H:i:s',$c);
                }
                
                
                //$diffArrMalem = count(array_diff($arrMalem,$arr1M));
                $listm = array_intersect($arrMalem,$arr1M);
                $hitungss = count($listm);
                
                
                    if($hitungss % 2 == 0){
                        $finalYmalem = ($hargaMalem/2) * $hitungss; //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam
                    }    else {
                        //$finalYmalem = ($hargaMalem/2) * $hitungss; // untuk per setengah jam
                        if($hitungss % 2 == 0){
                            $finalYmalem = ($hargaMalem/2) * $hitungss; //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam
                        }    else {
                            $finalYmalem = ($hargaMalem/2) * ($hitungss);                                
                        }
                    }
                    $hargaanyamalem =  $finalYmalem;
                  
                
                $calculatePagi = $hargaPagi;
                $calculateSiang = $hargaanyaSiang;
                $calculatemalem = $hargaanyamalem;
                $totalSemua = $calculatePagi+$calculateSiang+$calculatemalem;
                    if($tanggalFrom == $tanggalThru){
                        if($calculatePagi != 0 && $calculateSiang == 0 && $calculatemalem == 0){
                            //ini pagi
                            $akhirNya = $calculatePagi;
                        } elseif($calculatePagi != 0 && $calculateSiang != 0 && $calculatemalem == 0){
                            //ini pagi dan siang
                            //echo 'pagi dan siang, pagi dikurang';
                            $akhirNya = ($harga/2) * ($hitung-1) + $calculateSiang;
                        } elseif($calculatePagi == 0 && $calculateSiang != 0 && $calculatemalem == 0){
                            //ini siang 
                            $akhirNya = $calculateSiang;
                        } elseif($calculatePagi == 0 && $calculateSiang != 0 && $calculatemalem != 0){
                            //ini siang dan malam
                            //echo 'siang dan malam, siang dikurang';
                            $akhirNya = ($hargaSiang/2) * ($hitungs-1) + $calculatemalem;
                        } elseif($calculatePagi == 0 && $calculateSiang == 0 && $calculatemalem != 0){
                            //ini malem
                            $akhirNya = $calculatemalem;
                        } elseif($calculatePagi != 0 && $calculateSiang != 0 && $calculatemalem != 0){
                            //ini pagi siang malem
                            //echo 'pagi siang malam, semua dikurang 1';
                            $akhirNya = ($harga/2) * ($hitung-1) + ($hargaSiang/2) * ($hitungs-1) + ($hargaMalem/2) * ($hitungss);
                        } else {
                            //jika jam 00:00:00
                            $akhirNya = $calculatePagi;
                        
                        }
                
                } else {
                    $akhirNya = $this->generateLebihdariduaHari($arr1,$arr1S,$arr1M,$harga,$hargaSiang,$hargaMalem,$arrPagi,$arrSiang,$arrMalem,$idLapangan,$time_from,$tanggalFrom,$tanggalThru,$time_Thru);
                }
                return $akhirNya;
                
                //return ''.$calculatePagi.'+'.$calculateSiang.'+'.$calculatemalem.'';
                //print_r($hargaanyamalem * count($arrJamM));
        }
        
        public function generateLebihdariduaHari($arr1,$arr1S,$arr1M,$harga,$hargaSiang,$hargaMalem,$arrPagi,$arrSiang,$arrMalem,$idLapangan,$time_from,$tanggalFrom,$tanggalThru,$time_Thru)
        {
            $start = $tanggalFrom.' '.$time_from;
            $end = $tanggalThru.' '.$time_Thru;
            $interval = 1800;
            $timeRange = array();
            for($i=strtotime($start); $i<strtotime($end); $i += $interval){
                $timeRange[] = date('H:i:s',$i);
            }
            
            //************************************START PAGI *****************************************/
            $list = array_intersect($arrPagi,$timeRange);
            $hitung = count($timeRange);
            $getSelisih = $this->my_model->ambilSelisihDua($start,$end);
            $selisihHari = $getSelisih[0]['selisih'];
            $total = count($list)-1;
            
            if($hitung % 2 == 0){ 
                //perjam
                $finalYPagi = ($harga/2) * $total * $selisihHari;
                //echo ($harga/2) * $hitung;
            }   else { 
                if($hitung % 2 == 0){
                // untuk per setengah jam
                    $finalYPagi = ($harga/2) * $total * $selisihHari; //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam        
                    
                } else {
                    $finalYPagi = ($harga/2) * $total * $selisihHari; //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam        
                }
            }
            //START lagi per jamnya
            $listJamseterusnya = array_intersect($arrPagi,$arr1);
                $hitungPagiSelanjutnya = count($listJamseterusnya);
                //print_r($list);
                    if($hitungPagiSelanjutnya % 2 == 0){ 
                        //perjam
                        $finalYPagiLanjut = ($harga/2) * $hitungPagiSelanjutnya;
                    }   else {
                        
                        if($hitung % 2 == 0){
                        // untuk per setengah jam
                        $finalYPagiLanjut = ($harga/2) * $hitungPagiSelanjutnya; //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam        
                            
                        } else {
                            $finalYPagiLanjut = ($harga/2) * ($hitungPagiSelanjutnya); //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam        
                        }
                    }
                    $hargaPagi =  $finalYPagiLanjut;
            $akhirdarisegalanyaPagi = $finalYPagi + $hargaPagi;
            //echo ''.$finalYPagi.' + '.$hargaPagi.'';
            
            //************************************START SIANG*****************************************/
            $listSiang = array_intersect($arrSiang,$timeRange);
            $hitungSiang = count($timeRange);
            $totalSiang = count($listSiang)-1;
            
            if($hitungSiang % 2 == 0){ 
                //perjam
                $finalYSiang = ($hargaSiang/2) * $totalSiang * $selisihHari;
                //echo ($harga/2) * $hitung;
            }   else { 
                if($hitungSiang % 2 == 0){
                // untuk per setengah jam
                    $finalYSiang = ($hargaSiang/2) * $totalSiang * $selisihHari; //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam        
                    
                } else {
                    $finalYSiang = ($hargaSiang/2) * $totalSiang * $selisihHari; //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam        
                }
            }
            //START PERJAM SIANg
            $listJamseterusnyaSiang = array_intersect($arrSiang,$arr1S);
                $hitungsSiangLanjut = count($listJamseterusnyaSiang);    
                if($hitungsSiangLanjut % 2 == 0){
                    $finalYSiangLanjut = ($hargaSiang/2) * $hitungsSiangLanjut; //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam
                }    else {
                    if($hitungsSiangLanjut % 2 == 0){
                        $finalYSiangLanjut = ($hargaSiang/2) * $hitungsSiangLanjut; //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam
                    } else {
                        $finalYSiangLanjut = ($hargaSiang/2) * ($hitungsSiangLanjut); 
                    }
                }
                $hargaanyaSiang =  $finalYSiangLanjut;
            $akhirdarisegalanyaSiang = $finalYSiang ;
            //$akhirdarisegalanyaSiang = $finalYSiang + $hargaanyaSiang;
            //************************************START MALEM*****************************************/
            $listMalem = array_intersect($arrMalem,$timeRange);
            $hitungMalem = count($timeRange);
            $totalMalem = count($listMalem)-1;
            
            if($hitungMalem % 2 == 0){ 
                //perjam
                $finalYmalem = ($hargaMalem/2) * $totalMalem * $selisihHari;
                //echo ($harga/2) * $hitung;
            }   else { 
                if($hitungMalem  % 2 == 0){
                // untuk per setengah jam
                    $finalYmalem = ($hargaMalem/2) * $totalMalem * $selisihHari; //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam        
                    
                } else {
                    $finalYmalem = ($hargaMalem/2) * $totalMalem * $selisihHari; //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam        
                }
            }
            
            //START HARGA PERJAM MALEM
            $listm = array_intersect($arrMalem,$arr1M);
                $hitungss = count($listm)-1;
                
                if($hitungss % 2 == 0){
                    $finalYmalemLanjut = ($hargaMalem/2) * $hitungss; //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam
                }    else {
                    //$finalYmalem = ($hargaMalem/2) * $hitungss; // untuk per setengah jam
                    if($hitungss % 2 == 0){
                        $finalYmalemLanjut = ($hargaMalem/2) * $hitungss; //harga asli dibagi 2 dikali total array intersect, untuk per 1 jam
                    }    else {
                        
                        $finalYmalemLanjut = ($hargaMalem/2) * ($hitungss);                                
                    }
                }
                $hargaanyamalem =  $finalYmalemLanjut;
                //$akhirdarisegalanyaMalem = $finalYmalem + $finalYmalemLanjut;
                $akhirdarisegalanyaMalem = $finalYmalem;
                
                
                
            if($hargaPagi != 0 && $hargaanyaSiang == 0 && $hargaanyamalem == 0){
                            //ini pagi
                $condition = $finalYPagi + $hargaPagi + $akhirdarisegalanyaSiang + $akhirdarisegalanyaMalem;
            } elseif($hargaPagi != 0 && $hargaanyaSiang != 0 && $hargaanyamalem ==0){
                //ini pagi dan siang
                //echo 'pagi dan siang, pagi dikurang';
                //$condition = ($finalYPagi + ($harga/2) * ($hitungPagiSelanjutnya-1)) + ($finalYSiang + $hargaanyaSiang);
                $condition = $finalYPagi + ($harga/2) * ($hitungPagiSelanjutnya-1) + $hargaanyaSiang + $akhirdarisegalanyaSiang + $akhirdarisegalanyaMalem; 
                  
            } elseif($hargaPagi != 0 && $hargaanyaSiang != 0 && $hargaanyamalem !=0){
                //ini siang 
                $condition = $finalYPagi + ($harga/2) * ($hitungPagiSelanjutnya-1) + ($hargaSiang/2) * ($hitungsSiangLanjut-1) + $hargaanyamalem + $akhirdarisegalanyaSiang + $akhirdarisegalanyaMalem;
                //MASIH ERROR
            } else {
                //jika ketemunya 00:00:00
                $condition = $finalYPagi + $hargaPagi + $akhirdarisegalanyaSiang + $akhirdarisegalanyaMalem;
            }
            return $condition;
        }
        
        public function gethargalapangan($idLapangan,$time)
        {
              $getQueryLapangan = $this->db->query("SELECT * FROM lapangan WHERE id='".$idLapangan."'")->result_array();
              
              $getWaktuLapangan = array();
              $timeInterval = 1800;
              foreach($getQueryLapangan as $valLap){
                    list($harga,$timeSewastart,$timeSewaEnd) = explode('|',$valLap['harga_sewa_pagi']);
                    for($t=strtotime($timeSewastart); $t<=strtotime($timeSewaEnd); $t += $timeInterval){
                        $getWaktuLapangan[] = date('H:i:s',$t);
                    }
              }
              $explHarga = explode('|',$getQueryLapangan[0]['harga_sewa_pagi']);
              
              /**************************HARGA SIANG***********************/
              $getWaktuLapanganSIang = array();
              $timeIntervalSiang = 1800;
              foreach($getQueryLapangan as $valSiang){
                    list($harga,$timeSewastart,$timeSewaEnd) = explode('|',$valSiang['harga_sewa_siang']);
                    for($q=strtotime($timeSewastart); $q<=strtotime($timeSewaEnd); $q += $timeIntervalSiang){
                        $getWaktuLapanganSIang[] = date('H:i:s',$q);
                    }
              }
              $explHargaSiang = explode('|',$getQueryLapangan[0]['harga_sewa_siang']);
              
              
              /**************************HARGA MALAM***********************/
              $getWaktuLapanganMalem = array();
              $timeIntervalMalem = 1800;
              foreach($getQueryLapangan as $valMalem){
                    list($harga,$timeSewastart,$timeSewaEnd) = explode('|',$valMalem['harga_sewa_malem']);
                    for($r=strtotime($timeSewastart); $r<=strtotime($timeSewaEnd); $r += $timeIntervalMalem){
                        $getWaktuLapanganMalem[] = date('H:i:s',$r);
                    }
              }
              $explHargaMalem = explode('|',$getQueryLapangan[0]['harga_sewa_malem']);
              
              if(in_array($time,$getWaktuLapangan)){
                    echo $explHarga[0];
              } else if(in_array($time,$getWaktuLapanganSIang)) {
                    echo $explHargaSiang[0];
              }else if(in_array($time,$getWaktuLapanganMalem)) {
                    echo $explHargaMalem[0];
              }
        }
        
        public function delete($id)
        {
            $this->db->query("DELETE FROM bookings WHERE id='$id'");
            $this->db->query("DELETE FROM booking_time WHERE booking_id='$id'");
        }
        
        public function get_week_view_event_data($date, $location = '',$week_dates,$idLapangan)
        {
          // Get the event data for the selected week, month, year and location.
          
          // Use several of the already created arrays from week_widget.php as global variables.
          global $wdays_ind;
          global $wdays;
          
          global $week_day_start;
          
          global $location_db_name;
          list ($year, $month, $day) = explode("-", $date);
                
            $query = "
            select bookings.*,booking_time.*, bookings.id as id_booking,
              customers.nama,customers.no_ktp,customers.alamat,customers.gender,customers.no_telfon
              from bookings,booking_time,customers 
              WHERE bookings.id = booking_time.booking_id
              AND bookings.id_customer = customers.id
              AND booking_time.time_interval >= '".$week_dates[0]." 00:00:00' 
              AND booking_time.time_interval <= '".$week_dates[6]." 23:59:59' 
              AND bookings.id_lapangan='$idLapangan'
              
              ORDER BY booking_time.time_interval
              ";
              
            
            //$query = "
//            select bookings.*,booking_time.*, bookings.id as id_booking,
//              customers.nama,customers.no_ktp,customers.alamat,customers.gender,customers.no_telfon
//              from bookings,booking_time,customers 
//              WHERE bookings.id = booking_time.booking_id
//              AND bookings.id_customer = customers.id
//              AND booking_time.time_interval >= '".$week_dates[0]." 00:00:00' 
//              AND booking_time.time_interval <= '".$week_dates[6]." 23:59:59' 
//              AND bookings.id_lapangan='$idLapangan'
//              
//              ORDER BY booking_time.time_interval  
//             ";
              
          
          //$query = $this->db->query("
//              select bookings.*,booking_time.*, bookings.id as id_booking,
//              customers.nama,customers.no_ktp,customers.alamat,customers.gender,customers.no_telfon
//              from bookings,booking_time,customers 
//              WHERE bookings.id = booking_time.booking_id
//              AND bookings.id_customer = customers.id
//              AND booking_time.time_interval >= '".$week_dates[0]." 00:00:00' 
//              AND booking_time.time_interval <= '".$week_dates[6]." 23:59:59' 
//              AND bookings.id_lapangan='$idLapangan'
//              
//              ORDER BY booking_time.time_interval    
//          ");
          
          
          //echo $this->db->last_query();
          
          //echo $query."<br /><br />";
          $result = mysql_query($query);
          $db_num_rows = mysql_num_rows($result);
          
          // Event Row Data Assoc. Array
          //    $event_row_data['display_time']['date'] = 'db_row_id|row_span|start_time|end_time';
          $event_row_data = array();
          
          // Get the Display Times and Number of Rows
          $data_display_times = $this->get_times_in_range(MIN_BOOKING_HOUR, MAX_BOOKING_HOUR, BOOKING_TIME_INTERVAL, true);
          $number_of_display_time_rows = count($data_display_times);
          ;
          
          // Create an Assoc. Date array for index lookup.
          $display_time_lookup = array ();
          for ($i=0; $i<$number_of_display_time_rows; $i++) {
          	$display_time_lookup[$data_display_times[$i]] = $i;
          }
          
          foreach ($week_dates as $week_date) {
        	foreach ($data_display_times as $display_time) {
        		$event_row_data[$display_time][$week_date] = '';
        	}
        	reset($data_display_times);
          }
          reset($week_dates);
          
          // $event_row_data array - build out the schedule time blocks
          
          if (!$result) {
        	//echo "No Database Events / Results<br />";
        	return false;
          }
          // Go thru the database $result data and fill out the $event_row_data array.
          $previous_event_id = 0;
          $row_span = 0;
          $row = 0;
          $previous_event_date = 0;
          $event = array();
          //echo "<h1>TESTING</h1>";
          
          for ($row=0; $row<=$db_num_rows; $row++) {
        	
        	// define db variables
        	$event = $this->wrap_db_fetch_array($result);
           // echo '<pre/>';
            //print_r($arr2);
            
            $db_event_id = $event['booking_id'];
            
        	//echo "ID: $db_event_id<br />";
        	@ list ($db_starting_date, $db_starting_time) = explode(" ", $event['time_interval']);
            
            //echo $event['schedule_date_time'].'<br/>';
        	@ list ($db_hr, $db_min, $db_sec) = explode(":", $db_starting_time);
        	$db_starting_time = sprintf("%02d", $db_hr).':'.sprintf("%02d", $db_min);
            
            //echo "<pre/>";
//            print_r($db_starting_time);
        	if ($previous_event_id != $db_event_id || $previous_event_date != $db_starting_date || 
        		$previous_event_id == 0) { 
        		
        		if ($previous_event_id != 0) { 
        			
        			$event_row_data[$event_start_time][$event_start_date] = $event_start_db_row_id."|".$row_span."|".$event_start_time."|".
        							@ $data_display_times[($display_time_lookup[$event_start_time]+$row_span)];
        			
        			$row_span = 1;
                    //echo '<pre/>';
                   // print_r($event_row_data);
        		}
        		// Mark the event starting time and db row id to be used to data_seeking
        		//echo "<strong>Mark Start:</strong> ".$db_starting_date." ".$db_starting_time.", ".$row.", ".$db_event_id."<br />";
        		$event_start_time = $db_starting_time; // mark the starting time
        		$event_start_date = $db_starting_date; // mark the starting date
        		$event_start_db_row_id = $row; // mark the starting db row
        		$row_span = 1;
        		
        	} else { // same event_id
        		// Set the 'row_span' for the spanning cells of the event to zero ('row_span' = 0)
        		$event_row_data[$db_starting_time][$db_starting_date] = 0;
        		//echo "<strong>Same Event ID:</strong> ".$db_starting_time.", ".$row.", ".$db_event_id."<br />";
        		$row_span++;
        	}
        	$previous_event_id = $db_event_id;
        	$previous_event_date = $db_starting_date;
        	
          } // end of while
        $q = $query;
        
          return array('results'=>$result,'row_data'=>$event_row_data);
        }        
        
        function wrap_db_fetch_array($db_query) {
	
        	@ $result = mysql_fetch_array($db_query);
    	
    	return $result;
      }
        
        public function getlapangan($idLapangan)
        {
              $getDataSetting = $this->my_model->getDataSetting();
              $dataConvertTimeMin = $this->convertTime($getDataSetting[0]['min_time']);
              $dataConvertTimeMax = $this->convertTimeMax($getDataSetting[0]['max_time']);
              
              define('WEEK_START', '0'); // Weekday Start ('0' for Sunday or '1' for Monday)
              define('DEFINE_AM_PM', true); // Set to 'true' for AM PM display.
  
              define('BOOKING_TIME_INTERVAL', '30'); // 15, 30 or 60 minutes (Recommended: 30 or 60 mins)
              define('MIN_BOOKING_HOUR', ''.$dataConvertTimeMin.'');   // 00-24 hours  
              define('MAX_BOOKING_HOUR', ''.$dataConvertTimeMax.'');  // 20 = 8 PM    
            
              $wdays_ind = array ();
              $wdays_ind = $this->weekday_index_array(WEEK_START);
              // Build the wdays string using the weekday_short_name function.
              $wdays = array ();
              foreach ($wdays_ind as $index) {
            	$wdays[] = $this->weekday_name($index);
              }
              reset($wdays_ind);
              
                $requestDate = date('Y-m-d');
                
              if (WEEK_START == 1) { // Starts on Monday
            	$week_day_start = $this->monday_before_date($requestDate);
              } else { // Starts on Sunday
            	$week_day_start = $this->sunday_before_date($requestDate);
              }
              // Define the 7 dates of the Week yyyy-mm-dd
              $week_dates = array ();
              for ($i=0; $i<=6; $i++) {
            		$week_dates[] = $this->add_delta_ymd($week_day_start, 0, 0, $i);
              }
  
              $data_display_times = array ();
              $data_display_times = $this->get_times_in_range(MIN_BOOKING_HOUR, MAX_BOOKING_HOUR, BOOKING_TIME_INTERVAL);
              array_pop($data_display_times);
              
              $ret = $this->get_week_view_event_data($requestDate,'',$week_dates,$idLapangan);
              $event_data = $ret['results'];
              $event_row_data = $ret['row_data'];
              
              $table = '';
              $table .= '<table style="" id="the-table" class="tablesorter">';
              $table .='<thead>';
                  $table .='<tr>';
                        $table .= '<th>';
                            $table .= 'Time';
                        $table .= '</th>';
                        
                  for ($i=0; $i<=6; $i++) {
                    //print_r($wdays[$i]);
                    
                		$week_date = $week_dates[$i];
                		list($year, $month, $day) = explode("-", $week_date);
                        
                        $table .= '<th>';
                            $table .= $wdays[$i];
                        $table .= '</th>';
                        
                  }
                  
                  $table .='</tr>';
              $table .="</thead>";
              $table .= '<tbody>';
             
              
                 foreach ($data_display_times as $display_time) {
                    list ($hour, $min) = explode(":", $display_time);
                	$time_str = sprintf("%02d:%02d", $hour, $min);
                	$std_time_str = $time_str;
                	
                    
                	// To Cater for the AM PM Hour display
                	if (DEFINE_AM_PM) {
                		// Note that the time placed in the HREF will be in 24 hour
                		$time_str = $this->format_time_to_ampm($time_str);
                	}
    
                      $table .='<tr>';
                            $table .= '<td>';
                                $table .= $time_str;
                            $table .= '</td>';
                    reset($week_dates);
                    
                	$cnt=0;
                    
                	foreach ($week_dates as $week_date) {
                	    
                           // print_r($event_row_data[$display_time][$week_date]);
                	   //echo $week_date.'<br/>';
                		if (strlen($event_row_data[$display_time][$week_date]) > 1) {
                			$cnt++;
                           
                		// list ($bookId,$keterangan,$tglBayar,$statusBayar,$jmlDibayar,$date1,$date2,$ktp,$jenisKelamin,$alamat,$telfon,$custId,$idnya,$db_row_id, $row_span, $start_time, $end_time) = explode("|", $event_row_data[$display_time][$week_date]);
                		@ list ($db_row_id, $row_span, $start_time, $end_time) = explode("|", $event_row_data[$display_time][$week_date]);
				            $rv = $this->wrap_db_data_seek($event_data, $db_row_id);
			
                            $this_event = $this->wrap_db_fetch_array($event_data);
                            
                            $dateFrom = strtotime($this_event['time_start']);
                                $dateEnd = strtotime($this_event['time_end']);
                                $kurangin = $dateEnd - $dateFrom;
                                $jam = intval(floor($kurangin/3600));
                                $menit = intval(floor($kurangin%3600)/60);
                                
                                if($jam != 0){
                                    $getJam = $jam.' Jam';
                                } else {
                                    $getJam = '';
                                }
                                if($menit != 0){
                                    $getMinute = $menit.' Menit';
                                } else {
                                    $getMinute = '';
                                }
                                
                                $getDuration = $getJam.' '.$getMinute;
                                    
                                $table .= '<td rowspan="'.$row_span.'" style="background:#35D600; border-bottom:1px solid #FFFFFF;" >';
                                    $table .= "<a class='book' href='javascript:openWindowDetail(\"$this_event[no_ktp]\",\"$this_event[gender]\",\"$this_event[alamat]\",\"$this_event[no_telfon]\",\"$this_event[id_customer]\",\"$this_event[time_start]\",\"$this_event[time_end]\",\"$getDuration\",$idLapangan,\"$this_event[keterangan]\",\"$this_event[tanggal_booking]\",\"$this_event[status_bayar]\",\"$this_event[jumlah_yang_dibayar]\",$this_event[booking_id],\"$this_event[nama]\")'>$this_event[nama] ($start_time-$end_time)</a>";           
                                    //$table .= "<a href=''>$this_event[no_ktp]($start_time-$end_time)</a>";           
                                    
                                $table .= '</td>';
                            
                			
                		} elseif ($event_row_data[$display_time][$week_date] == '0') {
                			// This is where the cell is already taken from the prev row.
                		
                		} else {
                		  $acl = getAclAdd($this->uri->segment(1),$this->uri->segment(2),$this->session->userdata('id'),array('add'=>'add'));
                          if($acl == 'true'){
                            $aclTambahdata = '-';
                          } elseif($acl == 'false'){
                            $aclTambahdata = "<a href='javascript:openWindow(\"$week_date\",\"$std_time_str\",$idLapangan)'>(+)</a>";
                          }
                		  $table .= '<td>';
                                $table .= "$aclTambahdata";           
                          $table .= '</td>';
                
                		} // end of if/elseif/else
                	} // end of foreach $week_date
                    $table .='</tr>';
                }
                  $table .= '</tbody>';
            $table .= '</table>';
            $data['table'] = $table;
            $data['id_lapangan'] = $idLapangan;
            $data['time_min'] = $getDataSetting[0]['min_time'];
            
            if($getDataSetting[0]['max_time'] == '00:00:00'){
                $max = '23:30:00';
            } else {
                $max = $getDataSetting[0]['max_time'];
            }
            
            $data['time_max'] = $max;
            $this->load->view('html/data-grid',$data);
            
        }
         function wrap_db_data_seek($db_query, $row_number) {
	
        	@ $result = mysql_data_seek($db_query, $row_number);
        	
        	return $result;
          }
        
        public function format_time_to_ampm($time, $add_leading_zeros = false)
        {
          list ($hour, $min) = explode(":", $time);
          // To Cater for the AM PM Hour display
          if (DEFINE_AM_PM) {
        	if ($hour > 12 ) { $hour = $hour - 12; $ampm = " PM"; 
        	} elseif ($hour == 12) { $ampm=" PM"; } else { $ampm=" AM"; }
          }
          if ($add_leading_zeros) {
        		$time = sprintf("%02d:%02d", $hour, $min) . $ampm;
          } else {
        		$time = sprintf("%d:%02d", $hour, $min) . $ampm;
          }
          return $time;
        }
        
        public function monday_before_date($date)
        {
          // Split the date into its components.
          list($year, $month, $day) = explode("-", $date);
          // Find the current day of the week as a single digit.
          // Range from "0" (Sunday) to "6" (Saturday)
          $day_of_the_week = date("w", mktime(1, 0, 0, $month, $day, $year));
          // If Sunday, subtract 6 days to get to Monday.
          if ($day_of_the_week == 0) {
            return date('Y-m-d', mktime(1, 0, 0, $month, $day - 6, $year));
          // Else If Monday, return that day.
          } elseif ($day_of_the_week == 1) {
            return date('Y-m-d', mktime(1, 0, 0, $month, $day, $year));
          // Else, subtract the day of the week to get to Sunday
          // and then add one to get to Monday.
          } else {
            return date('Y-m-d', mktime(1, 0, 0, $month, $day - $day_of_the_week + 1, $year));
          }
        }
        public function sunday_before_date($date)
        {
          // Split the date into its components.
          list($year, $month, $day) = explode("-", $date);
          // Find the current day of the week as a single digit.
          // Range from "0" (Sunday) to "6" (Saturday)
          $day_of_the_week = date("w", mktime(1, 0, 0, $month, $day, $year));
          // Subtract the day of the week for Sunday from the specified
          // day and reformat into YYYY-MM-DD format.
          return date('Y-m-d', mktime(1, 0, 0, $month, $day - $day_of_the_week, $year));
        }
        public function convertTimeMax($minTime){
            if($minTime == '00:00:00' ){
                return '24';
            } elseif($minTime == '23:00:00'){
                return '23';
            }elseif($minTime == '22:00:00'){
                return '22';
            }elseif($minTime == '21:00:00'){
                return '21';
            }elseif($minTime == '20:00:00'){
                return '20';
            }elseif($minTime == '19:00:00'){
                return '19';
            }elseif($minTime == '18:00:00'){
                return '18';
            }elseif($minTime == '17:00:00'){
                return '17';
            }elseif($minTime == '16:00:00'){
                return '16';
            }elseif($minTime == '15:00:00'){
                return '15';
            }elseif($minTime == '14:00:00'){
                return '14';
            }elseif($minTime == '13:00:00'){
                return '13';
            }elseif($minTime == '12:00:00'){
                return '12';
            }elseif($minTime == '11:00:00'){
                return '11';
            }elseif($minTime == '10:00:00'){
                return '10';
            }elseif($minTime == '09:00:00'){
                return '9';
            }elseif($minTime == '08:00:00'){
                return '8';
            }elseif($minTime == '07:00:00'){
                return '7';
            }elseif($minTime == '06:00:00'){
                return '6';
            }elseif($minTime == '05:00:00'){
                return '5';
            }elseif($minTime == '04:00:00'){
                return '4';
            }elseif($minTime == '03:00:00'){
                return '3';
            }elseif($minTime == '02:00:00'){
                return '2';
            }elseif($minTime == '01:00:00'){
                return '1';
            }
        }
        public function convertTime($minTime){
            
            if($minTime == '00:00:00' ){
                return '0';
            } elseif($minTime == '23:00:00'){
                return '23';
            }elseif($minTime == '22:00:00'){
                return '22';
            }elseif($minTime == '21:00:00'){
                return '21';
            }elseif($minTime == '20:00:00'){
                return '20';
            }elseif($minTime == '19:00:00'){
                return '19';
            }elseif($minTime == '18:00:00'){
                return '18';
            }elseif($minTime == '17:00:00'){
                return '17';
            }elseif($minTime == '16:00:00'){
                return '16';
            }elseif($minTime == '15:00:00'){
                return '15';
            }elseif($minTime == '14:00:00'){
                return '14';
            }elseif($minTime == '13:00:00'){
                return '13';
            }elseif($minTime == '12:00:00'){
                return '12';
            }elseif($minTime == '11:00:00'){
                return '11';
            }elseif($minTime == '10:00:00'){
                return '10';
            }elseif($minTime == '09:00:00'){
                return '9';
            }elseif($minTime == '08:00:00'){
                return '8';
            }elseif($minTime == '07:00:00'){
                return '7';
            }elseif($minTime == '06:00:00'){
                return '6';
            }elseif($minTime == '05:00:00'){
                return '5';
            }elseif($minTime == '04:00:00'){
                return '4';
            }elseif($minTime == '03:00:00'){
                return '3';
            }elseif($minTime == '02:00:00'){
                return '2';
            }elseif($minTime == '01:00:00'){
                return '1';
            }
        }
        public function weekday_name($weekday_value)
        {
            //cek jika tanggal sekarang kasih arterisk
            if($weekday_value == 0){
                if(date('N') == 7){
                    return 'Minggu <span style="color:red;">* (Now)</span>';
                } else {
                    return 'Minggu ';
                }
            } elseif($weekday_value == 1){
                if(date('N') == 1){
                    return 'Senin <span style="color:red;">* (Now)</span>';
                } else {
                    return 'Senin ';
                }
            }elseif($weekday_value == 2){
                if(date('N') == 2){
                    return 'Selasa <span style="color:red;">* (Now)</span>';
                } else {
                    return 'Selasa ';
                }
            }elseif($weekday_value == 3){
                if(date('N') == 3){
                    return 'Rabu <span style="color:red;">* (Now)</span>';
                } else {
                    return 'Rabu ';
                }
            }elseif($weekday_value == 4){
                if(date('N') == 4){
                    return 'Kamis <span style="color:red;">* (Now)</span>';
                } else {
                    return 'Kamis';
                }
            }elseif($weekday_value == 5){
                
                if(date('N') == 5){
                    return 'Jumat <span style="color:red;">* (Now)</span>';
                } else {
                    return 'Jumat ';
                }
            }elseif($weekday_value == 6){
                
                if(date('N') == 6){
                    return 'Sabtu <span style="color:red;">* (Now)</span>';
                } else {
                    return 'Sabtu ';
                }
            } else {
                return "unknown-weekday($w)";
            }
            
         // switch($weekday_value) {
//        	case 0: return "Minggu";
//        	case 1: return "Senin";
//        	case 2: return "Selasa";
//        	case 3: return "Rabu";
//        	case 4: return "Kamis";
//        	case 5: return "Jumat";
//        	case 6: return "Sabtu";
//          }
//          return "unknown-weekday($w)";
        }
        public function weekday_index_array ($w)
        {
          switch($w) {
        	case 0: return array (0,1,2,3,4,5,6); // Start with Sunday
        	case 1: return array (1,2,3,4,5,6,0); // Start with Monday
          }
          return array (0,1,2,3,4,5,6); // Default - Start with Sunday
        }
        public function add_delta_ymd($date, $delta_years = 0, $delta_months = 0, $delta_days = 0)
        {
          // delta_years adjustment:
          // Use this to adjust for next and previous years.
          // Add the $delta_years to the current year and make the new date.
          
          if ($delta_years != 0) {
        	// Split the date into its components.
        	list($year, $month, $day) = explode("-", $date);
        	// Careful to check for leap year effects!
        	if ($month == 2 && $day == 29) {
        		// Check the number of days in the month/year, with the day set to 1.
        		$tmp_date = date("Y-m", mktime(1, 0, 0, $month, 1, $year + $delta_years));
        		list($new_year, $new_month) = explode("-", $tmp_date);
        		$days_in_month = number_of_days_in_month($new_year, $new_month);
        		// Lower the day value if it exceeds the number of days in the new month/year.
        		if ($days_in_month < $day) { $day = $days_in_month; }
        		$date = $new_year . '-' . $month . '-' . $day;
            } else {
        		$new_year = $year + $delta_years;
        		$date = sprintf("%04d-%02d-%02d", $new_year, $month, $day);
        	}
          }
          
          // delta_months adjustment:
          // Use this to adjust for next and previous months.
          // Note: This DOES NOT subtract 30 days! 
          // Use $delta_days for that type of calculation.
          // Add the $delta_months to the current month and make the new date.
          
          if ($delta_months != 0) {
        	// Split the date into its components.
        	list($year, $month, $day) = explode("-", $date);
        	// Calculate New Month and Year
        	$new_year = $year;
        	$new_month = $month + $delta_months;
        	if ($delta_months < -840 || $delta_months > 840) { $new_month = $month; } // Bad Delta
        	if ($delta_months > 0) { // Adding Months
        		while ($new_month > 12) { // Adjust so $new_month is between 1 and 12.
        			$new_year++;
        			$new_month -= 12;
        		}
        	} elseif ($delta_months < 0) { // Subtracting Months
        		while ($new_month < 1) { // Adjust so $new_month is between 1 and 12.
        			$new_year--;
        			$new_month += 12;
        		}
        	}
        	// Careful to check for number of days in the new month!
        	$days_in_month = number_of_days_in_month($new_year, $new_month);
        	// Lower the day value if it exceeds the number of days in the new month/year.
        	if ($days_in_month < $day) { $day = $days_in_month; }
        	$date = sprintf("%04d-%02d-%02d", $new_year, $new_month, $day);
          }
          
          // delta_days adjustment:
          // Use this to adjust for next and previous days.
          // Add the $delta_days to the current day and make the new date.
          
          if ($delta_days != 0) {
        	// Split the date into its components.
        	list($year, $month, $day) = explode("-", $date);
        	// Create New Date
        	$date = date("Y-m-d", mktime(1, 0, 0, $month, $day, $year) + $delta_days*24*60*60);
          }
          
          // Check Valid Date, Use for TroubleShooting
          //list($year, $month, $day) = explode("-", $date);
          //$valid = checkdate($month, $day, $year);
          //if (!$valid)  return "Error, function add_delta_ymd: Could not process valid date!";
          
          return $date;
        }
        
        public function get_times_in_range ($min_time = "00:00", $max_time = "24:00", 
			$time_inc = 30, $include_max_time = false)
            {
              @list ($start_hour, $start_min) = explode(":", $min_time);
              if (substr($start_hour, 0, 1) == '0') $start_hour = substr($start_hour, 1, 1);
              $start_hour = (int)$start_hour;
              if (substr($start_min, 0, 1) == '0') $start_min = substr($start_min, 1, 1);
              $start_min = (int)$start_min;
              @list ($end_hour, $end_min) = explode(":", $max_time);
              if (substr($end_hour, 0, 1) == '0') $end_hour = substr($end_hour, 1, 1);
              $end_hour = (int)$end_hour;
              if (substr($end_min, 0, 1) == '0') $end_min = substr($end_min, 1, 1);
              $end_min = (int)$end_min;
            
              $time_strings = array ();
              $hour = $start_hour;
              $min = $start_min;
            
              // Count up to the first hour segment.
              if ($start_min != 0) {
            	while ($min < 60) {
            		if (60 - $min >= $time_inc) { // check remainder
            			$time_strings[] = sprintf("%02d:%02d", $hour, $min);
            		}
            		$min = $min + $time_inc;
            	}
            	$hour++;
              }
              // Start counting up the full hours.
              while ($hour < $end_hour) {
            	$min = 0;
            	while ($min < 60) {
            		if (60 - $min >= $time_inc) { // check remainder
            			$time_strings[] = sprintf("%02d:%02d", $hour, $min);
            		}
            		$min = $min + $time_inc;
            	}
            	$hour++;
              }
              // Count up the last hour segment.
              $min = 0;
              if ($end_min != 0 && $hour < 24) {
            	while ($min < 60 && $min < $end_min) {
            		if ($end_min - $min >= $time_inc) { // check remainder
            			$time_strings[] = sprintf("%02d:%02d", $hour, $min);
            		}
            		$min = $min + $time_inc;
            	}
            	$hour++;
              }
            
              if ($include_max_time && $time_strings[count($time_strings)-1] != sprintf("%02d:%02d", $hour, $min)) {
            	$time_strings[] = sprintf("%02d:%02d", $hour, $min);
              }
              // returns array values in 24 hour format ("%02d:%02d")
              return $time_strings;
            }
        
        
    }
?>