<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	

function all_cat(){

	$this->db->select('*');
	$this->db->from('category');
    return $this->db->get()->result_array();
}

function all_sub_cat(){
 
 $this->db->select('tbl_sub_category.* , tbl_sub_category.id as sub_id,category.* , category.id as cat_id ');
 $this->db->join('category', 'category.id = tbl_sub_category.cat_id','left');

$result = $this->db->get('tbl_sub_category')->result_array();
return $result;

}

function check_cat($catname){
	 $this->db->select('id');
	 $this->db->where('cat_name',$catname);
	 return $this->db->get('category')->num_rows();


}

function all_pro($param=array()){
	//print_r($param); exit();
 //$this->db->select('tbl_sub_category.*,category.*,tbl_products.*,tbl_products.id as prodct_id');
$this->db->select('tbl_products.id as product_id,tbl_products.product_name,tbl_products.price,tbl_products.product_code,tbl_products.cat_id,tbl_products.subcat_id,tbl_sub_category.subcat_name,category.cat_name,tbl_product_images.img_ext');
 $this->db->join('tbl_sub_category', 'tbl_sub_category.id = tbl_products.subcat_id','left');
 $this->db->join('category', 'category.id = tbl_sub_category.cat_id','left');
 $this->db->join('tbl_product_images','tbl_product_images.prod_id=tbl_products.id','left');
 if(!empty($param['page']) && !empty($param['page_size'])){
            $limit = $param['page_size'];
            $offset = $limit*($param['page']-1);
            $this->db->limit($limit, $offset);
        }

$result = $this->db->get('tbl_products')->result_array();
return $result;

}

function all_cms(){

	$this->db->select('*');
	return $this->db->get('tbl_cms')->result_array();
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

 function all_prodect_suc_cat($sub_cat_id){
 	$this->db->select('*');
 	$this->db->where('subcat_id',$sub_cat_id);
 	return $this->db->count_all_results('tbl_products');
 }

 function count_all_product(){

 	$this->db->select('id');
 	return $this->db->count_all_results('tbl_products');
 }


function search_product($param){
//print_r($param); 
$this->db->select('*');

if($param['subcat_id']!=''){
$this->db->where('subcat_id',$param['subcat_id']);
}else if($param['cat_id']!=''){
$this->db->where('cat_id',$param['cat_id']);
}else if($param['product_name']!=""){
 $this->db->like('product_name',($param['product_name']));
}

$this->db->order_by('id','DESC');
return $this->db->get('tbl_products')->result_array();


}


function add_pr($data = array()){

	$this->db->insert('tbl_pr',$data);
	$last_id = $this->db->insert_id();
	return $last_id;


}

 function add_pr_item($param = array()){
 	$this->db->insert('tbl_pr_items',$param);
 	return true;


 }


//////////////////// End Class //////////////////////
}
