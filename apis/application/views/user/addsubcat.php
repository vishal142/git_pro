<html>
<title></title>
<head></head>
<body>

<div >


<center>Welcome <?php echo adminName();?> </center>

<a href="<?php echo base_url();?>User/logout"> Logout </a>
	

</div>

<a href="<?php echo base_url();?>User/dashboard">Back </a>

<h1>Add Sub Categoery !</h1>
	<div id="body">
<span style="color:red;"><?php echo validation_errors(); ?></span>
<?php $attributes = array('class' => 'email', 'id' => 'myform');
echo form_open('Category/addsubcat', $attributes); ?>
  
  <lable> Categoery Name</label> 
 <select name="cat_id">
 <option value="">Select Categoery</option>
 <?php foreach($all_cat as $cat){ ?>
 <option value="<?php echo $cat['id']?>"><?php echo $cat['cat_name']?></option>
 	<?php } ?>
 

 </select>

  <br>
  <lable> Sub Categoery Name</label> <input type="txt" name="catname" placeholder="Categoery name"><br>
  <input type="submit" name ="submit" value="Submit">
  
 <?php echo form_close(); ?>




</body>
</html>