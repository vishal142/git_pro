<html>
<title></title>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
</head>
<body>

<div >


<center>Welcome <?php echo adminName();?> </center>

<a href="<?php echo base_url();?>User/logout"> Logout </a>
	

</div>

<a href="<?php echo base_url();?>User/dashboard">Back </a>

<h1>Add Mutiple Price !</h1>

<?php $attributes = array('class' => 'email', 'id' => 'myform','onsubmit'=>'return form_validate()');
echo form_open('user/basicPrice', $attributes); ?>


<div class ="parent_div">

<?php //echo '<pre>';print_r($customer_pr); ?>
<?php //echo '<pre>';print_r($customer_pr_product); ?>

<a href="javascript:void(0);" class="gray fl-right addRow"  data-structure="1">
<span class="plus-icon"><i class="fa fa-plus-circle"></i></span>Add item</a> &nbsp;
&nbsp;&nbsp;

<a href="javascript:void(0);" id="remove_offr" class="gray fl-right revItem"  data-structure="2">
<span class="plus-icon"><i class="fa fa-plus-circle"></i></span>Remove item</a>


<br><br>

 <div class ="main_c">
 <input type="hidden" name="" class = "total_div" id="loop_div" value="">
  <div id="error_msg"></div>

  <span style="color:red;"><?php echo validation_errors(); ?></span>

  <input type="text" name="pr_name" id="pr_name" placeholder="Enter Pr Name " value="<?php echo isset($customer_pr['pr_name'])?$customer_pr['pr_name']:''?>"> <br><br>


  <?php 
   if(isset($customer_pr_product) && count($customer_pr_product) > 0){
    //$customer_pr_product = array();

    foreach($customer_pr_product as $key=> $row){?>

  <div class="loop_div">
   <input type="text" id ="tax_<?php echo $row['id'];?>" name="tax[]" placeholder="Enter Tax Rate" onblur="add_more_get_total(<?php echo $row['id'];?>);" onkeypress="return isNumberKey(event)" value="<?php echo isset($row['tax'])?$row['tax']:''?>">
   <input type="text" id = "qty_<?php echo $row['id'];?>" name="qty[]" placeholder="Enter qty" onblur="add_more_get_total(<?php echo $row['id'];?>);" onkeypress="return isNumberKey(event)" value="<?php echo isset($row['qty'])?$row['qty']:''?>">
   <input type="text" id ="rate_<?php echo $row['id'];?>" name="rate[]" placeholder="Enter Product Rate" onblur="add_more_get_total(<?php echo $row['id'];?>);" onkeypress="return isFloatNumberKey(event,this)" value="<?php echo isset($row['rate'])?$row['rate']:''?>">
   <input type="text" id = "basicPrice_<?php echo $row['id'];?>" name="basicPrice[]" placeholder="Enter basicPrice" value="<?php echo isset($row['basic_total'])?$row['basic_total']:''?>"><br>
  </div>

  <?php }
  }else{ ?>
 
 <div class="loop_div">
 <input type="text" id ="tax" name="tax[]" placeholder="Enter Tax Rate" onblur="get_total();" onkeypress="return isNumberKey(event)">
 <input type="text" id = "qty" name="qty[]" placeholder="Enter qty" onblur="get_total();" onkeypress="return isNumberKey(event)">
 <input type="text" id ="rate" name="rate[]" placeholder="Enter Product Rate" onblur="get_total();" onkeypress="return isFloatNumberKey(event,this)">
 <input type="text" id = "basicPrice" name="basicPrice[]" placeholder="Enter basicPrice"><br>
 </div>

  <?php } ?>

  

 </div>

  <br>

  <input type="hidden" name="pr_id" value="<?php echo isset($customer_pr['pr_name'])?$customer_pr['id']:''?>">

   <input type="submit" name ="submit" value="Submit">
 <?php echo form_close(); ?>



</div>

