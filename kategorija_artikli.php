<?php
require('arhiva.php'); 

//Upit za popunjavanje "option" artikala
$database->query("SELECT * FROM artikli WHERE id_korisnika='$id_korisnika' AND status='1' ");
$rows_artikli = $database->resultset();
?>

<script>
		$("#artikli").css("background-color", "green");
</script>

			<div class="col-xs-12 col-sm-3 col-md-3">
			
				Naziv Artikla:<br>	
				<input type="text" id="artikal-input" onblur="ajax_filter('artikli','artikal', this)" list="artikal" autofocus>	

				<datalist id="artikal">
					<?php
						foreach($rows_artikli as $row){
							echo '<option data-id="'.$row['id_artikla'].'" value="'.$row['artikal'].'"></option>';
						}	
					?>
				</datalist>
	
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<table class="table table-bordered text-center" id="tabela">
		
					<tr class="row warning" id="tr">
						<td class="col col-lg-3"><b>ARTIKAL</b></td>
						<td class="col col-lg-1"><b>J.M.</b></td>
						<td class="col col-lg-2"><b>ULAZ</b></td>
						<td class="col col-lg-2"><b>IZLAZ</b></td>	
						<td class="col col-lg-2"><b>ZADUZENJA</b></td>	
						<td class="col col-lg-2"><b>STANJE</b></td>						
					</tr>
						
					<tr class="row" id="rezultat">
						
					</tr>
						
				</table>
			</div> 	

		
		</div>	<!--(iz arhiva.php) -->
	</div>	<!-- END .row (iz arhiva.php)-->
</div> <!-- END .container (iz arhiva.php)-->
		
		
<?php
//include header template
require('layout/footer.php'); 
?>	
	
	