<?php 
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(E_ALL);
require_once 'src/OAuth2/Autoloader.php';
/**
 * @SWG\Info(
 *   title="My First API",
 *   description="My First API",
 *   version="1.0.0"
 *
 * )
 * @SWG\Swagger(
 *   host="localhost/",
 *   basePath="Demo_ci/apis",
 *   schemes={"http"},
 *   produces={"application/json"},
 *   consumes={"application/json"}
 * )

 * @SWG\Swagger(
 *     @SWG\SecurityScheme(
 *         securityDefinition="oauth2", type="oauth2", description="OAuth2 Implicit Grant", flow="accessCode",
 *         in="header",
 *         name="Authorization",
 *         tokenUrl="http://localhost/Demo_ci/apis/api_1_0_0/Test_user/token",
 *         scopes={"scope": "Description of scope."}
 *     )
 * ),
 *  @SWG\Definition(
definition="ApiResponseFormatDataset",
 *   type="object",
 *   description="API Response Format",
 *   allOf={
 *     @SWG\Schema(
@SWG\Property(property="dataset", format="array", type="object"),
@SWG\Property(property="status", format="array", type="object", @SWG\Property(property="action_status", format="string", type="string", description="For SUCCESS response, it is TRUE; For ERROR response, it is FALSE"),@SWG\Property(property="msg", format="string", type="string", description="Success/Error Message")),
@SWG\Property(property="publish", format="array", type="object", @SWG\Property(property="version", format="string", type="string", description="API Version"),@SWG\Property(property="developer", format="string", type="string", description="API Developer")),

 *       )
 *   }
 * ),

@SWG\Definition(
definition="ApiResponseFormat",
 *   type="object",
 *   description="API Response Format",
 *   allOf={
 *     @SWG\Schema(
@SWG\Property(property="status", format="array", type="object",
@SWG\Property(property="action_status", format="string", type="string", description="For SUCCESS response, it is TRUE; For ERROR response, it is FALSE"),
@SWG\Property(property="msg", format="string", type="string", description="Success/Error Message")),
@SWG\Property(property="publish", format="array", type="object",
@SWG\Property(property="version", format="string", type="string", description="API Version"),
@SWG\Property(property="developer", format="string", type="string", description="API Developer")),
 *       )
 *   },
),

 */

//All the required library file for API has been included here

require APPPATH . 'libraries/REST_Controller.php';
class Test_user extends REST_Controller
{


public function __construct()
    {
        parent::__construct();
        //echo "Here"; exit();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: authorization, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header('Access-Control-Allow-Credentials: true');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method == "OPTIONS") {
            die();
        }

        $this->load->config('rest');
        $this->load->config('tables');
        
        $developer      = 'www.massoftind.com';
        $this->app_path = "api_" . $this->config->item('test_api_ver');
        //publish app version
        $version       = str_replace('_', '.', $this->config->item('test_api_ver'));
        $this->publish = array(
            'version'   => $version,
            'developer' => $developer,
        );

         $this->load->model('api_' . $this->config->item('test_api_ver') . '/User_model', 'user');

        $this->load->model('common_model', 'common');
        $this->tables = $this->config->item('tables');
        $this->load->helper('Common_helper');

    
        $dsn = 'mysql:dbname=' . $this->config->item('oauth_db_database') . ';host=' . $this->config->item('oauth_db_host');
        //print_r($dsn);exit();

        $dbusername = $this->config->item('oauth_db_username');
        $dbpassword = $this->config->item('oauth_db_password');

        OAuth2\Autoloader::register();


        $storage = new OAuth2\Storage\Pdo(array(
            'dsn' => $dsn,
            'username' => $dbusername,
            'password' => $dbpassword
            ));

