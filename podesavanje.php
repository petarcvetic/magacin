<?php 
require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

//define page title
$title = 'Magacin - Podesavanje';

require('classes/Database.php');

$id_korisnika = $_SESSION['id_korisnika'];
$id_member = $_SESSION['memberID'];
	
$database = new Database;



$today = date("Y-m-d");

//kliknuto je "Unos_radnika"---------------------------------------------------
if(isset($_POST["unos_radnika"])){
	$ime = strip_tags($_POST['ime']);
	$id_kartica = strip_tags($_POST['id_kartica']);
	$telefon = strip_tags($_POST['telefon']);
	$radno_mesto = strip_tags($_POST["radno_mesto"]);
	$odelo = strip_tags($_POST["odelo"]);
	$cipele = strip_tags($_POST["cipele"]);
	$majica = strip_tags($_POST["majica"]);
	
	//provera da li je vec radnik
	$database->query("SELECT * FROM radnici WHERE id_korisnika='$id_korisnika' AND ime='$ime' AND id_kartica='$id_kartica' ");
	$radnik = $database->resultsetAssoc();

	$id_radnika = $radnik["id_radnika"];
	
	if($id_radnika == ""){
		$database->query("INSERT INTO radnici (id_korisnika, id_kartica, ime, telefon, radno_mesto, odelo, cipele, majica, zaduzenje, status) VALUES (:id_korisnika, :id_kartica, :ime, :telefon, :radno_mesto, :odelo, :cipele, :majica, :zaduzenje, :status) ");
		
		$database->bind(':id_korisnika', $id_korisnika);
		$database->bind(':id_kartica', $id_kartica);
		$database->bind(':ime', $ime);
		$database->bind(':telefon', $telefon);
		$database->bind(':radno_mesto', $radno_mesto);
		$database->bind(':odelo', $odelo);	
		$database->bind(':cipele', $cipele);
		$database->bind(':majica', $majica);
		$database->bind(':zaduzenje', "");
		$database->bind(':status', "1");
		
		$database->execute();
		
		$id_dobavljaca = $database->lastInsertId();
	}
	else{echo "<script>alert('Radnik ".$ime." je već u bazi podataka');</script>";}

} // END "Unesi radnika"-------------------------------------------------------------------------------------

//kliknuto je "Edit_radnika"---------------------------------------------------
if(isset($_POST["edit_radnika"])){
	$ime = strip_tags($_POST['ime']);
	$id_radnika = strip_tags($_POST["id_radnika"]);
	$id_kartica = strip_tags($_POST['id_kartica']);
	$telefon = strip_tags($_POST['telefon']);
	$radno_mesto = strip_tags($_POST["radno_mesto"]);
	$odelo = strip_tags($_POST["odelo"]);
	$cipele = strip_tags($_POST["cipele"]);
	$majica = strip_tags($_POST["majica"]);
	$status = strip_tags($_POST["status"]);

	
	if($id_radnika != ""){
		$database->query("UPDATE radnici SET id_kartica = :id_kartica, ime = :ime, telefon = :telefon, radno_mesto = :radno_mesto, odelo = :odelo, cipele = :cipele, majica = :majica, status = :status WHERE id_korisnika = '$id_korisnika' AND id_radnika = '$id_radnika'");

		
		$database->bind(':id_kartica', $id_kartica);
		$database->bind(':ime', $ime);
		$database->bind(':telefon', $telefon);
		$database->bind(':radno_mesto', $radno_mesto);
		$database->bind(':odelo', $odelo);	
		$database->bind(':cipele', $cipele);
		$database->bind(':majica', $majica);
		$database->bind(':status', $status);
		
		$database->execute();
	}
	else{echo "<script>alert('Radnika ".$ime." nema u bazi, nemozete ga editovati');</script>";}

} // END "Unesi radnika"-------------------------------------------------------------------------------------



