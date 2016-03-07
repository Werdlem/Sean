<?php 
//include_once('../DAL/PDOConnection.php');

$productDal = new products();
if ($_GET['sku_id'] == ''){
	$sku = $_GET['sku'];
	$sku = $productDal->GetProducts($sku);
	foreach ($sku as $result){
		$sku_id = $result['sku_id'];
		}
	}

else
{
$sku_id = $_GET['sku_id'];
}

?>

<div class="panel panel-primary" style="width:24%; float:left; margin-left:13px">
<div class="panel-heading" style="text-align:center"><h3>Order History</h3></div>
<div class="panel-body" style="margin-bottom:-34px" >

<div>
  <?php		
			$sku_id = $productDal->get_history($sku_id); ?>
<table class="table" style="text-align:center">
<thead><tr class="heading">
<th style="text-align:center"> Date Ordered</th>
        
			<?php echo '<tr>';
		foreach($sku_id as $result){?>
            <td><?php echo $result['date']; ?></td>
           </tr></thead>
            <span id="notesInfo"></span>
     
      
    
       
<?php }echo '</table></div></div></div>'?>
