<?php
require_once './DAL/stock.php';
$productDal = new products();

include('/templates/stock_on_hand.php');

if (isset($_GET['sku'])){	
	$sku = $_GET['sku'];
	}
	else{
	$sku = $_POST['search_board'];	
	$goods_in = $productDal->Get_All($sku);
	}
	
		$goods_in = $productDal->Get_All($sku);

	?>

<div class="panel panel-primary" style="width:100%; float:left;">
  <div class="panel-heading" style="text-align:center;">
    <h3>Product Details</h3>
  </div>
  <div class="panel-body">
    <div>
   
      <label for="product">Product</label><br />
      <a href="">
      <input id="product" name="product" type="text" disabled="disabled" class="form-control" style="width: 47%;" value="<?php echo $sku ?>"/></a>
     <span id="notesInfo"></span>
      </div>
    </form>
    <div>
      </div>
      
     <?php
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
		 
		 
		 $goods_out = $productDal->Goods_Out_total($sku, $alias1, $alias2, $alias3, $sku, $alias1, $alias2, $alias3);
		 foreach ($goods_out as $goods_out_result)
		 {
			 $goods_out_result['total'];
			 echo 'SKU: '. $goods_out_result['sku'].' | &nbsp;  TOTAL STOCK OUT: '.$goods_out_result['total'].' | (description SKU : '.$goods_out_result['desc1'].')<br/>';
			 }
				echo $goods_out_result['total'];
		
		 }
	  ?>
  