       $this->oauth_server = new OAuth2\Server($storage);
       // Add the "Authorization Code" grant type (this is where the oauth magic happens)
       $this->oauth_server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
       // Add the "Authorization Code" grant type (this is where the oauth magic happens)
        $this->oauth_server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

        
    }

 /**
     *
     * @SWG\Post(
     *      path="/api_1_0_0/Test_user/category_list",
     *      summary="Categoery listing",
     *      tags={"Product Version 1: Everything about Category"},
     *      description="Listing of the Categoery",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          in="header",
     *          description="oAuth2.0 Acess token",
     *          required=true,
     *          type="string",
     *      ),
    *    @SWG\Parameter(
    *      name="page_no",
    *      in="formData",
    *      description="Page No",
    *      required=false,
    *      type="string",
    *     ),
    *    @SWG\Parameter(
    *      name="page_size",
    *      in="formData",
    *      description="Page Size",
    *      required=false,
    *      type="string",
    *     ), 
    *    @SWG\Parameter(
    *      name="filter",
    *      in="formData",
    *      description="filter by categoery Name",
    *      required=false,
    *      type="string",
    *     ),
    *    @SWG\Parameter(
    *      name="search",
    *      in="formData",
    *      description="search by categoery Name",
    *      required=false,
    *      type="string",
    *     ),   

     *      @SWG\Response(response="200",description="For SUCCESS Response ACTION_STATUS is true, for ERROR response ACTION_STATUS is false",@SWG\Schema(ref="#/definitions/ApiResponseFormatDataset")
    ),

     * )
     */


    public function category_list_post()
    {
        //echo "Here"; exit();
        $response      = array();
        $error_message = $success_message = "";
        
        if (!$this->oauth_server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
            $error_message = 'Invalid token';
            $http_response = 'http_response_unauthorized';
        } else{
            $flag = true;
            $data = array();

            $data['page_no'] = $this->post('page_no');
            $data['page_size'] = $this->post('page_size');
            $data['filter'] = $this->post('filter');
            $data['search'] = $this->post('search');
           
                if($flag){
                $data = $this->user->all_cat($data);
                if (!empty($data)) {
                    $response['dataset'] = $data;
                    $success_message     = 'Result fetch successfully';
                    $http_response       = 'http_response_ok';
                } else {
                    $response['dataset'] = array();
                    $success_message     = 'No Record';
                    $http_response       = 'http_response_ok';
                }
            } else {
                $http_response = 'http_response_bad_request'; //Invalid
            }
       }
          
        if ($error_message != '') {
            $response['error_message'] = $error_message;
        } else {
            $response['success_message'] = $success_message;
        }
    
     //echo $error_message; exit();
    //echo '<pre>';print_r($response).'</pre>'; exit();
        $response['publish'] = $this->publish;
        $this->response(array(
            'response' => $response,
        ), $this->config->item($http_response));
    }


/**
     *
     * @SWG\Post(
     *      path="/api_1_0_0/Test_user/add_category",
     *      summary="Add New Categoery",
     *      tags={"Product Version 1: Everything about Category"},
     *      description="Add New Categoery",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          in="header",
     *          description="oAuth2.0 Acess token",
     *          required=true,
     *          type="string",
     *      ),
    *    @SWG\Parameter(
    *      name="category_name",
    *      in="formData",
    *      description="Category Name",
    *      required=true,
    *      type="string",
    *     ),

     *      @SWG\Response(response="200",description="For SUCCESS Response ACTION_STATUS is true, for ERROR response ACTION_STATUS is false",@SWG\Schema(ref="#/definitions/ApiResponseFormatDataset")
    ),

     * )
     */



function add_category_post(){

    $response = array();
    $error_message = $success_message = "";

    if(!$this->oauth_server->verifyResourceRequest(OAuth2\Request::createFromGlobals())){
        $error_message ='Invalid token';
        $http_response = 'http_response_unauthorized';


    }else{
        $flag = true;
        $data = array();

        if(!$this->post('category_name')){
            $flag = false;
           $error_message = 'Category Name Required';

        }else{
            $data['category_name'] = $this->post('category_name');
        }

    if($flag){

        $tables = 'category';
        $param = array(
        'cat_name'=> $data['category_name']
            );
        $this->user->add_category($tables,$param);
        $response['dataset']  = $data;
        $success_message = 'Category add successfully';
        $http_response = 'http_response_ok';


    }else{
        $http_response = 'http_response_bad_request'; //Invalid
    }

}

    if($error_message !=''){

        $response['error_message']=$error_message;
    }else{

        $response['success_message']=$success_message;
    }

    $response['publish']= $this->publish;
    $this->response(array('response'=>$response),$this->config->item($http_response));

    }

