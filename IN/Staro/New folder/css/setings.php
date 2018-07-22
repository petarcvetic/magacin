<?php 
$firma=$firmaId=$brFakture=$val=$datum=$firmaStaro="";
require_once('connect.inc.php');
include('header.inc.php');

//--------------KLIKNUTO JE "IZMENI KUPCA" ------------------------------------------------
if(isset($_POST['izmeni'])){
	$firmaID = strip_tags($_POST["firmaHidden"]);
	$firmaNovo = strip_tags($_POST["firmaEdit"]);
	$adresa = strip_tags($_POST["adresaEdit"]);
	$mesto = strip_tags($_POST["mestoEdit"]);
	$pib = strip_tags($_POST["pibEdit"]);
	$matBr = strip_tags($_POST["matBrEdit"]);

	if(isset($_POST["block"])){
		$status = strip_tags($_POST["block"]);
	}
	else{
		$status=0;
	}


	if($firmaID!=="" && $firmaNovo!=="" && $adresa!=="" && $mesto!=="" && $pib!==""){
		$query = mysqli_query($conn, "UPDATE kupci SET naziv_kupca='$firmaNovo', adresa_kupca='$adresa', mesto_kupca='$mesto', pib_kupca='$pib', mat_broj='$matBr', status_kupca='$status'  WHERE id_kupca='$firmaID' ");
	}
}

//-----------KLIKNUTO JE "DODAJ ARTIKAL"---------------------------------------
if(isset($_POST['dodaj_artikal'])){
	$novi_artikal = strip_tags($_POST['novi_artikal']);
	$nova_mera = strip_tags($_POST['nova_mera']);
	$nova_cena = strip_tags($_POST['nova_cena']);
	$novi_pdv = strip_tags($_POST['novi_pdv']);
	
	$find = mysqli_query($conn,"SELECT * FROM artikli WHERE id_korisnika='$idKorisnika' AND artikal='$novi_artikal'");
	
	if(mysqli_num_rows($find)==0){
		$query = mysqli_query($conn,"INSERT INTO artikli (id_korisnika,artikal,jedinica_mere,cena,pdv) VALUE('$idKorisnika','$novi_artikal','$nova_mera','$nova_cena','$novi_pdv') ");
	}
	else{
		echo "<script> alert ('OVAJ ARTIKAL VEC POSTOJI U BAZI!'); </script>";
	}
}

//--------------KLIKNUTO JE "IZMENI ARTIKAL" ------------------------------------------------
if(isset($_POST['izmeni_artikal'])){
	$idArtikla = strip_tags($_POST["artikalHidden"]);
	$edit_artikal = strip_tags($_POST["edit_artikal"]);
	$edit_mera = strip_tags($_POST['edit_mera']);
	$edit_cena = strip_tags($_POST["edit_cena"]);
	$edit_pdv = strip_tags($_POST["edit_pdv"]);
	
	if(isset($_POST["blockArtical"])){
		$statusArtikla = strip_tags($_POST["blockArtical"]);
	}
	else{
		$statusArtikla=0;
	}
	
	if($idArtikla!=="" && $edit_artikal!=="" && $edit_mera!=="" && $edit_cena!=="" && $edit_pdv!==""){

		$query = mysqli_query($conn, "UPDATE artikli SET artikal='$edit_artikal', jedinica_mere='$edit_mera', cena='$edit_cena', pdv='$edit_pdv', status_artikla='$statusArtikla' WHERE id_artikla='$idArtikla' ");
	}
	else{
		echo "<script> alert ('SVA POLJA MORAJU BITI POPUNJENA!'); </script>";
	}
}

