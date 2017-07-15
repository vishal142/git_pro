<html>
<title></title>
<head></head>


<script src="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<body>

<script>
$(document).ready(function() {
    $('table.display').DataTable();
</script>

<div>


<center>Welcome <?php echo adminName();?> </center>

<a href="<?php echo base_url();?>User/logout"> Logout </a>
	

</div>
<?php if ($this->session->flashdata('sucess') == 'sucess_insert'): ?>
                    <div style="color:green;">
                        <?php echo "<p>Sucessfully Categoery Add.</p>"; ?>
                    </div> 
                <?php endif; ?>


<?php if ($this->session->flashdata('sucess') == 'product_insert'): ?>
                    <div style="color:green;">
                        <?php echo "<p>Sucessfully Product Add.</p>"; ?>
                    </div> 
                <?php endif; ?>



<?php if ($this->session->flashdata('sucess') == 'sucess_update'): ?>
                    <div style="color:green;">
                        <?php echo "<p>Sucessfully Update.</p>"; ?>
                    </div> 
                <?php endif; ?>

<?php if ($this->session->flashdata('sucess') == 'sucess_delete'): ?>
                    <div style="color:green;">
                        <?php echo "<p>Sucessfully Delete.</p>"; ?>
                    </div> 
                <?php endif; ?>

                

<a href="<?php echo base_url();?>Category/addcat">Add Categoery </a>
<?php //print_r($all_cat);?>
<table>
<th>Categoery Name</th>	
<th>Action</th>	

<tr>
<?php foreach($all_cat as $key=>$cat){
	//print_r($cat);?>
<td> <?php echo $cat['cat_name'];?></td>
<td><a href="<?php echo base_url();?>Category/updatecat/<?php echo $cat['id'];?>">Edit</a>&nbsp;&nbsp;
<a href="<?php echo base_url();?>Category/deletecat/<?php echo $cat['id'];?>" onclick="return confirm('Do you want to delete?')" title="Delete">Delete</a>
</td>
</tr>
<?php } ?>

</table>

<br><br><br>
<a href="<?php echo base_url();?>Category/addsubcat">Add Subcategoery </a>
<table>
<th>Categoery Name</th>	
<th>Sub Categoery Name</th>	
<th>Total Product </th>
<th>Action </th>	
<tr>
<?php foreach($all_sub_cat as $sub_ct){
 //print_r($sub_ct);?>
<td> <?php echo $sub_ct['cat_name'];?></td>
<td> <?php echo $sub_ct['subcat_name'];?></td>
<td><?php echo all_product(array('sub_cat_id'=>$sub_ct['sub_id']));?></td>
<td><a href="<?php echo base_url();?>Category/edit_subcat/<?php echo $sub_ct['sub_id'];?>">Edit</a> &nbsp;&nbsp;<a href="<?php echo base_url();?>Category/deletesubcat/<?php echo $sub_ct['sub_id'];?>" onclick="return confirm('Do you want to delete?')" title="Delete">Delete</a></td>
</tr>
<?php } ?>

</table>



<br><br><br>
<a href="<?php echo base_url();?>User/addproduct">Add Product </a>
<table id="myTable" class="display">
<th>Categoery Name</th>	
<th>Sub Categoery Name</th>	
<th>Product Name</th>
<th>Product Code</th>	
<th>Product Price</th>
<th>Product Image</th>
<th>Action </th>	
<tr>
<?php foreach($all_pro as $pro){
 //print_r($pro);?>
<td> <?php echo $pro['cat_name'];?></td>
<td> <?php echo $pro['subcat_name'];?></td>
<td> <?php echo $pro['product_name'];?></td>
<td> <?php echo $pro['product_code'];?></td>
<td> <?php echo $pro['price'];?></td>
<td>
 <?php 
   if(!empty($pro['img_ext'])){
  $img =  base_url().'assets/product_img/'.$pro['product_id'].'.'.$pro['img_ext'];
    }else{
      $img =base_url().'assets/product_img/no_image/no_image.jpg';

      }?> 

<img src="<?php echo $img;?>" height="60" width="60">  

</td>
<td><a href="<?php echo base_url();?>User/edit_product/<?php echo $pro['product_id'];?>">Edit</a>
&nbsp;&nbsp;<a href="<?php echo base_url();?>User/deleteproduct/<?php echo $pro['product_id'];?>" onclick="return confirm('Do you want to delete?')" title="Delete">Delete</a>
</td>
</tr>
<?php } ?>
<tr>
  <td colspan="7"> <center>
  <?php //echo $this->pagination->create_links();
   echo $links; ?></center>
   </td>

</tr>



</table>

<br><br>
<a href="<?php echo base_url();?>User/addPage">Add Cms Page </a>

<table>
<th>Page Name</th>
<th>Status</th>
<th>Create Date</th>
<th>Image</th>
<th>Action</th>


<?php foreach($all_cms as $row):
//print_r($row); ?>
<tr>
<td><?php echo $row['page_name'];?></td>
<td><?php echo $row['status'];?></td>
<td><?php echo date('d-M-y H:i:s',strtotime($row['page_create_time']));?></td>
<td>
<?php
$img =base_url().'assets/cms/thumb/'.$row['page_name'].'.'.$row['page_image_extension']; ?>
<img src="<?php echo $img;?>" height="30" weight="30">
</td>
<td><a href="<?php echo base_url();?>User/update_page/<?php echo $row['id'];?>">Edit</a></td>
</tr>
<?php endforeach;?>

</table>

<br>
<br>
<br>
<a href="<?php echo base_url();?>User/searchProduct">Search The Product </a>





</body>
</html>