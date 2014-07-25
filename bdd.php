<?php
try{
	// Editer la configuration ici (connexion BDD)
	$DB = new PDO('mysql:host=localhost;dbname=arma3life','ID_Utilisateur','MDP_BaseDeDonnée');
}
catch(PDOException $e){
    echo $e->getMessage();
    exit();
}

$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>