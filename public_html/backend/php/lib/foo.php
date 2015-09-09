<?php
$message = "<h1>You Have No Inventory</h1>";
$messageSanitizeString = filter_var($message, FILTER_SANITIZE_STRING);
$messageEscapeTags = filter_var($message, FILTER_SANITIZE_SPECIAL_CHARS);
var_dump($messageSanitizeString);
var_dump($messageEscapeTags);