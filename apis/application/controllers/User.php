<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('Common_model');
        $this->load->helper('Common_helper');
        date_default_timezone_set("Asia/Kolkata");
        check_user_loggedin();
    }
    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : dashboard
     * @ Added Date               : 13-04-2017
     * @ Added By                 : Vishal Kumar Gupta
     * -----------------------------------------------------------------
     * @ Description              : Dashboard
     * -----------------------------------------------------------------
     * @ param                    :
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */
    function dashboard()
    {
        $this->load->library('pagination');

    $config['base_url'] = base_url('user/dashboard');
    $config['total_rows'] = $this->user_model->count_all_product();
    $config['use_page_numbers'] = TRUE;
    $config['per_page'] = 4;
    $config['uri_segment'] = 3;
    $choice = $config['total_rows']/$config['per_page'];
    $config['num_links'] = round($choice);
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        $config["cur_page"] = $page;

$arr = array();
$this->pagination->initialize($config);
 $data['links'] = $this->pagination->create_links();
 $data['page']      = $page;
 $data['page_size'] = $config['per_page'];
        $data['all_cat']     = $this->user_model->all_cat();
        
        $sub_cat_data = $this->user_model->all_sub_cat();
        
        $data['all_sub_cat'] = $this->user_model->all_sub_cat();
     
        $data['all_pro'] = $this->user_model->all_pro(array('page'=>$data['page'],'page_size'=>$data['page_size']));

        $data['all_cms']=$this->user_model->all_cms();
       
       // echo '<pre>';print_r($data['all_pro']);
        //echo '<pre>';print_r($data);
        $this->load->view('user/dashboard', $data);
    }
    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : logout
     * @ Added Date               : 13-04-2017
     * @ Added By                 : Vishal Kumar Gupta
     * -----------------------------------------------------------------
     * @ Description              : All Session Destroy 
     * -----------------------------------------------------------------
     * @ param                    :
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */
    function logout()
    {
        $this->session->sess_destroy();
        $this->session->unset_userdata('user_id');
        $this->session->set_flashdata('sucess', 'logout');
        redirect(base_url());
    }
    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : addproduct
     * @ Added Date               : 13-04-2017
     * @ Added By                 : Vishal Kumar Gupta
     * -----------------------------------------------------------------
     * @ Description              : Add Product
     * -----------------------------------------------------------------
     * @ param                    :
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */
    function addproduct()
    {
        $this->load->helper('Common_helper');
        $data = array();
        if ($this->input->post()) {
            $this->form_validation->set_rules('cat_id', 'Categoery Name', 'trim|required');
            $this->form_validation->set_rules('sub_cat_id', 'Sub Categoery Name', 'trim|required');
            $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
            $this->form_validation->set_rules('price', 'Price', 'trim|required');
            //$this->form_validation->set_rules('product_img', 'Product Image', 'trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                
            } else {
                $code = randomAlphaNum(10, 1, "upper_case,numbers");
                $data = array(
                    'product_name' => $this->input->post("product_name"),
                    'product_code' => $code,
                    'price' => $this->input->post("price"),
                    'cat_id' => $this->input->post("cat_id"),
                    'subcat_id' => $this->input->post("sub_cat_id"),
                    'status' => $this->input->post("status")
                );
                $this->db->insert('tbl_products', $data);
                $product_id = $this->db->insert_id();
                //$product_id = 1;
                

                if (isset($_FILES['product_img']) && $_FILES['product_img']['size'] > 0) {
                    $config['upload_path']          = './assets/product_img/';
                    $config['allowed_types']        ='gif|jpg|png';
                    //$config['max_size']             = 100;
                    $config['width']            = 300;
                    $config['height']           = 300;
                    $array                   = explode('.', $_FILES['product_img']['name']);
                    $extension               = end($array);
                    $new_name = $product_id.'.'.$extension;
                    $config['file_name'] = $new_name;
                    $config['image_library'] = 'gd2';

                    $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('product_img'))
                        {
                        $error = array('error' => $this->upload->display_errors());
                        //print_r($error['error']); exit();
                        $data['error_message'] = $error['error'];
                        //$data['image_uplod_error']= $error['error'];
                        //$data['all_cat']     = $this->user_model->all_cat();
                        //$data['all_sub_cat'] = $this->user_model->all_sub_cat();
                        //$this->load->view('user/add_product', $data);
                        }
                        else
                        {
                            $data = array('upload_data' => $this->upload->data());
                            $data2 = array('prod_id'=>$product_id,'img_ext'=>$extension);
                            $this->Common_model->add('tbl_product_images', $data2); // Add  the  image 
                            $this->session->set_flashdata('sucess', 'product_insert');
                            redirect('User/dashboard');

                            //$this->load->view('upload_success', $data);
                        }

                }
                        
                        $this->session->set_flashdata('sucess', 'product_insert');
                        redirect('User/dashboard');
              
            }
        } 
                    $data['all_cat']     = $this->user_model->all_cat();
                    $data['all_sub_cat'] = $this->user_model->all_sub_cat();
                    $this->load->view('user/add_product', $data);
}