/**
     *
     * @SWG\Post(
     *      path="/api_1_0_0/Test_user/update_category",
     *      summary="Update Categoery",
     *      tags={"Product Version 1: Everything about Category"},
     *      description="Update Categoery",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          in="header",
     *          description="oAuth2.0 Acess token",
     *          required=true,
     *          type="string",
     *      ),
     
    *  @SWG\Parameter(
    *      name="categotry_id",
    *      in="formData",
    *      description="Category id",
    *      required=true,
    *      type="string",
    *     ),
     

    *    @SWG\Parameter(
    *      name="category_name",
    *      in="formData",
    *      description="Category Name",
    *      required=true,
    *      type="string",
    *     ),

     *      @SWG\Response(response="200",description="For SUCCESS Response ACTION_STATUS is true, for ERROR response ACTION_STATUS is false",@SWG\Schema(ref="#/definitions/ApiResponseFormatDataset")
    ),

     * )
     */

function update_category_post(){

    $response = array();
    $error_message = $success_message ="";

    if(!$this->oauth_server->verifyResourceRequest(OAuth2\Request::createFromGlobals())){
     $error_message = 'Invalid token';
     $http_response = 'http_response_unauthorized';

    }else{

        $flag = true;
        $data = array();

        if(!$this->post('categotry_id',true)){
            $flag = false;
            $error_message = 'Category ID Required';
        }else{
            $data['categoery_id'] = $this->post('categotry_id',true);
        }
        if(!$this->post('category_name',true)){
            $flag = false;
            $error_message = 'Category Name Required';

        }else{
            $data['category_name'] = $this->post('category_name');
        }

        if($flag){
        $tables = 'category';
        $cat_id = $this->user->chk_categoery($tables,$data['categoery_id']);
        $categoery_id = $data['categoery_id'];
        if($cat_id > 0){
        $tables = 'category';
         $param = array(
       'cat_name'=> $data['category_name']
            );
        $this->common->update($tables,array('id'=>$categoery_id),$param);
          

        $response['dataset'] = array();
        $success_message = 'Category update successfully';
        $http_response = 'http_response_ok';

        }else{
        
        $response['dataset'] = array();
        $success_message = 'Category Not Found';
        $http_response = 'http_response_ok';

        }

       }else{
            $http_response = 'http_response_bad_request'; // Invaild
        }
 }

 if($error_message!=''){
  
   $response['error_message'] = $error_message;

 }else{
    $response['success_message'] = $success_message;
 }
 //print_r($response); exit();

 $response['publish'] = $this->publish;
 $this->response(array('response'=>$response),$this->config->item($http_response));
 //$this->response(array('response'=>$response),$this->config->item($http_response));

}


/**
     *
     * @SWG\Delete(
     *      path="/api_1_0_0/Test_user/delete_category/3",
     *      summary="Delete Categoery",
     *      tags={"Product Version 1: Everything about Category"},
     *      description="Delete Categoery",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          in="header",
     *          description="oAuth2.0 Acess token",
     *          required=true,
     *          type="string",
     *      ),
    *      @SWG\Response(response="200",description="For SUCCESS Response ACTION_STATUS is true, for ERROR response ACTION_STATUS is false",@SWG\Schema(ref="#/definitions/ApiResponseFormatDataset")
    ),

     * )
     */


