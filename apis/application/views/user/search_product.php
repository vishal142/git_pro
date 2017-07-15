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

<h1>Search Product !</h1>
	<div id="body">
<?php print_r($subcat_id); ?>
<table>
<h3>Search Product <h3>
<form action="<?php echo base_url();?>User/searchProduct" method="post">
<th><input type="text" name="product_name" placeholder="Enter Product Name"></th>  
<th><select name ="subcat_id">
<option value="">Subcategoery</option>
<?php foreach($all_sub_cat as $sub_ct){
  if($sub_ct['sub_id']== $subcat_id ){
    $selected ="selected='selected'";

  }else{
    $selected = "";

  }

   //$selected = $subcat_id == $sub_ct['sub_id']; ? 'selected' : '';
 ?>
<option value="<?php echo $sub_ct['sub_id']; ?>" <?php echo $selected;?>><?php echo $sub_ct['subcat_name']; ?></option>

<?php } ?>


 </select>
</th> 
<th>
<select name ="cat_id">
<option value="">Categoery</option>
<?php foreach($all_cat as $key=>$cat){ 
  if($cat['id'] == $cat_id ){
    $selected ="selected='selected'";

  }else{
    $selected = "";

  }
  ?>
<option value="<?php echo $cat['id']; ?>" <?php echo $selected;?>><?php echo $cat['cat_name']; ?></option>

<?php } ?>


 </select>
</th> 
<th><input type="submit" value="Sumit"> </form> </th>
</table>

<table>

<th>Categoery Name</th>
<th>Subcategoery Name</th>
<th>Product Name</th>
<th>Product Code </th>
<th>Product Price</th>
<th>Product Image </th>
<th>Action </th>

<?php
if(!empty($search_product)){
  foreach($search_product as $row):
///print_r($row);?>
  <tr>
<td> <?php echo $row['cat_id'];?> </td>
<td> <?php echo $row['subcat_id'];?> </td>
<td> <?php echo $row['product_name'];?></td>
<td> <?php echo $row['product_code'];?></td>
<td> <?php echo $row['price'];?></td>
<td> <?php echo $row['cat_id'];?> </td>
<td> Edit </td>
  </tr>
<?php endforeach;
 }else{ ?>
 <tr>
 <td colspan="6"><center>No Records Found.</center></td>
 </tr>

 <?php }?>



</table>


</div>

</body>
</html>