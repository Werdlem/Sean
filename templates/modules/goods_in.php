<?php 
$goods_in = $productDal->get_Sheetboard($sku);
$total = $productDal->goods_In_total($sku); 

?>

<table class="table" style="width:48%; float:left;">
  
    <td style="border-bottom:none; float:right"><h3>Goods In</h3></td>
  <tr class="heading">
    <td>Date Rec</td>
    <td style="text-align:center">Qty</td>
  </tr>
  <tr>
    <?php 
	if (!$total){
		$goods_in_amt = 0;
		}
		else{
		foreach ($total as $goods_in_amt){ $goods_in_amt; //<----- total amount received stored as a variable for use on sheetboard_details
		}
			
		?>
    <?php
	 		foreach ($goods_in as $Result){?>
    <td><?php echo $Result['delivery_date']?></td>
    <td style="text-align:center"><?php echo $Result['qty_received']?></td>
  </tr>
  <?php 
			}
			}

	
	?>
</table>
