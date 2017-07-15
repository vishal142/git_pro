<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

 
 function addCategory($table,$data){
 
 $this->db->insert($table,$data);
 return $this->db->insert_id();
 }


//////////////////// End Class //////////////////////
}
