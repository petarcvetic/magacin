<?php
require('includes/config.php'); 
require('classes/Database.php');
$id_korisnika = $_SESSION['id_korisnika'];
$database = new Database;

if (isset($_GET[''])){
	$akcija = $_GET['akcija'];
	$id = $_GET['id'];
	$value = $_GET['value'];


?>