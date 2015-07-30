<?php

require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once("../php-classes/movement.php");

try {
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/invtext.ini");
	$movement = new Movement(null, 1, 1, 1, 1, 2.50, 2015-07-29, "T", 4.50);
	$movement->insert($pdo);
	var_dump($movement);
} catch(PDOException $pdoException) {
	// handle PDO errors
} catch(Exception $exception) {
	// handle other errors
}

$movement_dump = Movement::getAllMovements($pdo);

foreach($movement_dump as $index) {
	//var stringStart = "<table class=\"info-table\">";
	//var tableHeaders = "<thead><tr><th>Movement ID</th><th>From Location ID</th><th>To Location ID</th><th>Product ID</th> .
	//						  <th>Unit ID</th><th>Cost</th><th>Movement Date</th><th>Movement Type</th><th>Price</th></tr></thead>";
	//var stringEnd = "</table>";
	echo $index;
}

?>