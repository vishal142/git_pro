<?php
/* * ******************************************************************
 * Common model 
  ---------------------------------------------------------------------
 * @ Added by                 : Saswata Pal 
 * @ Framework                : CodeIgniter
 * @ Added Date               : 07-01-2016
  ---------------------------------------------------------------------
 * @ Details                  : It Cotains all the common query related method
  ---------------------------------------------------------------------
 ***********************************************************************/
class Common_model extends CI_Model
{  
    function __construct()
    {
        //load the parent constructor
        parent::__construct();
    }
    
    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : select
     * @ Added Date               : 07-01-2016
     * @ Added By                 : Saswata Pal
     * -----------------------------------------------------------------
     * @ Description              : all select
     * -----------------------------------------------------------------
     * @ param                    : array(param)
     * @ return                   : int()
     * -----------------------------------------------------------------
     * 
     */
    public function select($table = '', $where = array(), $select = '', $join = array(), $page = 0, $page_size = 0, $order_by='', $order=''){  
        if(empty($select)){
            $this->db->select('*');
        }else{
            $this->db->select($select);
        }
        if(!empty($join)){
            foreach($join['table'] as $key => $j){
                $this->db->join($join['table'][$key], $join['on'][$key], $join['type'][$key]);
            }
        }
        if(!empty($where)){
            $this->db->where($where);
        }
        if(!empty($page) && !empty($page_size)){
            $limit = $page_size;
            $offset = $limit*($page-1);
            $this->db->limit($limit, $offset);
        }
        if($order_by && $order){
            $this->db->order_by($order_by, $order);
        }
        $result = $this->db->get($table)->result_array();
        //echo $this->db->last_query(); exit;
        return $result;
    }


    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : select_one_row
     * @ Added Date               : 07-01-2016
     * @ Added By                 : Saswata Pal
     * -----------------------------------------------------------------
     * @ Description              : select one row
     * -----------------------------------------------------------------
     * @ param                    : array(param)
     * @ return                   : int()
     * -----------------------------------------------------------------
     * 
     */
    public function select_one_row($table = '', $where = array(), $select = '', $join = array()){  
        if(empty($select)){
            $this->db->select('*');
        }else{
            $this->db->select($select);
        }
        if(!empty($join)){
            foreach($join['table'] as $key => $j){
                $this->db->join($join['table'][$key], $join['on'][$key], $join['type'][$key]);
            }
        }
        if(!empty($where)){
            $this->db->where($where);
        }
        $result = $this->db->get($table)->row_array();
        //echo $this->db->last_query();
        return $result;
    }

    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : add
     * @ Added Date               : 07-01-2016
     * @ Added By                 : Saswata Pal
     * -----------------------------------------------------------------
     * @ Description              : add
     * -----------------------------------------------------------------
     * @ param                    : array(param)
     * @ return                   : int()
     * -----------------------------------------------------------------
     * 
     */
    public function add($table = '', $param = array()){  
        $this->db->insert($table, $param);
        $insert_id = $this->db->insert_id(); 
        return $insert_id;
    }
    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : update
     * @ Added Date               : 07-01-2016
     * @ Added By                 : Saswata Pal
     * -----------------------------------------------------------------
     * @ Description              : update
     * -----------------------------------------------------------------
     * @ param                    : array(param)
     * @ return                   : int()
     * -----------------------------------------------------------------
     * 
     */
    public function update($table = '', $where = array(), $param = array()){  
        
        $this->db->where($where);
        $this->db->update($table, $param);
        $affected_rows = $this->db->affected_rows(); 
        return $affected_rows;
    }

    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : delete
     * @ Added Date               : 07-01-2015
     * @ Added By                 : Saswata Pal
     * -----------------------------------------------------------------
     * @ Description              : delete
     * -----------------------------------------------------------------
     * @ param                    : array(param)
     * @ return                   : int()
     * -----------------------------------------------------------------
     * 
     */
    public function delete($table = '', $where = array()){  
        $this->db->where($where);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }
    
    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : count
     * @ Added Date               : 07-01-2016
     * @ Added By                 : Saswata Pal
     * -----------------------------------------------------------------
     * @ Description              : count
     * -----------------------------------------------------------------
     * @ param                    : array(param)
     * @ return                   : int()
     * -----------------------------------------------------------------
     * 
     */
    public function count($table = '', $where = array()){  
        if(!empty($where)){
            $this->db->where($where);
        }
        $result = $this->db->count_all_results($table);
        return $result;
    }

    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : send_email
     * @ Added Date               : 07-01-2016
     * @ Added By                 : Saswata Pal
     * -----------------------------------------------------------------
     * @ Description              : common send email method
     * -----------------------------------------------------------------
     * @ param                    : array(param)
     * @ return                   : int()
     * -----------------------------------------------------------------
     * 
     */
    public function send_email($to, $from, $cc_mail="", $subject = '', $param = array(), $template){
        //$this->email->clear();
       // echo $this->config->item('admin_email').'-'.$this->config->item('site_title')
        $config['protocol']        = 'sendmail';
        $config['mailpath']        = '/usr/sbin/sendmail';
        $config['charset']         = 'utf-8';
        $config['wordwrap']        = TRUE;
        $config['mailtype']        = 'html';
        $this->email->initialize($config); 

        $this->email->from($from, $this->config->item('site_title'));
        $this->email->to($to);
        if($cc_mail)
        {
            $this->email->cc($cc_mail);
        }
        $this->email->subject($subject);
       
        $email_body = $this->load->view('email_templates/'.$template,$param,TRUE);
        $this->email->message($email_body);
        $status = $this->email->send();
        
        //echo $this->email->print_debugger(); exit;
        return $status; 
    }    


    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : uploadImage
     * @ Added Date               : 07-01-2016
     * @ Added By                 : Saswata Pal
     * -----------------------------------------------------------------
     * @ Description              : upload image
     * -----------------------------------------------------------------
     * @ param                    : array(param)
     * @ return                   : int()
     * -----------------------------------------------------------------
     * 
     */
    public function uploadImage($fileparam = array()){ 
        if(!empty($fileparam['files'])){   
            $config['upload_path'] = $fileparam['upload_path'];
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            if($fileparam['upload_type']=='single'){
                $files = $fileparam['files'];
                //upload images start here
                $path = $files[$fileparam['field_name']]['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $filename = rand().time();
                $config['file_name'] = $filename.'.'.$ext; 
                $this->load->library('upload', $config);    
                $this->upload->initialize($config);  
                $this->upload->do_upload($fileparam['field_name']);
                $dataIMG = array();
                $dataIMG = $this->upload->data();
                if(!empty($fileparam['thumb_image_width'])){                
                    //upload thum image
                    $this->load->library('image_lib');
                    foreach($fileparam['thumb_image_width'] as $key=>$t){
                        //this is the larger image
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $dataIMG['full_path'];
                        $config['maintain_ratio'] = false;
                        $config['width'] = $fileparam['thumb_image_width'][$key];
                        $config['height'] = $fileparam['thumb_image_height'][$key];         
                        $config['new_image'] = $config['upload_path']. $config['width']."X".$config['height']."_".$dataIMG['orig_name'];
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                        $this->image_lib->clear();
                    }
                    
                }
            }else if($fileparam['upload_type']=='multiple'){                
                $_FILES = reArrayFiles($fileparam['files'][$fileparam['field_name']]);
                if(!empty($_FILES)){
                    foreach($_FILES as $k=>$files){
                        $path = $files['name'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $filename = rand().time();
                        $config['file_name'] = $filename.".".$ext; 
                        $this->load->library('upload', $config); 
                        $this->upload->initialize($config);  
                        $this->upload->do_upload($k);
                        $dataIMG = array();
                        $dataIMG = $this->upload->data();

                        if(!empty($fileparam['thumb_image_width'])){                
                            //upload thum image
                            $this->load->library('image_lib');
                            foreach($fileparam['thumb_image_width'] as $key=>$t){
                                //this is the larger image
                                $config['image_library'] = 'gd2';
                                $config['source_image'] = $dataIMG['full_path'];
                                $config['maintain_ratio'] = false;
                                $config['width'] = $fileparam['thumb_image_width'][$key];
                                $config['height'] = $fileparam['thumb_image_height'][$key];         
                                $config['new_image'] = $config['upload_path']. $config['width']."X".$config['height']."_".$dataIMG['orig_name'];
                                $this->image_lib->initialize($config);
                                $this->image_lib->resize();
                                $this->image_lib->clear();
                            }
                            
                        }
                    }
                }                
                
            }             
            if($fileparam['upload_type']=='single'){
                return $config['file_name'];
            }
        }     
    }

    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : save_base64_image
     * @ Added Date               : 07-01-2016
     * @ Added By                 : Saswata Pal
     * -----------------------------------------------------------------
     * @ Description              : save base64 image
     * -----------------------------------------------------------------
     * @ param                    : array(param)
     * @ return                   : int()
     * -----------------------------------------------------------------
     * 
     */
    public function save_base64_image($fileparam){ 
        //echo '<pre>'; print_r($fileparam); exec(command)
        if(!empty($fileparam)){   
            $temp_path_directory = "./../assets/uploads/";
            $data2 = base64_decode($fileparam['files']);
            $temp_file_name = rand().time().'.png';
            $temp_path = $temp_path_directory.$temp_file_name;            
            $filename = $fileparam['image_id'].'.'.'png';
            $uploaded = file_put_contents($temp_path, $data2);
            $orig_img_path = $fileparam['upload_path'].$fileparam['image_id'].'.'.'png';
            //echo $orig_img_path; exit;
            try{
                $response = $this->aws->uploadfile($this->aws->bucket,$orig_img_path,$temp_path,'public-read');                     
            } catch(S3Exception $e) {
                die("there was an error uploading that file");
            }
            if(!empty($fileparam['thumb_image_width'])){ 
                foreach($fileparam['thumb_image_width'] as $key=>$t){
                    
                    $width = $fileparam['thumb_image_width'][$key];
                    $height = $fileparam['thumb_image_height'][$key];
                    $thumb_img_path = $fileparam['upload_path'].$width . "X" . $height . "_" .$fileparam['image_id'].'.'.'png';
                    $temp_thumb_path = $temp_path_directory.$width . "X" . $height . "_" .$temp_file_name; 
                    createThumb($temp_path, $temp_thumb_path, $width, $height);
                    try{
                        $response = $this->aws->uploadfile($this->aws->bucket,$thumb_img_path,$temp_thumb_path,'public-read');                     
                    } catch(S3Exception $e) {
                        die("there was an error uploading that file");
                    }
                    unlink($temp_thumb_path);  
                }
                
            }           
            unlink($temp_path);  
        }     
    }

    public function fetch_expire_token()
    {   $this->db->where('expires <',date('Y-m-d H:i:s'));
        $this->db->delete('oauth_access_tokens');
        return $this->db->affected_rows();
    }

    /*ADMIN
     * --------------------------------------------------------------------------
     * @ Function Name            : getLastID()
     * @ Added Date               : 05-09-2016
     * @ Added By                 : Piyalee
     * -----------------------------------------------------------------
     * @ Description              : This function is fetch last id of table
     * -----------------------------------------------------------------
     * @ param                    : Array(params)    
     * @ return                   : review list array
     * -----------------------------------------------------------------
     * 
    */
    function getLastID($table = '')
    {
        $this->db->select('id');
        $this->db->order_by('id','DESC');
        $qry = $this->db->get($table);
        return $qry->row_array();
    }


    /*********************************
     * End of common model
     **********************************/
}