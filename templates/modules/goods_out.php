<?php 
$goods_out = $productDal->get_Movement($sku);
$total = $productDal->total($sku);
$qty_delivered = $productDal->Qty_Delivered($sku);
  if ($total){foreach ($total as $goods_out_amt){ $goods_out_amt;}} else {echo '0';}
if ($qty_delivered){ foreach ($qty_delivered as $qty_total){ $qty_total['total'];}}
	$total_goods_out = $qty_total['total'] - $goods_out_amt;
?>
<table class="table" style="width:48%; float:right">
  <td style="border-bottom:none; float:right"><h3>Adjustment</h3></td>
    <tr class="heading">
    <td>Date</td>
    <td style="text-align:center">Qty Out</td>
    <td style="text-align:center">Qty In</td>
    <td style="text-align:center">Delete</td>
    </tr>
    <tr>
   <?php
     if (!$goods_out);else{
	 foreach ($goods_out as $result){
		?>
     <td ><?php echo $result['date']?></td>
      <td style="text-align:center"><?php echo $result['qty_out']?></td>
      <td style="text-align:center"><?php echo $result['qty_in']?></td>
      <td style="text-align:center"><a href="?action=action&delete_line&id=<?php echo $result['id'];?>&sku=<?php echo $result['sku'] ?>">X</a></td>       
  </tr>
       
<?php }}
?>
</table>
