<?php

require('includes/config.php'); 
require('classes/Database.php');

$id_korisnika = $_SESSION['id_korisnika'];
$id_member = $_SESSION['memberID'];

$database = new Database;

$database->query("SELECT * FROM radnici WHERE id_korisnika='$id_korisnika'");
$radnici = $database->resultset();


	if(isset($_GET["load"])){
		if($_GET["load"] = "yes"): ?>
		
		<div class="col-xs-12 col-sm-3 col-md-3">
		
			Ime i prezime:<br>	
			<input type="text" id="artikal-input" onblur="ajax_filter('radnici','radnik', this)" list="artikal" autofocus>
			
		</div>

		
		<div class="col-xs-12 col-sm-9 col-md-9">
			<table class="table table-bordered text-center" id="tabela">
				
				<tr class="row" id="tr">
					<td class="col col-lg-1"><b>Kartica</b></td>
					<td class="col col-lg-5"><b>Ime i prezime</b></td>
					<td class="col col-lg-2"><b>Telefon</b></td>
					<td class="col col-lg-2"><b>Radno mesto</b></td>							
					<td class="col col-lg-1"><b>Odelo</b></td>
					<td class="col col-lg-1"><b>Cipele</b></td>	
				</tr>
				
		<?php
			foreach($radnici as $radnik){
		?>
				<tr>
					<td class="col col-lg-1" id="c1"><?php echo $radnik["id_kartica"]; ?> </td>
					<td class="col col-lg-5" id="c2"><?php echo $radnik["ime"]; ?> </td>
					<td class="col col-lg-2" id="c3"><?php echo $radnik["telefon"]; ?></td>
					<td class="col col-lg-2" id="c4"><?php echo $radnik["radno_mesto"]; ?></td>
					<td class="col col-lg-1" id="c4"><?php echo $radnik["odelo"]; ?></td>
					<td class="col col-lg-1" id="c5"><?php echo $radnik["cipele"]; ?>  </td>
				</tr>
		<?php
			}
			
		?>
					
				<div  id="rezultat">
					
				</div>
					
			</table>
		</div> <!-- END content -->	
		
		
		<?php endif;		
	}	