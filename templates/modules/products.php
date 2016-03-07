<head>
    <title>Add New Product</title>
    </head>
<body>
<?php 
include_once('./DAL/PDOConnection.php');
if(isset($_GET['search'])){
$new = $_GET['search'];
}
else
{
	$new = '';
	}
 ?>

<div class="panel panel-primary">
<div class="panel panel-heading">
<h3>Add Product</h3></div>
<div class="panel-body">
    <form method="post" id="productDetail">
        <div>
            <label for="sku">Product</label>
            <input id="sku" class="form-control" name="sku" type="text" value="<?php echo $new; ?>"/>
            <span id="notesInfo"></span>
        </div>
       <div>
        <label for="alias_1">Alias 1</label>
        <input id="alias_1" name="alias_1" type="text" class="form-control"/>
      </div>
      <div >
        <label for="alias_2">Alias 2</label>
        <input id="alias_2" name="alias_2" type="text" class="form-control" />
      </div>
      <div>
        <label for="alias_3">Alias 3</label>
        <input id="alias_3" name="alias_3" type="text" class="form-control" />
      </div>
        <div>
            <label for="customer">Customer/Supplier</label>
            <input id="customer" class="form-control" name="customer" type="text" />
            <span id="notesInfo"></span>
        </div>
        <div>
            <label for="description">Description</label>
            <textarea id="description" class="form-control" name="description" rows="1" type="text"></textarea>
        <div>
            <label for="quantity">Quantity</label>
            <input id="quantity" class="form-control" name="quantity" type="text" value="0"/>
             </div>
             <div>
            <label for="quantity">Buffer Quantity</label>
            <input id="buffer_quantity" class="form-control" name="buffer_quantity" type="text" value="0"/>
             </div>
             <div>
             <div>
            
            
            <input id="last_ordered" class="form-control" name="last_ordered" rows="1" value=" " type="hidden"/>
        </div>
            
            <label for="notes">Notes</label>
            <textarea id="notes" class="form-control" name="notes" rows="7" type="text"> </textarea>
        </div>
            </div>
            <br/>
            <button type="submit" class="btn btn-primary" name="add" >Add</button>
       
        </form>
       </div>
        </div>
        
     <?php   if(isset($_POST['add'])){
	
$product = strtoupper($_POST['product']);
$alias_1 = strtoupper($_POST['alias_1']);
$alias_2 = strtoupper($_POST['alias_2']);
$alias_3 = strtoupper($_POST['alias_3']);
$customer = strtoupper($_POST['customer']);
$notes = nl2br($_POST['notes']);
$quantity = $_POST['quantity'];
$buffer_quantity = $_POST['buffer_quantity'];
$description = nl2br($_POST['description']);
$last_ordered = $_POST['last_ordered'];

$productDal = new products();  

$add_product = $productDal->AddProduct($product, $customer, $notes, $quantity,$buffer_quantity, $description, $last_ordered, $alias_1, $alias_2, $alias_3);
header('location:?action=update_product&id='.$product.'&p_id=');
}?>

</body>
</html>