function check_cat(){
 $catname = $this->input->post('catname'); 
 $cat = $this->user_model->check_cat($catname);
 echo $cat; exit();
 
}
    function get_all_sub_cat()
    {
        $cat_id  = $this->input->post("cat_id");
        $sub_cat = $this->user_model->get_all_sub_cat($cat_id);
        //print_r($sub_cat); exit();
        if (!empty($sub_cat)) {
            foreach ($sub_cat as $sub)
                echo "<option value=" . $sub['id'] . ">" . $sub['subcat_name'] . "</option>";
        } else {
            echo "<option value=''>Select Sub Categoery</option>";
        }
    }
    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : edit_product
     * @ Added Date               : 13-04-2017
     * @ Added By                 : Vishal Kumar Gupta
     * -----------------------------------------------------------------
     * @ Description              : Update the Product
     * -----------------------------------------------------------------
     * @ param                    :
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */
    function edit_product($id)
    {
        $data['all_cat']       = $this->user_model->all_cat();
        $data['all_sub_cat']   = $this->user_model->all_sub_cat();
        $data['product_image'] = $this->user_model->get_all_product_img($id);
        //print_r($data['product_image']);
        $data['product_value'] = $this->user_model->product_value($id);

        if ($this->input->post()) {
            $this->form_validation->set_rules('cat_id', 'Categoery Name', 'trim|required');
            $this->form_validation->set_rules('sub_cat_id', 'Sub Categoery Name', 'trim|required');
            $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
            $this->form_validation->set_rules('price', 'Product Price', 'trim|required');
            $this->form_validation->set_rules('status', 'Product status', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
            } else {
                   $product_id = $id;

                   if (isset($_FILES['product_img']) && $_FILES['product_img']['size'] > 0) {
                     $img_path = $this->config->item('full_img_path');
                     $img =  $img_path.$id.'.'.$data['product_image'][0]['img_ext'];

                      unlink($img);
                     
                    $config['upload_path']          = './assets/product_img/';
                    $config['allowed_types']        ='gif|jpg|png';
                    //$config['max_size']             = 100;
                    $config['width']            = 300;
                    $config['height']           = 300;
                    $array                   = explode('.', $_FILES['product_img']['name']);
                    $extension               = end($array);
                    $new_name = $product_id.'.'.$extension;
                    $config['file_name'] = $new_name;
                    $config['image_library'] = 'gd2';

                    $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('product_img'))
                        {
                            $error = array('error' => $this->upload->display_errors());
                            //print_r($error['error']); exit();
                            $data['error_message'] = $error['error'];
                            //$data['image_uplod_error']= $error['error'];
                            //$data['all_cat']     = $this->user_model->all_cat();
                            //$data['all_sub_cat'] = $this->user_model->all_sub_cat();
                            //$this->load->view('user/add_product', $data);
                        }
                        else
                        {
                          //print_r($data['product_image']); exit();
                            
                            //$data1['product_image'] = $this->user_model->get_all_product_img($id);
                            //print_r($data1['product_image']); exit();
                           
                           
                         
                            $data2 = array('prod_id'=>$product_id,'img_ext'=>$extension);
                            if(!empty($data['product_image'])){
                            $this->Common_model->update('tbl_product_images', array('prod_id' =>$product_id), $data2);
                            }else{
                            $this->Common_model->add('tbl_product_images', $data2); // Add  the  image    
                            }
                            $data = array('upload_data' => $this->upload->data());
                            
                            
                        }

                }




                $data = array(
                    'product_name' => $this->input->post("product_name"),
                    'price' => $this->input->post("price"),
                    'cat_id' => $this->input->post("cat_id"),
                    'subcat_id' => $this->input->post("sub_cat_id"),
                    'status' => $this->input->post("status")
                );
                $this->db->where('id', $id);
                $this->db->update('tbl_products', $data);
                $this->session->set_flashdata('sucess', 'sucess_update');
                redirect(base_url() . "user/dashboard");
            }
        }
        ///print_r($data['product_value']);
        $this->load->view('user/update_product', $data);
    }




    function deleteproduct($id){

        $this->Common_model->delete('tbl_products', array('id' => $id));
        $this->Common_model->delete('tbl_product_images', array('prod_id' => $id));
        
        $data['product_ext'] = $this->user_model->get_all_product_img($id);
        //$img =  base_url().'assets/product_img/'.$id.'.'.$data['product_ext'][0]['img_ext'];
        $img =  'assets/product_img/'.$id.'.'.$data['product_ext'][0]['img_ext'];
         @unlink($img);
        //print_r($img); exit();

        $this->session->set_flashdata('sucess', 'sucess_delete');
        redirect('User/dashboard');
    }





 function addPage(){
    $data = array();
    if ($this->input->post()) {
        $page_name = $this->input->post('page_name');
        $this->form_validation->set_rules('page_name', 'Page Name', 'trim|required');
        //$this->form_validation->set_rules('cms_img', 'Image', 'trim|required');
        $this->form_validation->set_rules('content', 'Content', 'trim|required');
            if ($this->form_validation->run() == FALSE) {


            }else{

          $this->load->library('upload');
            if (isset($_FILES['cms_img']) && $_FILES['cms_img']['size'] > 0) {

                 $image_info      = getimagesize($_FILES['cms_img']['tmp_name']);
                 $image_width     = $image_info[0];
                $image_height    = $image_info[1];
                $original_width  = $image_width;
                $original_height = $image_height;
                $new_width       = 640;
                $new_height      = 360;
                $thumb_width             = $new_width;
                $thumb_height            = $new_height;
                $array                   = explode('.', $_FILES['cms_img']['name']);
                $extension               = end($array);
                $file_name               = $page_name . "." . $extension;
                $config['upload_path']   = 'assets/cms';
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['overwrite'] = true;
                $config['file_name'] = $file_name;
                $this->upload->initialize($config);
                if ($this->upload->do_upload('cms_img')) {

                   $upload_data_details = $this->upload->data();
                    $image    = $upload_data_details['file_name'];
                    $this->load->library('image_lib');
                    $config['source_image']   = 'assets/cms/' . $image;
                    $config['new_image']      = 'assets/cms/' . $image;
                    $config['height']         = 420;
                    $config['width']          = 920;
                    $config['maintain_ratio'] = false;
                    $this->image_lib->initialize($config);
                    if ($this->image_lib->resize()) {
                        /**  Resize thumb **/
                        $config['image_library']  = 'gd2';
                        $config['source_image']   = 'assets/cms/' . $image;
                        $config['new_image']      = 'assets/cms/thumb/' . $image;
                        $config['create_thumb']   = true;
                        $config['maintain_ratio'] = true;
                        $config['width']          = $thumb_width;
                        $config['height']         = $thumb_height;
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();                        
                    }


                    $data1 = array(
                    'page_name'=>$page_name,
                    'contant'=> $this->input->post('content'),
                    'page_image_extension'=>$extension,
                    'status'=>1,
                    'page_create_time'=>date('Y-m-d h:i:s')
                    );
                   //print_r($data1); exit();
                  $id = $this->Common_model->add('tbl_cms',$data1);
                  $this->session->set_flashdata('message', "Page Insert successfully");
                  redirect('user/update_page/'.$id);


                 }else{
                $data['image_not_valid'] = $this->upload->display_errors(); 


                 }
            }

       }
}
 $this->load->view('user/add_page',$data);

     }


