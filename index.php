<?php require('includes/config.php');

//if logged in redirect to members page
if( $user->is_logged_in() ){ 
	if($_SESSION['status']>1){
		header('Location: izlaz.php'); 
	}
	else{
		header('Location: arhiva.php');
	}
}
else{
	header('Location: login.php'); 
}




//include header template
require('layout/footer.php');
?>
