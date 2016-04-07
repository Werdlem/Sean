<?php

include 'search.php';

require_once('DAL/PDOConnection.php');

$productDal = new products();


$sku = $_GET['sku'];
//$sku_id = $_GET['sku_id'];
	
$sku = $productDal->GetProducts($sku);
	foreach($sku as $productDetail){
		
?>

<div class="panel panel-primary" style="width:49%; float:left">
  <div class="panel-heading" style="text-align:center;">
    <h3>Product Details</h3>
  </div>
  <div class="panel-body">
    <form method="post" action="?action=action&updates">
      <div>
        <label for="sku">Product</label>
        <input id="sku" name="sku" type="text" class="form-control" value="<?php echo $productDetail['sku']; ?>"/>
        <input id="sku_id" name="sku_id" type="hidden" value="<?php echo $productDetail['sku_id']; ?> "
        <span id="notesInfo"></span> </div>
      <div>
        <label for="description">Description</label>
        <textarea id="description" name="description" type="text" class="form-control" rows="1"><?php echo  str_replace('<br />','',$productDetail['description']); ?></textarea>
      </div>
      <div style="width:50%; float: left;">
        <label for="alias_1">Alias 1</label>
        <input id="alias_1" name="alias_1" type="text" class="form-control"  value="<?php echo $productDetail['alias_1']; ?>"/>
      </div>
      <div style="width:50%; margin-left:200px">
        <label for="alias_2">Alias 2</label>
        <input id="alias_2" name="alias_2" type="text" class="form-control" value="<?php echo $productDetail['alias_2'];?>" />
      </div>
      <div style="width:50%;">
        <label for="alias_3">Alias 3</label>
        <input id="alias_3" name="alias_3" type="text" class="form-control" value="<?php echo $productDetail['alias_3'];?>" />
      </div>
      <div>
        <label for="last_ordered">Last Ordered</label>
        <input id="last_ordered" name="last_ordered" type="text" class="form-control" readonly="readonly" style="width: 40%" value="<?php echo $productDetail['last_order_date']; ?>"/>
      </div>
      <div style="width:50%; float: left;">
        <label for="buffer_qty">Buffer Qty</label>
        <input id="buffer_qty" name="buffer_qty" type="text" class="form-control"  value="<?php echo $productDetail['buffer_qty']; ?>"/>
      </div>
      <div style="width:50%; margin-left:200px">
        <label for="stock_qty">Total Stock</label>
        <input id="stock_qty" name="stock_qty" type="text" class="form-control" value="<?php echo $productDetail['stock_qty'];?>" />
      </div>
      <div style="width:50%; float: left;">
        <label for="allocation_id">Allocation</label>
        <?php $product = $productDal->Get_Allocation();
	  $dropdown = "<select style='width:90%' name='allocation_id' id='allocation_id' onchange='select()'>";
	  			$dropdown.="\r\n<option value='{$productDetail['allocation_id']}'>{$productDetail['name']}</option>";
				$dropdown.="\r\n<option value='0'>None</option>";
	  foreach ($product as $result){
		  $dropdown .="\r\n<option value='{$result['allocation_id']}'>{$result['name']}</option>";
		  }
		  $dropdown .="\r\n</select>";
		  echo $dropdown;
	   ?>
        <script>
       function select(){
		   var x = document.getElementById("allocation_id").value;
		   
		   }
       </script> 
      </div>
      <div style="width:50%; margin-left:200px">
        <label for="supplier_name">Supplier</label>
        <input id="supplier_name" name="supplier_name" type="text" class="form-control" value="<?php echo $productDetail['supplier_name']; ?>"/>
      </div>
      <div>
        <label for="notes">Notes</label>
        <textarea id="notes" name="notes" type="text" class="form-control" rows="4"><?php echo str_replace('<br />',"", $productDetail['notes']); ?></textarea>
      </div>
      <br/>
      <button id="updates" class="btn btn-large btn-primary" name="updates" type="submit">Update</button>
      <a href="?action=test_send&sku=<?php echo $productDetail['sku'];?>&id=<?php echo $productDetail['sku_id'];?>" class="btn btn-large btn-primary">Order</a>
    </form>
  </div>
  <?php }?>
</div>
<?php
include 'modules/location_list.php';
include 'modules/update_location.php';
include 'modules/order_history.php'; 


