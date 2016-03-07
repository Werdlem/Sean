<?php

require_once('./DAL/PDOConnection.php');

$productDal = new products();
if(isset($_POST['add_location'])){
    //form submitted
    $location = strtoupper ($_POST['location']);
	
        $productDal->addLocation($location);
		header("location: ?action=update");
        
}
?>
 <div class="panel panel-primary" >
<div class="panel panel-heading">
<h3 style="text-align:center">Add Location</h3></div>
<div class="panel-body">
    <form method="post" id="productDetail" action="?action=add_location">
     
            <label for="location">Location</label> <br />
            <input id="location" name="location" type="text" style="width:50px"/>
           <span id="locationInfo"></span>    </br>  
             </br>      
            
        <button class="btn btn-large btn-primary" id="add_location" name="add_location" type="submit"/>Add
 <?php       if (mysql_errno() == 1062) {
    
    print '<div class="alery alert-warning" role="alert">Duplicate Racking Location Entered, Please try Again!</div>';
}

?>
        </form>
        </div>
        </div>
        
       <?php $locationDelete = new products();
 $getEmptyLocations = $locationDelete->EmptyLocations();
if(isset($_GET['delete'])){
	
    $locationDelete->DeleteLocation($_GET['delete']);
	header("Status: 200");
    header("Location: ?action=empty_location");
		} ?>
       
      