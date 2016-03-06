<?php 

require_once './DAL/PDOConnection.php';


if(isset($_GET['term'])){
	$return_arr = array();
	
		$pdo = Database::DB();
		$stmt = $pdo->prepare('select *
		from location
		where location_name
		like :term');
		$stmt->execute(array('term' => '%'.$_GET['term'].'%'));
		foreach ($stmt as $result)
		{
			$result['value'] = $result['location_name'];
			$result['label'] = "{$result['location_name']}";
			$matches[] = $result;
			}
}
		$matches = array_slice($matches, 0, 7);
		print json_encode($matches);