function update_page($id){
 $data = array();
    if ($this->input->post()) {
        $page_name = $this->input->post('page_name');
        $data['cms_page_update'] = $this->Common_model->select_one_row('tbl_cms', array('id' => $id));
        $extension = $data['cms_page_update']['page_image_extension'];
        $this->form_validation->set_rules('page_name', 'Page Name', 'trim|required');
        //$this->form_validation->set_rules('cms_img', 'Image', 'trim|required');
        $this->form_validation->set_rules('content', 'Content', 'trim|required');
            if ($this->form_validation->run() == FALSE) {


            }else{
         $this->load->library('upload');
            if (isset($_FILES['cms_img']) && $_FILES['cms_img']['size'] > 0) {
              

                 $image_info      = getimagesize($_FILES['cms_img']['tmp_name']);
                 $image_width     = $image_info[0];
                $image_height    = $image_info[1];
                $original_width  = $image_width;
                $original_height = $image_height;
                $new_width       = 640;
                $new_height      = 360;
                $thumb_width             = $new_width;
                $thumb_height            = $new_height;
                $array                   = explode('.', $_FILES['cms_img']['name']);
                $extension               = end($array);
                $file_name               = $page_name . "." . $extension;
                $config['upload_path']   = 'assets/cms';
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['overwrite'] = true;
                $config['file_name'] = $file_name;
                $this->upload->initialize($config);
                if ($this->upload->do_upload('cms_img')) {

                    $data['cms_page_update'] = $this->Common_model->select_one_row('tbl_cms', array('id' => $id));

                    $img_thumb = $this->config->item('cms_img_path').'thumb/'.$data['cms_page_update']['page_name'].'.'.$data['cms_page_update']['page_image_extension'];
                    $img = $this->config->item('cms_img_path').$data['cms_page_update']['page_name'].'.'.$data['cms_page_update']['page_image_extension'];
                    if(file_exists($img_thumb)){
                        unlink($img_thumb);
                    }

                    if(file_exists($img)){
                        unlink($img);
                    }


                   $upload_data_details = $this->upload->data();
                    $image    = $upload_data_details['file_name'];
                    $this->load->library('image_lib');
                    $config['source_image']   = 'assets/cms/' . $image;
                    $config['new_image']      = 'assets/cms/' . $image;
                    $config['height']         = 420;
                    $config['width']          = 920;
                    $config['maintain_ratio'] = false;
                    $this->image_lib->initialize($config);
                    if ($this->image_lib->resize()) {
                        /**  Resize thumb **/
                        $config['image_library']  = 'gd2';
                        $config['source_image']   = 'assets/cms/' . $image;
                        $config['new_image']      = 'assets/cms/thumb/' . $image;
                        $config['create_thumb']   = true;
                        $config['maintain_ratio'] = true;
                        $config['width']          = $thumb_width;
                        $config['height']         = $thumb_height;
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();                        
                    }


                 }
                 else{
                $data['image_not_valid'] = $this->upload->display_errors(); 


                 }

            }
                 $data1 = array(
                    'page_name'=>$page_name,
                    'contant'=> $this->input->post('content'),
                    'page_image_extension'=>$extension,
                    'status'=>1,
                    'page_create_time'=>date('Y-m-d h:i:s')
                    );
                 //print_r($data1); exit();
                  $this->Common_model->update('tbl_cms',array('id'=>$id),$data1);
                  $this->session->set_flashdata('message', "Page update successfully");
                  redirect('user/update_page/'.$id);



         }
    }

    //print_r($data['image_not_valid']);

    $data['page_data']= $this->Common_model->select_one_row("tbl_cms",array('id'=>$id));
    $this->load->view('user/update_page',$data);
      }



  function searchProduct(){
   $data = array();
   $data['product_name'] = $this->input->post('product_name');
   $data['subcat_id'] = $this->input->post('subcat_id');
   $data['cat_id'] = $this->input->post('cat_id');
   $data['search_product']= $this->user_model->search_product($data);
   //echo $this->db->last_query();
   $data['all_cat']     = $this->user_model->all_cat();
   $data['all_sub_cat'] = $this->user_model->all_sub_cat();
   print_r($data['subcat_id']);
   $this->load->view('user/search_product', $data);


  }
    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : basicPrice
     * @ Added Date               : 21-7-2017
     * @ Added By                 : Vishal Kumar Gupta
     * -----------------------------------------------------------------
     * @ Description              : Basic Price
     * -----------------------------------------------------------------
     * @ param                    :
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */


  function basicPrice($pr_id = NULL){
    $data = array();

    if($this->input->post()){
      $this->form_validation->set_rules('pr_name', 'Pr Name', 'trim|required');
      $this->form_validation->set_rules("qty[]", "Qty", "trim|required");
      $this->form_validation->set_rules("tax[]", "Tax", "trim|required");
      $this->form_validation->set_rules("rate[]", "Rate", "trim|required");
      $this->form_validation->set_rules("basicPrice[]", "Basic price", "trim|required");

        if ($this->form_validation->run() == FALSE)
            {

            }else{

              $pr_name = $this->input->post('pr_name',true);

              $qty = $this->input->post('qty[]',true);
              $tax = $this->input->post('tax[]',true);
              $rate = $this->input->post('rate[]',true);
              $basicPrice = $this->input->post('basicPrice[]',true);
              $pr_id = $this->input->post('pr_id',true);

              $data = array();

              $pr_item = array();

              $data = array(

                'pr_name' => $pr_name,
                'status' => '1',
                'id'=> $pr_id

                );


              $pr_id = $this->user_model->add_pr($data);

              $chk_old_pr_item = $this->user_model->chk_pr_item($pr_id);
              
              if($chk_old_pr_item > 0) {
              $del_old_pr_item = $this->user_model->del_old_pr_item($pr_id);

               }

             for($i=0;$i<count($tax);$i++){
              $pr_item['fk_pr_id'] = $pr_id;
              $pr_item['tax'] = $tax[$i];
              $pr_item['qty'] = $qty[$i];
              $pr_item['rate'] = $rate[$i];
              $pr_item['basic_total'] = $basicPrice[$i];

              $this->user_model->add_pr_item($pr_item);
            }

             redirect('');
           }

     }

      $customer_pr_product = array();


      if($pr_id > 0)
       {

       $cond = " AND tbl_pr.id ='".$pr_id."'";
       $select = "";
       $customer_pr = $this->user_model->fetch_pr($cond,$select);
       $prod_cond = "AND fk_pr_id='".$pr_id."'";
       $customer_pr_product = $this->user_model->fetch_pr_products($prod_cond);

       if(empty($customer_pr)){

         redirect('');

       }



       if(is_array($customer_pr) && count($customer_pr) && count($customer_pr_product) > 0){

         $data['customer_pr'] = $customer_pr[0];
         $data['customer_pr_product'] = $customer_pr_product;
       }
     }

    $this->load->view('user/addBasicPrice',$data);


  }


  public function addSupplier($sp_id = NULL){
    $data = array();

    if($this->input->post()){

      //print_r($this->input->post()); exit();
      $this->form_validation->set_rules('name','Name','trim|required');
      $this->form_validation->set_rules('phone','Phone','trim|required');
      $this->form_validation->set_rules('email','Email','trim|required');
      $this->form_validation->set_rules('name','Name','trim|required');
      if($this->form_validation->run() == FALSE){


          $this->load->view('user/addSupplier',$data);

      }else{

        $data['name']= $this->input->post('name');
        $data['phone']= $this->input->post('phone');
        $data['email']= $this->input->post('email');
        $data['address']= $this->input->post('address');
        $data['id'] = $this->input->post('supplier_id');
        $last_id = $this->user_model->add_supplier($data);
        redirect('user/addSupplier/'.$last_id);

      }


    }else{

      if($sp_id > 0){

        $data['sup_detail'] = $this->user_model->sup_detail($sp_id);
        if(empty($data['sup_detail'])){

          redirect('');

        }

      }

     $this->load->view('user/addSupplier',$data);

    }

    


  }






    //////////////////// End Class //////////////////////
}
