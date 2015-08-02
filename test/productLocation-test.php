<?php

require_once("/etc/apache2/data-design/encrypted-config.php");
require_once("../php/classes/productLocation.php");

try {
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/invtext.ini");
	$productLocation = new ProductLocation(1, 1, 1, 200);
	$productLocation->insert($pdo);
	var_dump($productLocation);
} catch(PDOException $pdoException) {
	// handle PDO errors
	throw(new PDOException($pdoException->getMessage(), 0, $pdoException));
} catch(Exception $exception) {
	// handle other errors
	throw(new Exception($exception->getMessage(), 0, $exception));
}

$productLocation_dump = ProductLocation::getAllProductLocations($pdo);

$stringStart = "<table>";
$tableHeaders = "<thead><tr><th>Location ID</th><th>Product ID</th><th>Unit ID</th><th>Quantity</th></tr></thead>";
echo "$stringStart . $tableHeaders";

foreach($productLocation_dump as $index) {
	echo $index;
}

echo "</table>";

?>