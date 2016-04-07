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
	
	public function Search($fetch,$fetch){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('
			Select *
			from products
			left join location 
			on location.sku_id=products.sku_id
			where (sku like :stmt) or (alias_1 like :stmt)
		');
		$stmt->bindValue(':stmt', "%".$fetch."%");
		$stmt->bindValue(':stmt', "%".$fetch."%");
		$stmt->execute();
		if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			die("<div class='alert alert-danger' role='alert'>The Product '".$fetch."' Could not be found. please click
			<a href='?action=add_product_location&search=".$fetch."'>here</a> to add it to the database!</div></div></ br></br>");
			}
	}
	
	public function GetProducts($sku){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('Select *
			from products
			left join stock_allocation on products.allocation_id=stock_allocation.allocation_id
			where sku = :stmt');
		$stmt->bindValue(':stmt', $sku);
		$stmt->execute();
		if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			die("<div class='alert alert-danger' role='alert'>The Product '".$sku."' Could not be found. please click
			<a href='?action=add_product_location&search=".$sku."'>here</a> to add it to the database!</div></div></ br></br>");
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
		
		public function UpdateProduct($sku_id, $sku, $notes, $buffer_qty, $allocation_id, $supplier_name, $description, $alias_1, $alias_2, $alias_3, $stock_qty){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('update products
		set sku = :sku, notes = :notes, buffer_qty = :buffer_qty, allocation_id = :allocation_id, supplier_name = :supplier_name, description = :description, alias_1 = :alias_1, alias_2 = :alias_2, alias_3 = :alias_3, stock_qty = :stock_qty
		where sku_id = :sku_id');		
		$stmt->bindValue(':sku', $sku);
		$stmt->bindValue(':notes', $notes);
		$stmt->bindValue(':buffer_qty', $buffer_qty);
		$stmt->bindValue(':allocation_id', $allocation_id);
		$stmt->bindValue(':supplier_name', $supplier_name);
		$stmt->bindValue(':description', $description);
		$stmt->bindValue(':alias_1', $alias_1);
		$stmt->bindValue(':alias_2', $alias_2);
		$stmt->bindValue(':alias_3', $alias_3);
		$stmt->bindValue(':stock_qty', $stock_qty);
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
            	<font style='color:red; font-size:20px'> '". $Search ."'</font> could not be found! Please try again.</strong></div></ br></br>");
				}
			}
			
		}	

		public function Delete_Sku($sku){
			$pdo = Database::DB();
			$stmt = $pdo->prepare('delete  
			from products
			where
			sku like :stmt');
			$stmt->bindValue(':stmt', $sku);
			$stmt->execute();
		}
		
		public function Clear_Location($location_id){
			$pdo = Database::DB();
			$stmt = $pdo->prepare('update location
			set sku_id = "0"
			where
			location_id like :stmt');
			$stmt->bindValue(':stmt', $location_id);
			$stmt->execute();
		}
		
		public function sku_order($today, $sku_id){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('update 
		products 
		set last_order_date = ?
		where
		sku_id like ?
		');
		$stmt->bindValue(1, $today);
		$stmt->bindValue(2, $sku_id);
		$stmt->execute();
		}
		
		public function EmptyLocations(){
			$pdo = Database::DB();
			$stmt = $pdo->query('select * from location
			where sku_id
			like "0"');
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
		
		public function Add_Sku($sku, $pack_qty, $alias_1, $alias_2, $alias_3, $allocation_id, $description, $stock_qty, $buffer_qty, $notes){
			$pdo = Database::DB();
		try{
			$stmt = $pdo->prepare('insert
			into products
			(sku, pack_qty, alias_1, alias_2, alias_3, allocation_id, description, stock_qty, buffer_qty, notes)
			values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
			$stmt->bindValue(1, $sku);
			$stmt->bindValue(2, $pack_qty);
			$stmt->bindValue(3, $alias_1);
			$stmt->bindValue(4, $alias_2);
			$stmt->bindValue(5, $alias_3);
			$stmt->bindValue(6, $allocation_id);
			$stmt->bindValue(7, $description);
			$stmt->bindValue(8, $stock_qty);
			$stmt->bindValue(9, $buffer_qty);
			$stmt->bindValue(10, $notes);
			$stmt->execute();
			echo '<div class="alert alert-success" role="alert">The product '.$sku . ' has been sucessfully added!</div>';	}	
			
			catch (PDOException $e){

				echo '<div class="alert alert-danger" role="alert">'. $e .'</div>';
			
				}			
		}
		
			public function GetAisle($aisle){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('Select * 
		from location 
		left join products on location.sku_id=products.sku_id 
		where location_name
		like :stmt 
		order by length(location_name),location_name');
		$stmt->bindValue(':stmt', $aisle."%");
		$stmt->execute();
		while($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
		}
	}
	
	public function GetProductsLocation($location_id){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('select *
		from location
		left join products on location.sku_id=products.sku_id
		where location_id = :stmt');
		$stmt->bindValue(':stmt', $location_id);
		$stmt->execute();				
		while($row = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $row;
		}
	}
	
	public function Update_Location($sku_id, $result){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('update
		location
		set sku_id = :stmt
		where
		location_id = :id');
		$stmt->bindValue(':stmt', $sku_id);
		$stmt->bindValue(':id', $result);
		$stmt->execute();
		echo '<div class="alert alert-success" role="alert">Product Successfully updated to Location</div>';
	}
	
	public function goods_in_sku(){
	$pdo = Database::DB();
	$stmt = $pdo->query('select goods_in.sku, products.sku_id
	from goods_in
	left outer join products on goods_in.sku=products.sku
	group by goods_in.sku');
	$stmt->execute();
	if ($stmt->rowCount()> 'null'){
		while ($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
			}
		}
	}
	
	public function get_Goods_In_Sku($sku){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('
			Select *
			from goods_in
			where sku like :stmt
			having qty_received <> "0.00"
			order by delivery_date desc
			limit 10			
		');
		$stmt->bindValue(':stmt', $sku);
		$stmt->execute();
		if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			
			}
	}
	
	public function get_sku(){
	$pdo = Database::DB();
	$stmt = $pdo->prepare('select stock_adjustment.sku, MAX(order_date)
	from stock_adjustment
	left join products on stock_adjustment.sku=products.sku
	group by stock_adjustment.sku	
	');
	$stmt->execute();
	if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
	}
	
	public function Goods_In_Total($total){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('select
		coalesce(sum(qty_received),0) as total
		from goods_in
		group by sku
		having sku = ?
		');
		$stmt->bindValue(1, $total);
		//$stmt->bindValue(2, $sku);
		$stmt->execute();
		
		$results = $stmt->fetch(PDO::FETCH_ASSOC);
		{
			return $results;		
		}
		
		
	}
	
	public function get_Movement($sku){
	$pdo = Database::DB();
		$stmt = $pdo->prepare('
			Select *
			from stock_adjustment 
			where stock_adjustment.sku like (?)
			having date <> "0000-00-00"
			order by date DESC
			limit 10
			
		');
		$stmt->bindValue(1, $sku);		
		$stmt->execute();
		if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			
			}
	}
	
	public function total($sku){ //Stock adjustment total
		$pdo = Database::DB();
		$stmt = $pdo->prepare('select 
		coalesce(sum(qty_in),0) - coalesce(sum(qty_out),0) as total
		from stock_adjustment		
		where
		stock_adjustment.sku like (?)
		
		');
		$stmt->bindValue(1, $sku);
		$stmt->execute();
		if ($stmt->rowCount()>0){
			
				$results = $stmt->fetch(PDO::FETCH_ASSOC);{
				return $results;
		
				}
		}
	}
	
	public function qty_In($sku, $qty_in, $date){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('insert into
		stock_adjustment (sku, qty_in, date)
		values (?,?,?)		
		');
		$stmt->bindValue(1, $sku);
		$stmt->bindValue(2, $qty_in);
		$stmt->bindValue(3, $date);
		$stmt->execute();
		}
		
		public function qty_Out($sku,$qty_out, $date){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('insert into
		stock_adjustment (sku, qty_out, date)
		values(?,?,?)
		
		');
		$stmt->bindValue(1, $sku);
		$stmt->bindValue(2, $qty_out);
		$stmt->bindValue(3, $date);
		$stmt->execute();
		}
		
		public function goods_in_last_total($total){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('select * from 
		products
		left join goods_in on goods_in.sku=products.sku
		where products.sku like (?) 
		group by goods_in.sku
	
		');
		$stmt->bindValue(1, $total);
		$stmt->execute();	
		if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			die();
			}
	}
	
	public function Stock_Adjustment_Total($total){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('select 
		coalesce(sum(stock_adjustment.qty_out),0) - coalesce(sum(stock_adjustment.qty_in),0) as total
		from stock_adjustment
		group by stock_adjustment.sku 
		having sku = ?
		');
		$stmt->bindValue(1, $total);
		$stmt->execute();		
		$results = $stmt->fetch(PDO::FETCH_ASSOC);
		{
			return $results;		
		}
		
	}
	
	public function delete_line($id){
	$pdo = Database::DB();
	$stmt = $pdo->prepare('delete 
	from stock_adjustment
	where id like (?)'
	);	
	$stmt->bindValue(1, $id);
			$stmt->execute();
	}
	
	public function Get_Allocation(){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('
			Select *
			from stock_allocation			
		');
		$stmt->execute();
		if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			die();
			}
	}
	
	public function Get_Allocation_Sku ($fetch){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('select *
		from products
		where allocation_id=(?)
		order by sku asc');
		$stmt->bindValue(1 ,$fetch);
	$stmt->execute();
	if ($stmt->rowCount()> 'null'){
		while ($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
			}
		}
	}
	
	public function Qty_Instock($selection){
			$pdo = Database::DB();
			$stmt = $pdo->prepare('select sum(qty_delivered) as total
				from goods_out 
				where goods_out.sku like (?)');
				$stmt->bindValue(1, '%'.$selection.'%');
				//$stmt->bindValue(2, '%'.$selection.'%');			
				$stmt->execute();
				while($row = $stmt->fetchALL(PDO::FETCH_ASSOC))
		{
			return $row;
		}
			}
			
			public function Qty_Delivered($selection){
			$pdo = Database::DB();
			$stmt = $pdo->prepare('select sum(qty_delivered) as total
				from goods_out
				where (goods_out.sku like (?) or goods_out.desc2 like (?))');
				$stmt->bindValue(1, '%'.$selection.'%');
				$stmt->bindValue(2, '%'.$selection.'%');		
				$stmt->execute();
				while($row = $stmt->fetchALL(PDO::FETCH_ASSOC))
		{
			return $row;
		}
			}
			
			public function Qty_In_Stock($total){
			$pdo = Database::DB();
			$stmt = $pdo->prepare('select 
		sum(qty_in) - sum(qty_out) as amount
		from stock_adjustment
		where sku = ?');
				$stmt->bindValue(1, $total);				
				$stmt->execute();
		$results = $stmt->fetch(PDO::FETCH_ASSOC);
		{
			return $results;		
		}
			}
			
			public function Total_Stock($sku){
			$pdo = Database::DB();
			$stmt = $pdo->prepare('select
			sum(qty_received) - (select sum(qty_delivered) from goods_out			
			from goods_in
			where sku like (?)');
			$stmt->bindValue(1, $sku);
			//$stmt->bindValue(2, $sku);				
			$stmt->execute();
		$results = $stmt->fetch(PDO::FETCH_ASSOC);
		{
			return $results;		
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
		
		public function Add_Allocation($allocation){
		$pdo = Database::DB();
		try{
		$stmt = $pdo->prepare('insert into
		stock_allocation (name)
		values(?)
		');
		$stmt->bindValue(1, $allocation);
		$stmt->execute();
		
		echo '</div><div class="alert alert-success" role="alert">The customer '.$allocation . ' has been sucessfully added!</div>';	}
		catch (PDOException $e){
		{
			echo '</div><div class="alert alert-danger" role="alert">the customer '.$allocation . ' appears to have been entered already</div>';
			}
		}
	}
	
	
	
	//------------------------------------------------------GOODS_OUT_QUERY------------------------------------------------------------------------------//
	
	public function Get_All($sku){
	$pdo = Database::DB();
		$stmt = $pdo->prepare('
		select *
				from goods_in
			left join products on goods_in.sku = products.sku
				where goods_in.sku like (?) 
				group by goods_in.sku			
		');
		$stmt->bindValue(1, $sku);
		$stmt->execute();
		if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			
			}
}
	public function Goods_Out_total($sku, $alias1, $alias2, $alias3, $sku, $alias1, $alias2, $alias3){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('select *, sum(qty_delivered) as total 
		from goods_out
		where 
		(sku like (?)) or
		(sku like (?)) or
		(sku like (?)) or
		(sku like (?)) or
		(desc1 like (?)) or
		(desc1 like (?)) or
		(desc1 like (?)) or
		(desc1 like (?))
	
		');
		$stmt->bindValue(1, $sku);
		$stmt->bindValue(2, '%'.$alias1.'%');
		$stmt->bindValue(3, '%'.$alias2.'%');
		$stmt->bindValue(4, '%'.$alias3.'%');
		$stmt->bindValue(5, '%'.$sku.'%');
		$stmt->bindValue(6, '%'.$alias1.'%');
		$stmt->bindValue(7, '%'.$alias2.'%');
		$stmt->bindValue(8, '%'.$alias3.'%');
		$stmt->execute();
		if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			
			}			
		}
		
		public function select_all(){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('
		select *
		from products
		where 
		allocation_id > "0"						
		');
		$stmt->execute();
		if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			
			}
}
public function Low_Stock_Qty($amount){
		$pdo = Database::DB();
		$stmt = $pdo->prepare('
		select *
		from products
		where 
		buffer_qty > (?)
		and 
		allocation_id > "0"						
		');
		$stmt->bindValue(1, $amount);
		$stmt->execute();
		if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			
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
	

}
