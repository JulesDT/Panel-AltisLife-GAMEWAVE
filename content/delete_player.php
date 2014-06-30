<?php
if(!Auth::isLogged() && !Auth::isAdmin()){
	header('Location:'.WEBROOT);
}
if(isset($_GET['j']) && Auth::isAdmin()) {
	$j = $_GET['j'];
	$DB->exec("DELETE FROM players WHERE playerid='$j'");
	$DB->exec("DELETE FROM vehicles WHERE pid='$j'");
	header('Location:'.WEBROOT.'success');
}
?>