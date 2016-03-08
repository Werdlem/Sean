<?php

require_once './DAL/PDOConnection.php';

$productDal = new products();
  $location_id = $_GET['location_id'];  
    $location_id = $productDal->GetProductsLocation($location_id);{
		
foreach($location_id as $productDetail);
	
?><head>

<script src="./Jquery/jquery.min.js" type="text/javascript"></script> 
<script src="./Jquery/jquery-ui.min.js" type="text/javascript"></script>  
    <title>Product Update</title>
    </head>
    
	<script type="text/javascript">   
	$(document).ready
	(function(){ var ac_config = { source: "autoSelect.php", select: function(event, ui){ 
	$("#sku").val(ui.item.sku); 
	$("#sku_id").val(ui.item.sku_id); },
	minLength:1 }; 
	$("#sku").autocomplete(ac_config);}); 
    </script>
    
 <div class="panel panel-primary">
<div class="panel-heading" style="text-align:center; font-size:15px">Update Location</div>
<div class="panel-body">
    <form method="post"
          action="?action=action">
        <div>
            <label for="location">Location</label>
            <input id="location" class="form-control" name="location" type="text" readonly  value="<?php echo $productDetail['location_name']; ?>"/>
            <input id="location_id" name="location_id" type="hidden" readonly  value="<?php echo $productDetail['location_id']; }?>"/>
            <span id="productInfo"></span>
        </div>
        <br />
        <div>
            <label for="sku">Product</label>
            <input id="sku" name="sku" class="form-control" type="text" value=""/>
            <input id="sku_id" name="sku_id" class="auto" type="hidden" value=""/></p>
            <span id="notesInfo"></span>
        </div>
      
        <button id="update_location" class="btn btn-primary" name="update_location" type="submit">Submit</button>
        </form>
        
      </div>