<?php
require_once('settings.php');
class Database
{  

    private static $conn  = null;
     
    public static function DB()
    {       
		if (!isset(self::$conn)) {
			
          self::$conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
		  self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
           return self::$conn;
    }
}

class products{	
	
	public function search($Search){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('
			Select *
			from products
			left join location 
			on products.sku_id=location.sku_id
			where sku like :stmt
		');
		$stmt->bindValue(':stmt', "%".$Search."%");
		$stmt->execute();
		if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			die("<div class='alert alert-danger' role='alert'>The Product '".$Search."' Could not be found. please click
			<a href='?action=update&search=".$Search."'>here</a> to add it to the database!</div></div></ br></br>");
			}
	}
	
	public function GetProducts($sku){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('Select *
			from products
			where sku = :stmt');
		$stmt->bindValue(':stmt', $sku);
		$stmt->execute();				
		while($row = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $row;
		}
	}
	
	public function fetchProductbyId($sku_id){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('Select *
			from location
			where sku_id = :stmt
			order by location_name ASC');
		$stmt->bindValue(':stmt', $sku_id);
		$stmt->execute();
		if($stmt->rowCount()>0){				
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
		
		}
	}
	
	public function GetProductsId($sku){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('Select *
			from products
			where sku_id = :stmt');
		$stmt->bindValue(':stmt', $sku);
		$stmt->execute();				
		while($row = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $row;
		}
	}
	
	public function get_history($sku_id){
			$pdo = Database::DB();
			$stmt = $pdo->prepare('select *
			from order_history
			where sku_id
			like :stmt
			order by date desc limit 6');
			$stmt->bindValue(':stmt', $sku_id);
			$stmt->execute();
			if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			else{
			die("<div class='alert alert-danger' role='alert'>No History</div><br/>");
			}
		}
		
		public function UpdateProduct($sku_id, $sku, $notes, $buffer_qty, $allocation_id, $supplier_id, $description){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('update products
		set sku = :sku, notes = :notes, buffer_qty = :buffer_qty, allocation_id = :allocation_id, supplier_id = :supplier_id, description = :description
		where sku_id = :sku_id');		
		$stmt->bindValue(':sku', $sku);
		$stmt->bindValue(':notes', $notes);
		$stmt->bindValue(':buffer_qty', $buffer_qty);
		$stmt->bindValue(':allocation_id', $allocation_id);
		$stmt->bindValue(':supplier_id', $supplier_id);
		$stmt->bindValue(':description', $description);
		$stmt->bindValue(':sku_id', $sku_id);
		$stmt->execute();
		
		}
		
		public function Update_Product_Location($sku_id, $result){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('update location
		set sku_id = :sku_id
		where location_name = :location_name');		
		$stmt->bindValue(':sku_id', $sku_id);
		$stmt->bindValue(':location_name', $result);
		$stmt->execute();
		}
		
		public function Remove_Location($id){
			$pdo = Database::DB();
			$stmt = $pdo->prepare("update location
			set sku_id = :null
			where location_id = :stmt");	
			$stmt->bindValue(':null', null, PDO::PARAM_NULL);		
			$stmt->bindValue(':stmt', $id);
			$stmt->execute();
			}	
		
		public function SearchLocation($Search){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('Select * 
		from location 
		left join products on location.sku_id=products.sku_id 
		where location_name like :stmt');
		$stmt->bindValue(':stmt', $Search);
		$stmt->execute();
		if($stmt->rowCount()>0){
		while($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
		}
	}
		else{
			$stmt = $pdo->prepare('Select * 
		from products
		left join location on location.sku_id=products.sku_id 
		where description like :stmt');
		$stmt->bindValue(':stmt', "%".$Search."%");
		$stmt->execute();
		if($stmt->rowCount()>0){
		while($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
		}
		}
		else{die ("<div> <style='line-height: 4.0em; align='center'>
            	<font style='color:red; font-size:20px'> '". $Search ."'</font> could not be found! Please try again.</strong></div></ br></br>");}
	}
}		
	
	//--------------------------------------------------------------------------------------------------------------------------------------------------//
	
	
	
	
	public function SearchNotes($Search){
		
		$pdo = Database::DB();
		$stmt = $pdo->prepare('Select * 
		from products
		left join location on location.product_id=products.product_id 
		where notes like :stmt');
		$stmt->bindValue(':stmt', "%".$Search."%");
		$stmt->execute();
		while($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
		}
	}
	
	public function GetAisle($Aisle){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('Select * 
		from location 
		left join products on location.product_id=products.product_id 
		where location 
		like :stmt 
		order by length(location),location');
		$stmt->bindValue(':stmt', $Aisle."%");
		$stmt->execute();
		while($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
		}
	}
	
	public function GetLocation($id){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('Select * 
		from location 
		where id 
		like :stmt 
		');
		$stmt->bindValue(':stmt', $id);
		$stmt->execute();
		while($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
		}
	}
	
	public function update_location($location_id, $location){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('update
		location
		set location = :stmt
		where
		id = :id');
		$stmt->bindValue(':stmt', $location);
		$stmt->bindValue(':id', $location_id);
		$stmt->execute();
		echo '<div class="alert alert-success" role="alert">Product Successfully updated to Location</div>';		
		}
		
	public function GetAisleSort($Aisle){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('Select * 
		convert (substring(location from 4),unsigned integer)
		inner join products on location.product_id=products.product_id 
		where location 
		like :stmt 
		order by location');
		$stmt->bindValue(':stmt', $Aisle."%");
		$stmt->execute();
		while($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
		}
	}
	
	public function GetProductsLocation($id){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('select *
		from location
		left join products on location.product_id=products.product_id
		where id = :stmt');
		$stmt->bindValue(':stmt', $id);
		$stmt->execute();				
		while($row = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $row;
		}
	}
		
		public function InsertProduct($id, $product, $notes, $quantity, $description){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('update products
		set product :product, notes = :notes, quantity = :quantity, description = :description
		where product_id = :id');		
		$stmt->bindValue(':product', $product);
		$stmt->bindValue(':notes', $notes);
		$stmt->bindValue(':quantity', $quantity);
		$stmt->bindValue(':description', $description);
		$stmt->bindValue(':id', $id);
		
		}
			
		public function EmptyLocations(){
			$pdo = Database::DB();
			$stmt = $pdo->query('select * from location
			where product_id
			is null');
			$stmt->execute();
			if($stmt->rowCount()> 'null'){
			while($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
		}
			}
		else{
			die ("No Empty Locations Avaliable!");
			}		
		}
			
		public function AddLocation($location){
			$pdo = Database::DB();
			try{
			$stmt = $pdo->prepare('insert into
			location(location, product_id)
			values (:stmt, null)');
			$stmt->execute(array(
			":stmt" => $location));
			echo "<div class='alert alert-success'>Location Added!</div>";
			}
			catch (PDOException $e){
				echo "<div class='alert alert-danger' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>LOCATION ALREADY EXISTS</div>";
				}
			}
			
		public function DeleteLocation($id){				
			$pdo= Database::DB();
			$stmt = $pdo->prepare('delete 
			from location 
			where id = :stmt');
			$stmt->bindValue(':stmt', $id);
			$stmt->execute();				
				}
				
		public function AddProduct($product, $notes, $quantity, $description, $last_ordered){
			$pdo = Database::DB();
		try{
			$stmt = $pdo->prepare('insert
			into products
			(product, notes, quantity, description, last_ordered)
			values (?, ?, ?, ?, ?)');
			$stmt->bindValue(1, $product);
			$stmt->bindValue(2, $notes);
			$stmt->bindValue(3, $quantity);
			$stmt->bindValue(4, $description);
			$stmt->bindValue(5, $last_ordered);
			$stmt->execute();
			echo '<div class="alert alert-success" role="alert">The product '.$product . ' has been sucessfully added!</div>';	}	
			
			catch (PDOException $e){

				echo '<div class="alert alert-danger" role="alert">'. $e .'</div>';
			
				}			
		}
		
		public function ProductDelete($product){				
			$pdo= Database::DB();
			$stmt = $pdo->prepare('delete 
			from products 
			where product = :stmt');
			$stmt->bindValue(':stmt', $product);
			$stmt->execute();				
				}
			
		public function order($product, $today){
			$pdo = Database::DB();
			$stmt = $pdo->prepare('update
			products
			set last_ordered = :today
			where product = :stmt');
			$stmt->bindValue(':today', $today);
			$stmt->bindValue(':stmt', $product);
			$stmt->execute();
			}
			
			public function order_history($id, $today){
				$pdo = Database::DB();
				$stmt = $pdo->prepare('insert
				into order_history
				(product_id, date)
				values(?,?)');				
				$stmt->bindValue(1, $id);
				$stmt->bindValue(2, $today);
				$stmt->execute();
				}
			
		public function autoselect($Search){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('
			Select *
			from products
			where product like :stmt
		');
		$stmt->bindValue(':stmt', "%".$Search."%");
		$stmt->execute();
		if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			die("<div> <style='line-height: 4.0em; align='center'>
            	<font style='color:red; font-size:20px'> '". $Search ."'</font> could not be found.</strong></div></ br></br>");
			}
	}
	public function getProductByProductId($product_id){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('Select *
			from products
			left join location 
			on products.product_id=location.product_id
			where products.product_id like :stmt');
		$stmt->bindValue(':stmt', $product_id);
		$stmt->execute();
		while($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
		}
	}
	
	public function GetLocationById($search){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('Select * 
		from location 
		left join products
		on location.product_id=products.product_id
		where id 
		like :stmt 
		');
		$stmt->bindValue(':stmt', $search);
		$stmt->execute();
		while($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
		}
	}
	
	public function exportLocation($loc){
		$d = date("d-m-y");
	$pdo = Database::DB();
	$stmt = $pdo->prepare("select 'Location', 'Product'
	union
	select location, product
	from location
	left join products
	on location.product_id=products.product_id
	where location like :stmt
	into outfile 'c:/tmp/Aisle_" .$loc ."_". $d . ".csv'
	fields terminated by ','
	");
	$stmt->bindValue(':stmt', $loc."%");
	$stmt->execute();
	while($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
	{
		return $results;
		echo "Success";
		
		}
	}
	
	public function Suppliers(){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('select
		distinct name
		from
		supplier_details
		order by name ASC
		');
		$stmt->execute();
		if($stmt->rowCount()> 'null')
		{
			while($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
		}
}
	}
	
	public function select($supplier_name, $dateFrom, $dateTo){
	$pdo = Database::DB();
	$stmt = $pdo->prepare('
	select *
	from supplier_details
	where name like (?)
	and next_due > (?)
	and next_due < (?)
	order by next_due DESC
	');
	$stmt->bindValue(1 , "%".$supplier_name."%");
	$stmt->bindValue(2 ,$dateFrom);
	$stmt->bindValue(3 ,$dateTo);
	$stmt->execute();
	if($stmt->rowCount()> 'null')
	{
			while($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
		}
			}
		else{
			die ("No Results");
			}		
		}
}