<script type="text/javascript">
    $(document).ready(function(){

      //var count_div = '1';
      //alert(count_div);

      

      $('.parent_div').on("click",".addRow",function(e){
        var total_loop_div = $(this).parents('.parent_div').find('.loop_div').length;
        $("#loop_div").val(total_loop_div+1);
        

        
        e.preventDefault();
        var index = $(this).parents('.parent_div').find('.main_c').length*1+1; 
        var count_div = $.trim($(".total_div").val());

       
        $(this).parents('.parent_div').find('.main_c').append('<div class ="loop_div"><div id ="remove_'+count_div+'"><input type="text" id="tax_'+count_div+'" name="tax[]" placeholder="Enter Tax" onblur="add_more_get_total('+count_div+');" onkeypress="return isNumberKey(event)"><input type="text" id="qty_'+count_div+'" name="qty[]" placeholder="Enter qty" onblur="add_more_get_total('+count_div+');" onkeypress="return isNumberKey(event)"><input type="text" id="rate_'+count_div+'" name="rate[]" placeholder="Enter Product Rate" onblur="add_more_get_total('+count_div+');" onkeypress="return isFloatNumberKey(event,this)"><input type="text" id = "basicPrice_'+count_div+'" name="basicPrice[]" placeholder="Enter basicPrice"><br></div></div>');




      });


  $('.parent_div').on("click",".revItem",function(e){
    e.preventDefault();

    //var index = $(this).parents('.parent_div').find('.loop_div').length*1;
    var index = $.trim($(".total_div").val());

    //alert(index);
    

    if($(this).data("structure")==2){

      if(index > 1){

        $("#remove_offr").show();

      }else{

        $("#remove_offr").hide();

        }


    }

   //$(this).parents(".parents_div").find(".loop_div").length>1 && $(this).parents(".parents_div").find(".loop_div").eq(index-1).remove();
   //$(this).parents(".main_c").find(".loop_div").eq(index-1).remove();
   alert(index);
   $("#remove_"+index).remove();
   $(this).parents(".loop_div").addClass("remove_"+index);
  

  });

 });

 function get_total(){

  var tax = $("#tax").val();
  var qty = $("#qty").val();
  var rate = $("#rate").val();

  var pro_t = qty*rate;
  var basic_val = parseFloat(pro_t).toFixed(2);
  var basic_tax = parseFloat(tax).toFixed(2);
  var basic_t = parseFloat(basic_val)+ parseFloat(basic_tax);
  var basic_total = parseFloat(basic_t).toFixed(2);
  $("#basicPrice").val(basic_total);
  //alert(basic_total);
  
  }

function add_more_get_total(elm){
  var v_error     = '1px solid #f32517';
  var v_ok        = '1px solid #b8bab8';


  var count_div = elm;

  var tax = $("#tax_"+count_div).val();
  var qty = $("#qty_" + count_div).val();
  var rate = $("#rate_" + count_div ).val();


   if($.trim(tax) ==''){
   $('#error_msg').html('Please enter tax').fadeIn(3000).fadeOut(5000);
   $('#tax_'+count_div).css('border', v_error);
   $('#tax_'+count_div).focus();
   return false;

  }

   if($.trim(qty) ==''){
   $('#error_msg').html('Please enter Quantity').fadeIn(3000).fadeOut(5000);
   $('#qty_'+count_div).css('border', v_error);
   $('#qty_'+count_div).focus();
   return false;

  }


   if($.trim(rate) ==''){
   $('#error_msg').html('Please enter rate').fadeIn(3000).fadeOut(5000);
   $('#rate_'+count_div).css('border', v_error);
   $('#rate_'+count_div).focus();
   return false;

    }

  
  var pro_t = qty*rate;
  var basic_val = parseFloat(pro_t).toFixed(2);
  var basic_tax = parseFloat(tax).toFixed(2);
  var basic_t = parseFloat(basic_val)+ parseFloat(basic_tax);
  var basic_total = parseFloat(basic_t).toFixed(2);
  $("#basicPrice_" + count_div).val(basic_total);
  //alert(basic_total);
  
  }

  function form_validate(){
  var v_error     = '1px solid #f32517';
  var v_ok        = '1px solid #b8bab8';
  var pr_name = $("#pr_name").val();
  var tax = $("#tax").val();
  var qty = $("#qty").val();
  var rate = $("#rate").val();
  if($.trim(pr_name) ==''){
   $('#error_msg').html('Please enter pr name').fadeIn(3000).fadeOut(5000);
   $('#pr_name').css('border', v_error);
   $('#pr_name').focus();
   return false;
  }else{
    $('#pr_name').css('border', '');
  }
  if($.trim(tax) ==''){
   $('#error_msg').html('Please enter tax').fadeIn(3000).fadeOut(5000);
   $('#tax').css('border', v_error);
   $('#tax').focus();
   return false;
  }else{
      $('#tax').css('border', '');
  }
  if($.trim(qty) ==''){
    $('#error_msg').html('Please enter Quantity').fadeIn(3000).fadeOut(5000);
    $('#qty').css('border', v_error);
    $('#qty').focus();
    return false;
  }else{
    $('#qty').css('border', '');
  }
    if($.trim(rate) ==''){
    $('#error_msg').html('Please enter rate').fadeIn(3000).fadeOut(5000);
    $('#rate').css('border', v_error);
    $('#rate').focus();
    return false;
  }else{
    $('#rate').css('border', '');
  }
 }

  



    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
            return true;
    }

  function isFloatNumberKey(evt,obj)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        var value = obj.value;
        var dotcontains = value.indexOf(".") != -1;
        if (dotcontains)
            if (charCode == 46) return false;
            if (charCode == 46) return true;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
    }



      </script>

</body>
</html>