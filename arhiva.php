<?php
require('includes/config.php'); 
$artikliKomadi="";

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

//define page title
$title = 'Magacin - Arhiva';

require('classes/Database.php');

$id_korisnika = $_SESSION['id_korisnika'];
$id_member = $_SESSION['memberID'];

$database = new Database;

//include header template
require('layout/header.php'); 
?>
<script>
		$("#n3").css("color", "white");
</script>


<div class="container">

	<div class="row">
					
	    <div class="col-xs-12 col-sm-10 col-md-10 col-sm-offset-1 col-md-offset-1">   
			<h1 class="text-center" id="kategorija_naslov"> ARHIVA </h1>
			
			<div class="menu"> <!-- Podmeni -->
				<ul class="menulist">
					<li><a href="kategorija_artikli"><button class="btn btn-primary select-kat" name="artikli" id="artikli">Artikli</button></a></li>
					<li><a href="kategorija_ulaz"><button class="btn btn-primary select-kat" name="ulaz" id="ulaz">Ulaz</button></a></li>
					<li><a href="kategorija_izlaz"><button class="btn btn-primary select-kat" name="izlaz" id="izlaz">Izlaz</button></a></li>
					<li><a href="kategorija_zaduzenje"><button class="btn btn-primary select-kat" name="zaduzenje" id="zaduzenje">Zaduzenje</button></a></li>
					<li><a href="kategorija_radnici"><button class="btn btn-primary select-kat" name="radnici" id="radnici">Radnici</button></a></li>	
					<li><a href="kategorija_gradilista"><button class="btn btn-primary select-kat" name="gradilista" id="gradilista">Gradilista</button></a></li>
				</ul>	
			</div>   <!-- END menu -->
			
			<br>













