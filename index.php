<?php
$pass = 'ops';

if (!isset($_COOKIE['password'])){ 
      include ("templates/login.html");
    } 
	
include("templates/header.php");
// Set the default name

$action = 'search';

// Specify some disallowed paths

$disallowed_paths = array('header', 'footer', 'autoSelect');

if (!empty($_GET['action'])) {

    $tmp_action = basename($_GET['action']);

    // If it's not a disallowed path, and if the file exists, update $action

    if (!in_array($tmp_action, $disallowed_paths) && file_exists("templates/{$tmp_action}.php"))

        $action = $tmp_action;

}

// Include $action

include("templates/$action.php");

//include("templates/footer.html");