<?php
require_once('settings.php');
class SBDatabase
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

class sheetboard{	

public function sku(){
	$pdo = SBDatabase::DB();
	$stmt = $pdo->query('select *
	from goods_in
	left join sheetboard_movement on goods_in.sku=sheetboard_movement.sku
	group by sheetboard_movement.sku');
	$stmt->execute();
	if ($stmt->rowCount()> 'null'){
		while ($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
			}
		}
	}
	
	public function get_Sheetboard($sku){
		$pdo = SBDatabase::DB();
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
			die();
			}
	}
	
	public function get_Details($sku, $description){
	$pdo = SBDatabase::DB();
		$stmt = $pdo->prepare('
			Select *
			from goods_in 		
			where goods_in.sku like (?)
			and goods_in.description like(?)			
		');
		$stmt->bindValue(1, $sku);
		$stmt->bindValue(2, $description);		
		$stmt->execute();
		if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			die();
			}
	}
	
	public function get_Movement($sku){
	$pdo = SBDatabase::DB();
		$stmt = $pdo->prepare('
			Select *
			from sheetboard_movement 
			where sheetboard_movement.sku like (?)
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
	
	public function qty_In($sku, $qty_in, $date){
		$pdo = SBDatabase::DB();
		$stmt = $pdo->prepare('insert into
		sheetboard_movement (sku, qty_in, date)
		values (?,?,?)
		
		');
			$stmt->bindValue(1, $sku);
		$stmt->bindValue(2, $qty_in);
		$stmt->bindValue(3, $date);
		$stmt->execute();
		}
		
		public function qty_Out($sku,$qty_out, $date){
		$pdo = SBDatabase::DB();
		$stmt = $pdo->prepare('insert into
		sheetboard_movement (sku, qty_out, date)
		values(?,?,?)
		
		');
		$stmt->bindValue(1, $sku);
		$stmt->bindValue(2, $qty_out);
		$stmt->bindValue(3, $date);
		$stmt->execute();
		}


public function total($sku){
		$pdo = SBDatabase::DB();
		$stmt = $pdo->prepare('select 
		coalesce(sum(qty_out),0) - coalesce(sum(qty_in),0) as total
		from sheetboard_movement		
		where
		sheetboard_movement.sku like (?)
		
		');
		$stmt->bindValue(1, $sku);
		$stmt->execute();
		if ($stmt->rowCount()>0){
			
				$results = $stmt->fetch(PDO::FETCH_ASSOC);{
				return $results;
		
				}
		}
}

public function get_sku(){
	$pdo = SBDatabase::DB();
	$stmt = $pdo->prepare('select sku, MAX(order_date)
	from sheetboard_movement
	group by sku	
	');
	$stmt->execute();
	if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
	}		
	
	public function get_sku_order_date(){
	$pdo = SBDatabase::DB();
	$stmt = $pdo->prepare('select order_date
	from sheetboard_movement
	order by order_date asc
	');
	$stmt->execute();
	if($stmt->rowCount()>0) {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
	}		

		public function goods_In_total($sku){
		$pdo = SBDatabase::DB();
		$stmt = $pdo->prepare('select 
		coalesce(sum(qty_received),0) as total
		from goods_in
		group by sku
		having sku = ?
		');
		$stmt->bindValue(1, $sku);
		$stmt->execute();
		
		$results = $stmt->fetch(PDO::FETCH_ASSOC);
		{
			return $results;		
		}
		
		
	}
	
	public function goods_in_sku(){
	$pdo = SBDatabase::DB();
	$stmt = $pdo->query('select *
	from goods_in
	group by sku');
	$stmt->execute();
	if ($stmt->rowCount()> 'null'){
		while ($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
		{
			return $results;
			}
		}
	}
	
	public function zTotal($total){
		$pdo = SBDatabase::DB();
		$stmt = $pdo->prepare('select 
		coalesce(sum(sheetboard_movement.qty_out),0) - coalesce(sum(sheetboard_movement.qty_in),0) as total
		from sheetboard_movement
		group by sheetboard_movement.sku 
		having sku = ?
		');
		$stmt->bindValue(1, $total);
		$stmt->execute();		
		$results = $stmt->fetch(PDO::FETCH_ASSOC);
		{
			return $results;		
		}
		
	}
	
	public function Zgoods_In_total($sku){
		$pdo = SBDatabase::DB();
		$stmt = $pdo->prepare('select 
		coalesce(sum(qty_received),0) as total
		from goods_in
		group by sku
		having sku = ?
		');
		$stmt->bindValue(1, $sku);
		$stmt->execute();
		
		$results = $stmt->fetch(PDO::FETCH_ASSOC);
		{
			return $results;		
		}
		
		
	}
	
	public function goods_in_last_total($total){
		$pdo = SBDatabase::DB();
		$stmt = $pdo->prepare('select * from 
		(select * from goods_in 
		where sku like (?) 
		order by delivery_date desc) 
		as goods_in 
		group by sku
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
	
	public function goods_in_last_date($total){
		$pdo = SBDatabase::DB();
		$stmt = $pdo->prepare('select *
		from goods_in 
		where sku like (?)
		');
		$stmt->bindValue(1, $total);
		$stmt->execute();	
		$results = $stmt->fetch(PDO::FETCH_ASSOC);
		{
			return $results;		
		}
	}
	
	public function delete_line($id){
	$pdo = SBDatabase::DB();
	$stmt = $pdo->prepare('delete 
	from sheetboard_movement
	where id like (?)'
	);	
	$stmt->bindValue(1, $id);
			$stmt->execute();
	}
}
	

