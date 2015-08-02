<?php

require_once("/etc/apache2/data-design/encrypted-config.php");
require_once("/home/ccollopy/public_html/foodinventory/php/classes/movement.php");

/****
$date = DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-29 18:45:06');

try {
 * **/
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/invtext.ini");/**
	$movement = new Movement(null, 2, 5, 3, 4, 4, 6.25, $date, "TR", 8.50);
	$movement->insert($pdo);
	var_dump($movement);
} catch(PDOException $pdoException) {
	// handle PDO errors
	throw(new PDOException($pdoException->getMessage(), 0, $pdoException));
} catch(Exception $exception) {
	// handle other errors
	throw(new Exception($exception->getMessage(), 0, $exception));
}
****/

$movement_dump = Movement::getAllMovements($pdo);

$stringStart = "<table>";
$tableHeaders = "<thead><tr><th>Movement ID</th><th>From Location ID</th><th>To Location ID</th><th>Product ID</th><th>Unit ID</th>
									 <th>User ID</th><th>Cost</th><th>Movement Date</th><th>Movement Type</th><th>Price</th></tr></thead>";
echo "$stringStart $tableHeaders";

foreach($movement_dump as $index) {
	echo $index;
}

echo "</table>";

$allMovement3 = Movement::getMovementByMovementId($pdo, 4);

$stringStart = "<table>";
$tableHeaders = "<thead><tr><th>Movement ID</th><th>From Location ID</th><th>To Location ID</th><th>Product ID</th><th>Unit ID</th>
									 <th>User ID</th><th>Cost</th><th>Movement Date</th><th>Movement Type</th><th>Price</th></tr></thead>";
echo "$stringStart $tableHeaders $allMovement3";
echo "</table>";

$allMovementUser = Movement::getMovementByUserId($pdo, 1);

$stringStart = "<table>";
$tableHeaders = "<thead><tr><th>Movement ID</th><th>From Location ID</th><th>To Location ID</th><th>Product ID</th><th>Unit ID</th>
									 <th>User ID</th><th>Cost</th><th>Movement Date</th><th>Movement Type</th><th>Price</th></tr></thead>";
echo "$stringStart $tableHeaders";

foreach($allMovementUser as $index) {
	echo $index;
}
echo "</table>";

?>