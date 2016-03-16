<?php require_once './DAL/PDOConnection.php';
$productDal = new products();
$fetch = $productDal->Get_Allocation();
?>

<div class="panel panel-primary" style="width:100%; float:left;">
<div class="panel-heading" style="text-align:center;">
  <h3>Stock Quantity Totals</h3>
</div>
<div class="panel-body">
<form  method="post" id="Search" action="?action=stock_qty">
      <div id="search" style="text-align:center">
        <?php $product = $productDal->Get_Allocation();
	  $dropdown = "<select name='search_stock' id='mySelect' onchange='select()'>";
	  foreach ($product as $result){
		  $dropdown .="\r\n<option value='{$result['allocation_id']}'>{$result['name']}</option>";
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
			$fetch = $_POST['search_stock'];
			
			$fetch = $productDal->Get_Allocation_Sku($fetch);
			?>
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
  

foreach ($fetch as $result){ ?>
  <tr>
    <td style=""><a href="?action=sheetboard_details&sku=<?php echo $result['sku'];?>"><?php echo $result['sku']; ?></a></td>
    <td style="text-align:center"><?php if ($result['last_order_date'] < '(NULL)') { echo '';} else{ echo date('d-m-Y',strtotime($result['last_order_date']));} ?></td>
    <?php
$total = $result['sku'];
$selection = $result['sku'];
//$test = $result['sku']; //<--------------possible improvment
//$test_qty = $productDal->Total_Stock($test);

//foreach ($test_qty as $qty){ echo $qty['qty'];}

$last_qty = $productDal->goods_in_last_total($total);
$adjustment_total = $productDal->Stock_Adjustment_Total($total);
$sku_total = $productDal->Goods_in_total($total);
$qty_in = $productDal->Qty_Instock($selection);

foreach ($last_qty as $last_qty_result){ $percentage  = (50 / 100) * $last_qty_result['qty_received'];
	if ($adjustment_total){foreach ($adjustment_total as $amt);{ $amt;}}else{$amt = 0;} ;	
	if ($sku_total){foreach ($sku_total as $goods_in_amt);{ $goods_in_amt;}}else{$goods_in_amt = 0;};
	if ($qty_in){foreach ($qty_in as $qty_in_total);{ $qty_in_total['total'];}}else{$qty_in_total = 0;};  
	?>
    <td style="text-align:center"><?php $date =  date('d-m-Y', strtotime($last_qty_result['delivery_date']));{ if (!$date){echo  '';} else{ echo $date ;} }?></td>
    <td style="text-align:center; */"><?php $Total_stock = $goods_in_amt - $amt;
	
	
$amount = $goods_in_amt - ($qty_in_total['total'] + $amt);
echo $amount;

	?>
	</td>
    <td style="text-align:center"><a href="?action=send&sku=<?php echo $result['sku'];?>" class="btn btn-large btn-primary">Order</a></td>
    
  <?php }
}
		}
	}
 
?>
  </tr>
</table>
