<?php

$servername ="localhost";
$dBUsername ="root";
$dBPassword ="";
$dBName ="lorcards";

$pdo = new PDO("mysql:host=$servername;dbname=$dBName", $dBUsername, $dBPassword);

session_start();

?>