function delete_category_delete($id){
    $response = array();
    $error_message = $success_message = '';

    if(!$this->oauth_server->verifyResourceRequest(OAuth2\Request::createFromGlobals())){
        $error_message = 'Invalid token';
        $http_response = 'http_response_unauthorized';

    }else{

         //echo $id; exit();

        $flag = true;
        $data = array();

        if(!$id){

            $flag = false;
            $error_message = 'Category ID Required';
        }else{
            $data['categoery_id'] = $id;
        }

        if($flag){
          $category = 'category';
          $subcategory = 'tbl_sub_category';
          $product = 'tbl_products';
          $cat_id = $this->user->chk_categoery($category,$data['categoery_id']);
          if($cat_id > 0){

            $cat_id = array('id'=>$id);
            $cat_id1 = array('cat_id'=>$id);
            $cat_id2 = array('cat_id'=>$id);

            $this->common->delete($category,$cat_id);
            $this->common->delete($subcategory,$cat_id1);
            $this->common->delete($product,$cat_id2);
            $response['dataset'] = array();
            $error_message = 'Category Delete';
            $http_response = 'http_response_ok';

          }else{
            $response['dataset'] = array();
            $error_message = 'Category Not Found';
            $http_response = 'http_response_ok';
          }

          

        }else{

         $http_response = 'http_response_bad_request';
        }

    }

    if($error_message !=''){

        $response['error_message'] = $error_message;
    }else{
     $response['success_message'] = $success_message;
    }

    $response['publish'] = $this->publish;
    $this->response(array('response'=>$response),$this->config->item($http_response));

}



/**
     *
     * @SWG\Post(
     *      path="/api_1_0_0/Test_user/sub_category",
     *      summary="Listing of the all Subcategory",
     *      tags={"Product Version 1: Everything about Subcategory"},
     *      description="Listing of the all Subcategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          in="header",
     *          description="oAuth2.0 Acess token",
     *          required=true,
     *          type="string",
     *      ),
     *      @SWG\Response(response="200",description="For SUCCESS Response ACTION_STATUS is true, for ERROR response ACTION_STATUS is false",@SWG\Schema(ref="#/definitions/ApiResponseFormatDataset")
    ),

     * )
     */






 function sub_category_post(){
  $response=array();
  $error_message = $success_message= "";

  if (!$this->oauth_server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
    $error_message='Invalid token';
    $http_response = 'http_response_unauthorized';

  }else{ 
    $flag=true;
    $data=array();
    if($flag){

    $data = $this->user->all_sub_cat();
  
    if(!empty($data)){
    $response['dataset'] = $data;
    $success_message = 'Result fetch successfully';
    $http_response = 'http_response_ok';

    }else{
    $response['dataset']= $data;
    $success_message = 'No Record Found';
    $http_response = 'http_response_ok';
    }

}else{
    $http_response = 'http_response_bad_requestd';

}


  }

  if ($error_message!= ''){
    $response['error_message'] = $error_message;
  }else{
    $response['success_message'] = $success_message;
  }

  $response['publish'] = $this->publish;

  $this->response(array('response'=>$response),$this->config->item($http_response));

   
 }


