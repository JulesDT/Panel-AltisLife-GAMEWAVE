<?php
$ip = "localhost";
$bdd = "arma3life";
$user = "nom_utilisateur";
$passwd = "mot_de_passe";
try{
    $DB = new PDO('mysql:host='.$ip.';dbname='.$bdd, $user, $passwd);
}
catch(PDOException $e){
    echo $e->getMessage();
    exit();
}

$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>