<?php
require_once './DAL/PDOConnection.php';
$productDal = new products();

include('/templates/sheetboard.php');

if (isset($_GET['sku'])){	
	$sku = $_GET['sku'];
	}
	else{
	$sku = $_POST['search_board'];	
	$goods_in = $productDal->get_Goods_In_Sku($sku);
	}
	
		$goods_in = $productDal->get_sku($sku);

	?>

<div class="panel panel-primary" style="width:100%; float:left;">
  <div class="panel-heading" style="text-align:center;">
    <h3>Product Details</h3>
  </div>
  <div class="panel-body">
    <div>
   
      <label for="product" style="font-size:16px"><strong>Product:</label>
      <a href="?action=update_product&sku=<?php echo $sku ?>&sku_id=" style="font-size:16px">
      <?php echo $sku ?></a></strong>
     <span id="notesInfo"></span>
      </div>
    </form>
    <div>
      <form  method="post" action="?action=action&update_sheetboard&sku=<?php echo $sku?>">
        <input id="product_id" name="product_id" type="hidden" value="" />
        <br />
        <div style="width:49%; float:left; text-align:center">
          <label for="add">Add</label>
          <input id="add" name="add" type="text" autocomplete="off" class="form-control"/>
        </div>
        <div style="width:49%; float:right; text-align:center">
          <label for="subtract">Subtract</label>
          <input id="subtract" name="subtract" type="text" autocomplete="off" class="form-control" />
        </div>
        <span id="notesInfo"></span>
        <button type="submit" id="update_sheetboard" name="update_sheetboard" class="btn btn-primary" style="margin-top:10px">Post</button>
      </form>
    </div>
    <?php 
include ('/templates/modules/goods_in.php');
include ('/templates/modules/goods_out.php');

$total = $goods_in_amt - $total_goods_out;


echo '<label for="total" style="position:absolute; margin-top:-127px; margin-left:-404px" >Total in Stock: '. $total . '</label>';
 
 echo ' </div>';
echo '</div>';


