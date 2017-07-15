<html>
<title></title>
<head>
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
</head>
<body>

<div >


<center>Welcome <?php echo adminName();?> </center>

<a href="<?php echo base_url();?>User/logout"> Logout </a>
	

</div>

<a href="<?php echo base_url();?>User/dashboard">Back </a>

<h1>Update Cms Page !</h1>
	<div id="body">
<span style="color:red;"><?php echo validation_errors(); ?></span>
<p id="error_msg" style="color:red;"></p>
<?php if($this->session->flashdata('message')!=''){?>
    <span style="color:green;"><?php echo $this->session->flashdata('message')?></span>
      <?php
      }?>


<?php $attributes = array('class' => 'email', 'id' => 'myform');
echo form_open_multipart('', $attributes); ?>

<label>Page Name</label> <input type="text" name="page_name" value="<?php echo $page_data['page_name'];?>"><br>

<label>Change Page Banner</label><input type="file" name="cms_img" onchange="loadFile(event)" required="true"><br>
<label>Page Image</label>
<?php if($page_data['page_image_extension']) { ?>

          <?php $rand =  rand() ;?>
          <img id="image" src="<?php echo base_url();?>assets/cms/thumb/<?php echo $page_data['page_name'].'.'.$page_data['page_image_extension']?>?img=<?php echo $rand; ?>">
          <?php }else { ?>

<img id ="image" src=""> 
<?php } ?> <br>
  
  <lable> Page Description </label> <textarea id="content" name="content" rows="10"><?php echo $page_data['contant'];?></textarea><br>
  
  <button type="button" name="" onclick="validateContent()">Update Page</button>
   
  
 <?php echo form_close(); ?>
<br>
<br>
<br>
<br>
<br>
<br>
<br>




<script>
function validateContent(){
 var page_name = $("input[name='page_name']").val();
 var cms_img = $("input[name='cms_img'").val();
 //alert(cms_img);
 //var content = $("input[name='content']").val();
 var content ='content';
 var content_2_data = CKEDITOR.instances[content].getData();

 if(content_2_data ==""){
  $("#error_msg").text("Please enter page content").fadeIn(1000).fadeOut(1000);
  $("html,body").animate({scrollTop:100},500);
  return false;
}else if(page_name==""){
    $("#error_msg").text("Enter Page Name").fadeIn(1000).fadeOut(1000);
    $("html,body").animate({scrollTop:100},500);
}else{
	$("#myform").submit();
}
 
	}

$(document).ready(function(){

     CKEDITOR.replace('content',{
      allowedContent : true,
      
    toolbar :
    [
      { name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat' ] },
      { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote' ] },
      { name: 'tools', items : [ 'Maximize','-','About' ] },
      { name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','Scayt' ] },
      { name: 'styles', items : [ 'Styles','Format' ] },
       { name: 'insert', items : [ 'Source' ] },
    ],
    uiColor : '#9AB8F3'
      });
   });

var loadFile = function(event) {
      var reader = new FileReader();
        reader.onload = function(){
          var output = document.getElementById('image');

    output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
</script>

</body>
</html>