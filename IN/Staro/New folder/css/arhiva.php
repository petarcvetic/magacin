<?php 
$firma=$firmaId=$brFakture=$val=$datum=$adminHeader="";
require_once('connect.inc.php');
include('header.inc.php');
$adminStatus = $_COOKIE['status'];


	



function arhiva_header(){

			

	echo "<div id='arhiva'>
			
			<table id='tabelaArhiva' border='1'>
				<tr id='tr'>
					<th class='red'>Faktura</th>
					<th class='opis'>Firma</th>
					<th class='cena'>Datum</th>
					<th class='cena'>Iznos</th>
					<th class='red'>Rabat</th>
					<th class='cena'>Uplaceno</th>
					<th colspan='2'>Valuta</th>
					<th class='uplata'>Uplata</th>"
					.$adminHeader.	
				"</tr>";
}

	
	
// KLIKNUTO JE DUGME "Pretrazi"---------------------------------------------------------------------------------
if (isset($_POST["pretrazi"])){
	//BROJ FAKTURE
		$br = $_POST["brFakture"];
		$q = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM fakture WHERE id_korisnika='$idKorisnika' AND broj_fakture = '$br'"))["id_fakture"];
		if ($q !== ""){
			$brFakture = $q;
		}
		else{$brFakture=""; echo "<script>alert('FAKTURA ".$br." NE POSTOJI');</script>";}
		
	//FIRMA	
		if(isset($_POST["firma"])){
			$firma = $_POST["firma"];
		}
		else{$firma="";}
		
		if($firma !== ""){
			$q = mysqli_query($conn, "SELECT * FROM kupci WHERE naziv_kupca = '$firma'");
			$firmaId = mysqli_fetch_assoc($q)["id_kupca"]; //dobijanje ID-ja kupca
			if(mysqli_num_rows($q) == 0){ // ako nema rezultata u bazi
				echo "<script> alert ('OVE FIRME NEMA U BAZI !'); </script>";
			}
		}
		else{ $firmaId = ""; }
		
	//VALUTA	
		if(isset($_POST["valuta"])){
			$val = $_POST["valuta"];
		}
		else{$val = "";}
	
	//DATUM
		$date = $_POST['datum'];
		if($date !== ""){
			$datum = date("d.m.Y", strtotime($date));
		}
		else{$datum = "";}
}
	$query = mysqli_query($conn,"SELECT * FROM fakture id_korisnika='$idKorisnika' ORDER BY id_fakture DESC");
	
	if($brFakture !== ""){ //ako je u filteru upisan broj fakture
		$query = mysqli_query($conn,"SELECT * FROM fakture WHERE id_fakture='$brFakture'");
	}
	
	if($datum !== ""){  // Ako je u filteru selektovan datum
		$query = mysqli_query($conn,"SELECT * FROM fakture WHERE id_korisnika='$idKorisnika' AND datum='$datum' ORDER BY id_fakture DESC ");
	}

	if($firmaId !== ""){ //Ako je u filteru upisana firma
		$query = mysqli_query($conn,"SELECT * FROM fakture WHERE id_korisnika='$idKorisnika' AND kupac_id='$firmaId' ORDER BY id_fakture DESC");
		if($datum !== ""){ //Ako je u filteru upisana firma i selektovan datum
			$query = mysqli_query($conn,"SELECT * FROM fakture WHERE id_korisnika='$idKorisnika' AND kupac_id='$firmaId' AND datum='$datum' ORDER BY id_fakture DESC");
		}
	}
	
	
	if($brFakture =="" && $firmaId == "" && $datum == ""){
		$query = mysqli_query($conn,"SELECT * FROM fakture WHERE id_korisnika='$idKorisnika' ORDER BY id_fakture DESC");
	}

	$ii=1;
	$i=1;
	
	if (logged_in()){ //Ako je korisnik ulogovan prikazuje se sledeca (redovna) stranica	
	
		if($adminStatus == "3"){
			$adminHeader = "<th class='cena'>Kucao</th>";
		}
		
	
		arhiva_header();
		while($row = mysqli_fetch_assoc($query)){
			$idKupca = $row["kupac_id"];  //id kupca
			$firm = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM kupci WHERE id_kupca = '$idKupca'"))["naziv_kupca"];  //naziv kupca (firme)

			$valuta = strtotime('-'.$row["valuta"].' days');
			$datumFakture = strtotime($row["datum"]);
			if($datumFakture < $valuta){
				$vazno = "ISTEKLA!";	
			}
			else{$vazno = "nije istekla";}
			
			$zaUplatu = $row["ukupno"]*(1-$row["rabat"]/100);
			
			
			
			if($val == "1"){ //ako je cekirano polje filtera "valuta" (pretraga isteklih vauta)		
				if($datumFakture < $valuta){  //ako je istekla valuta
					
					if($adminStatus == "3"){
						$admin = "<th class='cena'>".$row["username"]."</th>";
					}
					else{$admin = "";}
			
					echo  "<tr id='tr".$ii."'>
							<td class='red'><button class='submit' onclick='location.href=".'"faktura.php?br='.$row['id_fakture'].'"'."'>" .$row['broj_fakture']. "</button></td>
							<td class='opis'>".$firm."</td>
							<td class='cena'>".$row["datum"]."</td>
							<td class='cena1'>".$zaUplatu."</td>
							<td class='red'>".$row["rabat"]."%</td>
							<td class='cena' id='uplaceno".$row["id_fakture"]."'>".$row["uplata"]."</td>
							<td>".$row["valuta"]." dana</td>
							<td>".$vazno."</td>
							<td class='uplata'><input type='text' id='uplata".$row["id_fakture"]."' name='uplata".$row["id_fakture"]."' size='5' onBlur='upis(this.value,".$row["id_fakture"].")'></td>"
							.$admin.
						"</tr>";	
						
					if($vazno == "ISTEKLA!"){
						echo "<script>$('#tr".$ii."').css('background-color','#b8222e');</script>";
					}	
					$ii++;
				}
			}
			else{ //ako nije cekirano polje filtera "valuta"
				
				 echo  "<tr id='tr".$i."'>
							<td class='red'><button class='submit' onclick='location.href=".'"faktura.php?br='.$row["id_fakture"].'"'."'>".$row['broj_fakture']." </button></td>
							<td class='opis'>".$firm."</td>
							<td class='cena'>".$row["datum"]."</td>
							<td class='cena1'>".$zaUplatu."</td>
							<td class='red'>".$row["rabat"]."%</td>
							<td class='cena' id='uplaceno".$row["id_fakture"]."'>".$row["uplata"]."</td>
							<td>".$row["valuta"]." dana</td>
							<td>".$vazno."</td>
							<td class='uplata'> <input type='text' id='uplata".$row["id_fakture"]."' name='uplata".$row["id_fakture"]."' size='5' onBlur='upis(this.value,".$row["id_fakture"].")'> </dt>
						</tr>";	
					
				if($vazno == "ISTEKLA!"){ //ako je faktura izasla iz valute izpisuje se "ISTEKLA" i polje se farba u crveno
					echo "<script>$('#tr".$i."').css('background-color','#b8222e');</script>";
				}
				
				if($zaUplatu <= $row["uplata"]){						
						echo "<script>
								$('#tr".$i."').css('background-color','#33cc33');
								$('#uplata".$row["id_fakture"]."').css('display','none')
							</script>";
				}
				
				$i++;	
			}					
		}
		echo "</table></div>"; //END tabela i END arhiva


		$i=0;
		?>
		<!-- FILTER ZA PRETRAGU FAKTURA -->	
			<div class="editKupaca">
				<form method="post" action="">
					<fieldset class="fieldset">
						<legend>&nbsp;FILTER PRETRAGE&nbsp;</legend><br>
						Br. fakture:<input type="text" id="brFakture" name="brFakture" size="3" class="kupacInfo" ><br><br>
						Firma: <input type="text" name="firma" id="firma" class="kupacInfo" class="awesomplete" size="10" onblur="autofill(this)"  list="kupci" value="" ><br><br>
							<datalist id="kupci">
								<?php
									$kupci = mysqli_query($conn,"SELECT * FROM kupci");
									while ($row = mysqli_fetch_assoc($kupci)) {
										echo '<option >'.$row['naziv_kupca'].'</option>';
									}	
								?>
							</datalist>	
						Istekla valuta:  &nbsp; <input type="checkbox" name="valuta" id="valuta" value="1"><br><br>
						Datum: &nbsp; <input type="date" name="datum" class="kupacInfo" id="datum" value=""><br><br>
						<button type="submit" class="submit" name="pretrazi">Pretrazi</button>
					</fieldset>
					<br><br>
				</form>	
				
				<button name='print' id='print' class='submit' onClick='printArhiva()' value='Print'>PRINT</button>
			</div> 
		<!-- END filter -->
		
		
	<?php
		}
		else{  //Ako korisnik nije ulogovan
			header ('Location:index.php');
		}
		
		include_once ('footer.inc.php');
	?>

<script>
	$('#brFakture').on('blur', function() { //ako uner broj fakture ondan polje "firma" i checkbox "valuta" postaju neaktivni
        if ($(this).val() !== ''){
			$('#firma').attr("disabled", true); 
			$('#valuta').attr("disabled", true); 			
		}
		else {
			$('#firma').attr("disabled", false); 
			$('#valuta').attr("disabled", false); 			
		}
    });
	
	
	function printArhiva(){
		window.print();
	}
	
</script>	

</div> <!-- END wrapper -->
</body>
</html>