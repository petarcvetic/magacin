<?php 
require('includes/config.php'); 
$artikliKomadi="";
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

//define page title
$title = 'Magacin - Ulaz';

require('classes/Database.php');

$id_korisnika = $_SESSION['id_korisnika'];
$id_member = $_SESSION['memberID'];

if($_SESSION['status']<2){
	header('Location: arhiva.php'); 
}
	
$database = new Database;

//Upit za popunjavanje "option" artikala
$database->query("SELECT * FROM artikli WHERE id_korisnika='$id_korisnika' AND status='1' ");
$rows_artikli = $database->resultset();

$database->query("SELECT * FROM dobavljaci WHERE id_korisnika='$id_korisnika' AND status='1' ");
$rows_dobavljaci = $database->resultset();

$today = date("Y-m-d");

//kliknuto je "UNESI"---------------------------------------------------
if(isset($_POST["submit"])){
	$datum = strip_tags($_POST['datum']);
	$dobavljac = strip_tags($_POST['dobavljac']);
	$otpremnica = strip_tags($_POST['otpremnica']);
	$num_of_rows = strip_tags($_POST["number_of_rows"]);
	$napomena = strip_tags($_POST["napomena"]);
	//provera da li je vec kreiran dobavljac, ako nije kreira se
	$database->query("SELECT * FROM dobavljaci WHERE id_korisnika='$id_korisnika' AND naziv_dobavljaca='$dobavljac' ");
	$dobavljaci = $database->resultsetAssoc();

	$id_dobavljaca = $dobavljaci["id_dobavljaca"];
	
	if($id_dobavljaca == ""){
		$database->query("INSERT INTO dobavljaci (id_korisnika, naziv_dobavljaca, status) VALUES (:id_korisnika, :dobavljac, :status) ");
				
		$database->bind(':id_korisnika', $id_korisnika);
		$database->bind(':dobavljac', $dobavljac);
		$database->bind(':status', "1");
		
		$database->execute();
		
		$id_dobavljaca = $database->lastInsertId();
	}
	
		
	$cena = 0; //Nije definisana cena artikla za magacin
	$i=0;
	while($i<$num_of_rows){ // petlja za izlistavanje stavki iz fakture
		if(isset($_POST["artikal".$i])){
			$artikal = strip_tags($_POST["artikal".$i]);
			$mera = strip_tags($_POST["mera".$i]);
			$kolicina = strip_tags($_POST["kolicina".$i]);
			
			
			$database->query("SELECT * FROM artikli WHERE id_korisnika='$id_korisnika' AND artikal='$artikal' AND jedinica_mere='$mera' ");
			$artikli = $database->resultsetAssoc();

			$artikalId = $artikli["id_artikla"];
			$stanje = $artikli["stanje"];
			
			if($artikalId == "" && $artikal != "" && $mera != ""){  //Ako artikla nema u bazi upisuje se novi artikal
				$database->query("INSERT INTO artikli (id_korisnika, artikal, jedinica_mere, cena, stanje, status) VALUES (:id_korisnika, :artikal, :jedinica_mere, :cena, :stanje, :status) ");
				
				$database->bind(':id_korisnika', $id_korisnika);
				$database->bind(':artikal', $artikal);
				$database->bind(':jedinica_mere', $mera);
				$database->bind(':cena', $cena);
				$database->bind(':stanje', "0");
				$database->bind(':status', "1");
				
				$database->execute();
				
				$artikalId = $database->lastInsertId();
				$stanje = 0;
			}
			
			if($artikalId!="" && $kolicina!=""){
				$novo_stanje = $stanje + $kolicina;
				
				//upis kolicine u stanje artikla
				$database->query("UPDATE artikli SET stanje=:novo_stanje WHERE id_artikla='$artikalId' ");
				$database->bind(':novo_stanje', $novo_stanje);				
				$database->execute();
				
				
				
				$artikalKomada = $artikalId."/".$kolicina."/".$cena." ";  //par "artikal"/"komada"/"cena"
				$artikliKomadi .=  ",".$artikalKomada;  //------String koji sadrzi parove "artikal"/"komada"---------------//
				
			}
			else{
				$artikalKomada = "";
			}

		}
		$i++;
	}
	$artikliKomadi = rtrim($artikliKomadi, ","); //brisanje poslednjeg zareza (koji razdvaja parove artika/komada) iz stringa
	
	if($artikliKomadi != ""){
		
		$database->query("INSERT INTO ulaz (id_korisnika, datum, br_fakture, id_dobavljaca, napomena, artikli_kolicina_cena, id_member, status) VALUES (:id_korisnika, :datum, :br_fakture, :id_dobavljaca, :napomena, :artikli_kolicina_cena, :id_member, :status) ");

		$database->bind(':id_korisnika', $id_korisnika);
		$database->bind(':datum', $datum);
		$database->bind(':br_fakture', $otpremnica);
		$database->bind(':id_dobavljaca', $id_dobavljaca);
		$database->bind(':napomena', $napomena);
		$database->bind(':artikli_kolicina_cena', $artikliKomadi);
		$database->bind(':id_member', $id_member);
		$database->bind(':status', "1");
		
		$database->execute();
	}
	else{
		echo "<script type='text/javascript'> alert('DOSLO JE DO GRESKE PRI POVEZIVANJU SA BAZOM') </script>";
	}

} // END "UNESI"-------------------------------------------------------------------------------------

