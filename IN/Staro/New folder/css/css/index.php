
<?php
require_once('connect.inc.php');
include('header.inc.php');
$artikliKomadi = $cena = $ukupno = "";

if (isset($_GET['errors'])){
	$errors=$_GET['errors'];	
}
else{ $errors = "";}

//-------KLIKNUTO JE "PRINT"--------------------------------
if(isset($_POST["print"])){
	$firma = strip_tags($_POST["firma"]);
	$adresa = strip_tags($_POST["adresa"]);
	$mesto = strip_tags($_POST["mesto"]);
	$pib = strip_tags($_POST["pib"]);
	$matBr = strip_tags($_POST["matBr"]);
	$nacin = strip_tags($_POST["nacin"]);
	$valuta = strip_tags($_POST["valuta"]);
	$datum = strip_tags($_POST["datum"]);
	$mestoFakture = strip_tags($_POST["mestoFakture"]);
	$skonto = strip_tags($_POST["skontoHidden"]);
	$rabat1 = strip_tags($_POST["rabat"]);
	$rabat = $skonto + $rabat1;
	$slovima = strip_tags($_POST["slovimaHidden"]);
	$napomena = strip_tags($_POST["napomena"]);
	$status = strip_tags($_POST["status"]);
	
	
	//Upis kupca u bazu ukoliko ga nema u bazi	
	$find = mysqli_query($conn,"SELECT * FROM kupci WHERE id_korisnika='$idKorisnika' AND naziv_kupca='$firma'");
	if(mysqli_num_rows($find)==0){
		$query = mysqli_query($conn,"INSERT INTO kupci (id_korisnika, naziv_kupca,adresa_kupca,mesto_kupca,pib_kupca,mat_broj) VALUE('$idKorisnika', '$firma','$adresa','$mesto','$pib','$matBr') ");
	}
	
	$kupac_id = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM kupci WHERE id_korisnika='$idKorisnika' AND naziv_kupca='$firma'"))['id_kupca'];
	
	$i=0;
	while($i<19){ // petlja za izlistavanje stavki iz fakture
		if(isset($_POST["artikal".$i])){
			$artikal = $_POST["artikal".$i];
			$kolicina = $_POST["kolicina".$i];
			$cena = $_POST["cena".$i];
			$artikli = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM artikli WHERE id_korisnika='$idKorisnika' AND artikal='$artikal' "));
			$artikalId = $artikli["id_artikla"];
			if($artikalId!="" && $kolicina!=""){
				$artikalKomada = $artikalId."/".$kolicina."/".$cena;  //par "artikal"/"komada"/"cena"
				$artikliKomadi .=  $artikalKomada.",";  //------String koji sadrzi parove "artikal"/"komada"---------------//
			}
			else{
				$artikalKomada = "";
			}
//			$cena = $artikli["cena"];
			$pdv = $artikli["pdv"];
			$zbirno = $kolicina * $cena*(100+$pdv)/100;
			$ukupno = $ukupno+$zbirno;	//------Ukupna cena------//
		}
		$i++;
	}
	$artikliKomadi = rtrim($artikliKomadi, ","); //brisanje poslednjeg zareza (koji razdvaja parove artika/komada) iz stringa
	
	if($artikliKomadi != ""){
		echo "<script> alert('".$idKorisnika." ".$kupac_id." ".$nacin." ".$valuta." ".$datum." ".$mestoFakture." ".$artikliKomadi." ".$rabat." ".$slovima." ".$ukupno." ".$napomena." ".$username."') </script>";
		
		mysqli_query($conn, "UPDATE fakture SET id_korisnika='$idKorisnika', kupac_id='$kupac_id', nacin='$nacin', valuta='$valuta', datum='$datum', mestoFakture='$mestoFakture', artikliKomadi='$artikliKomadi', rabat='$rabat', slovima='$slovima', ukupno='$ukupno', napomena='$napomena', username='$username', status='1'  WHERE username='$username' AND status='0' ");
	}
	else{
		echo "<script type='text/javascript'> alert('DOSLO JE DO GRESKE PRI POVEZIVANJU SA BAZOM') </script>";
	}
} // END "PRINT"


