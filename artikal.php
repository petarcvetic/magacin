<?php 
require('includes/config.php'); 
require('classes/Database.php');

$id_korisnika = $_SESSION['id_korisnika'];

$database = new Database;


if(isset($_GET["artikal"])){
	$naziv = strip_tags($_GET["artikal"]);
	
	if (isset($_GET['zahtev'])){
		$zahtev = strip_tags($_GET["zahtev"]);
		
		$database->query("SELECT * FROM artikli WHERE id_korisnika='$id_korisnika' AND status='1' AND artikal='$naziv'");
		$rows_artikli = $database->resultsetAssoc();
		
		$odgovor = $rows_artikli[$zahtev];
	
		
		echo $odgovor;
	}
}
?>
