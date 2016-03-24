<?php 
require_once './DAL/stock.php';
//require_once '../DAL/sheetboard_PDOConnection.php';
$productDal = new products();

?>
<style>
.home {
	background-color: #e5e5e5;
	box-shadow: 0 3px 8px rgba(0, 0, 0, 0.125) inset;
	color: #555;
	text-decoration: none;
}
.panel-success {
	width:100%;
}
</style>


<div class="panel panel-success" style="float:left">
  <div class="panel panel-heading">
    <h3 style="text-align:center">Stock Search</h3>
  </div>
  <div class="panel-body">
    <form  method="post" id="Search" action="?action=stock_on_hand_2">
      <div id="search" style="text-align:center">
        <?php $product = $productDal->goods_in_sku();
	  $dropdown = "<select name='search_board' id='mySelect' onchange='select()'>";
	  foreach ($product as $result){
		  $dropdown .="\r\n<option value='{$result['sku']}'>{$result['sku']}</option>";
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
        <button type="submit" class="btn btn-large btn-success" name="submit">Search</button>
        <input type="hidden" name="doSearch" value="1">
      </div>
    </form>
  </div>
</div>
