<?php 

include_once ('./DAL/PDOConnection.php');

$customer = new products();

//$stock = $products->select_stock_qty();?>

<div class="panel panel-primary">
  <div class="panel-heading" style="text-align:center;">
    <h3>Customer select</h3>
  </div>
  <div class="panel-body">
    <form  method="post" id="Search" action="?action=goods_out_customer_total">
      <div id="search" style="text-align:center">
        <?php $product = $customer->select_customer();
	  $dropdown = "<select name='customer' id='mySelect' onchange='select()'>";
	  foreach ($product as $result){
		  $dropdown .="\r\n<option value='{$result['customer']}'>{$result['customer']}</option>";
		  }
		  $dropdown .="\r\n</select>";
		  echo $dropdown;
	   ?>
        <script>
       function select(){
		   var x = document.getElementById("mySelect").value;
		   
		   }
       </script> 
        <br />
        <br />
        <button type="submit" class="btn btn-large btn-success" name="submit" >Search</button>
        <input type="hidden" name="doSearch" value="1">
      </div>
    </form>

<?php
if(isset($_POST['doSearch'])){
	
	if($_POST['doSearch']==1)
		{
			$search = $_POST[''];

foreach ($stock as $result){
	$sku = $result['sku'];
	?>

	<tr>
	
	<?php
	echo '<td>'. $result['sku'] .'</td>';
	echo '<td>'. $result['supplier'] .'</td>';
	echo '<td>'. $result['delivery_date'] .'</td>';
	$qty_used = $products->qty_instock($sku);
		foreach ($qty_used as $qty){
			echo '<td>'. $qty['total'] .'</td>';
			
			
		$total_stock = $result['total_received'] - $qty['total'];
		echo '<td>'. $total_stock .'</td>';
			
			}
}
		}
}