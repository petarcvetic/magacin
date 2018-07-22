<?php
$conn = mysqli_connect("mysql525.loopia.se","mburger@m34873","nefertiti1205","mburger_rs_db_2");

mysqli_query($conn, 'SET NAMES utf8');

if(!$conn){
	echo "Konekcija nije uspela!";
}


?>
