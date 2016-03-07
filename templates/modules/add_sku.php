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
    <form method="post" action="?action=action">
        <div>
            <label for="sku">Product</label>
            <input id="sku" class="form-control" name="sku" type="text" value="<?php echo $new; ?>"/>
            <span id="notesInfo"></span>
        </div>
        <div>
            <label for="pack_qty">Pack QTY</label>
            <input id="pack_qty" class="form-control" name="pack_qty" type="text" value="0"/>
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
            <label for="allocation_id">Customer/Supplier</label>
            <input id="allocation_id" class="form-control" name="allocation_id" type="text" value="0"/> 
            <span id="notesInfo"></span>
        </div>
        <div>
            <label for="description">Description</label>
            <textarea id="description" class="form-control" name="description" rows="1" type="text"></textarea>
        <div>
            <label for="stock_qty">Quantity</label>
            <input id="stock_qty" class="form-control" name="stock_qty" type="text" value="0"/>
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
            <button type="submit" class="btn btn-primary" name="add_sku" >Add</button>
       
        </form>
       </div>
        </div>
        
</body>
</html>