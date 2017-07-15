<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL);
class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

     function __construct() {
        parent::__construct();
        $this->load->model('Home_model');
      //  error_reporting();
        }

	public function index()
	{
		$this->load->view('login');
	}

public function login(){
$email_id = $this->input->post("email_id");
$pass = md5($this->input->post("password"));
$data = array();
if ($this->input->post()){
            $this->form_validation->set_rules('email_id', 'email_id', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            if ($this->form_validation->run() == false) {
                //$data['message'] = "Please enter Login id and Password";
            } else {
                $data['email_id'] = $this->input->post("email_id");
                $data['password'] = $this->input->post("password");
                //if ($this->input->post("timezone") != "") {
                    //$data_time['timezone'] = $this->input->post("timezone");
                //} else {
                    //$data_time['timezone'] = $this->config->item('timezone_id');
                //}
                $check_login = $this->Home_model->check_admin($data);
                //print_r($check_login);
   
                if (count($check_login) > 0) {
                	//print_r($check_login); exit();
                    $this->session->set_userdata("user_id", $check_login['id']);
                    redirect(base_url() . "user/dashboard");
                    //$timezone_array = $this->Common_model->select_one_row('master_timezones', array('timezone' => $data_time['timezone'])
                    //);
                    //$param = array('last_login_timestamp' => date("Y-m-d H:i:s"),
                        //'fk_timezone_id'                  => $timezone_array['id'],
                    //);

                    //$offset = $timezone_array['utc_offset'];
                    //$this->session->set_userdata("utc_offset",$offset );

                    //$updateLogin = $this->Admin_model->updateLastLogin($check_login['id'], $param);
                    
                } else {
                    $data['error_message'] = "Enter proper email and password";
                }
            }
        }

        $this->load->view('login',$data);
  

 }


function register(){
if ($this->input->post('submit') AND $this->input->post('submit') == "Submit") {
$this->form_validation->set_rules('username', 'UserName', 'trim|required');
$this->form_validation->set_rules('password', 'Password', 'trim|required');
$this->form_validation->set_rules('email', 'Email', 'trim|required');
$this->form_validation->set_rules('name', 'Name', 'trim|required');
//$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|is_unique[users.username]');
 if($this->form_validation->run() == FALSE) {
 $this->load->view('register');
}else{

$data = array(
'email_id'=>$this->input->post("email"),
'name'=>$this->input->post("name"),
'username'=>$this->input->post("username"),
'password'=>md5($this->input->post("password"))
		);

 $this->db->insert('users',$data);
 $q = $this->Home_model->validate($this->input->post("username"),md5($this->input->post("password")));
 //print_r($q); exit();
if(!empty($q)){
	//print_r($q); exit();
	$newdata = array(
		'id'=>$q['id'],
        'username'  => $q['username'],
        'email'     => $q['email_id'],
        'name'     => $q['name'],
        'logged_in' => TRUE
);

$this->session->set_userdata($newdata);

redirect('User/dashboard');

	}else{
			$this->session->set_flashdata('suc', 'suc_reg');
		redirect('');
	}
}

}else{

$this->load->view('register');

}

 
}

function usernamechk(){
$username = $this->input->post("username");
echo $q = $this->Home_model->usernamechk($username);

}

//////////////////// End Class //////////////////////
}
