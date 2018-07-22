<?php
$datum=$id_dobavljaca="";
$i = 1;
require('includes/config.php'); 
$artikliKomadi=$id=$ulaz_kolicina=$upit_kolicina="";

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

require('classes/Database.php');

$id_korisnika = $_SESSION['id_korisnika'];
$id_member = $_SESSION['memberID'];

$database = new Database;


if(isset($_GET["kategorija"])){
	
	$kategorija = strip_tags($_GET['kategorija']);	
	$kriterijum = strip_tags($_GET['kriterijum']);	
	$id = strip_tags($_GET['id']);

//ARTIKLI----------------------------------------------------------------	
	if($kategorija == "artikli"){
		
		if($kriterijum == "artikal"){
		
			//Upit u tabelu 'artikli' radi stanja
			$database->query("SELECT * FROM artikli WHERE id_korisnika='$id_korisnika' AND status='1' AND id_artikla='$id'");
			$artikal = $database->resultsetAssoc();
			
			//Upit u tabelu 'ulaz'
			$database->query("SELECT * FROM ulaz WHERE id_korisnika='$id_korisnika' AND status='1' AND artikli_kolicina_cena LIKE '%,$id/%'");
			$ulaz = $database->resultset();
			foreach($ulaz as $row){
				$ulaz_array = explode(" ",$row['artikli_kolicina_cena']); //pretvaranje stringa u niz, podela na " " (clan niza je ",artikal/komada/cena")
				foreach($ulaz_array as $ulaz_part){
					$ulaz_part_array = explode("/", $ulaz_part); //pretvaranje stringa u niz, podela na "/" (clanovi niza su ",artikal" , "kolicina" , "cena")
					$ulaz_id = substr($ulaz_part_array[0], 1);
					if($ulaz_id == $id){
						$ulaz_kolicina += (int)$ulaz_part_array[1];
					}
				}
			}
			
			//Upit u tabelu 'upit'
			function upit($tabela,$id){
				$upit_kolicina = "0";
				$id_korisnika = $_SESSION['id_korisnika'];
				$id_member = $_SESSION['memberID'];
				$database = new Database;
				
				if($tabela == "radnici"){
					
					$database->query("SELECT * FROM $tabela WHERE id_korisnika='$id_korisnika' AND status='1' AND zaduzenje LIKE '%,$id/%'");
					$upit = $database->resultset();
					foreach($upit as $row){
						$upit_array = explode(",",$row['zaduzenje']); //pretvaranje stringa u niz, podela na "," (clan niza je "artikal/komada/datum")
						
						foreach($upit_array as $upit_part){
							if($upit_part != ""){
								$upit_part_array = explode("/", $upit_part); //pretvaranje stringa u niz, podela na "/" (clanovi niza su ",artikal" , "kolicina" , "datum")
								$upit_id = $upit_part_array[0];
								if($upit_id == $id){
									$upit_kolicina += (int)$upit_part_array[1];
								}
							}
						}
					}
					return $upit_kolicina;
				}
				else{
					$database->query("SELECT * FROM $tabela WHERE id_korisnika='$id_korisnika' AND status='1' AND artikli_kolicina_cena LIKE '%,$id/%'");
					$upit = $database->resultset();
					foreach($upit as $row){
						$upit_array = explode(" ",$row['artikli_kolicina_cena']); //pretvaranje stringa u niz, podela na " " (clan niza je ",artikal/komada/cena")
						foreach($upit_array as $upit_part){
							$upit_part_array = explode("/", $upit_part); //pretvaranje stringa u niz, podela na "/" (clanovi niza su ",artikal" , "kolicina" , "cena")
							$upit_id = substr($upit_part_array[0], 1);
							if($upit_id == $id){
								$upit_kolicina += (int)$upit_part_array[1];
							}
						}
					}
					return $upit_kolicina;
				}
			}
	
?>

			<tr class="row del">
				<td class="col col-lg-3" id="c1"><?php echo $artikal["artikal"]; ?> </td>
				<td class="col col-lg-1" id="c2"><?php echo $artikal["jedinica_mere"]; ?> </td>
				<td class="col col-lg-2" id="c3"><?php echo upit("ulaz",$id); ?></td>
				<td class="col col-lg-2" id="c4"><?php echo upit("izlaz",$id); ?></td>
				<td class="col col-lg-2" id="c4"><?php echo upit("radnici",$id); ?></td>
				<td class="col col-lg-2" id="c5"><?php echo $artikal["stanje"]; ?>  </td>
			</tr>
<?php 
		}
	}// END ARTIKLI
	
	
//RADNICI-------------------------------------------------------------------------------------	
	if($kategorija == "radnici"){
		
		if($kriterijum == "radnik" || $kriterijum=="br_fakture"){
			$database->query("SELECT * FROM radnici WHERE id_korisnika='$id_korisnika' AND id_radnika='$id'");
			$radnik = $database->resultsetAssoc();
			
			$artikli_komadi_datum = explode(",",$radnik["zaduzenje"]);
?>

			<tr class="row del">
				<td class="col col-lg-1"></td>
				<td class="col col-lg-1" id="c1"><?php echo $radnik["id_kartica"]; ?> </td>
				<td class="col col-lg-4" id="c2"><?php echo $radnik["ime"]; ?> </td>
				<td class="col col-lg-2" id="c3"><?php echo $radnik["telefon"]; ?></td>
				<td class="col col-lg-2" id="c4"><?php echo $radnik["radno_mesto"]; ?></td>
				<td class="col col-lg-1" id="c4"><?php echo $radnik["odelo"]; ?></td>
				<td class="col col-lg-1" id="c5"><?php echo $radnik["cipele"]; ?>  </td>
			</tr>
			
			<tr class="row del">
				<td class="col col-lg-12" colspan="7">
					<table class="table table-bordered text-center col-lg-12">
						<tr class="row active">
							<td class="col col-lg-12" colspan="7"><b>ZADUZENJE</b></td>
						</tr>
						<tr class="row active">
							<td class="col col-lg-1"><b>br.</b></td>
							<td class="col col-lg-5"><b>Artikal</b></td>
							<td class="col col-lg-2"><b>Kolicina</b></td>
							<td class="col col-lg-4"><b>Datum</b></td>
						</tr>
			<?php	
				
				foreach($artikli_komadi_datum as $part){ // izlistavanje artikala
					if($part != ""){
						$part = explode("/",$part);
						$id_artikla = $part[0];
						$database->query("SELECT * FROM artikli WHERE id_korisnika='$id_korisnika' AND id_artikla='$id_artikla'");
						$artikal = $database->resultsetAssoc();
						
						$datumi_array = explode("+", $part[2]);
						$datum ="";
						
						foreach($datumi_array as $datum_part){
							$dan = substr($datum_part, -2, 2);
							$mesec = substr($datum_part, -4, 2);
							$godina = substr($datum_part, -6, 2);
							$datum .= $dan.".".$mesec.".".$godina."<br>";
						}
			?>
						<tr class="row del">
							<td class="col col-lg-1"><?php echo $i ?></td>
							<td class="col col-lg-5"><?php echo $artikal["artikal"]; ?></td>
							<td class="col col-lg-2"><?php echo $part[1]." ".$artikal["jedinica_mere"]; ?></td>
							<td class="col col-lg-4"><?php echo $datum; ?></td>
						</tr>
			<?php 
						$i++;
					}
				} 
			?>
					</table>
				</td>
			</tr> 
<?php 
		}
		
		if($kriterijum == "radno_mesto"){
			$database->query("SELECT * FROM radnici WHERE id_korisnika='$id_korisnika' AND radno_mesto='$id'");
			$radnici = $database->resultset();
			$i=1;
			foreach($radnici as $radnik){
			?>
				<tr class="row del">
					<td class="col col-lg-1"><button onclick="ajax_filter('radnici','br_fakture', '<?php echo $radnik["id_radnika"]; ?>')"><?php echo $i; ?></button></td>
					<td class="col col-lg-1" id="c1"><?php echo $radnik["id_kartica"]; ?> </td>
					<td class="col col-lg-5" id="c2"><?php echo $radnik["ime"]; ?> </td>
					<td class="col col-lg-2" id="c3"><?php echo $radnik["telefon"]; ?></td>
					<td class="col col-lg-2" id="c4"><?php echo $radnik["radno_mesto"]; ?></td>
					<td class="col col-lg-1" id="c4"><?php echo $radnik["odelo"]; ?></td>
					<td class="col col-lg-1" id="c5"><?php echo $radnik["cipele"]; ?>  </td>
				</tr>
			<?php
				$i++;
			}
			
		}
	}
//END RADNICI-------------------------------------------------------------------------------------

//ULAZ--------------------------------------------------------------------------------------------
	if($kategorija=="ulaz"){
		if($kriterijum=="dobavljac" || $kriterijum=="datum" || $kriterijum=="napomena"){
			if($kriterijum=="dobavljac"){
				$database->query("SELECT * FROM ulaz WHERE id_korisnika='$id_korisnika' AND id_dobavljaca='$id' ORDER BY id_ulaza DESC");
			}
			if($kriterijum=="datum"){
				$database->query("SELECT * FROM ulaz WHERE id_korisnika='$id_korisnika' AND datum='$id' ORDER BY id_ulaza DESC");
			}
			if($kriterijum=="napomena"){ //ako je kriterijum napomena onda je upit drugaciji (trazi se deo recenice)
				$database->query("SELECT * FROM ulaz WHERE id_korisnika='$id_korisnika' AND napomena LIKE '%$id%' ORDER BY id_ulaza DESC");
			}

			$ulaz = $database->resultset();
			
			foreach($ulaz as $row){ // 
					if($kriterijum=="datum" || $kriterijum=="napomena"){$id_dobavljaca = $row["id_dobavljaca"];}
					if($kriterijum=="dobavljac"){$id_dobavljaca = $id;}

					
					$database->query("SELECT * FROM dobavljaci WHERE id_korisnika='$id_korisnika' AND id_dobavljaca='$id_dobavljaca'");
					$dobavljac = $database->resultsetAssoc();
					
					$br_fakture = $row["br_fakture"];
				?>
					<tr class="row del">
						<td class="col col-lg-1"><button onclick="ajax_filter('ulaz','br_fakture', '<?php echo $br_fakture; ?>')"><?php echo $i; ?></button></td>
						<td class="col col-lg-4"><?php echo $dobavljac["naziv_dobavljaca"]; ?></td>
						<td class="col col-lg-2"><?php echo $br_fakture; ?></td>
						<td class="col col-lg-2"><?php echo $row["datum"]; ?></td>
						<td class="col col-lg-3"><?php echo $row["napomena"]; ?></td>
					</tr>
				<?php 
					$i++;
			} 
		}//END dobavljaci/datum
		
		if($kriterijum == "artikal"){//Po artiklu
			$database->query("SELECT * FROM ulaz WHERE id_korisnika='$id_korisnika' AND artikli_kolicina_cena  LIKE '%,$id/%' ORDER BY id_ulaza DESC");
			$ulaz = $database->resultset();
			
			foreach($ulaz as $row){ // 
					$id_dobavljaca = $row["id_dobavljaca"];
		
					$database->query("SELECT * FROM dobavljaci WHERE id_korisnika='$id_korisnika' AND id_dobavljaca='$id_dobavljaca'");
					$dobavljac = $database->resultsetAssoc();
					
					$br_fakture = $row["br_fakture"];
				?>
					<tr class="row del">
						<td class="col col-lg-1"><button onclick="ajax_filter('ulaz','br_fakture', '<?php echo $br_fakture; ?>')"><?php echo $row["id_ulaza"]; ?></button></td>
						<td class="col col-lg-4"><?php echo $dobavljac["naziv_dobavljaca"]; ?></td>
						<td class="col col-lg-2"><?php echo $br_fakture; ?></td>
						<td class="col col-lg-2"><?php echo $row["datum"]; ?></td>
						<td class="col col-lg-3"><?php echo $row["napomena"]; ?></td>
					</tr>
				<?php 
					$i++;
			} 
		}//END artikal
		
		if($kriterijum == "br_fakture"){//Po broju fakture

			$database->query("SELECT * FROM ulaz WHERE id_korisnika='$id_korisnika' AND br_fakture='$id'");
			$ulaz = $database->resultsetAssoc();
			
			$id_dobavljaca = $ulaz["id_dobavljaca"];
			$database->query("SELECT * FROM dobavljaci WHERE id_korisnika='$id_korisnika' AND id_dobavljaca='$id_dobavljaca'");
			$dobavljac = $database->resultsetAssoc();
			
			$artikli_kolicina_cena = explode(",",$ulaz["artikli_kolicina_cena"]);
?>
		
			<tr class="row warning del">
				<td class="col col-lg-1">1</td>
				<td class="col col-lg-4"><?php echo $dobavljac["naziv_dobavljaca"]; ?></td>
				<td class="col col-lg-2"><?php echo $ulaz["br_fakture"]; ?></td>
				<td class="col col-lg-2"><?php echo $ulaz["datum"]; ?></td>
				<td class="col col-lg-3"><?php echo $ulaz["napomena"]; ?></td>
			</tr>

			<tr class="row del">
				<td class="col col-lg-12" colspan="6">
					<table class="table table-bordered text-center col-lg-12">
						<tr class="row active">
							<td class="col col-lg-1"><b>br.</b></td>
							<td class="col col-lg-5"><b>Artikal</b></td>
							<td class="col col-lg-2"><b>Kolicina</b></td>
							<td class="col col-lg-4"><b>Datum</b></td>
						</tr>
			<?php	
				$i = 1;
				foreach($artikli_kolicina_cena as $part){ // izlistavanje artikala
					if($part != ""){
						$part = explode("/",$part);
						$id_artikla = $part[0];
						$database->query("SELECT * FROM artikli WHERE id_korisnika='$id_korisnika' AND id_artikla='$id_artikla'");
						$artikal = $database->resultsetAssoc();
			?>
						<tr class="row del">
							<td class="col col-lg-1"><?php echo $i ?></t>
							<td class="col col-lg-5"><?php echo $artikal["artikal"]; ?></td>
							<td class="col col-lg-2"><?php echo $part[1]." ".$artikal["jedinica_mere"]; ?></td>
							<td class="col col-lg-4"></td>
						</tr>
			<?php 
						$i++;
					}
				} 
			?>
					</table>
				</td>
			</tr> 

<?php 
		}
		
	}//END ULAZ--------------------------------------------------------------------------------------------
	
	
//IZLAZ------------------------------------------------------------------------------------------	
	if($kategorija=="izlaz"){
		if($kriterijum=="id_gradilista" || $kriterijum=="datum" || $kriterijum=="br_fakture"){

			$database->query("SELECT * FROM izlaz WHERE id_korisnika='$id_korisnika' AND $kriterijum='$id' ORDER BY id_izlaza DESC");
			$izlaz = $database->resultset();
		
			foreach($izlaz as $row){ // 
				$id_gradilista = $row["id_gradilista"];
				
				$database->query("SELECT * FROM gradiliste WHERE id_korisnika='$id_korisnika' AND id_gradilista='$id_gradilista'");
				$gradiliste = $database->resultsetAssoc();
				$id_fakture = $row["id_izlaza"];
				$id_radnika = $row["id_radnika"];
				$database->query("SELECT * FROM radnici WHERE id_korisnika='$id_korisnika' AND id_radnika='$id_radnika'");
				$potpisao = $database->resultsetAssoc();
			?>
				<tr class="row del">
					<td class="col col-lg-1"><button onclick="ajax_filter('izlaz','id_fakture', '<?php echo $id_fakture; ?>')"><?php echo $i; ?></button></td>
					<td class="col col-lg-3"><?php echo $gradiliste["naziv_gradiliste"]; ?></td>
					<td class="col col-lg-2"><?php echo $row["br_fakture"]; ?></td>
					<td class="col col-lg-2"><?php echo $row["datum"]; ?></td>
					<td class="col col-lg-2"><?php echo $potpisao["ime"]; ?></td>
					<td class="col col-lg-2"><?php echo $row["napomena"]; ?></td>
				</tr>
			<?php
				$i++;
			}					
		}//END gradiliste/datum/faktura
	
		if($kriterijum == "artikal" || $kriterijum=="napomena"){//Po artiklu
			if($kriterijum=="artikal"){
				$database->query("SELECT * FROM izlaz WHERE id_korisnika='$id_korisnika' AND artikli_kolicina_cena  LIKE '%,$id/%' ORDER BY id_izlaza DESC");
			}
			if($kriterijum=="napomena"){
				$database->query("SELECT * FROM izlaz WHERE id_korisnika='$id_korisnika' AND napomena  LIKE '%$id%' ORDER BY id_izlaza DESC");
			}
			$izlaz = $database->resultset();


			
			foreach($izlaz as $row){ // 
					$id_gradilista = $row["id_gradilista"];
		
					$database->query("SELECT * FROM gradiliste WHERE id_korisnika='$id_korisnika' AND id_gradilista='$id_gradilista'");
					$gradiliste = $database->resultsetAssoc();					
					$br_fakture = $row["br_fakture"];
					$id_fakture = $row["id_izlaza"];
					$id_radnika = $row["id_radnika"];
					$database->query("SELECT * FROM radnici WHERE id_korisnika='$id_korisnika' AND id_radnika='$id_radnika'");
					$potpisao = $database->resultsetAssoc();	
				?>
					<tr class="row del">
						<td class="col col-lg-1"><button onclick="ajax_filter('izlaz','id_fakture', '<?php echo $id_fakture; ?>')"><?php echo $row["id_izlaza"]; ?></button></td>
						<td class="col col-lg-3"><?php echo $gradiliste["naziv_gradiliste"]; ?></td>
						<td class="col col-lg-2"><?php echo $br_fakture; ?></td>
						<td class="col col-lg-2"><?php echo $row["datum"]; ?></td>
						<td class="col col-lg-2"><?php echo $potpisao["ime"]; ?></td>
						<td class="col col-lg-2"><?php echo $row["napomena"]; ?></td>
					</tr>
				<?php 
					$i++;
			} 
		}//END artikal
		
		if($kriterijum == "id_fakture"){//Po ID-ju izlaza

			$database->query("SELECT * FROM izlaz WHERE id_korisnika='$id_korisnika' AND id_izlaza='$id'");
			$izlaz = $database->resultsetAssoc();
			$id_radnika = $izlaz["id_radnika"];
			
			$database->query("SELECT * FROM radnici  WHERE id_korisnika='$id_korisnika' AND id_radnika='$id_radnika'");
			$radnici = $database->resultsetAssoc();
			$radnik = $radnici["ime"];
			
			$id_gradilista = $izlaz["id_gradilista"];
			$database->query("SELECT * FROM gradiliste WHERE id_korisnika='$id_korisnika' AND id_gradilista='$id_gradilista'");
			$gradiliste = $database->resultsetAssoc();
			
			$artikli_kolicina_cena = explode(",",$izlaz["artikli_kolicina_cena"]);
?>

			<tr class="row warning del">
				<td class="col col-lg-1">1</td>
				<td class="col col-lg-3"><?php echo $gradiliste["naziv_gradiliste"]; ?></td>
				<td class="col col-lg-2"><?php echo $izlaz["br_fakture"]; ?></td>
				<td class="col col-lg-2"><?php echo $izlaz["datum"]; ?></td>
				<td class="col col-lg-2"><?php echo $radnik; ?></td>
				<td class="col col-lg-2"><?php echo $izlaz["napomena"]; ?></td>
			</tr>
	
			<tr class="row del">
				<td class="col col-lg-12" colspan="6">
					<table class="table table-bordered text-center col-lg-12">
						<tr class="row active">
							<td class="col col-lg-1"><b>br.</b></td>
							<td class="col col-lg-5"><b>Artikal</b></td>
							<td class="col col-lg-2"><b>Kolicina</b></td>
							<td class="col col-lg-4"><b>Datum</b></td>
						</tr>
			<?php	
				$i = 1;
				foreach($artikli_kolicina_cena as $part){ // izlistavanje artikala
					if($part != ""){
						$part = explode("/",$part);
						$id_artikla = $part[0];
						$database->query("SELECT * FROM artikli WHERE id_korisnika='$id_korisnika' AND id_artikla='$id_artikla'");
						$artikal = $database->resultsetAssoc();
			?>
						<tr class="row del">
							<td class="col col-lg-1"><?php echo $i ?></t>
							<td class="col col-lg-5"><?php echo $artikal["artikal"]; ?></td>
							<td class="col col-lg-2"><?php echo $part[1]." ".$artikal["jedinica_mere"]; ?></td>
							<td class="col col-lg-4"><?php echo $izlaz["datum"]; ?></td>
						</tr>
			<?php 
						$i++;
					}
				} 
			?>
					</table>
				</td>
			</tr> 

<?php 
		}
		
	}//END IZLAZ------------------------------------------------------------------------------------------

}
?>

