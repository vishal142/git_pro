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

<h1>Add Product !</h1>
	<div id="body">
<span style="color:red;"><?php echo validation_errors(); ?></span>

<?php if(isset($error_message) && $error_message!=''){?>
 <p style ="color:red;" class="dberror"><?php echo $error_message;?></p>
                  <?php }?>

                  
<?php $attributes = array('class' => 'email', 'id' => 'myform');
echo form_open_multipart('User/addproduct', $attributes); ?>
  
  <lable> Categoery Name</label> 
 <select name="cat_id" onchange="sub_cat();" id="cat_id">
 <option value="">Select Categoery Name </option>
 <?php foreach($all_cat as $cat){ ?>
 <option value="<?php echo $cat['id']?>"><?php echo $cat['cat_name']?></option>
 	<?php } ?>
 

 </select>

  <br>
  <lable> Sub Categoery Name</label> 
 <select name="sub_cat_id" id="sub_cat2">
 <option>Select Subcategoery</option>
 
</select>

  <br>

  <lable> Product Name</label> <input type="txt" name="product_name" placeholder="Product Name"><br>
  <lable> Product Price </label> <input type="txt" name="price" placeholder="Product Price"><br>
   <lable> Product Image </label> <input type="file" name="product_img"><br>

 <lable> Status</label> 
  <select name="status">
 <option value="">Select Status</option>
 <option value="1">Active</option>
 <option value="0">In-active</option>
 
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