//kliknuto je "Unos_artikla"---------------------------------------------------
if(isset($_POST["unos_artikla"])){
	$artikal = strip_tags($_POST['artikal']);
	$jedinica_mere = strip_tags($_POST['jedinica_mere']);
	$cena = strip_tags($_POST['cena']);
	$stanje = strip_tags($_POST["stanje"]);
	
	//provera da li je vec radnik
	$database->query("SELECT * FROM artikli WHERE id_korisnika='$id_korisnika' AND artikal='$artikal' AND jedinica_mere='$jedinica_mere' ");
	$artikli = $database->resultsetAssoc();

	$id_artikla = $artikli["id_artikla"];
	
	if($id_artikla == ""){
		$database->query("INSERT INTO artikli (id_korisnika, artikal, jedinica_mere, cena, stanje, status) VALUES (:id_korisnika, :artikal, :jedinica_mere, :cena, :stanje, :status) ");
		
		$database->bind(':id_korisnika', $id_korisnika);
		$database->bind(':artikal', $artikal);
		$database->bind(':jedinica_mere', $jedinica_mere);
		$database->bind(':cena', $cena);
		$database->bind(':stanje', $stanje);
		$database->bind(':status', "1");
		
		$database->execute();
		
		$id_artikla = $database->lastInsertId();
	}
	else{echo "<script>alert('artikal ".$artikal." je već u bazi podataka');</script>";}

} // END "Unesi artikla"-------------------------------------------------------------------------------------

//kliknuto je "Edit_artikla"---------------------------------------------------
if(isset($_POST["edit_artikla"])){
	$artikal = strip_tags($_POST['artikal']);
	$id_artikla = strip_tags($_POST["id_artikla"]);
	$jedinica_mere = strip_tags($_POST['jedinica_mere']);
	$cena = strip_tags($_POST['cena']);
	$stanje = strip_tags($_POST["stanje"]);
	$status = strip_tags($_POST["status"]);

	
	if($id_artikla != ""){
		$database->query("UPDATE artikli SET artikal = :artikal, jedinica_mere = :jedinica_mere, cena = :cena, stanje = :stanje, status = :status WHERE id_korisnika = '$id_korisnika' AND id_artikla = '$id_artikla'");

		
		$database->bind(':artikal', $artikal);
		$database->bind(':jedinica_mere', $jedinica_mere);
		$database->bind(':cena', $cena);
		$database->bind(':stanje', $stanje);
		$database->bind(':status', $status);
		
		$database->execute();
	}
	else{echo "<script>alert('Artikla ".$artikal." nema u bazi, nemozete ga editovati');</script>";}

} // END "Unesi radnika"-------------------------------------------------------------------------------------

//Upit za popunjavanje "option" radnici
$database->query("SELECT * FROM radnici WHERE id_korisnika='$id_korisnika'");
$rows_radnici = $database->resultset();

//Upit za popunjavanje "option" radnici
$database->query("SELECT * FROM artikli WHERE id_korisnika='$id_korisnika'");
$rows_artikli = $database->resultset();

//include header template
require('layout/header.php'); 

?>

<script>
		document.getElementById("n4").style.color = "white";
</script>

