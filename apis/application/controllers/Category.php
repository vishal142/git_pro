<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL);
class Category extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('Common_model');
        $this->load->model('Category_model');
        $this->load->helper('Common_helper');
        check_user_loggedin();
    }
    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : addcat
     * @ Added Date               : 13-04-2017
     * @ Added By                 : Vishal Kumar Gupta
     * -----------------------------------------------------------------
     * @ Description              : Categoery Add
     * -----------------------------------------------------------------
     * @ param                    :
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */
    function addcat()
    {
        $data = array();
        if ($this->input->post()) {
            $this->form_validation->set_rules('catname', 'Categoery Name', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
            } else {
                $data = array(
                    'cat_name' => $this->input->post("catname")
                );
                //$this->db->insert("category",$data);
                $add  = $this->Category_model->addCategory('category', $data);
                $this->session->set_flashdata('sucess', 'sucess_insert');
                redirect('User/dashboard');
            }
        }
        $this->load->view('user/addcat', $data);
    }
    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : updatecat
     * @ Added Date               : 13-04-2017
     * @ Added By                 : Vishal Kumar Gupta
     * -----------------------------------------------------------------
     * @ Description              : Update the categoery 
     * -----------------------------------------------------------------
     * @ param                    :
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */
    function updatecat($id)
    {
        $data = array();
        if ($this->input->post()) {
            $this->form_validation->set_rules('catname', 'Categoery Name', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
               
            } else {
                $data = array(
                    'cat_name' => $this->input->post("catname")
                );
                //$this->db->where('id',$id);
                //$this->db->update("category",$data);
                $this->Common_model->update('category', array(
                    'id' => $id
                ), $data);
                $this->session->set_flashdata('sucess', 'sucess_update');
                redirect('User/dashboard');
            }
        }
        $data['update_cat'] = $this->user_model->update_cat($id);
        //print_r($data['update_cat']);
        $this->load->view('user/updatecat', $data);
    }
    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : addsubcat
     * @ Added Date               : 13-04-2017
     * @ Added By                 : Vishal Kumar Gupta
     * -----------------------------------------------------------------
     * @ Description              : Sub categoery  Add
     * -----------------------------------------------------------------
     * @ param                    :
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */
    function addsubcat()
    {
        $data = array();
        if ($this->input->post()) {
            $this->form_validation->set_rules('cat_id', 'Categoery Name', 'trim|required');
            $this->form_validation->set_rules('catname', 'Sub categoery Name', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
            } else {
                $data = array(
                    'cat_id' => $this->input->post("cat_id"),
                    'subcat_name' => $this->input->post("catname")
                );
                //$this->db->insert('tbl_sub_category',$data);
                $this->Common_model->add('tbl_sub_category', $data);
                $this->session->set_flashdata('sucess', 'sucess_insert');
                redirect('User/dashboard');
            }
        }
        $data['all_cat'] = $this->user_model->all_cat();
        $this->load->view('user/addsubcat', $data);
    }
    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : edit_subcat
     * @ Added Date               : 13-04-2017
     * @ Added By                 : Vishal Kumar Gupta
     * -----------------------------------------------------------------
     * @ Description              : Load the view of edit subcateroey 
     * -----------------------------------------------------------------
     * @ param                    :
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */
    function edit_subcat($id)
    {
        $data['all_cat']   = $this->user_model->all_cat();
        $data['sub_value'] = $this->user_model->edit_subcat($id);
        //print_r($data['sub_value']);
        $this->load->view('user/edit_subcat', $data);
    }
    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : updatesubcat
     * @ Added Date               : 13-04-2017
     * @ Added By                 : Vishal Kumar Gupta
     * -----------------------------------------------------------------
     * @ Description              : Sub categoery  Update
     * -----------------------------------------------------------------
     * @ param                    :
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */
    function updatesubcat($id)
    {
        $data = array();
        if ($this->input->post()) {
            $this->form_validation->set_rules('subcatname', 'Sub Categoery Name', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
            } else {

                
                $data1 = array(
                    'cat_id' => $this->input->post("cat_id"),
                    'subcat_name' => $this->input->post("subcatname")
                );
                $this->Common_model->update('tbl_sub_category', array(
                    'id' => $id
                ), $data1);
                $this->session->set_flashdata('sucess', 'sucess_update');
                redirect('User/dashboard');
            }
        }
        $data['all_cat']   = $this->user_model->all_cat();
        $data['sub_value'] = $this->user_model->edit_subcat($id);
        $this->load->view('user/edit_subcat', $data);
    }
    function deletecat($id)
    {
        $this->Common_model->delete('category', array(
            'id' => $id
        ));
        $this->Common_model->delete('tbl_sub_category', array(
            'cat_id' => $id
        ));
        $this->Common_model->delete('tbl_products', array(
            'cat_id' => $id
        ));
        $this->session->set_flashdata('sucess', 'sucess_delete');
        redirect('User/dashboard');
    }
    function deletesubcat($id)
    {
        $this->Common_model->delete('tbl_sub_category', array(
            'id' => $id
        ));
        $this->Common_model->delete('tbl_products', array(
            'subcat_id' => $id
        ));
        $this->session->set_flashdata('sucess', 'sucess_delete');
        redirect('User/dashboard');
    }
    //////////////////// End Class //////////////////////
}
