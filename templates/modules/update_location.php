<?php

require_once './DAL/PDOConnection.php';


$productDal = new products();

$isEditing = isset($_GET['id']);

if ($_GET['sku_id']==''){
	$id = $_GET['sku'];
	$id = $productDal->GetProducts($id);
	}
else{
  $id = $_GET['sku_id'];  

    $id = $productDal->GetProductsId($id);
}
foreach($id as $productDetail){

?>

<script src="./Jquery/jquery.min.js" type="text/javascript"></script> 
<script src="./Jquery/jquery-ui.min.js" type="text/javascript"></script>  
    <title>Product Update</title>
    </head>
    
	<script type="text/javascript">   
	$(document).ready
	(function(){ var ac_config = { source: "autoSelectLocation.php", select: function(event, ui){ 
	$("#location_name").val(ui.item.location_name); 
	$("#location_id").val(ui.item.Location_id); },
	minLength:1 }; 
	$("#location_name").autocomplete(ac_config);}); 
    </script>
    
 <div class="panel panel-primary" style="width:24%; float:right; margin-right:13px">
<div class="panel-heading" style="text-align:center"><h3>Update Location</h3></div>
<div class="panel-body">
    <form method="post" 
          action="?action=action&add_location">
        <div>
            <label for="sku">Product</label>
            <input id="sku" class="form-control" name="sku" type="text" readonly  value="<?php echo $productDetail['sku']; ?>"/>
            <input id="sku_id" name="sku_id" type="hidden" readonly  value="<?php echo $productDetail['sku_id']; ?>"/>
            <span id="productInfo"></span>
        </div>
        <br />
        <div>
            <label for="location_name">Location</label>
            <input id="location_name" name="location_name" class="form-control" type="text" value=""/>
            <input id="id" name="id" class="auto" type="hidden" value=""/></p>
            <span id="notesInfo"></span>
        </div>
      
        <button id="add_location" class="btn btn-primary" name="add_location" type="submit" >Update</button>
        
        </form>
         
      </div>
      <?php }?>
      </div>
     
     
	  
    