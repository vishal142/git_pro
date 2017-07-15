<html>
<title></title>
<head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

</head>
<body>

<div>


<center>Welcome <?php echo adminName();?> </center>

<a href="<?php echo base_url();?>User/logout"> Logout </a>
	

</div>

<a href="<?php echo base_url();?>User/dashboard">Back </a>

<h1>Update Categoery !</h1>
	<div id="body">
<span style="color:red;"><?php echo validation_errors(); ?></span>
<?php $attributes = array('class' => 'email', 'id' => 'myform');
echo form_open('Category/updatecat/'.$update_cat[0]['id'], $attributes); ?>
  
  <lable> Categoery Name</label> <input type="txt" name="catname" placeholder="Categoery name" value="<?php echo $update_cat[0]['cat_name'];?>" onblur="check_cat()" ><span id="error_msg" style="color: red"></span><br>
  <!--<input type="submit" name ="submit" value="Submit">-->
  <button type="button" name="" onclick="form_submit()">Submit</button>
  
 <?php echo form_close(); ?>


<script>

function check_cat(){
 var catname = $("input[name='catname']").val();

 $.ajax({
  	       type:"POST",
  	       url:"<?php echo base_url();?>User/check_cat",
  	       data:{catname:catname},
  	       success:function(msg){
           //alert(msg);
          if(msg == 1){
          $("input[name='catname']").val('');
  	      $("#error_msg").html(" Categoery Name Alredy Exists").fadeIn(1000).fadeOut(1000);
  	      } 
  	      
  	       	}
  	       
  	});
 
}
	
function form_submit(){
 var catname = $("input[name='catname']").val();
  if(catname ==""){
 $("#error_msg").html("Categoery is required").fadeIn(1000).fadeOut(1000);

 }else{
 	$("#myform").submit();

 }
 

}
</script>

</body>
</html>