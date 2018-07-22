<?php
require('arhiva.php'); 

//Upit za popunjavanje "option" gradiliste
$database->query("SELECT * FROM gradiliste WHERE id_korisnika='$id_korisnika'");
$rows_gradilista = $database->resultset();

//Upit za popunjavanje "option" artikal
$database->query("SELECT * FROM artikli WHERE id_korisnika='$id_korisnika'");
$rows_artikli = $database->resultset();

//Upit za fakture
$database->query("SELECT * FROM izlaz ORDER BY id_izlaza DESC");
$rows_izlaz = $database->resultset();

?>

<script>
		$("#izlaz").css("background-color", "green");
</script>

			<div class="col-xs-12 col-sm-3 col-md-3">			
				Gradilište:<br>	
				<input type="text" onblur="ajax_filter('izlaz','id_gradilista', this)" list="id_gradilista">	
				<datalist id="id_gradilista">
					<?php
						foreach($rows_gradilista as $row){
							echo '<option data-id="'.$row['id_gradilista'].'" value="'.$row['naziv_gradiliste'].'"></option>';
						}	
					?>
				</datalist>	
				
				<br>Artikal:<br>	
				<input type="text" onblur="ajax_filter('izlaz','artikal', this)" list="artikal">	
				<datalist id="artikal">
					<?php
						foreach($rows_artikli as $row){
							echo '<option data-id="'.$row['id_artikla'].'" value="'.$row['artikal'].'"></option>';
						}	
					?>
				</datalist>	
				
				<br>Br. fakture:<br>	
				<input type="text" onblur="ajax_filter('izlaz','br_fakture', this)">	
				
				<br>Datum:<br>	
				<input type="date" onblur="ajax_filter('izlaz','datum', this)">

				<br>Napomena:<br>	
				<input type="text" onblur="ajax_filter('izlaz','napomena', this)">	
				
				
			</div>
			
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<table class="table table-bordered text-center" id="tabela">
		
					<tr class="row warning" id="tr">
						<td class="col col-lg-1"><b>Br.</b></td>
						<td class="col col-lg-3"><b>GRADILISTE</b></td>
						<td class="col col-lg-2"><b>BR. FAKTURE</b></td>
						<td class="col col-lg-2"><b>DATUM</b></td>		
						<td class="col col-lg-2"><b>POTPISAO</b></td>
						<td class="col col-lg-2"><b>NAPOMENA</b></td>
					</tr>
						
			<?php		
				$i = 1;
				foreach($rows_izlaz as $izlaz){
					$id_gradilista = $izlaz["id_gradilista"];
					$database->query("SELECT * FROM gradiliste WHERE id_korisnika='$id_korisnika' AND id_gradilista='$id_gradilista'");
					$gradiliste = $database->resultsetAssoc();
					$br_fakture = $izlaz["br_fakture"];
					$id_fakture = $izlaz["id_izlaza"];
					$id_radnika = $izlaz["id_radnika"];

					$database->query("SELECT * FROM radnici  WHERE id_korisnika='$id_korisnika' AND id_radnika='$id_radnika'");
					$radnici = $database->resultsetAssoc();
					$radnik = $radnici["ime"];
			?>
					<tr class="row del" >
						<td class="col col-lg-1" id="c5" ><button onclick="ajax_filter('izlaz','id_fakture', '<?php echo $id_fakture; ?>')"><?php echo $i; ?></button>  </td>
						<td class="col col-lg-3" id="c1"><?php echo $gradiliste["naziv_gradiliste"]; ?></td>
						<td class="col col-lg-2" id="c2"><?php echo $br_fakture; ?> </td>
						<td class="col col-lg-2" id="c3"><?php echo $izlaz["datum"]; ?></td>
						<td class="col col-lg-2" id="c4"><?php echo $radnik; ?></td>
						<td class="col col-lg-2" id="c4"><?php echo $izlaz["napomena"]; ?></td>
					</tr>
			<?php
					$i++;
				}
				
			?>
						
				</table>
			</div> 	

		
		</div>	<!--(iz arhiva.php) -->
	</div>	<!-- END .row (iz arhiva.php)-->
</div> <!-- END .container (iz arhiva.php)-->
		
		
<?php
//include header template
require('layout/footer.php'); 
?>	