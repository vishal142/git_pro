<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	

function all_cat($param = array()){

	$this->db->select('*');

	if(isset($param['page_no']) && isset($param['page_size'])){

		$limit = $param['page_size'];
		$offset = $limit*($param['page_no']-1);
		$this->db->limit($limit,$offset);
	}

	if(isset($param['search'])){
	$con = "";
	$con .="And (cat_name LIKE '%".$this->db->escape_str($param['search'])."%')";
	$where = "1 ".$con;
	$this->db->where($where);


	}

	$this->db->from('category');
    return $this->db->get()->result_array();
}

function add_category($table,$param){
 $this->db->insert($table,$param);
 return $this->db->insert_id();
}

function chk_categoery($tables,$param){
	$this->db->select('id');
	$this->db->where('id',$param);
	return $this->db->get($tables)->num_rows();



}

function fetch_subcate($table,$param){

	$this->db->select('id');
	$this->db->where('subcat_name',$param);
	return $this->db->get($table)->num_rows();
}

function all_sub_cat(){
 
 $this->db->select('tbl_sub_category.subcat_name , category.cat_name');
 $this->db->join('category', 'category.id = tbl_sub_category.cat_id','left');

$result = $this->db->get('tbl_sub_category')->result_array();
return $result;

}

function all_pro($param = array()){
  //print_r($param); exit();
 //$this->db->select('tbl_sub_category.*,category.*,tbl_products.*,tbl_products.id as prodct_id');
$this->db->select('tbl_products.id as product_id,tbl_products.product_name,tbl_products.price,tbl_products.product_code,tbl_products.cat_id,tbl_products.subcat_id,tbl_sub_category.subcat_name,category.cat_name');
 $this->db->join('tbl_sub_category', 'tbl_sub_category.id = tbl_products.subcat_id','left');
 $this->db->join('category', 'category.id = tbl_sub_category.cat_id','left');

 if(isset($param['filter']) && $param['filter'] !=''){

  $this->db->where('tbl_products.price',$param['filter']);

 }

 if(isset($param['search']) && $param['search'] !=''){

 	$con = "";
 	$con .="AND (tbl_sub_category.subcat_name LIKE '%".$this->db->escape_str($param['search'])."%' OR category.cat_name LIKE '%".$this->db->escape_str($param['search'])."%' OR tbl_products.product_name LIKE '%".$this->db->escape_str($param['search'])."%')";

 	$where = "1 ". $con;
    $this->db->where($where);
 }

 if(!empty($param['page_no']) && !empty($param['page_size'])){
                $limit = $param['page_size'];
                $offset = $limit*($param['page_no']-1);
               $this->db->limit($limit, $offset);
            }

$result = $this->db->get('tbl_products')->result_array();
return $result;

}


function get_all_sub_cat($cat_id){
$this->db->select('*');
 $this->db->where('cat_id', $cat_id); 
	$this->db->from('tbl_sub_category');
    return $this->db->get()->result_array();
}

function edit_subcat($id){
$this->db->select('*');
 $this->db->where('id', $id); 
	$this->db->from('tbl_sub_category');
    return $this->db->get()->result_array();

}

function update_cat($id){
$this->db->select('*');
 $this->db->where('id', $id); 
	$this->db->from('category');
    return $this->db->get()->result_array();
}

function product_value($id){
	//$this->db->select('*');
	//$this->db->where('id',$id);
	//$this->db->from('tbl_products');

	$this->db->select('tbl_products.*,tbl_products.id as p_id,tbl_sub_category.*,category.*');
	$this->db->join('tbl_sub_category','tbl_sub_category.id=tbl_products.subcat_id','left');
	$this->db->join('category','category.id=tbl_sub_category.cat_id','left');
	$this->db->where('tbl_products.id',$id);
	return $this->db->get('tbl_products')->result_array();


}

function getAdminName($user_id){
 $this->db->select('name');
 $this->db->where('id',$user_id);
 $this->db->from('users');
 $res = $this->db->get()->result_array();
 foreach($res as $name){

 	$row= $name['name'];
 }
 return $row;
}

 function get_all_product_img($id){
 	$this->db->select('*');
 	$this->db->where('prod_id',$id);
 	return $this->db->get('tbl_product_images')->result_array();


 }


 function all_cms(){
  $this->db->select('*');
  return $this->db->get('tbl_cms')->result_array();

 }
//////////////////// End Class //////////////////////
}