/**
     *
     * @SWG\Post(
     *      path="/api_1_0_0/Test_user/add_subcategory",
     *      summary="Add Sub Category",
     *      tags={"Product Version 1: Everything about Subcategory"},
     *      description="Add Sub category",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          in="header",
     *          description="oAuth2.0 Acess token",
     *          required=true,
     *          type="string",
     *      ),
     
    *  @SWG\Parameter(
    *      name="cat_id",
    *      in="formData",
    *      description="Category id",
    *      required=true,
    *      type="string",
    *     ),
     

    *    @SWG\Parameter(
    *      name="subcategory",
    *      in="formData",
    *      description="Subcategory Name",
    *      required=true,
    *      type="string",
    *     ),

     *      @SWG\Response(response="200",description="For SUCCESS Response ACTION_STATUS is true, for ERROR response ACTION_STATUS is false",@SWG\Schema(ref="#/definitions/ApiResponseFormatDataset")
    ),

     * )
     */

 function add_subcategory_post(){
    $response = array();
    $error_message = $success_message = "";

    if(!$this->oauth_server->verifyResourceRequest(OAuth2\Request::createFromGlobals())){
        $error_message = 'Invalid token';
        $http_response = 'http_response_unauthorized';
      }else{
   //print_r($this->post('subcategory',true)); exit();
        $flag = true;
        $data= array();
       
        if(!$this->post('subcategory',true)){
            $flag = false;
            $error_message = 'Sub category Name Required';
        }else{
            $data['subcategory'] = $this->post('subcategory',true);
        }
        if(!$this->post('cat_id',true)){
            $flag = false;
            $error_message = 'Category id Required';
        }else{
            $data['cat_id'] = $this->post('cat_id',true);
        }

        //print_r($data); 

        if($flag){

        $tbl_sub_category = 'tbl_sub_category';
        $sub_cat_name = $this->user->fetch_subcate($tbl_sub_category,$data['subcategory']);
        $cat_id = $this->user->chk_categoery($tbl_sub_category,$data['cat_id']);
        if($sub_cat_name > 0){
          $response['dataset'] = array();
          $error_message = 'Subcategoery Name allredy exists.';
          $http_response = 'http_response_ok';


        }else{

            if($cat_id > 0){
      

             $param = array(
             'cat_id' => $data['cat_id'],
             'subcat_name' => $data['subcategory']
                );

            //print_r($param); exit();

         $this->common->add($tbl_sub_category,$param);
         $response['dataset'] = array();
         $success_message = 'Subcategoery Add Successfully';
         $http_response = 'http_response_ok';

            }else{
               
          $response['dataset'] = array();
          $error_message = 'Category ID not found.';
          $http_response = 'http_response_ok';
      }
        }

    }else{
        $http_response = 'http_response_bad_requestd';
    }



    }

    if($error_message!=''){

        $response['error_message'] = $error_message;
    }else{
        $response['success_message']= $success_message;
    }

    $response['publish']= $this->publish;

    //$this->response(array('response'=>$response),$this->config->item($http_response));
    $this->response(array('response'=>$response),$this->config->item($http_response));
 }


/**
     *
     * @SWG\Post(
     *      path="/api_1_0_0/Test_user/update_sub_product",
     *      summary="Update Sub Category",
     *      tags={"Product Version 1: Everything about Subcategory"},
     *      description="Update Sub category",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          in="header",
     *          description="oAuth2.0 Acess token",
     *          required=true,
     *          type="string",
     *      ),
     
    *  @SWG\Parameter(
    *      name="cat_id",
    *      in="formData",
    *      description="Category id",
    *      required=true,
    *      type="string",
    *     ),
    *  @SWG\Parameter(
    *      name="subcat_id",
    *      in="formData",
    *      description="Subcategory id",
    *      required=true,
    *      type="string",
    *     ),
     

    *    @SWG\Parameter(
    *      name="subcategory",
    *      in="formData",
    *      description="Subcategory Name",
    *      required=true,
    *      type="string",
    *     ),

     *      @SWG\Response(response="200",description="For SUCCESS Response ACTION_STATUS is true, for ERROR response ACTION_STATUS is false",@SWG\Schema(ref="#/definitions/ApiResponseFormatDataset")
    ),

     * )
     */

 function update_sub_product_post(){
 $response = array();
 $error_message = $success_message = "";

 if(!$this->oauth_server->verifyResourceRequest(OAuth2\Request::createFromGlobals())){

    $error_message = 'Invalid token';
    $http_response = 'http_response_unauthorized';

 }else{
     $flag = true;
     $data = array();

     if(!$this->post('subcategory',true)){
        $flag = false;
       $error_message = 'Sub category Name Required';
     }else{
       $data['subcategory'] = $this->post('subcategory',true);
     }

     if(!$this->post('cat_id',true)){
            $flag = false;
            $error_message = 'Category id Required';
        }else{
            $data['cat_id'] = $this->post('cat_id',true);
    }

    if(!$this->post('subcat_id',true)){
            $flag = false;
            $error_message = 'Sub category id Required';
        }else{
            $data['subcat_id'] = $this->post('subcat_id',true);
    }

    if($flag){

        $tbl_sub_category = 'tbl_sub_category';
        $sub_cat_name = $this->user->fetch_subcate($tbl_sub_category,$data['subcategory']);
        //$sub_cat_name = $this->user->check_sub_cat($tbl_sub_category,$data['subcat_id']);
        $cat_id = $this->user->chk_categoery($tbl_sub_category,$data['cat_id']);



        if($cat_id > 0){

            $up = array(
             'cat_id'=> $data['cat_id'],
             'subcat_name'=> $data['subcategory']
                );

        $this->common->update($tbl_sub_category,array('id'=>$data['subcat_id']),$up);
          $response['dataset'] = array();
          $success_message = 'Subcategoery Updated Successfully.';
          $http_response = 'http_response_ok';


        }else{
          $response['dataset'] = array();
          $error_message = 'Category ID not found.';
          $http_response = 'http_response_ok';

        }




    }else{
        $http_response = 'http_response_bad_requestd';

    }




 }

 if($error_message!=''){
    $response['error_message']= $error_message;
 }else{
    $response['success_message']=$success_message;
 }

 $response['publish']= $this->publish;
 $this->response(array('response'=>$response),$this->config->item($http_response));

 }