<div class="container">

	
		<h1 class="text-center"> PODESAVANJE </h1>
		
	<!-- RADNIK ----------------------------------------------------------------------->
	<div class="row">
	    <div class="col-xs-12 col-sm-8 col-md-3 col-sm-offset-1 ">   			
			<fieldset class="fieldset">
				<legend>&nbsp;Novi radnik&nbsp;</legend><br>
				<form method="post" action="">
					Ime i prezime: <input type="text" class="right" name="ime" autofocus><br>
					Br. kartice: <input type="text" class="right" name="id_kartica"><br>
					Telefon: <input type="text" class="right" name="telefon"><br>
					Radno mesto: <input type="text" class="right" name="radno_mesto"><br>
					Odelo: <input type="text" class="right" name="odelo"><br>
					Cipele: <input type="text" class="right" name="cipele"><br>
					Majica: <input type="text" class="right" name="majica"><br>
					<input type="submit" name="unos_radnika" class="btn btn-success right" value="Unesi">
				</form>
			</fieldset>
		</div>
		
		<div class="col-xs-12 col-sm-8 col-md-3 col-sm-offset-1 ">   			
			<fieldset class="fieldset">
				<legend>&nbsp;Edit radnika&nbsp;</legend><br>
				<form method="post" action="">
					Ime i prezime: <input type="text" class="right" name="ime" onblur="autofillEdit('radnik',7,this)" list="radnik">					
						<datalist id="radnik">
							<?php
								foreach($rows_radnici as $row){
//									echo '<option data-id="'.$row['id_radnika'].'" value="'.$row['id_radnika'].'">'.$row['ime'].'</option>';
									echo '<option data-id="'.$row['id_radnika'].'" value="'.$row['ime'].'"></option>';
								}	
							?>
						</datalist>
					<input type="hidden" id="radnik0" class="right" name="id_radnika"><br>	
					Br. kartice: <input type="text" id="radnik1" class="right" name="id_kartica"><br>
					Telefon: <input type="text" id="radnik2" class="right" name="telefon"><br>
					Radno mesto: <input type="text" id="radnik3" class="right" name="radno_mesto"><br>
					Odelo: <input type="text" id="radnik4" class="right" name="odelo"><br>
					Cipele: <input type="text" id="radnik5" class="right" name="cipele"><br>
					Majica: <input type="text" id="radnik6" class="right" name="majica"><br>
					<input type="radio" class="right" id="radnik_A" name="status" value="1"> Radi<br>
					<input type="radio" class="right" id="radnik_B" name="status" value="0"> Ne radi<br>

					<input type="submit" name="edit_radnika" class="btn btn-success right" value="Edit">
				</form>
			</fieldset>
		</div>
	</div>
	
	<!-- ARTIKAL -------------------------------------------------------------------------------------->
	<div class="row">	
		<div class="col-xs-12 col-sm-8 col-md-3 col-sm-offset-1 ">   			
			<fieldset class="fieldset">
				<legend>&nbsp;Novi artikal&nbsp;</legend><br>
				<form method="post" action="">
					Artikal: <input type="text" class="right" name="artikal" ><br>
					Jedinica mere: <input type="text" class="right" name="jedinica_mere"><br>
					Cena: <input type="text" class="right" name="cena" value="0"><br>
					Stanje: <input type="text" class="right" name="stanje" value="0"><br>
					<input type="submit" name="unos_artikla" class="btn btn-success right" value="Unesi">
				</form>
			</fieldset>
		</div>
		
		<div class="col-xs-12 col-sm-8 col-md-3 col-sm-offset-1 ">   			
			<fieldset class="fieldset">
				<legend>&nbsp;Edit artikla&nbsp;</legend><br>
				<form method="post" action="">
					Artikal: <input type="text" class="right" name="artikal" onblur="autofillEdit('artikal',4,this)" list="artikal"><br>				
						<datalist id="artikal">
							<?php
								foreach($rows_artikli as $row){
									echo '<option data-id="'.$row['id_artikla'].'" value="'.$row['artikal'].'"></option>';
								}	
							?>
						</datalist>
					<input type="hidden" id="artikal0" class="right" name="id_artikla">	
					Jedinica mere: <input type="text" id="artikal1" class="right" name="jedinica_mere"><br>
					Cena: <input type="text" id="artikal2" class="right" name="cena" value="0"><br>
					Stanje: <input type="text" id="artikal3" class="right" name="stanje" value="0"><br>
					<input type="radio" id="artikal_A" class="right" name="status" value="1"> Aktivno<br>
					<input type="radio" id="artikal_B" class="right" name="status" value="0"> Neaktivno<br>

					<input type="submit" name="edit_artikla" class="btn btn-success right" value="Edit">
				</form>
			</fieldset>
		</div>			
	</div> 
 
	
	<div class="">
		<p></p>
	</div>


</div>

<?php 
//include header template
require('layout/footer.php'); 
?>