//-----------KLIKNUTO JE "DODAJ KUPCA"------------------------------------
if(isset($_POST["novi_kupac"])){
	$nova_firma = strip_tags($_POST["nova_firma"]);
	$nova_adresa = strip_tags($_POST["nova_adresa"]);
	$novo_mesto = strip_tags($_POST["novo_mesto"]);
	$novi_pib = strip_tags($_POST["novi_pib"]);
	$novi_matBr = strip_tags($_POST["novi_matBr"]);
	$status = strip_tags($_POST["novi_status"]);
	
	$find = mysqli_query($conn,"SELECT * FROM kupci WHERE naziv_kupca='$nova_firma'");
	
	if(mysqli_num_rows($find)==0){
		$query = mysqli_query($conn,"INSERT INTO kupci (id_korisnika,naziv_kupca,adresa_kupca,mesto_kupca,pib_kupca,mat_broj) VALUE('$idKorisnika','$nova_firma','$nova_adresa','$novo_mesto','$novi_pib','$novi_matBr') ");
	}
}  // END "DODAJ KUPCA"

$i=0;

if (logged_in()){ //Ako je korisnik ulogovan prikazuje se sledeca (redovna) stranica
	
	$query = mysqli_query($conn,"SELECT * FROM fakture WHERE kupac_id='0' AND id_korisnika='$idKorisnika' AND username='$username' AND status='0' ")->num_rows;
	
	if($query == 0){ //ako nepostoji zapoceta faktura
//		$poslednjaFaktura = mysqli_query($conn,"SELECT * FROM fakture WHERE id_korisnika='$idKorisnika'")->num_rows;
		$poslednjaFaktura = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM fakture WHERE id_korisnika='$idKorisnika' ORDER BY id_fakture DESC limit 1"))['broj_fakture'];
		$brojFakture = $poslednjaFaktura + 1;
	}
	else{ //ako postoji zapoceta faktura
		$brojFakture = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM fakture WHERE kupac_id='0' AND id_korisnika='$idKorisnika' AND username='$username' AND status='0' "))["broj_fakture"];
	}
	
	$dodatakBroju = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM korisnici WHERE id_korisnika='$idKorisnika'"))['dodatak_broju'];

	if($statusKorisnika!=='0'){
?>

<!--  FAKTURA -->

		<div id="faktura">
			
			<center>
				<img id="logo" src="<?php echo $logoKorisnika; ?>" alt="logo" height="71" width="353"><br>
				<span class="head" id="nazivFirme"><b><?php echo $korisnik; ?> </b></span><br>
				<span class="head"><b>TEL./FAX: <?php echo $telefon; ?>; <?php echo $fax; ?></b></span><br>
				<span class="head"><u><b>TEKUĆI RAČUN: <?php echo $tekuciRacun; ?>, kod <?php echo $banka; ?></b></u></span>
			</center>
			<form method="post" action="" id="formaFaktura">	
				<div id="kupac">
					<div id="alert">  </div>
					Kupac: <input type="text" class="awesomplete" onblur="autofill(this,'faktura')" name="firma" id="firma" list="kupci" value="" size="22" autofocus required><br>
					<datalist id="kupci">
						<?php
							$kupci = mysqli_query($conn,"SELECT * FROM kupci WHERE id_korisnika='$idKorisnika' AND status_kupca='0' ");
							while ($row = mysqli_fetch_assoc($kupci)) {
								echo '<option >'.$row['naziv_kupca'].'</option>';
							}	
						?>
					</datalist>	
					
					Adresa:<input id="adresa" name="adresa" type="text" class="kupacInfo" size="22" required><br>
					Mesto:<input id="mesto" name="mesto" type="text" class="kupacInfo" size="22" required><br>
					PIB:<input id="pib" name="pib" type="text" class="kupacInfo" size="22" required><br>
					Mat. br. <input id="matBr" name="matBr" type="text" class="kupacInfo" size="22" required>
					<input type="hidden" id="status" name="status" value="1">
				</div>

				<div id="dksInfo">
					Adresa: <?php echo $adresaKorisnika.", ".$mestoKorisnika?><br>
					Matični broj: <?php echo $maticniBrojKorisnika; ?><br>
					PIB: <?php echo $pibKorisnika; ?> <br> 
					Šifra delatnosti: <?php echo $sifraDelatnostiKorisnika; ?>
				</div>
				
				<center id="redBr">
					<div id="br">
						RAČUN BR:
						<?php
						
						if($_COOKIE['status'] == "0" || $_COOKIE['status'] == "1"){
							echo $brojFakture.$dodatakBroju;
						}
						else if($_COOKIE['status'] == "2" || $_COOKIE['status'] == "3"){
							echo $brojFakture.$dodatakBroju;
						//	echo "<input type='text' id='brojFakture' name='brojFakture' value='".$brojFakture."' size='5'>".$dodatakBroju;
						}
						?>					
					</div>
				</center>
				
				<div id="placanje">
					Način plaćanja:<input type="text" id="nacin" name="nacin" class="plac" size="7" value="Virmanski" required><br>
					Valuta plaćanja: <select id="valuta" name="valuta" class="plac" onchange="kes(this.value)" required>
									  <option value="1">1</option>
									  <option value="7">7</option>
									  <option value="30" selected>30</option>
									  <option value="45">45</option>
									  <option value="60">60</option>
									</select>
				</div>

				<div id="datum">
					<div class="dat">
						Datum fakture i prometa dobara i usluga:<input type="text" id="datumFakture" name="datum" class="plac" value="<?php echo $d=date('d.m.o'); ?>" size="8" required>
					</div><br>
					<div class="dat">
						Mesto:<input type="text" id="mestoFakture" name="mestoFakture" class="plac" value="Kovilj" size="8" required>
					</div>
				</div>

				<table id="tabela" border="1">
					<tr id="tr" >
						<th class="red">Red. broj</th>
						<th class="opis">OPIS</th>
						<th class="red">Jed. mere</th>
						<th class="red">Kol.</th>
						<th class="cena">Cena po jed. mere</th>
						<th class="cena">Osnovica<br> PDV-a</th>
						<th class="cena">Stopa<br> PDV-a</th>
						<th class="cena">Obračun<br> PDV-a</th>
						<th class="cena">Iznos</th>
					</tr>

					<tr id="tr<?php $i=$i+1; echo $i; ?>">
						<td class="red"><?php echo $i; ?></td>
						<td class="opis"><input class="awesomplete" name="artikal<?php echo $i; ?>"  id="artikal<?php echo $i; ?>"  onblur="autofillArtikal(this,'<?php echo $i; ?>','faktura')" list="artikli" value="" style="font-size:12.5px;" size="36" required>
							<datalist id="artikli">
								<?php
									$artikli = mysqli_query($conn,"SELECT * FROM artikli WHERE id_korisnika='$idKorisnika' AND status_artikla='0'");
									while ($row = mysqli_fetch_assoc($artikli)) {
										echo '<option >'.$row['artikal'].'</option>';
									}	
								?>
							</datalist>	</td>
						<td class="red" id="mera<?php echo $i; ?>"></td>
						<td class="red"><input type="text" name="kolicina<?php echo $i; ?>" id="kolicina<?php echo $i; ?>" onBlur="calculate(this.value,0,<?php echo $i;  ?>)" class="kol" size="2"></td>
						<td class="cena"> <input type="text" name="cena<?php echo $i; ?>" id="cena<?php echo $i; ?>" onBlur="calculate(0,this.value,<?php echo $i;  ?>)" size="2" value=""> </td>
						<td class="cena" id="osnovica<?php echo $i; ?>"></td>
						<td class="cena"><span id="stopaPDV<?php echo $i; ?>"> </span> %</td>
						<td class="cena" id="pdv<?php echo $i; ?>"></td>
						<td class="cena" id="iznos<?php echo $i; ?>"></td>
					</tr>
					
					<tr id="tr<?php $i=$i+1; echo $i; ?>">
						<td class="red"><?php echo $i; ?></td>
						<td class="opis"><input class="awesomplete"  name="artikal<?php echo $i; ?>"  id="artikal<?php echo $i; ?>"  onblur="autofillArtikal(this,'<?php echo $i; ?>','faktura')" onfocus="createNewInput('<?php echo $i; ?>')" list="artikli" value="" style="font-size:12.5px;" size="36"></td>
						<td class="red" id="mera<?php echo $i; ?>" ></td>
						<td class="red"><input type="text"  name="kolicina<?php echo $i; ?>" id="kolicina<?php echo $i; ?>" onBlur="calculate(this.value,0,<?php echo $i;  ?>)" class="kol" size="2"></td>
						<td class="cena"> <input type="text" name="cena<?php echo $i; ?>" id="cena<?php echo $i; ?>" onBlur="calculate(0,this.value,<?php echo $i;  ?>)" size="2" value=""> </td>
						<td class="cena" id="osnovica<?php echo $i; ?>"></td>
						<td class="cena"><span id="stopaPDV<?php echo $i; ?>"> </span> %</td>
						<td class="cena" id="pdv<?php echo $i; ?>"></td>
						<td class="cena" id="iznos<?php echo $i; ?>"></td>
					</tr>
					
				<!-- PRAZNO POLJE -->	
					<tr style="font-size:12px">
						<td colspan='9'></td>
					</tr>
					
				<!-- UKUPNO -->	
					<tr style="font-size:12px">
						<td colspan='5'><b>U K U P N O :</b></td>
						<td class="cena" id="ukupnoOsnovica" ></td>
						<td class="cena" ></td>
						<td class="cena" id="ukupnoPDV" ></td>
						<td class="cena" id="ukupnoIznos"></td>
					</tr>
					
				<!-- KASA SKONTO -->	
					<tr style="font-size:12px">
						<td colspan='2'><b>KASA SKONTO:</b></td>
						<td class="red" >%</td>
						<td class="red" >
							<input type="text" onBlur="racun(this.value)" name="skonto" id="skonto" class="kol" size="2" value="0" disabled>
							<input type="hidden" name="skontoHidden" id="skontoHidden" value="0">
						</td>
						<td colspan='5' ></td>
					</tr>	

				<!-- RABAT -->	
					<tr style="font-size:12px">
						<td colspan='2'><b>RABAT:</b></td>
						<td class="red" >%</td>
						<td class="red" ><input type="text" onBlur="racun(this.value)" name="rabat" id="rabat" class="kol" size="2" value="0" required></td>
						<td colspan='5' ></td>
					</tr>	

				<!-- Ukupno za uplatu -->	
					<tr style="font-size:16px">
						<td colspan='5'><b>U K U P N O &nbsp &nbsp  Z A &nbsp &nbsp  U P L A T U:</b></td>
						<td class="red" id="zaUplatuOsnovica"></td>
						<td class="cena" ></td>
						<td class="cena" id="zaUplatuPDV" ></td>
						<td class="cena" id="zaUplatuIznos" ><b><div> </div></b></td>
					</tr>			
				</table>
					
				<!-- SLOVIMA -->
				<div class="napomene">
					Slovima: <span id="slovima" name="slovima"> </span><br><br>
					Slovima: <input id="slovimaHidden" name="slovimaHidden" size="57" value="" required><br><br>  -->
					<span id="poljeNapomena">NAPOMENA: <input id="napomena" name="napomena" size="53"></span>
				</div>
				
				<div class="potpis" id="primio">
					Robu primio:<br><br><br><hr>
				</div>
				
				<div class="potpis" id="predao">
					Podrum "Do Kraja Sveta" DOO Kovilj:<br><br><br><hr>
				</div>
				

				<div class="non-printable">
					<button type="submit" name="print" id="print" class="submit" onClick="printFaktura()" value="Print">PRINT</button>
				</div>
				
			</form>
			
		</div> <!-- END faktura -->

		<div class="non-printable" id="inputNew">
			<form method="post" action="">
				<fieldset class="fieldset">
					<legend>&nbsp;NOVI KUPAC&nbsp;</legend><br>
					Firma: <input type="text" name="nova_firma" class="kupacInfo"><br><br>
					Adresa: &nbsp;<input type="text" name="nova_adresa" class="kupacInfo"><br><br>
					Mesto:<input type="text" name="novo_mesto" class="kupacInfo"><br><br>
					PIB:<input type="text" name="novi_pib" class="kupacInfo"><br><br>
					Mat. br. <input type="text" name="novi_matBr" class="kupacInfo"><br><br>
					<input type="hidden" id="novi_status" name="novi_status" value="1">
					<button type="submit" class="submit" name="novi_kupac">DODAJ KUPCA</button>
				</fieldset>
				<br><br>
			</form>	
		</div> <!-- END inputNew -->

<?php
	}
	else{ // ako status korisnika nije '1' ili '2'
		echo "<h1>ZBOG NEIZMIRENIH OBAVEZA STE PRIVREMENO ISKLJUCENI!</h1><br><br>".$statusKorisnika."<br><br><br><br><br><br>";
	}
}
else{
	echo '<center>
			<form class="login" id="login" method="POST" action="login.php">
				<fieldset>
				<legend>&nbsp; LOGOVANJE ZA ADMINISTRATORA &nbsp; </legend>
					<br><br>
					Username:&nbsp <input type="text" name="username" id="username" autofocus><br><br>
					Password:&nbsp <input type="password" name="password" id="password"><br><br>
					<input type="submit" class="submit" name="submit" value="Login"><br><br>';
						echo "<p style='color:red'>".$errors."</p>";
						echo "<br>\n";
					
		echo	'</fieldset>
			</form>	
			</center>';
}
include_once ('footer.inc.php');
?>
</div> <!-- END WRAPPER -->
</body>

