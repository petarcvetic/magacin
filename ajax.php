<?php
require('includes/config.php'); 
require('classes/Database.php');
$id_korisnika = $_SESSION['id_korisnika'];
$database = new Database;


if (isset($_GET['akcija'])){
	$akcija = $_GET['akcija'];
	$id = $_GET['id'];
	$value = $_GET['value'];
	
	if($akcija == "ulaz"){
		$database->query("SELECT * FROM artikli WHERE id_korisnika='$id_korisnika' AND status='1' AND id_artikla='$id' ");
		$row = $database->resultsetAssoc();
		$staroStanje = $row["stanje"];
		
		$novoStanje = $staroStanje + $value;
		
		$database->query('UPDATE artikli SET stanje = :stanje WHERE id_artikla = :id');
		$database->bind(':stanje', $novoStanje);
		$database->bind(':id', $id);
		$database->execute();
		
		$database->query("SELECT * FROM artikli WHERE id_korisnika='$id_korisnika' AND status='1' AND id_artikla='$id' ");
		$row = $database->resultsetAssoc();
		$stanje = $row["stanje"];
		echo $stanje;
	}
	
	
	if ($akcija == "radnik"){
		$zahtev = $value;
		
		$database->query("SELECT * FROM radnici WHERE id_korisnika='$id_korisnika' AND id_radnika='$id' ");
		$row = $database->resultsetAssoc();
		echo $row[$zahtev];
	}
	
	if ($akcija == "artikal"){
		$zahtev = $value;
		
		$database->query("SELECT * FROM artikli WHERE id_korisnika='$id_korisnika' AND id_artikla='$id' ");
		$row = $database->resultsetAssoc();
		echo $row[$zahtev];
	}
}



?>