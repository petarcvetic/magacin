<?php
$logo ="";
$memberStatus = 0;
if($user->is_logged_in()){ 
	$id_korisnika = $_SESSION['id_korisnika'];
	$id_member = $_SESSION['memberID'];
	$memberStatus = $_SESSION['status'];
	
	$database->query("SELECT * FROM korisnici WHERE id_korisnika='$id_korisnika'");
	$rows = $database->resultsetAssoc();
	$korisnik = $rows['korisnik'];
	$logo = $rows["logo"];
}
else{$korisnik = "";}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php if(isset($title)){ echo $title; }?></title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
	<link href="style/awesomplete.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="style/main.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/functionsJS.js"></script>
	<script type="text/javascript" src="js/awesomplete.js"></script>

</head>

<body>

	<noscript>
		<p>Aplikacija je primetila da je na Vašem računaru isključen JavaScript, koji je neophodan za pravilno funkcionisanje našeg sajta. Ukoliko želite da pregledate naš meni i da poručujete, neophodno je da uključite JavaScript. </p>
		<p>Uputstvo za pretraživac Google Chrome se nalazi na ovom linku: <a>https://support.google.com/adsense/answer/12654?hl=en</a></p>
		<p>Uputstvo za pretraživac Mozilla Firefox se nalazi na ovom linku: <a>http://activatejavascript.org/en/instructions/firefox</a></p>
		<p>Uputstvo za pretraživac Internet Explorer se nalazi na ovom linku: <a>https://www.whatismybrowser.com/guides/how-to-enable-javascript/internet-explorer</a></p>
	</noscript>

	<div class="header">
		<div class="logo">
			<a href="index.php"> 
				<img src="<?php echo $logo ?>" alt="logo">
			</a>
		</div>
		
		<div class="naslov text-center">
			<h1 ><?php echo $korisnik; ?></h1>
		</div>
		
 
				
			<div class="menu">
				<ul class="menulist">
					<?php if($memberStatus > 1){ ?>
					<li><a id="n1" href="index.php">Izlaz</a></li>
					<li><a id="n2" href="ulaz.php">Ulaz</a></li>
					<?php } ?>
					<li><a id="n3" href="kategorija_artikli.php">Arhiva</a></li>
					<li><a id="n4" href="podesavanje.php">Podešavanje</a></li>	
					<li><a id="n5" href="odsustvo_vozaca.php">Potvrda</a></li>
				</ul>	
			</div>   <!-- END menu -->
			
			<div class="login">
				<?php 
				if( $user->is_logged_in() ){
					echo "Magacioner:&nbsp". $_SESSION['username']. " <a href='logout.php'> Logout</a><br>";
					if($_SESSION['status'] >= 3){
							echo "<a href='register.php'>Kreiraj nalog </a> ";
					}
				}
				?> 
			</div>  

				
	</div>
	