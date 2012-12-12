<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('my_model');
    }
	public function index()
	{
		$this->load->view('login');
	}
    
    public function auth()
    {
        $username = $this->security->xss_clean(strip_image_tags($this->input->post('username')));
        $password = $this->security->xss_clean(strip_image_tags($this->input->post('password')));
        $cekLogin = $this->my_model->cekLogin($username,$password);
        if($cekLogin['total'] > 0){
            $data = $cekLogin['rows'];
            $userType = config_item('user_type');

            if($data[0]['user_type'] == 0){
                $type = $userType[0];
            } else {
                $type = $userType[1];
            }
            
            $sessArr = array(
                'id'=>$data[0]['id'],
                'username'=>$data[0]['username'],
                'name'=>$data[0]['name'],
                'user_type'=>$type,
                'logged_in'=>TRUE
            );
            //print_r($sessArr);
            
            $this->session->set_userdata($sessArr);
            //print_r($this->session->userdata);
            echo "{success:true}";
            
        } else {
            echo "2";
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */