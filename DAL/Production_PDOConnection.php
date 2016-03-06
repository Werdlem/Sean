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
	
	public function GetProduct($id){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('
			Select *
			from production_stock
			where customer_id like :stmt
			order by product ASC
		');
		$stmt->bindValue(':stmt', $id);
		$stmt->execute();
		if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			die();
			}
	}
	
	public function GetAllProducts($products){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('
			Select *
			from production_stock
			order by product asc
		');
		$stmt->bindValue(':stmt', $products);
		$stmt->execute();
		if($stmt->rowCount()>0) {
		while ($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
		return $results;
	}
		}
	}
	
	public function GetCustomer($id){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('Select * 
		from customers
		');
		$stmt->bindValue(':stmt', $id);
		$stmt->execute();
		if($stmt->rowCount()>0){
		while($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
		}
	}
	}
	public function GetCustomerID($id){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('Select customer_id 
		from customers
		where customer_name like :stmt
		');
		$stmt->bindValue(':stmt', $id);
		$stmt->execute();
		if($stmt->rowCount()>0){
		while($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
		}
	}
	}
		
	public function GetProductDetails($product){
		
		$pdo = Database::DB();
		$stmt = $pdo->prepare('Select * 
		from production_stock
		left join customers on production_stock.customer_id=customers.customer_id
		where product_id
		like :stmt
		');
		$stmt->bindValue(':stmt', $product);
		$stmt->execute();
		while($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
		}
	}
	
	public function updateProduct($product, $today){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('update 
		production_stock
		set details = :today
		where product = :stmt');
		$stmt->bindValue(':today', $today);
		$stmt->bindValue(':stmt', $product);
		$stmt->execute();
		}
	
	public function GetStockMovment($product){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('Select * 
		from stock_movment
		where product_id
		like :stmt
		order by id desc limit 10
		');
		$stmt->bindValue(':stmt',$product);
		$stmt->execute();
		if($stmt->rowCount()>0)
		{
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			else
			{
				die("<div class='alert alert-danger' role='alert'>No History</div>");
			}
	}
	
	public function AddProduct($product, $customer, $details){
		$pdo = Database::DB();
		try{
		$stmt = $pdo->prepare('insert into
		production_stock (product, customer_id, details)
		values(?,?,?)
		');
		$stmt->bindValue(1, $product);
		$stmt->bindValue(2, $customer);
		$stmt->bindValue(3, $details);
		$stmt->execute();
		
		echo '<div class="alert alert-success" role="alert">The product '.$product . ' has been sucessfully added!</div>';	}
		catch (PDOException $e){
		{
			echo '<div class="alert alert-danger" role="alert">the product '.$product . ' appears to have been entered already</div>';
			}
		}
	}
	
	public function stock_In($date, $product_id, $qty_in){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('insert into
		stock_movment (product_id, qty_in, date)
		values(?,?,?)
		
		');
		$stmt->bindValue(1, $product_id);
		$stmt->bindValue(2, $qty_in);
		$stmt->bindValue(3, $date);
		$stmt->execute();
		}
		
		public function stock_Out($date, $product_id, $qty_out){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('insert into
		stock_movment (product_id, qty_out, date)
		values(?,?,?)
		
		');
		$stmt->bindValue(1, $product_id);
		$stmt->bindValue(2, $qty_out);
		$stmt->bindValue(3, $date);
		$stmt->execute();
		}
		
		public function AddCustomer($customer){
		$pdo = Database::DB();
		try{
		$stmt = $pdo->prepare('insert into
		customers (customer_name)
		values(?)
		');
		$stmt->bindValue(1, $customer);
		$stmt->execute();
		
		echo '</div><div class="alert alert-success" role="alert">The customer '.$customer . ' has been sucessfully added!</div>';	}
		catch (PDOException $e){
		{
			echo '</div><div class="alert alert-danger" role="alert">the customer '.$customer . ' appears to have been entered already</div>';
			}
		}
	}
	
	public function Total($total){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('select 
		coalesce(sum(qty_in),0) - coalesce(sum(qty_out),0) as total
		from stock_movment
		group by product_id
		having product_id = ?
		');
		$stmt->bindValue(1, $total);
		$stmt->execute();
		
		$results = $stmt->fetch(PDO::FETCH_ASSOC);
		{
			return $results;		
		}
		
	}
	public function deleteTotal($delete){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('delete
		from stock_movment
		where
		id like :stmt');
		$stmt->bindValue(':stmt', $delete);
			$stmt->execute();
		
	}
	
	public function deleteProduct($delete){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('delete
		from production_stock
		where
		product_id like :stmt');
		$stmt->bindValue(':stmt', $delete);
			$stmt->execute();
		
	}
}
