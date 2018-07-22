<?php 
require('includes/config.php'); 
require('classes/Database.php');

$id_korisnika = $_SESSION['id_korisnika'];

$database = new Database;


if(isset($_GET["driver"])){
	$driver_name = strip_tags($_GET["driver"]);
	
	if (isset($_GET['query'])){
		$zahtev = strip_tags($_GET["query"]);
		
		$database->query("SELECT * FROM drivers WHERE id_korisnika='$id_korisnika' AND status='1' AND driver_name='$driver_name' ");
		$rows_artikli = $database->resultsetAssoc();
		
		$odgovor = $rows_artikli[$zahtev];
	
		
		echo $odgovor;
	}
}
?>