//include header template
require('layout/header.php'); 

?>

<script>
		document.getElementById("n2").style.color = "white";
</script>

<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-8 col-sm-offset-1 ">   
			<h1 class="text-center"> ULAZ </h1>
			<div class="porudzbina">
				<form method="post" action="">
				
					Datum: <input type="date" name="datum" value="<?php echo $today;  ?>"><br><br> 
					Dobavljač: <input  name="dobavljac" list="dobavljaci" value="" size="36" autofocus required>
										<datalist id="dobavljaci">
											<?php
												foreach($rows_dobavljaci as $row){
													echo '<option >'.$row['naziv_dobavljaca'].'</option>';
												}	
											?>
										</datalist><br><br>
					Br. otpremnice: <input type="text" name="otpremnica"><br><br>
					Napomena: <input type="text" name="napomena"><br><br>
					<table class="table table-bordered text-center" id="tabela">
						<tr class="row" id="tr">
							<td class="col col-lg-1"><b>Br.</b></td>
							<td class="col col-lg-5"><b>ARTIKAL</b></td>
							<td class="col col-lg-2"><b>J.M.</b></td>
							<td class="col col-lg-2"><b>STANJE</b></td>							
							<td class="col col-lg-2"><b>KOLICINA</b></td>						
						</tr>
						
						
						<?php
							$i=0;
						?>
							
							<tr class="row" id="tr<?php $i=$i+1; echo $i; ?>">
								<td class="col col-lg-1"><?php echo $i; ?></td>
								<td class="col col-lg-5">
									<input class="awesomplete" name="artikal<?php echo $i; ?>"  id="artikal<?php echo $i; ?>"  onblur="autofillArtikal(this,'<?php echo $i; ?>','ulaz')" list="artikli" value="" size="36" required>
										<datalist id="artikli">
											<?php
												foreach($rows_artikli as $row){
													echo '<option >'.$row['artikal'].'</option>';
												}	
											?>
										</datalist>
								</td>
								
								<td class="col col-lg-2"><input type="text" id="mera<?php  echo $i;?>" name="mera<?php  echo $i;?>" size="2"></td>
								<td class="col col-lg-2" name="stanje<?php  echo $i ?>" id="stanje<?php  echo $i ?>"> </td>
								<td class="col col-lg-2"><input type="text" name="kolicina<?php echo $i;?>" id="kolicina<?php  echo $i ?>" size="2"></td>
							</tr>
							
							
							<tr class="row" id="tr<?php $i=$i+1; echo $i; ?>">
								<td class="col col-lg-1"><?php echo $i; ?></td>
								<td class="col col-lg-5">
									<input class="awesomplete" name="artikal<?php echo $i; ?>"  id="artikal<?php echo $i; ?>" onfocus="createNewInput('<?php echo $i; ?>')" onblur="autofillArtikal(this,'<?php echo $i; ?>','ulaz')" list="artikli" value="" size="36" >
								</td>								
								<td class="col col-lg-2"><input type="text" id="mera<?php  echo $i;?>" name="mera<?php  echo $i;?>" size="2"></td>
								<td class="col col-lg-2" name="stanje<?php  echo $i ?>" id="stanje<?php  echo $i ?>"> </td>
								<td class="col col-lg-2"><input type="text" name="kolicina<?php echo $i;?>" id="kolicina<?php  echo $i ?>"  size="2"></td>
							</tr>

							
					</table>
					<input type="hidden" name="number_of_rows" id="number_of_rows" value="2">
					<input type="submit" id="button_unos" name="submit" class="btn btn-success izlaz-btn" value="UNESI">
				</form>
			</div>
		
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

<script type="text/javascript">

</script>