/**
     *
     * @SWG\Post(
     *      path="/api_1_0_0/Test_user/all_product",
     *      summary="Product listing",
     *      tags={"Product Version 1: Everything about Product"},
     *      description="Listing of the Product",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          in="header",
     *          description="oAuth2.0 Acess token",
     *          required=true,
     *          type="string",
     *      ),

    *    @SWG\Parameter(
    *      name="page_no",
    *      in="formData",
    *      description="Page Number",
    *      required=false,
    *      type="string",
    *     ),
    *    @SWG\Parameter(
    *      name="page_size",
    *      in="formData",
    *      description="Page Size",
    *      required=false,
    *      type="string",
    *     ),
    *    @SWG\Parameter(
    *      name="filter",
    *      in="formData",
    *      description="Filter by Price",
    *      required=false,
    *      type="string",
    *     ),
    *    @SWG\Parameter(
    *      name="search",
    *      in="formData",
    *      description="Search by Prdct,Subcat,Cat name",
    *      required=false,
    *      type="string",
    *     ),



     *      @SWG\Response(response="200",description="For SUCCESS Response ACTION_STATUS is true, for ERROR response ACTION_STATUS is false",@SWG\Schema(ref="#/definitions/ApiResponseFormatDataset")
    ),

     * )
     */

function all_product_post(){
    $response = array();
    $error_message = $success_message ="";
    if (!$this->oauth_server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
      $error_message = 'Invalid token';
      $http_response = 'http_response_unauthorized';

  }else{

    $flag = true;
    $dataset = array();
    $param = array();
    $param['page_no'] = $this->post('page_no');
    $param['page_size'] = $this->post('page_size');
    $param['filter'] = $this->post('filter');
    $param['search'] = $this->post('search');



    if($flag){
           $data = $this->user->all_pro($param);
           if(!empty($data)){
            $response['dataset'] = $data;
            $success_message = 'Result fetch successfully';
            $http_response = 'http_response_ok';


           }else{
            $response['dataset'] = $dataset;
            $error_message = 'No Record Found';
            $http_response = 'http_response_ok';

           }



    } else{
        $http_response = 'http_response_bad_request'; // Invalid User
    }


  }

  if($error_message !=''){
   $response['error_message'] = $error_message;
  }else{
    $response['success_message'] = $success_message;
  }

  $response['publish'] = $this->publish;

  $this->response(array('response'=>$response),$this->config->item($http_response));

}

