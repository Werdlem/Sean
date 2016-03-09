<?php
require_once('./DAL/PDOConnection.php');
$productDal = new products;
?>
  <title>Racking</title>
      
<div class="panel panel-primary">
<div class="panel-heading" style="text-align:center; font-size:15px">Select Aisle Number</div>
<div class="panel-body">
<div style="text-align:center">
<a href="?action=aisles&aisle=2" class="btn btn-large btn-info">Aisle 2</a>
<a href="?action=aisles&aisle=3" class="btn btn-large btn-info">Aisle 3</a>
<a href="?action=aisles&aisle=4" class="btn btn-large btn-info">Aisle 4</a>
<a href="?action=aisles&aisle=5" class="btn btn-large btn-info">Aisle 5</a>
<a href="?action=aisles&aisle=6" class="btn btn-large btn-info">Aisle 6</a>
<a href="?action=aisles&aisle=7" class="btn btn-large btn-info">Aisle 7</a>
<a href="?action=aisles&aisle=8" class="btn btn-large btn-info">Aisle 8</a>
</div>
 <input type="hidden" name="aisle2" value="2">
</div></div>

<?php

  $aisle = $_GET['aisle']; 

?>
  
<div class="panel panel-info" style="width:60%; float:left">
  <!-- Default panel contents -->
  <div class="panel-heading" style="text-align:center; font-size:18px">Aisle No: <?php echo $aisle; ?></div>
  
   

    <table class="table">
        <thead>
        <tr class="heading">
            <th>Location</th>
            <th>Product</th>
            <th></th>
            <th></th>
           <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
				 		 
	$aisles = $productDal->GetAisle($aisle);	
    foreach ($aisles as $result)
    {
		?>
        <tr>
            <td><a href="edit_location.php?id=<?php echo $result['location_id']; ?>" style='color:black'><?php echo $result['location_name'];?></a></td>
            <td><?php echo $result['sku'];?></td>
            <td>
            <?php if ($result['sku'] > null){ ?>
               
            <a href="?action=update_product&sku=<?php echo $result['sku']; ?>&sku_id=<?php echo $result['sku_id'];?>">Details</a>
            </td>
            
            <td>
                <a href="?action=action&clear_location&location_id=<?php echo $result['location_id'] ?>">Delete</a>
            </td>
            
            <?php } else{
				echo
				"<td><a href='?action=update_location&location_id=". $result['location_id']."'>Update</a></td>";
				}?>
            
        </tr>
        <?php
	}
	
	?>
    
   
</tbody>
</table>
</div>

<?php include 'modules/empty_Location.php';