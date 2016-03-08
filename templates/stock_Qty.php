<?php require_once './DAL/PDOConnection.php';
$productDal = new products();
$stock = $productDal->get_sku();
?>

<div class="panel panel-primary" style="width:100%; float:left;">
<div class="panel-heading" style="text-align:center;">
  <h3>Stock Quantity Totals</h3>
</div>
<div class="panel-body">
<div>
<table class="table">
  <tr class="heading">
    <td style="font-size:16px"><strong>Product</td>
    <td style="font-size:16px; text-align:center"><strong>Date Ordered</td>
    <td style="font-size:16px; text-align:center"><strong>Date Rec</td>
    <td style="font-size:16px; text-align:center"><strong>Stock On Hand</td>
    <td style="font-size:16px; text-align:center"><strong>Order</td>
  </tr>
  <?php

foreach ($stock as $result){ ?>
  <tr>
    <td style=""><a href="?action=sheetboard_details&sku=<?php echo $result['sku'];?>"><?php echo $result['sku'];?></a></td>
    <td style="text-align:center"><?php if ($result['MAX(order_date)'] < '(NULL)') { echo '';} else{ echo date('d-m-Y',strtotime($result['MAX(order_date)']));} ?></td>
    <?php
$total = $result['sku'];
$sku = $result['sku'];
	$last_qty = $productDal->goods_in_last_total($total);
	$total = $productDal->Stock_Adjustment_Total($total);
	$sku = $productDal->Goods_in_total($sku);
	foreach ($last_qty as $last_qty_result){ $percentage  = (50 / 100) * $last_qty_result['qty_received'];
	if ($total){foreach ($total as $amt);{ $amt;}}else{echo '0';} ;	
	if ($sku){foreach ($sku as $goods_in_amt);{ $goods_in_amt;}}else{echo '0';}; 
	?>
    <td style="text-align:center"><?php echo date('d-m-Y', strtotime($last_qty_result['delivery_date'])) ?></td>
    <td style="text-align:center"><?php $Total_stock = $goods_in_amt - $amt;
	
	if ($Total_stock < $percentage)
	{
		echo '<strong style="color:red">' . $Total_stock;
		}
		else
	
	echo $Total_stock;
	?></td>
    <td style="text-align:center"><a href="?action=send&sku=<?php echo $result['sku'];?>" class="btn btn-large btn-primary">Order</a></td>
    <?php
}
}
?>
  </tr>
</table>
