<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL);
class Home extends CI_Controller {


     function __construct() {
        parent::__construct();
        $this->load->model('Home_model');
        $this->load->model('Common_model');
     $this->load->helper('Common_helper');
        check_user_authentication(); 
        }



  /*
     * --------------------------------------------------------------------------
     * @ Function Name            : index
     * @ Added Date               : 13-04-2017
     * @ Added By                 : Vishal Kumar Gupta
     * -----------------------------------------------------------------
     * @ Description              : Load the Login Page
     * -----------------------------------------------------------------
     * @ param                    :
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */
     


	public function index()
	{
		$this->load->view('login');
	}


 /*
     * --------------------------------------------------------------------------
     * @ Function Name            : Login
     * @ Added Date               : 13-04-2017
     * @ Added By                 : Vishal Kumar Gupta
     * -----------------------------------------------------------------
     * @ Description              : User Login Check
     * -----------------------------------------------------------------
     * @ param                    :
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */



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

/*
     * --------------------------------------------------------------------------
     * @ Function Name            : register
     * @ Added Date               : 13-04-2017
     * @ Added By                 : Vishal Kumar Gupta
     * -----------------------------------------------------------------
     * @ Description              : New User Register
     * -----------------------------------------------------------------
     * @ param                    :
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */

function register(){
$data = array();
if($this->input->post()){
//print_r($this->input->post());exit();
$this->form_validation->set_rules('username', 'UserName', 'trim|required');
$this->form_validation->set_rules('password', 'Password', 'trim|required');
$this->form_validation->set_rules('email', 'Email', 'trim|required');
$this->form_validation->set_rules('name', 'Name', 'trim|required');
$data = array();
//$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|is_unique[users.username]');
 if($this->form_validation->run() == FALSE) {
 
}else{

$data = array(
'email_id'=>$this->input->post("email"),
'name'=>$this->input->post("name"),
'username'=>$this->input->post("username"),
'password'=>md5($this->input->post("password"))
		);

 //print_r($data); exit();
 $this->db->insert('users',$data);
 $this->Common_model->add('users',$data);
 $q = $this->Home_model->validate($this->input->post("username"),md5($this->input->post("password")));
 //print_r($q); exit();
if(!empty($q)){
	$this->session->set_userdata("user_id", $q['id']);
                       
    redirect('User/dashboard');

	}
}

}
$this->load->view('register',$data);

 
}


/*
     * --------------------------------------------------------------------------
     * @ Function Name            : usernamechk
     * @ Added Date               : 13-04-2017
     * @ Added By                 : Vishal Kumar Gupta
     * -----------------------------------------------------------------
     * @ Description              : User Name Check
     * -----------------------------------------------------------------
     * @ param                    :
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */


function usernamechk(){
    $username = $this->input->post("username"); 
    echo $q = $this->Home_model->usernamechk($username);

}


/*
     * --------------------------------------------------------------------------
     * @ Function Name            : emailchk
     * @ Added Date               : 13-04-2017
     * @ Added By                 : Vishal Kumar Gupta
     * -----------------------------------------------------------------
     * @ Description              : Email Check
     * -----------------------------------------------------------------
     * @ param                    :
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */

function emailchk(){
 $email = $this->input->post("email");
 //echo $email; exit();
 echo $q = $this->Home_model->emailchk($email);
}

//////////////////// End Class //////////////////////
}
