<?php
$conn = mysqli_connect("localhost","hsva1215_dks","Become8]Day]]","hsva1215_brainsto_dokrajasveta");

mysqli_query($conn, 'SET NAMES utf8');

if(!$conn){
	echo "Konekcija nije uspela!";
}


?>