if (logged_in()){ //Ako je korisnik ulogovan prikazuje se sledeca (redovna) stranica
?>

	<!-- EDITOVANJE KUPACA -->	
	<div class="editKupaca">
		<form method="post" action="">
			<fieldset class="fieldset">
				<legend>&nbsp;EDIT  KUPCA&nbsp;</legend>
				<input type="hidden" id="firmaHidden" name="firmaHidden" value=""><br>
				Kupac:  &nbsp; <input class="awesomplete" onblur="autofill(this,'edit')" name="firmaEdit" id="firmaEdit" list="kupci" value=""> <br><br>
					<datalist id="kupci">  
						<?php
							$kupci = mysqli_query($conn,"SELECT * FROM kupci WHERE id_korisnika='$idKorisnika'");
							while ($row = mysqli_fetch_assoc($kupci)) {
								echo '<option >'.$row['naziv_kupca'].'</option>';
							}	
						?>
					</datalist>	
				Adresa: &nbsp; <input id="adresa" name="adresaEdit" type="text" class="kupacInfo"><br><br>
				Mesto: &nbsp; <input id="mesto" name="mestoEdit" type="text" class="kupacInfo"><br><br>
				PIB:<input id="pib" name="pibEdit" type="text" class="kupacInfo"><br><br>
				Mat. broj:<input id="matBr" name="matBrEdit" type="text" class="kupacInfo">	<br><br>
				Blokiraj kupca<input id="block" name="block" type="checkbox" value="1">     
				<button type="submit" class="submit" name="izmeni">Izmeni</button> 
			</fieldset>
		</form>	
	</div> <!-- END EDITOVANJE KUPACA --> 

	
<!-- NOVI ARTIKAL -->
	<div id="noviArtikal" class="editKupaca">
		<form method="post" action="">
			<fieldset class="fieldset">
				<legend>&nbsp;NOVI ARTIKAL&nbsp;</legend><br>
				Artikal: &nbsp;  <input type="text" name="novi_artikal" class="kupacInfo"><br><br>
				Jed. mere:<input type="text" name="nova_mera" class="kupacInfo"  size="10"><br><br>
				Cena:<input type="text" name="nova_cena" class="kupacInfo"  size="10"><br><br>
				PDV:<input type="text" name="novi_pdv" class="kupacInfo" value="20"  size="10"><br><br>
				<button type="submit" class="submit" name="dodaj_artikal">Dodaj artikal</button> 
			</fieldset>
		</form>
	</div> <!--END NOVI ARTIKAL -->
	
<!-- EDIT ARTIKLA -->
	<div class="editKupaca">
		<form method="post" action="">
			<fieldset class="fieldset">
				<legend>&nbsp;EDIT ARTIKLA&nbsp;</legend><br>
				<input type="hidden" id="hidden" name="artikalHidden" value="">
				Artikal: &nbsp; <input class="awesomplete"  name="edit_artikal"  id="artikal1"  onblur="autofillArtikal(this,'1','edit')" list="artikli" value="" ><br><br>
							<datalist id="artikli">
								<?php
									$artikli = mysqli_query($conn,"SELECT * FROM artikli WHERE id_korisnika='$idKorisnika' ");
									while ($row = mysqli_fetch_assoc($artikli)) {
										echo '<option >'.$row['artikal'].'</option>';
									}	
								?>
							</datalist>
				Jed. mere:<input type="text" id="mera" name="edit_mera" class="kupacInfo" size="10"><br><br>			
				Cena:<input type="text" id="cena1" name="edit_cena" class="kupacInfo"  size="10"><br><br>
				PDV:<input type="text" id="pdv" name="edit_pdv" class="kupacInfo" value="20"  size="10"><br><br>
				Blokiraj kupca<input id="blockArtical" name="blockArtical" type="checkbox" value="1">     
				<button type="submit" class="submit" name="izmeni_artikal">Izmeni artikal</button> 
			</fieldset>
		</form>
	</div> <!--END EDIT ARTIKLA -->	

<?php
	}
	else{
		header ('Location:index.php');
	}
	include_once ('footer.inc.php');
?>

</div> <!-- END wrapper -->
</body>
</html>