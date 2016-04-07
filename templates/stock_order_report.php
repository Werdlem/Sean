<?php require_once './DAL/PDOConnection.php';
$productDal = new products();
//$fetch = $productDal->Get_Allocation();


$select = $productDal->select_all();
			?>
            <div class="panel panel-primary" style="width:100%; float:left;">
<div class="panel-heading" style="text-align:center;">
  <h3>Low Stock Order Report</h3>
</div>
<div class="panel-body">
<div>
<table class="table">
  <tr class="heading">
    <td style="font-size:16px"><strong>Product</td>
    <td style="font-size:16px; text-align:center"><strong>Date Ordered</td>
    <td style="font-size:16px; text-align:center"><strong>Date Rec</td>
    <td style="font-size:16px; text-align:center"><strong>Stock On Hand</td>
    <td style="font-size:16px; text-align:center"><strong>Buffer Qty</td>
    <td style="font-size:16px; text-align:center"><strong>Order</td>
  </tr>
  <?php
  

foreach ($select as $result){ ?>
 
    <?php
$total = $result['sku'];
$selection = $result['sku'];
$last_qty = $productDal->goods_in_last_total($total);
$adjustment_total = $productDal->Stock_Adjustment_Total($total);
$sku_total = $productDal->Goods_in_total($total);
$goods_in = $productDal->Get_All($selection);

if (!$goods_in){
	
	}
	else {
	 foreach ($goods_in as $result){
		 $sku = $result['sku'];
		 $alias1 = $result['alias_1'];
		 $alias2 = $result['alias_2'];
		 $alias3 = $result['alias_3'];
		 
		 if ($alias3 == ''){
			 $alias3 = 'null';
			 }
		 else{
			 $alias3 = $result['alias_3'];
			 }
		 if ($alias1 == ''){
			 $alias1 = 'null';
			 }
		 else{
			 $alias1 = $result['alias_1'];
			 }
			 if ($alias2 == ''){
			 $alias2 = 'null';
			 }
		 else{
			 $alias2 = $result['alias_2'];
			 }
		 
		 
		 $qty_in = $productDal->Goods_Out_total($sku, $alias1, $alias2, $alias3, $sku, $alias1, $alias2, $alias3);
		 if ($qty_in){foreach ($qty_in as $qty_in_total);{$qty_in_total['total'];}}else{ $qty_in_total = 0;}; 		
		 {
			 }
				 } 
		 
foreach ($last_qty as $last_qty_result){ $percentage  = (50 / 100) * $last_qty_result['qty_received'];
	if ($adjustment_total){foreach ($adjustment_total as $amt);{ $amt;}}else{$amt = 0;} ;	
	if ($sku_total){foreach ($sku_total as $goods_in_amt);{ $goods_in_amt;}}else{$goods_in_amt = 0;};
	if ($qty_in){foreach ($qty_in as $qty_in_total);{$qty_in_total['total'];}}else{ $qty_in_total = 0;};  
	?>
    
    <?php $Total_stock = $goods_in_amt - $amt;	
				$amount = $goods_in_amt - ($qty_in_total['total'] + $amt);

					if ($amount < $result['buffer_qty']){?>

 <tr style="">
    <td style=""><a href="?action=sheetboard_details&sku=<?php echo $result['sku'];?>"><?php echo $result['sku']; ?></a></td>
    <td style="text-align:center"><?php if ($result['last_order_date'] < '(NULL)') { echo '';} else{ echo date('d-m-Y',strtotime($result['last_order_date']));} ?></td>
     <td style="text-align:center"><?php $date =  date('d-m-Y', strtotime($last_qty_result['delivery_date']));{ if (!$date){echo  '';} else{ echo $date ;} }?></td>
    <td style="text-align:center; color:#F00"><strong><?php echo $amount; ?></strong></td>	
    <td style="text-align:center; color:#06F;"><strong><?php echo $result['buffer_qty'];?></strong></td>
    <td style="text-align:center"><a href="?action=test_send&sku=<?php echo $result['sku'];?>" class="btn btn-default btn-primary">Order</a></td>
    
  <?php 
				}
			}
		}
	}
?>
  </tr>
</table>
