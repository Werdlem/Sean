<?php 
//require_once('DAL/Production_PDOConnection.php');
//require_once('DAL/sheetboard_PDOConnection.php');
require_once('DAL/PDOConnection.php');

$productDal = new products();
//$sheetboardDAL = new sheetboard();

if(isset($_POST['updates'])){
    //UPDATE PRODUCT FORM SUBMITTED
	$sku_id= $_POST['sku_id'];
	$sku = $_POST['sku'];
    $notes = nl2br($_POST['notes']);
	$buffer_qty = $_POST['buffer_qty'];
	$allocation = $_POST['allocation'];
	$supplier_id = $_POST['supplier_id'];
	$description = nl2br($_POST['description']);
	
	$productDal->UpdateProduct($sku_id, $sku,$notes,$buffer_qty, $allocation, $supplier_id ,$description);
	header("location:?action=update_product&sku=".$sku."&sku_id=".$sku_id);
}

if(isset($_POST['add_location'])){
   $result = $_POST['location_name'];
   		$sku = $_POST['sku'];
		$sku_id = $_POST['sku_id'];
        $productDal->Update_Product_Location($sku_id, $result);
		header("location:?action=update_product&sku=".$sku."&sku_id=".$sku_id);
		echo '<div class="alert alert-success" role="alert">Product Successfully updated to Location</div>';	
}

if(isset($_GET['delete'])){
    $productDal->Delete($_GET['delete']);
    header("Status: 200");
    header("Location: ?action=search");
}
if (isset($_GET['delete_product'])){
	$productDal->ProductDelete($_GET['delete_product']);
	header("Status: 200");
	header("Location: ?action=search");
	}
	
	if (isset($_GET['deleteLocation'])){
	
   		$sku = $_POST['sku'];
		$sku_id = $_POST['sku_id'];
		$id = $_POST['X'];
		//echo $id;
		$productDal->Remove_Location($id);
	header("Location: ?action=update_product&sku=".$sku."&sku_id=".$sku_id."&location_id=".$id);
	}



//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

if (isset($_GET['update_production'])){
	
$customer_id = $_GET['customer_id'];
$product_id = $_GET['product'];


if ($_POST['add'] > 0){
	$id = $_POST['add'];
	$date = date('d-m-Y');
	$product_id = $_GET['product'];
	$qty = $_POST['add'];
	$id = $productDal->stock_In($date, $product_id, $qty);
	}
	else{
		if($_POST['subtract']> 0){
		$id_out = $_POST['subtract'];
	$date = date('d-m-Y');
	$product_id = $_GET['product'];
	$qty_out = $_POST['subtract'];
	$id_out = $productDal->stock_Out($date, $product_id, $qty_out);
		}
	} 
   		
	header("Location: ?action=production_stock&id=".$customer_id."&product=".$product_id);
	}
	
	if(isset($_POST['add_customer'])){
		

$customer = strtoupper($_POST['customer']);

$add_customer = $productDal->AddCustomer($customer);

header("Location: ?action=add_production_stock");
	 }
	 
	 if (isset($_GET['delete_total'])){
		 $id = $_GET['id'];
		 $product = $_GET['product'];
		 $delete = $_GET['line_id'];
		 
		 echo $id; 
		 echo $product;
			echo $delete;
		$delete = $productDal->deleteTotal($delete);
		header('location: ?action=production_stock&id='.$id."&product=".$product);
	 }
	 
	 if (isset($_GET['delete_product'])){
		  $id = $_GET['id'];
		 $delete = $_GET['p_id'];
		 
		 echo $id; 
		 echo $delete;
		 $delete = $productDal->deleteProduct($delete);
		 header('location: ?action=production_stock&id='.$id);		
		 }
		 
		 
	if (isset($_GET['update_sheetboard'])) {
		$sku = $_GET['sku'];
		
		if ($_POST['add'] > 0){
	$add = $_POST['add'];
	$date = date('y-m-d');
	
	$qty_in = $_POST['add'];
	$add = $sheetboardDAL->qty_In($sku, $qty_in, $date);
	}
	else{
		if($_POST['subtract']> 0){
		$subtract = $_POST['subtract'];
	$date = date('y-m-d');

	$qty_out = $_POST['subtract'];
	$subtract = $sheetboardDAL->qty_Out($sku, $qty_out, $date);
		}
	
	}
	$dosearch = '1';
	header('Location: ?action=sheetboard_details&sku=' .$sku);
	}
		
		if (isset($_GET['delete_line'])){
			$id = $_GET['id'];
			$sku = $_GET['sku'];
			
			$delete_line = $sheetboardDAL->delete_line($id);
			header('location:? action=sheetboard_detials&sku='.$sku);
			}
		
		//header('Location: ?action=sheetboard_details&sku=' .$sku);
	
	
		
			 