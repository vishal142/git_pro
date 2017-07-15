<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

 public $tbl_user = 'users';
	

function validate($username,$pass){
    //echo $username.'<br>'.$pass; exit();
	$this->db->select('*');
    $this->db->from('users');
    $this->db->where('username', $username);
    $this->db->where('password', $pass);
    return $this->db->get()->row_array();


}
   
function usernamechk($username){
$this->db->select('*');
    $this->db->from('users');
    $this->db->where('username', $username);
    
    return $this->db->get()->num_rows();

}


public function check_admin($data = array())
    {
        $this->db->select($this->tbl_user . '.id');
        $this->db->from($this->tbl_user);
        $this->db->where($this->tbl_user . '.email_id', $data['email_id']);
        $this->db->where($this->tbl_user . '.password', md5($data['password']));
        //$this->db->where($this->tbl_user . '.is_active', '1');
        return $this->db->get()->row_array();
    }

function emailchk($email){
$this->db->select('*');
    //$this->db->from('users');
    $this->db->where('email_id', $email);
    return $this->db->get('users')->num_rows();

}

//////////////////// End Class //////////////////////
}
