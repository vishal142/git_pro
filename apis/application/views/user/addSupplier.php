<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

 <center>Welcome <?php echo adminName();?> </center>

<a href="<?php echo base_url();?>User/dashboard">Back </a> <br>
<a href="<?php echo base_url();?>User/logout"> Logout </a>

<div class="container">
  <h2><?php echo isset($sup_detail['id'])?'Update Suplier':'Add Supplier';?>
   </h2>

  <span style="color:red;"><?php echo validation_errors(); ?></span>
  <form action="<?php echo base_url();?>User/addSupplier" method="post" onSubmit ="return form_submit()">

  <div class="form-group">
      <label for="email">Name:</label>
      <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?php echo isset($sup_detail['name'])?$sup_detail['name']:''?>">
      <span id="error_name" style="color:red"></span>
    </div>

    <div class="form-group">
      <label for="email">Phone:</label>
      <input type="text" class="form-control" id="phone" placeholder="Enter phone number" name="phone" value="<?php echo isset($sup_detail['phone'])?$sup_detail['phone']:''?>">
      <span id="error_phone" style="color:red"></span>
    </div>

    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo isset($sup_detail['email'])?$sup_detail['email']:''?>">
      <span id="error_email" style="color:red"></span>
    </div>

    <div class="form-group">
      <label for="email">Address:</label>
      <input type="text" class="form-control" id="address" placeholder="Enter email" name="address" value="<?php echo isset($sup_detail['address'])?$sup_detail['address']:''?>">
      <span id="error_address" style="color:red"></span>
    </div>

    <input type="hidden" name="supplier_id" value="<?php echo isset($sup_detail['id'])?$sup_detail['id']:''?>">

    
    <input type="submit" class="btn btn-default" value="Submit" name="submit">
  </form>
</div>

<script>
  
  function form_submit(){
   
    var name = $.trim($("#name").val());
    var phone = $.trim($("#phone").val());
    var email = $.trim($("#email").val());
    var v_error = '1px solid #f32517';
    var v_ok        = '1px solid green';
    
    if(name ==''){

      $("#error_name").html('Enter Supplier Name').fadeIn(3000).fadeOut(5000);
      $("#name").css('border',v_error);
      return false;
      }else{
      $("#name").css('border',v_ok);
    }
    if(phone ==''){

    $("#error_phone").html('Enter Supplier Phone').fadeIn(3000).fadeOut(5000);
      $("#phone").css('border',v_error);
      return false;
      }else{
      $("#phone").css('border',v_ok);
    }
    if(email ==''){

    $("#error_email").html('Enter Supplier Phone').fadeIn(3000).fadeOut(5000);
      $("#email").css('border',v_error);
      return false;
      }else{
      $("#email").css('border',v_ok);
    }




  }

</script>

</body>
</html>