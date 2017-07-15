<html>
<title></title>
<head></head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<body>

<div >


<center>Welcome <?php echo adminName();?> </center>

<a href="<?php echo base_url();?>User/logout"> Logout </a>
	

</div>

<a href="<?php echo base_url();?>User/dashboard">Back </a>

<h1>Edit Product !</h1>
	<div id="body">
<span style="color:red;"><?php echo validation_errors(); ?></span>

<?php if(isset($error_message) && $error_message!=''){?>
 <p style ="color:red;" class="dberror"><?php echo $error_message;?></p>
                  <?php }?>
<?php //print_r($product_value[0]); ?>
<?php $attributes = array('class' => 'email', 'id' => 'myform');
echo form_open_multipart('User/edit_product/'.$product_value[0]['p_id'], $attributes); ?>
  
  <lable> Categoery Name</label> 
 <select name="cat_id" onchange="sub_cat();" id="cat_id">
 <option value="">Select Categoery Name </option>
 <?php foreach($all_cat as $cat){
 if($product_value[0]['cat_id'] ==$cat['id']){
$selected = 'selected=selected';
 }else{
$selected = '';
 }
  ?>
 <option value="<?php echo $cat['id']?>" <?php echo $selected;?> ><?php echo $cat['cat_name']?></option>
 	<?php } ?>
 

 </select>

  <br>
  <lable> Sub Categoery Name</label> 
 <select name="sub_cat_id" id="sub_cat2">
 <option value="<?php echo $product_value[0]['subcat_id'];?>"><?php echo $product_value[0]['subcat_name'];?></option>
 
</select>

  <br>

  <lable> Product Name</label> <input type="txt" name="product_name" placeholder="Product Name" value="<?php echo $product_value[0]['product_name'];?>"><br>
  <lable> Product Price </label> <input type="txt" name="price" placeholder="Product Price" value="<?php echo $product_value[0]['price'];?>"><br>
   <?php 
   if(!empty($product_image[0]['img_ext'])){
  $img =  base_url().'assets/product_img/'.$product_value[0]['p_id'].'.'.$product_image[0]['img_ext'];
    }else{
      $img =base_url().'assets/product_img/no_image/no_image.jpg';

      }?>
   <lable> Product Image </label>  <img src="<?php echo $img;?>" height="100" width="200"><br>

   <lable> Change Image </label> <input type="file" name="product_img"><br>

 <lable> Status</label> 
  <select name="status">
 <option value="">Select Status</option>
 <option value="1" <?php if($product_value[0]['status']==1){echo "selected=selected";}?>>Active</option>
 <option value="0" <?php if($product_value[0]['status']==0){echo "selected=selected";}?>>In-active</option>
 
</select> <br>
  <input type="submit" name ="submit" value="Submit">
  
 <?php echo form_close(); ?>

<script>
function sub_cat(){
 var cat_id = $("#cat_id").val();
$.ajax({
  	       type:"POST",
  	       url:"<?php echo base_url();?>User/get_all_sub_cat",
  	       data:{cat_id:cat_id},
  	       success:function(msg){
            //alert(msg);
          
  	       $("#sub_cat2").html(msg);
  	       
  	      
  	       	}
  	       
  	});

}
</script>

</body>
</html>