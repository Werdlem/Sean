<?php

$productsDal = new products;
$sku = $_GET['sku'];
 $sku_id = $productDetail['sku_id'];

$sku_id = $productsDal->fetchProductbyId($sku_id);
?>

<div class="panel panel-primary" style="width:24%; float:right">
  <div class="panel-heading" style="text-align:center">
  <?php echo '<h3>List of Locations</h3>';
		  ?>
  </div>
  <div class="panel-body">
    <form method="post" action="?action=action&deleteLocation&product=<?php echo $productDetail['sku'];?>&product_id=<?php echo $productDetail['sku_id'];?>">
      <table class="table" style="margin-bottom:0px">
      <?php if (!$sku_id) {echo"<div class='alert alert-danger' role='alert'>No Locations</div>";} 
else { 
foreach ($sku_id as $results)
{
	
	?>
      <tr>
        <td style="vertical-align:middle"><?php echo $results['location_name']; ?></td>
        <input id="sku_id" name="sku_id" type="hidden" readonly  value="<?php echo $productDetail['sku_id']; ?>"/>
        <input id="sku" class="form-control" name="sku" type="hidden" readonly  value="<?php echo $productDetail['sku']; ?>"/>
        <td><button id="X" class="btn btn-primary" name="X" type="submit" style="float:right;" value="<?php echo $results['location_id']; ?>" >X</button></td>
        <span id="notesInfo"></span>
        <?php } 
	}
	echo '</tr></table>';
	?>
    </form>
  </div>
</div>
<?php
     if (isset($_POST['X'])){	
   		$sku = $_POST['sku_id'];
		$sku_id = $_POST['sku_id'];
		$id = $_POST['X'];
	}
	
	?>
