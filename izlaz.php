<?php 
require('includes/config.php'); 
$artikliKomadi=$novo_zaduzenje="";

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

//if dont have permitions redirect to arhiva.php
if($_SESSION['status']<2){ header('Location: arhiva.php'); }

//define page title
$title = 'Magacin - Izlaz';

require('classes/Database.php');

$id_korisnika = $_SESSION['id_korisnika'];
$id_member = $_SESSION['memberID'];

$database = new Database;

//Upit za popunjavanje "option" artikala
$database->query("SELECT * FROM artikli WHERE id_korisnika='$id_korisnika' AND status='1' ");
$rows_artikli = $database->resultset();

//Upit za popunjavanje "option" gradiliste
$database->query("SELECT * FROM gradiliste WHERE id_korisnika='$id_korisnika' AND status='1' ");
$rows_gradilista = $database->resultset();

//Upit za popunjavanje "option" radnici
$database->query("SELECT * FROM radnici WHERE id_korisnika='$id_korisnika' AND status='1' ");
$rows_radnici = $database->resultset();

$today = date("Y-m-d");



//kliknuto je "IZLAZ"---------------------------------------------------
if(isset($_POST["submit"])){
	$datum_izlaza = strip_tags($_POST['datum']);
		$datum_zaduzenja = substr($datum_izlaza, 2); //brisanje prva dva karaktera iz stringa (npr. 2018-04-18 = 18-04-18)
		$datum_zaduzenja = str_replace("-","",$datum_zaduzenja); // brisanje karaktera "-", tj. zamena za "" (npr. 18-04-18 = 180418)
	$otpremnica = strip_tags($_POST['otpremnica']);
	$gradiliste = strip_tags($_POST['gradiliste']);	
	$napomena = strip_tags($_POST["napomena"]);
	$radnik = strip_tags($_POST['radnik']);	
	$num_of_rows = strip_tags($_POST["number_of_rows"]);
	
	$database->query("SELECT * FROM gradiliste WHERE id_korisnika='$id_korisnika' AND naziv_gradiliste='$gradiliste' ");
	$gradilista = $database->resultsetAssoc();
	$id_gradilista = $gradilista['id_gradilista'];
	
	if($id_gradilista == ""){
		$database->query("INSERT INTO gradiliste (id_korisnika, naziv_gradiliste, status) VALUES (:id_korisnika, :naziv_gradiliste, :status) ");
				
		$database->bind(':id_korisnika', $id_korisnika);
		$database->bind(':naziv_gradiliste', $gradiliste);
		$database->bind(':status', "1");
		
		$database->execute();
		
		$id_gradilista = $database->lastInsertId();
	}
	
	
	$database->query("SELECT * FROM radnici WHERE id_korisnika='$id_korisnika' AND ime='$radnik' ");
	$radnici = $database->resultsetAssoc();
	$id_radnika = $radnici['id_radnika'];
				
	$cena = 0; //Nije definisana cena artikla za magacin
	$i=0;
	while($i<$num_of_rows){ // petlja za izlistavanje stavki iz fakture
		if(isset($_POST["artikal".$i])){
			$artikal = strip_tags($_POST["artikal".$i]);
			$mera = strip_tags($_POST["mera".$i]);
			$kolicina = strip_tags($_POST["kolicina".$i]);
			$zaduzenje = "0";
			
			$database->query("SELECT * FROM artikli WHERE id_korisnika='$id_korisnika' AND artikal='$artikal' AND jedinica_mere='$mera' ");
			$artikli = $database->resultsetAssoc();

			$artikalId = $artikli["id_artikla"];
			$stanje = $artikli["stanje"];
			
			if($artikalId == ""){  //Ako artikla nema u bazi upisuje se novi artikal
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
			
			if(isset($_POST["zaduzenje".$i])){ //Ako je cekirano zaduzenje
				$database->query("SELECT * FROM radnici WHERE id_korisnika='$id_korisnika' AND status='1' AND ime='$radnik' AND zaduzenje LIKE '%,$artikalId/%'");
				$count = $database->resultsetAssoc(); 
			
				$database->query("SELECT * FROM radnici WHERE id_korisnika='$id_korisnika' AND ime='$radnik' ");
				$radnici = $database->resultsetAssoc();
				$staro_zaduzenje = $radnici['zaduzenje'];
				
				if($count["id_radnika"] != ""){ //ako je artikal vec zaduzivan					
					$zaduzenje_array = explode(",", $staro_zaduzenje);
					
					foreach($zaduzenje_array as $zaduzenje){
						
				//	echo "<script>alert('zaduzenje: ".$zaduzenje."');</script>";	
						
						if($zaduzenje != ""){
							$zaduzenje_part = explode("/", $zaduzenje);
								$part1 = $zaduzenje_part[0];
								$part2 = $zaduzenje_part[1];
								$part3 = $zaduzenje_part[2];
								
							if($part1 == $artikalId){ // ako vec postoji zaduzenje sa istim artiklom dodaje se nova kolicina zaduzenja i novi datum
								$part2 = $part2 + $kolicina; //zbirna kolicina zaduzenja
								$part3 = $part3 . "+" . $datum_zaduzenja; // dodavanje datuma zaduzenja
								$zaduzenje_dodato = array ($part1,$part2,$part3); //pravljenje niza (id,kolicina,datum)
								$zaduzenje = implode("/",$zaduzenje_dodato); //pretvaranje niza u string
								$zaduzenje = ",".$zaduzenje; //dodavanje zareza ispred 
							}
							else{ // ako artikal nije u trekucoj iteraciji zaduzenja ono se vraca u prvobitan oblik bez ikakvih izmena
								$zaduzenje = array($part1,$part2,$part3); //pravljenje niza
								$zaduzenje = implode("/",$zaduzenje); //pretvaranje niza u string
								$zaduzenje = ",".$zaduzenje;
							}
							$novo_zaduzenje .= $zaduzenje; //pravljenje stringa za unos u bazu
						}
					}
					
					
				}
				else{
					$novo_zaduzenje = $staro_zaduzenje.",".$artikalId."/".$kolicina."/".$datum_zaduzenja;
				}
				
				$database->query("UPDATE radnici SET zaduzenje=:zaduzenje WHERE id_radnika='$id_radnika' ");
				$database->bind(':zaduzenje', $novo_zaduzenje);				
				$database->execute();
				
				$novo_stanje = $stanje - $kolicina;
				
				//upis kolicine u stanje artikla
				$database->query("UPDATE artikli SET stanje=:novo_stanje WHERE id_artikla='$artikalId' ");
				$database->bind(':novo_stanje', $novo_stanje);				
				$database->execute();
				
				$artikalId = ""; //da se nebi smanjilo stanje artikla
			}
			
			
			if($artikalId != "" && $kolicina != "" && $id_radnika!=""){
				$novo_stanje = $stanje - $kolicina;
				
				//upis kolicine u stanje artikla
				$database->query("UPDATE artikli SET stanje=:novo_stanje WHERE id_artikla='$artikalId' ");
				$database->bind(':novo_stanje', $novo_stanje);				
				$database->execute();

				$artikalKomada = $artikalId."/".$kolicina."/".$cena." ";  //par "artikal"/"komada"/"cena"
				$artikliKomadi .=  ",".$artikalKomada;  //------String koji sadrzi parove "artikal"/"komada/cena"---------------//
			}
			else{
				if($id_radnika == ""){echo "<script type='text/javascript'> alert('Morate odabrati radnika koji je na listi zaposlenih') </script>";}
				$artikalKomada = "";
			}

		}
		$i++;
	}
	$artikliKomadi = rtrim($artikliKomadi, ","); //brisanje poslednjeg zareza (koji razdvaja parove artika/komada) iz stringa
	
	if($artikliKomadi != "" && $id_radnika != ""){
		
		$database->query("INSERT INTO izlaz (id_korisnika, datum, br_fakture, id_gradilista, napomena, id_radnika, artikli_kolicina_cena, id_member, status) VALUES (:id_korisnika, :datum, :br_fakture, :id_gradilista, :napomena, :id_radnika, :artikli_kolicina_cena, :id_member, :status) ");
		

		$database->bind(':id_korisnika', $id_korisnika);
		$database->bind(':datum', $datum_izlaza);
		$database->bind(':br_fakture', $otpremnica);
		$database->bind(':id_gradilista', $id_gradilista);
		$database->bind(':napomena', $napomena);
		$database->bind(':id_radnika', $id_radnika);
		$database->bind(':artikli_kolicina_cena', $artikliKomadi);
		$database->bind(':id_member', $id_member);
		$database->bind(':status', "1");
		
		$database->execute();
	}
	else{
		if($id_radnika == ""){echo "<script type='text/javascript'> alert('Morate odabrati radnika koji je na listi zaposlenih') </script>";}
	    if($artikliKomadi == ""){echo "<script type='text/javascript'> alert('Morate uneti bar jedan artikal') </script>";}
	}

} // END "UNESI"-------------------------------------------------------------------------------------

//include header template
require('layout/header.php'); 
?>

<script>
		document.getElementById("n1").style.color = "white";
</script>

<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-8 col-sm-offset-1 ">   
			<h1 class="text-center"> IZLAZ </h1>
			<div class="porudzbina">
				<form method="post" action="">
				
					Datum: <input type="date" name="datum" value="<?php echo $today;  ?>"><br><br> 
					Otpremnica: <input type="text" id="otpremnica" name="otpremnica" size="9"><br><br>
					Gradiliste: <input class="awesomplete" name="gradiliste" list="gradilista" value=""  size="28" required autofocus>
										<datalist id="gradilista">
											<?php
												foreach($rows_gradilista as $row){
													echo '<option >'.$row['naziv_gradiliste'].'</option>';
												}	
											?>
										</datalist><br><br>
					Napomena: <input type="text" name="napomena" size="20"><br><br>
					Ime i prezime: <input class="awesomplete" name="radnik" list="radnici" value="" size="28" required>
										<datalist id="radnici">
											<?php
												foreach($rows_radnici as $row){
													echo '<option >'.$row['ime'].'</option>';
												}	
											?>
										</datalist><br><br>
					
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
									<input class="awesomplete" name="artikal<?php echo $i; ?>"  id="artikal<?php echo $i; ?>"  onblur="autofillArtikal(this,'<?php echo $i; ?>','ulaz')" list="artikli" value="" style="font-size:12.5px;" size="36" required>
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
								<td class="col col-lg-2">
									<input type="text" name="kolicina<?php echo $i;?>" id="kolicina<?php  echo $i ?>"  size="2"> &nbsp
									<input type="checkbox" name="zaduzenje<?php echo $i;?>" value="1">
								</td>
							</tr>
							
							
							<tr class="row" id="tr<?php $i=$i+1; echo $i; ?>">
								<td class="col col-lg-1"><?php echo $i; ?></td>
								<td class="col col-lg-5">
									<input class="awesomplete" name="artikal<?php echo $i; ?>"  id="artikal<?php echo $i; ?>" onfocus="createNewInput('<?php echo $i; ?>')" onblur="autofillArtikal(this,'<?php echo $i; ?>','ulaz')" list="artikli" value="" style="font-size:12.5px;" size="36" >
								</td>								
								<td class="col col-lg-2"><input type="text" id="mera<?php  echo $i;?>" name="mera<?php  echo $i;?>" size="2"></td>
								<td class="col col-lg-2" name="stanje<?php  echo $i ?>" id="stanje<?php  echo $i ?>"> </td>
								<td class="col col-lg-2">
									<input type="text" name="kolicina<?php echo $i;?>" id="kolicina<?php  echo $i ?>"  size="2"> &nbsp
									<input type="checkbox" name="zaduzenje<?php echo $i;?>" value="1">
								</td>
							</tr>

							
					</table>
					<input type="hidden" name="number_of_rows" id="number_of_rows" value="2">
					<input type="submit" id="button_unos" name="submit" class="btn btn-success izlaz-btn" value="IZLAZ">
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






