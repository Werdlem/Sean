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
		

}