<?php

//----------------------------------------GOODS_OUT_TOTAL--------------------------------//

$goods_in = $productDal->Get_All($sku);

if(!$goods_in){
	
	$goods_out_result['total'] = '0';
	
	}
	else{

	 foreach ($goods_in as $result){
		 $sku = $result['sku'];
		 $alias1 = $result['alias_1'];
		 $alias2 = $result['alias_2'];
		 $alias3 = $result['alias_3'];
		 
		 if ($sku == ''){
			 $sku = 'null';
			 }
		 else{
			 $alias3 = $result['alias_3'];
			 }		 
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
		 
		 
		 $goods_out = $productDal->Goods_Out_total($sku, $alias1, $alias2, $alias3, $sku, $alias1, $alias2, $alias3);
		 foreach ($goods_out as $goods_out_result)
		 {
		 }
	 }
	}
		 

//--------------------------------------------------------------------------------------//
 
$goods_out_movement = $productDal->get_Movement($sku);
$total = $productDal->total($sku);

if ($total){foreach ($total as $goods_out_amt){ $goods_out_amt;}} else {echo '0';}
	$total_goods_out = $goods_out_result['total'] - $goods_out_amt;
	
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
     if (!$goods_out_movement);else{
	 foreach ($goods_out_movement as $result){
		?>
     <td ><?php echo date('d-m-Y', strtotime($result['date']))?></td>
      <td style="text-align:center"><?php echo $result['qty_out']?></td>
      <td style="text-align:center"><?php echo $result['qty_in']?></td>
      <td style="text-align:center"><a href="?action=action&delete_line&id=<?php echo $result['id'];?>&sku=<?php echo $result['sku'] ?>">X</a></td>       
  </tr>
       
<?php }}
?>
</table>
