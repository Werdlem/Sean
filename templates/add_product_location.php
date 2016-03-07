<?php
require_once('./DAL/PDOConnection.php');

echo'<div style="width:49%; float:left">';
include 'modules/add_sku.php';
echo'</div>';

echo'<div style="width:49%; float:right">';
include 'modules/add_location.php';
echo'</div>';