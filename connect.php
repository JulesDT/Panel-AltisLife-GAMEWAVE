<?php
session_start();

try{
	$DB = new PDO('mysql:host=localhost;dbname=arma3life','ID_Utilisateur','MDP_Utilisateur');
}
catch(PDOException $e){
    echo $e->getMessage();
    exit();
}

$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));

class Auth{
	static function isLogged(){
		if(isset($_SESSION['Auth']['id']) && isset($_SESSION['Auth']['username']) && isset($_SESSION['Auth']['password']) && isset($_SESSION['Auth']['role'])){
			return true;
		}
		else{
			return false;
		}
	}
	static function isAdmin(){
		if(isset($_SESSION['Auth']['id']) && isset($_SESSION['Auth']['username']) && isset($_SESSION['Auth']['password']) && isset($_SESSION['Auth']['role'])){
			if($_SESSION['Auth']['role']==3){
				return true;
			}
			else{
				return false;
			}
		}
	}
	static function isModo(){
		if(isset($_SESSION['Auth']['id']) && isset($_SESSION['Auth']['username']) && isset($_SESSION['Auth']['password']) && isset($_SESSION['Auth']['role'])){
			if($_SESSION['Auth']['role']==2){
				return true;
			}
			else{
				return false;
			}
		}
	}
	static function isGuest(){
		if(isset($_SESSION['Auth']['id']) && isset($_SESSION['Auth']['username']) && isset($_SESSION['Auth']['password']) && isset($_SESSION['Auth']['role'])){
			if($_SESSION['Auth']['role']==1){
				return true;
			}
			else{
				return false;
			}
		}
	}
}

if(!isset($_GET['p'])){ $_GET['p']='index'; }
if(!file_exists('content/'.$_GET['p'].'.php')){ $_GET['p']='404'; }

ob_start();
include 'content/'.$_GET['p'].'.php';
$content = ob_get_contents();
ob_end_clean();
?>