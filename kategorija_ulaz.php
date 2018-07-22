<?php
require('arhiva.php'); 

//Upit za popunjavanje "option" firma
$database->query("SELECT * FROM dobavljaci WHERE id_korisnika='$id_korisnika'");
$rows_dobavljaci = $database->resultset();

//Upit za popunjavanje "option" firma
$database->query("SELECT * FROM artikli WHERE id_korisnika='$id_korisnika'");
$rows_artikli = $database->resultset();

//Upit za fakture
$database->query("SELECT * FROM ulaz ORDER BY id_ulaza DESC");
$rows_ulazi = $database->resultset();

?>

<script>
		$("#ulaz").css("background-color", "green");
</script>

			<div class="col-xs-12 col-sm-3 col-md-3">			
				Dobavljač:<br>	
				<input type="text" onblur="ajax_filter('ulaz','dobavljac', this)" list="dobavljac">	
				<datalist id="dobavljac">
					<?php
						foreach($rows_dobavljaci as $row){
							echo '<option data-id="'.$row['id_dobavljaca'].'" value="'.$row['naziv_dobavljaca'].'"></option>';
						}	
					?>
				</datalist>

				<br>Artikal:<br>	
				<input type="text" onblur="ajax_filter('ulaz','artikal', this)" list="artikal">	
				<datalist id="artikal">
					<?php
						foreach($rows_artikli as $row){
							echo '<option data-id="'.$row['id_artikla'].'" value="'.$row['artikal'].'"></option>';
						}	
					?>
				</datalist>	
				
				<br>Br. fakture:<br>	
				<input type="text" onblur="ajax_filter('ulaz','br_fakture', this)">	
				
				<br>Datum:<br>	
				<input type="date" onblur="ajax_filter('ulaz','datum', this)" >	
				
				<br>Napomena:<br>	
				<input type="text" onblur="ajax_filter('ulaz','napomena', this)" >	
				
			</div>
			
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<table class="table table-bordered text-center" id="tabela">
		
					<tr class="row warning" id="tr">
						<td class="col col-lg-1"><b>Br.</b></td>	
						<td class="col col-lg-4"><b>DOBAVLJAC</b></td>
						<td class="col col-lg-2"><b>BR. FAKTURE</b></td>
						<td class="col col-lg-2"><b>DATUM FAKTURE</b></td>	
						<td class="col col-lg-3"><b>NAPOMENA</b></td>	
					</tr>

			<?php		
				$i = 1;
				foreach($rows_ulazi as $ulaz){
					$id_dobavljaca = $ulaz["id_dobavljaca"];
					$database->query("SELECT * FROM dobavljaci WHERE id_korisnika='$id_korisnika' AND id_dobavljaca='$id_dobavljaca'");
					$dobavljac = $database->resultsetAssoc();
					$br_fakture = $ulaz["br_fakture"]
			?>
					<tr class="row del" >
						<td class="col col-lg-1" id="c5" ><button onclick="ajax_filter('ulaz','br_fakture', '<?php echo $br_fakture; ?>')"><?php echo $i; ?></button>  </td>
						<td class="col col-lg-4" id="c1"><?php echo $dobavljac["naziv_dobavljaca"]; ?> </td>
						<td class="col col-lg-2" id="c2"><?php echo $br_fakture; ?> </td>
						<td class="col col-lg-2" id="c3"><?php echo $ulaz["datum"]; ?></td>
						<td class="col col-lg-3" id="c3"><?php echo $ulaz["napomena"]; ?></td>
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
	
	