<script type="text/javascript">
	
	
	function printFaktura(){
		//podaci kupca
		var kupac = $("#firma").val();
		var adresa = $("#adresa").val();
		var mesto = $("#mesto").val();
		var pib = $("#pib").val();
		var matBr = $("#matBr").val();
		
		//uslovi fakture
		var nacin = $("#nacin").val();
		var valuta = $("#valuta").val();
		var datumFakture = $("#datumFakture").val();
		var mestoFakture = $("#mestoFakture").val();
		var rabat = $("#rabat").val();
		var slovima = $("#slovima").val();
		var napomena = $("#napomena").val();
		var artikal = $("#osnovica1").text();

		
		//tabela
		var table = $("#tabela")[0];
		for (var i = 1, row; row = table.rows[i]; i++) { // iteracija tabele
			var osnovica = $("#osnovica"+i).text();
			if (osnovica == "" || osnovica == "0.00" || osnovica == " "){ // sakrivanje redova koji nisu popunjeni
				if(i !== 1){
					$("#tr"+i).hide();
				}
				else{ alert ("POLJE 'OPIS' MORA BITI POPUNJENO I MORA EGZISTIRATI U BAZI");}
			}
		}
		
		if(napomena == ""){ //sakrivanje polja "napomena" ukoliko nije uneto nista u to polje
			$("#poljeNapomena").hide();
		}
		
		if(kupac!=="" && adresa!=="" && mesto!=="" && pib!=="" && valuta!=="" && datum!=="" && mestoFakture!=="" && artikal!=="" && rabat!=="" && slovima!=="" ){	//ako je faktura popunjena sledi:
			//Provera i upis validnog ID-ja pred stampanje
			var xhr = new XMLHttpRequest();
			xhr.open("get", "id.php?username=<?php echo $username; ?>", false);
			xhr.send();
			var odgovor = xhr.responseText;
			if(odgovor!==""){
				$("#br").html(odgovor+"<?php echo $dodatakBroju; ?>");
				window.print();
			}
			else{alert("DOSLO JE DO GRESKE. PROVERITE KONEKCIJU");}
		}
	}

	
//ENTER radi kao TAB	
	$('body').on('keydown', 'input, select, textarea', function(e) {
		var self = $(this)
		  , form = self.parents('form:eq(0)')
		  , focusable
		  , next
		  ;
		if (e.keyCode == 13) {
			focusable = form.find('input,a,select,button,textarea').filter(':visible');
			next = focusable.eq(focusable.index(this)+1);
			if (next.length) {
				next.focus();
			} else {
				form.submit();
			}
			return false;
		}
	});

</script>

</html>





