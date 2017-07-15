<html>
<title></title>
<head></head>
<body>

	<div>
		<center>Welcome <?php echo adminName();?> </center>
		<a href="<?php echo base_url();?>User/logout"> Logout </a>
	</div>

<a href="<?php echo base_url();?>User/dashboard">Back </a>

<h1>Update Sub Categoery !</h1>
<div id="body">
	<span style="color:red;"><?php echo validation_errors(); ?></span>
	<?php $attributes = array('class' => 'email', 'id' => 'myform');
	echo form_open('Category/updatesubcat/'.$sub_value[0]['id'], $attributes); ?>
	  
	 <lable> Categoery Name</label> 
		 <select name="cat_id">
		  <option value="">Select Categoery</option>
		 <?php foreach($all_cat as $cat){ 
		 if($sub_value[0]['cat_id'] ==$cat['id']){
		$selected = 'selected=selected';
		 }else{
		$selected = '';
		 }
		 	?>
		 <option value="<?php echo $cat['id'];?>" <?php echo $selected;?>><?php echo $cat['cat_name']?>
		 	
		 </option>
	<?php } ?>
		 

		 </select>

	  <br>
	  <lable> Sub Categoery Name</label> <input type="txt" name="subcatname" placeholder="Categoery name" value="<?php echo $sub_value[0]['subcat_name'];?>"><br>
	  <input type="submit" name ="submit" value="Submit">
	  
	 <?php echo form_close(); ?>




	</body>
</html>