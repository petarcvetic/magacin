<?php require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

//define page title
$title = 'Members Page';

//include header template
require('layout/header.php'); 
?>

<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-8 col-sm-offset-2 ">   
			
			<span>Konobar:&nbsp <?php echo $_SESSION['username']; ?> </span> <a href='logout.php'> Logout</a>
			
			<hr>
			
			<div class="porudzbina">
				<form metdod="post" action="">
					<table class="table table-bordered text-center">
						<tr class="row">
							<td class="col col-lg-1"><b>Br.</b></td>
							<td class="col col-lg-4"><b>ARTIKAL</b></td>
							<td class="col col-lg-1"><b>STANJE</b></td>
							<td class="col col-lg-2"><b>KOLICINA</b></td>
							<td class="col col-lg-2"><b>CENA</b></td>
							<td class="col col-lg-2"><b>SUMA</b></td>
						</tr>
						
						<tr class="row">
							<td class="col col-lg-1">1</td>
							<td class="col col-lg-4">Coca Cola</td>
							<td class="col col-lg-1">13</td>
							<td class="col col-lg-2"><input type="input" name="kolicina" size="2"></td>
							<td class="col col-lg-2">120</td>
							<td class="col col-lg-2">240</td>
						</tr>	
						
						<tr class="row">
							<td class="col col-lg-1">1</td>
							<td class="col col-lg-4">Coca Cola</td>
							<td class="col col-lg-1">13</td>
							<td class="col col-lg-2"><input type="input" name="kolicina" size="2"></td>
							<td class="col col-lg-2">120</td>
							<td class="col col-lg-2">240</td>
						</tr>	
					</table>
				</form>
			</div>	

		</div>
	</div>  


</div>

<?php 
//include header template
require('layout/footer.php'); 
?>
