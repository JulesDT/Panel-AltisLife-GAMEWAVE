<?php
if(!Auth::isLogged()){
	header('Location:'.WEBROOT);
}
$_SESSION['Auth'] = array();
session_destroy();
header('Location:'.WEBROOT);
?>