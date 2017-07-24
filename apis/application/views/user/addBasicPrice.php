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

<?php $attributes = array('class' => 'email', 'id' => 'myform');
echo form_open('user/basicPrice', $attributes); ?>


<div class ="parent_div">

<a href="javascript:void(0);" class="gray fl-right addRow"  data-structure="2">
<span class="plus-icon"><i class="fa fa-plus-circle"></i></span>Add item</a>
<br>

 <div class ="main_c">
 <input type="hidden" name="" class = "total_div" id="loop_div" value="">


 <div class="loop_div">
 <input type="text" id ="tax" name="tax[]" placeholder="Enter Tax Rate" onblur="get_total();">
 <input type="text" id = "qty" name="qty[]" placeholder="Enter qty" onblur="get_total();">
 <input type="text" id ="rate" name="rate[]" placeholder="Enter Product Rate" onblur="get_total();">
 <input type="text" id = "basicPrice" name="basicPrice[]" placeholder="Enter basicPrice"><br>
 </div>

  

 </div>

  <br>

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
        var index = $(this).parents('.parent_div').find('.main_c').length*1+1; // 
        //alert(index);

        var count_div = $.trim($(".total_div").val());

        

        $(this).parents('.parent_div').find('.main_c').append('<div class ="loop_div"><input type="text" id="tax_'+count_div+'" name="tax[]" placeholder="Enter Tax" onblur="add_more_get_total('+count_div+');"><input type="text" id="qty_'+count_div+'" name="qty[]" placeholder="Enter qty" onblur="add_more_get_total('+count_div+');"><input type="text" id="rate_'+count_div+'" name="rate[]" placeholder="Enter Product Rate" onblur="add_more_get_total('+count_div+');"><input type="text" id = "basicPrice_'+count_div+'" name="basicPrice[]" placeholder="Enter basicPrice"><br></div>');




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
  var count_div = elm;

  var tax = $("#tax_"+count_div).val();
  var qty = $("#qty_" + count_div).val();
  var rate = $("#rate_" + count_div ).val();
  
  var pro_t = qty*rate;
  var basic_val = parseFloat(pro_t).toFixed(2);
  var basic_tax = parseFloat(tax).toFixed(2);
  var basic_t = parseFloat(basic_val)+ parseFloat(basic_tax);
  var basic_total = parseFloat(basic_t).toFixed(2);
  $("#basicPrice_" + count_div).val(basic_total);
  //alert(basic_total);
  
  }

  





      </script>

</body>
</html>