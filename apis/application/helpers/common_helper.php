<?php

function randomAlphaNum($length, $count, $characters)
{

// $length - the length of the generated password
    // $count - number of passwords to be generated
    // $characters - types of characters to be used in the password

// define variables used within the function
    $symbols      = array();
    $passwords    = array();
    $used_symbols = '';
    $pass         = '';

// an array of different character types
    $symbols["lower_case"]      = 'abcdefghijklmnopqrstuvwxyz';
    $symbols["upper_case"]      = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $symbols["numbers"]         = '1234567890';
    $symbols["special_symbols"] = '!?~@#-_+<>[]{}';

    $characters = explode(",", $characters); // get characters types to be used for the passsword
    foreach ($characters as $key => $value) {
        $used_symbols .= $symbols[$value]; // build a string with all characters
    }
    $symbols_length = strlen($used_symbols) - 1; //strlen starts from 0 so to get number of characters deduct 1

    for ($p = 0; $p < $count; $p++) {
        $pass = '';
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $symbols_length); // get a random character from the string with all characters
            $pass .= $used_symbols[$n]; // add the character to the password string
        }
        $passwords = $pass;
    }

    return $passwords; // return the generated password
}

function check_user_authentication(){
$CI = &get_instance();
    if ($CI->session->userdata('user_id')) {
        redirect(base_url() . 'user/dashboard', 'refresh');
    }
}

function check_user_loggedin(){
     $CI= &get_instance();
     if(!$CI->session->userdata('user_id')){
        redirect(base_url().'','refresh');
     }

}

function adminName(){
$CI= &get_instance();
 $CI->load->model('User_model');
  $user_id =$CI->session->userdata('user_id');
      $name = $CI->User_model->getAdminName($user_id);
        echo $name;

}


function all_product($pram=array()){
    $CI = &get_instance();
    $CI->load->model('User_model');
    $all_pro = $CI->user_model->all_prodect_suc_cat($pram['sub_cat_id']);
    return $all_pro;

  //print_r($pram['sub_cat_id']);
}