function addproduct_post(){
    $response = array();
    $error_message = $success_message = "";

    if(!$this->oauth_server->verifyResourceRequest(OAuth2\Request::createFromGlobals())){
        $error_message ='Invalid token';
        $http_response = 'http_response_unauthorized';


    }else{
        $flag = true;
        $data = array();
        $param = array();

      if(!$this->post('cat_id',true)){
        $flag = false;
        $error_message = 'Categoery filed is required';

       }else{

        $param['cat_id'] = $this->post('cat_id',true);

       }

       if(!$this->post('sub_cat_id',true)){

         $flag = false;
         $error_message = 'Sub Cat id is required';


       }else{
        $param['sub_cat_id'] = $this->post('sub_cat_id',true);
       }

       if(!$this->post('product_name',true)){
        $flag = false;
        $error_message = 'Product name is required';

       }else{

        $param['product_name'] = $this->post('product_name',true);


       }

       if(!$this->post('product_price',true)){
        $flag = false;
        $error_message = 'Product price is required';

       }else{

        $param['product_price'] = $this->post('product_price',true);
       }

     
       if(!$this->post('product_status',true)){
        $flag = false;
        $error_message = 'Product Status is required';

       }else{

        $param['product_status'] = $this->post('product_status',true);
       }

       //$param['product_img'] = array();

       $array = explode('.', $_FILES['product_img']['name']);
       $extension = end($array);

       if(!$extension){
        $flag = false;
        $error_message = 'Product Image is required';

       }else{

        $param['product_img'] = $_FILES['product_img']['name'];
       }

       print_r($param['product_img']);die;


    //$param['cat_id'] = '';
    $cat_table = 'category';
    $where = array('id'=> $param['cat_id']);
    $select = 'cat_name';
    $da_cat = $this->common->select_one_row($cat_table,$where,$select);

    $sub_cat = $this->common->select_one_row('tbl_sub_category',array('id'=>$param['sub_cat_id']),'subcat_name');

   if($flag){
    if($da_cat['cat_name'] !=''){

        if($sub_cat !=''){





        $response['dataset']  = '';
        $success_message = 'Product add successfully';
        $http_response = 'http_response_ok';

         }else{
            $error_message = 'Subcategoery id not found';
         }

       }else{
        $error_message = 'Category id not found';
    }


    }else{
        $http_response = 'http_response_bad_request'; //Invalid
    }

}

    if($error_message !=''){

        $response['error_message']=$error_message;
    }else{

        $response['success_message']=$success_message;
    }

    $response['publish']= $this->publish;
    $this->response(array('response'=>$response),$this->config->item($http_response));

}

function all_cms_post(){
    $response = array();
    $error_message = $success_message ="";

 if (!$this->oauth_server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
    $error_message = 'Invalid token';
    $http_response = 'http_response_unauthorized';

 }else{

    $flag = true;
    $data = array();

    if($flag){

       $cmc_list = $this->user->all_cms() ;
       
      
       if(!empty($cmc_list)){
      

       
       foreach ($cmc_list as $key => $value) {

        $cmc_list[$key]['cms_image'] = base_url().'assets/cms/'.$value['page_name'].'.'.$value['page_image_extension'];

         
       }
       $response['dataset']=$cmc_list;
        $success_message = 'Record fetch successfully';
        $http_response = 'http_response_ok';

       } else{
        $response['dataset'] = $data;
        $success_message  =  'No Record Found';
        $http_response = 'http_response_ok';
       }

    }else{
        $http_response = 'http_response_bad_request';
    }

 }

 if($error_message !=''){
    $response['error_message'] = $error_message;
  } else{
    $response['success_message'] = $success_message;
  }

 $response['publish'] = $this->publish;
 //$this->response(array('response'=$response),$this->config->item($http_response));
 $this->response(array('response'=>$response),$this->config->item($http_response));



}


/**
     *
     * @SWG\Post(
     *      path="/api_1_0_0/Test_user/token",
     *      summary="Generate Token",
     *      tags={"Get Token"},
     *      description="Generate New Token",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *     @SWG\Parameter(
     *          name="grant_type",
     *          in="formData",
     *          description="grant_type",
     *          required=true,
     *          type="string"
     *      ),
    @SWG\Parameter(
     *          name="client_id",
     *          in="formData",
     *          description="client_id",
     *          required=true,
     *          type="string"
     *      ),
    @SWG\Parameter(
     *          name="client_secret",
     *          in="formData",
     *          description="client_secret",
     *          required=true,
     *          type="string"
     *      ),
     *       @SWG\Response(
    response="200",description="For SUCCESS Response ACTION_STATUS is true, for ERROR response ACTION_STATUS is false",@SWG\Schema(ref="#/definitions/ApiResponseFormatDataset"
    )
    ),
     * )
     */

function token_post(){

 $this->oauth_server->handleTokenRequest(OAuth2\Request::createFromGlobals())->send();
 
}




}

