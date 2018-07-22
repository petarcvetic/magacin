<?php
require('arhiva.php'); 

//Upit za popunjavanje "option" radnika
$database->query("SELECT * FROM radnici WHERE id_korisnika='$id_korisnika'");
$rows_radnici = $database->resultset();
?>

<script>
		$("#radnici").css("background-color", "green");
</script>

		
			<div class="col-xs-12 col-sm-3 col-md-3">				
				Ime i prezime:<br>	
				<input type="text" onblur="ajax_filter('radnici','radnik', this)" list="radnik">					
				<datalist id="radnik">
					<?php
						foreach($rows_radnici as $row){
							echo '<option data-id="'.$row['id_radnika'].'" value="'.$row['ime'].'"></option>';
						}	
					?>
				</datalist>
				
				Radno mesto:<br>	
				<input type="text" onblur="ajax_filter('radnici','radno_mesto', this)" list="radno_mesto">					
				<datalist id="radno_mesto">		
					<option data-id="Poslovodja gradjevinske operative" value="Poslovodja gradjevinske operative"></option>
					<option data-id="Pomocni Gradjevinski radnik" value="Pomocni Gradjevinski radnik"></option>
					<option data-id="Gradjevinski radnik" value="Gradjevinski radnik"></option>
					<option data-id="Vodoinstalater" value="Vodoinstalater"></option>
					<option data-id="Tesar" value="Tesar"></option>
					<option data-id="Vozac" value="Vozac"></option>
					<option data-id="Bagerista" value="Bagerista"></option>
					<option data-id="Poslovodja masinske operative" value="Poslovodja masinske operative"></option>
					<option data-id="Zavarivac" value="Zavarivac"></option>
					<option data-id="Autogenac" value="Autogenac"></option>
					<option data-id="Bravar" value="Bravar"></option>
					<option data-id="Portir" value="Portir"></option>
					<option data-id="Magacioner" value="Magacioner"></option>
				</datalist>
			</div>

			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<table class="table table-bordered text-center" id="tabela">
					
					<tr class="row warning" id="tr">
						<td class="col col-lg-1"><b></b></td>
						<td class="col col-lg-1"><b>Kartica</b></td>
						<td class="col col-lg-4"><b>Ime i prezime</b></td>
						<td class="col col-lg-2"><b>Telefon</b></td>
						<td class="col col-lg-2"><b>Radno mesto</b></td>							
						<td class="col col-lg-1"><b>Odelo</b></td>
						<td class="col col-lg-1"><b>Cipele</b></td>	
					</tr>
					
			<?php
				$i = 1;
				foreach($rows_radnici as $radnik){
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