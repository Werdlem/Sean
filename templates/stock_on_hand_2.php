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
	 print_r($goods_in['sku']);
	 foreach ($goods_in as $result){
		 
		 echo $result['alias_1'] .'&nbsp'. $result['sku'].'&nbsp'. $result['alias_3'].'</br>';
		
		 }
	  ?>
  


