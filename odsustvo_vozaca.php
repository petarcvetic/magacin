<?php 
require('includes/config.php'); 
$artikliKomadi="";
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

//define page title
$title = 'Members Page';

require('classes/Database.php');

$id_korisnika = $_SESSION['id_korisnika'];
$id_member = $_SESSION['memberID'];
	
$database = new Database;
$database->query("SELECT * FROM drivers WHERE id_korisnika='$id_korisnika' AND status='1' ");
$rows_drivers = $database->resultset();

require('layout/header.php'); 

?>
<script>
		document.getElementById("n5").style.color = "white";
</script>

<div class="paper">
	<div class="container-left">
	
		<div class="center">
			<h4><b> POTVRDA O ODSUSTVOVANJU VOZAČA </b></h4>
			<p>(Popunjava se u štampanom obliku i potpisuje pre početka putovanja.<br>
			Čuva se uz originalni tahografski listić ili ispis iz digitalnog tahografa.</p><br>
			<b>Unos netačnih podataka u potvrdu predstavlja prekršaj</b> 
		</div> <!-- END .center -->



		<div class="main-container border">

			&nbsp &nbsp &nbsp <b>Popunjava prevoznik:</b>
			
			<div class="row">1. Naziv preduzeća / preduzetnika <span class="border-bottom" style="padding-right:278px;">"Bulevar Company" DOO </span></div>
			<div class="row">2. Ulica, poštanski broj, grad <span class="border-bottom" style="padding-right:110px;">Bulevar Oslobođenja 46A, 21000 Novi Sad,  Republika Srbija</span></div>
			<div class="border1"> Država: Republika Srbija</div>
			<div class="row">3. Broj telefona: <span class="border-bottom" style="padding-right:412px;">00 381 021-531-996</span></div>
			<div class="row">4. Broj faksa: <span class="border-bottom" style="padding-right:430px;">00 381 021-531-997</span></div>
			<div class="row">5. Adresa elektronske pošte: <span class="border-bottom" style="padding-right:307px;">office@bulevar-company.rs</span></div>
			
			&nbsp &nbsp &nbsp <b>Ja, dole potpisani:</b>
			<div class="row">6. Prezime i ime <span class="border-bottom" style="padding-right:470px;">Lolić Mile</span></div>
			<div class="row">7. na radnom mestu <span class="border-bottom" style="padding-right:466px;">direktor</span></div>
			
			&nbsp &nbsp &nbsp <b>izjavljujem da je vozač:</b><br>
			<div class="row">8. Prezime i ime vozača 
				<span id="name" class="border-bottom" style="width:485px;">
					<input name="name_of_driver"  id="name_of_driver" onblur="autofillPotvrda(this,'potvrda')"  list="drivers" value="" style="font-size:12.5px;" size="36" required autofocus>
						<datalist id="drivers">
							<?php
								foreach($rows_drivers as $row){
									echo '<option >'.$row['driver_name'].'</option>';
								}	
							?>
						</datalist>
				</span>
			</div>
			<div class="row">9. Datum rođenja vozača (dan/mesec/godina) <span id="birthday" class="border-bottom" style="width:363px;"></span></div>
			<div class="row">10. Broj vozačke dozvole, lične karte ili pasoša <span id="id-number" class="border-bottom" style="width:351px;"></span></div>
			<div class="row">11. koji je otpočeo sa radom u preduzeću (dan/mesec/godina) <span id="start-to-work" class="border-bottom" style="width:272px;"></span></div>
			
			&nbsp &nbsp &nbsp <b>za period:</b>
			<div class="row">12. od (čas, dan/mesec/godina)<div class="border-bottom"><input name="name_of_driver"  id="name_of_driver" size="3"> <input type="date" name="star-time"></div></div>
			<div class="row">13. do (čas, dan/mesec/godina) <div class="border-bottom"><input name="name_of_driver"  id="name_of_driver" size="3" value="07.00"><input type="date" name="star-time" value="<?php echo date('Y-m-d'); ?>"></div></div>
			<div class="row">14. <input type="checkbox" name="absence" value="1"> bio na bolovanju***</div>
			<div class="row">15. <input type="checkbox" name="absence" value="2"> koristio godišnji odmor***</div>
			<div class="row">16. <input type="checkbox" name="absence" value="3" checked> odsustvovao sa posla ili koristio slobodne dane***</div>
			<div class="row">17. <input type="checkbox" name="absence" value="4"> upravljao vozilom koje je prema AETR izuzeto obaveze beleženja aktivnosti***</div>
			<div class="row">18. <input type="checkbox" name="absence" value="5"> obavljao druge poslove osim upravljanja vozilom***</div>
			<div class="row">19. <input type="checkbox" name="absence" value="6"> bio raspoloživ***</div>
			<div class="row" class="row" style="padding-bottom: 15px;">20. Mesto <div class="border-bottom" style="width:280px;">Novi Sad</div> &nbsp &nbsp  Datum <span id="city" class="border-bottom" style="width:150px;"><input type="date" name="star-time" value="<?php echo date('Y-m-d'); ?>"></span></div>
			
			&nbsp &nbsp &nbsp Potpis <span class="border-bottom" style="width:280px;"></span>
		</div> <!-- END .main-container -->

		<div class="border">
			<div class="row" style="padding-bottom: 10px;">21. Ja, vozač, potvrđujem da nisam upravljao vozilom iz oblasti AETR-a tokom gorepomenutog perioda</div>
			<div class="row" style="padding-bottom: 15px;">22. Mesto <div class="border-bottom" style="width:280px;">Novi Sad</div> &nbsp &nbsp  Datum <span id="city" class="border-bottom" style="width:150px;"><input type="date" name="star-time" value="<?php echo date('Y-m-d'); ?>"></span></div>
			
			&nbsp &nbsp &nbsp Potpis vozača <span class="border-bottom" style="width:280px;"></span>
		</div> <!-- END .border -->
	
	</div> <!-- END .container-left -->
	
	<div class="sidebar">
		<p class="vertical-text">Privredna komora Srbije, Udruženje za saobraćaj i telekomunikacije, www.pks.rs/centarzaobuku</p>
	</div> <!-- END .sidebar -->
	
	<div class="bottom">
		<span class="border-bottom1" style="width:200px;"></span><br>
		*** Izabrati samo jednu od ponuđenih opcija
	</div>
	
	<button name="print" id="print" onclick="printDoc()">PRINT</button>

</div> <!-- END .paper -->



<?php 
//include header template
require('layout/footer.php'); 
?>


<script type="text/javascript">

	function printDoc(){
		window.print();
	}
	
	function autofillPotvrda(name,doc){
		var driverName = name.value;
		
		
		if(doc == "potvrda"){ //Ako je poziv funkcije iz "potvrda_o_zaustavljanju"
		

			

			//bitrhday
			var xhr = new XMLHttpRequest();
			xhr.open("get", "driver.php?driver="+driverName+"&query=date_of_birth", false);
			xhr.send();
			var odgovor = xhr.responseText;
			if(odgovor!==""){
				document.getElementById("birthday").innerHTML = odgovor;
			//	$("#bitrhday").text(odgovor); 
			}
			
			//id/licenc number
			var xhr = new XMLHttpRequest();
			xhr.open("get", "driver.php?driver="+driverName+"&query=driver_id_number", false);
			xhr.send();
			var odgovor = xhr.responseText;
			if(odgovor!==""){
				document.getElementById("id-number").innerHTML = odgovor;
			//	$("id-number").html(odgovor); 
			}
			
			//date when driver was start to work
			var xhr = new XMLHttpRequest();
			xhr.open("get", "driver.php?driver="+driverName+"&query=start_to_work", false);
			xhr.send();
			var odgovor = xhr.responseText;
			if(odgovor!==""){
				document.getElementById("start-to-work").innerHTML = odgovor;
			//	$("start-to-work").html(odgovor); 
			}
	
		} 	
		
		$( "#kolicina"+i ).focus();
	}

</script>


