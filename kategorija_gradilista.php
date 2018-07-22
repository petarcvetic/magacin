<?php
require('arhiva.php'); 

//Upit za popunjavanje "option" artikala
$database->query("SELECT * FROM gradiliste WHERE id_korisnika='$id_korisnika'");
$rows_artikli = $database->resultset();
?>

<script>
		$("#gradilista").css("background-color", "green");
</script>

			<div class="col-xs-12 col-sm-3 col-md-3">
			
				Naziv Artikla:<br>	
				<input type="text" id="artikal-input" onblur="ajax_filter('artikli','artikal', this)" list="lista" autofocus>
				
				<datalist id="lista">
					<?php
						foreach($rows_artikli as $row){
							echo '<option data-id="'.$row['id_gradilista'].'" value="'.$row['naziv_gradiliste'].'"></option>';
						}	
					?>
				</datalist>
			</div>
			
			
			<div class="col-xs-12 col-sm-5 col-md-5">
				<table class="table table-bordered text-center" id="tabela">
		
					<tr class="row" id="tr">
						<td class="col col-lg-1"><b>ARTIKAL</b></td>
						<td class="col col-lg-5"><b>J.M.</b></td>
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