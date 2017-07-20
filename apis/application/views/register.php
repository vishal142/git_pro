<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body { 
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<script src="<?php echo base_url();?>assets/admin/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/validationEngine.jquery.css" type="text/css"/>


<div id="container">
	<h1>I am New User !</h1>

				<div id="body">
				<span style="color:red;" class="msg_error1"><?php echo validation_errors(); ?></span>
				<?php $attributes = array('class' => 'email', 'id' => 'myform','name'=>'myform');
				echo form_open('', $attributes); ?>
				  <lable> User Name</label> <input type="text" id="username" name="username" placeholder="username" onblur="usernamechk(); return false;" class="validate[required]"><span id="msg_error" style="color:red;display: none;">Username Allredy Exits !!!</span><span id="validation_errors"></span> <br>
				  <lable> Email</label> <input type="email" name="email" id="email" onblur="emailchk(); return false;" placeholder="Email"><span id="email_error" style="color:red;display: none;">Email Allredy Exits !!!</span>
				  <span id="email_validate"></span> <br>
				  <lable> Password</label> <input type="password" name="password" id="password" placeholder="Password"><span id="validation_password1"></span><br>
				  <lable> Your Name </label> <input type="text" name="name" placeholder="Name"> <span id="name_errors">
				  </span><br>

				<!--<input type="button" name ="submit" value="Submit" onclick="form_submit();">-->
				<button type="button" name="" onclick="form_submit()">Submit</button>
				<!--<button type="button" name="" onclick="form_submit()">Submit</button>-->
				 <a href="<?php echo base_url();?>">Login</a>
				 <?php echo form_close(); ?>
							
					</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

<script>
function usernamechk(){
var username1 = $("#username").val();
var username = $.trim(username1);
//alert(username);
 $.ajax({
  	       type:"POST",
  	       url:"<?php echo base_url();?>Home/usernamechk",
  	       data:{username:username},
  	       success:function(msg){
               //alert(msg);
           if(msg>=1){
  	       $("#msg_error").show();
  	       $("#username").val('');
  	       $("#msg_error").fadeIn(1000) . fadeOut(3000);
  	       }else{
  	       	$("#msg_error").hide();

  	       }
  	      
  	       	}
  	       
  	});

}


function emailchk(){
var email1 = $("#email").val();
var email = $.trim(email1);
$.ajax({
  	       type:"POST",
  	       url:"<?php echo base_url();?>Home/emailchk",
  	       data:{email:email},
  	       success:function(msg){
            //alert(msg);
            if(msg==1){
           $("#validation_errors").hide();
  	       $("#email_error").show();
  	       $("#email").val('');
  	       $("#email_validate").hide();
  	       $("#email_error").fadeIn(1000) . fadeOut(3000);

  	       }else{
  	       	$("#msg_error").hide();

  	       	//$("#validation_errors").fadeIn(1000) . fadeOut(3000);
  	       	
  	       	

  	       }
  	      
  	       	}
  	       
  	});

}


function form_submit(){
var username = $("input[name='username']").val();
var email1 = $("input[name='email']").val();
var email = $.trim(email1);
var pass = $("input[name='password']").val();
var name = $("input[name='name']").val();
if(username.trim().length ==''){

$("#validation_errors").show();
$("#validation_errors").html('<span style="color:red;"><b>*Enter User Name</b></span>');
$("#validation_errors").fadeIn(1000) . fadeOut(3000);
return false;
} else if(email==''){
//$("#validation_errors").hide();
$("#email_validate").show();
$("#email_validate").html('<span style="color:red;"><b>*Enter Valid Email</b></span>');
$("#email_validate").fadeIn(1000) . fadeOut(3000);
return false;
}

else if(pass ==''){
//alert('Enter Your Password');
$("#validation_password1").show();
$("#validation_password1").html('<span style="color:red;"><b>*Enter Your Password</b></span>');
$("#validation_password1").fadeIn(1000) . fadeOut(3000);
return false;

}
else if(name.trim().length==''){
$("#name_errors").show();
$("#name_errors").html('<span style="color:red;"><b>*Enter Your Name</b></span>');
$("#name_errors").fadeIn(1000) . fadeOut(3000);
return false;

}else{

	//alert();

	$("#myform").submit();

}


}

</script>

</body>
</html>
