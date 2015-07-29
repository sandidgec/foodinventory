<?php

require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once("../php-classes/movement.php");

try {
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/invtext.ini");
	$movement = new Movement(null, 1, 1, 1, 1, 2.50, "2015-07-29", "T", 4.50);
	$movement->insert($pdo);
	var_dump($movement);
} catch(PDOException $pdoException) {
	// handle PDO errors
} catch(Exception $exception) {
	// handle other errors
}

$movement_dump = Movement::getAllMovements($pdo);

foreach($movement_dump as $index) {
	echo $index;
}

?>