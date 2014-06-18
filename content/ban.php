<?php
if(!Auth::isAdmin() && !isset($_GET['j'])){
	header('Location:'.WEBROOT);
}
$monfichier = fopen('C:\Altis_Life_Server\Arma3\ban.txt', 'r+');
$retour = chr(13);
fgets($monfichier);
//fseek($monfichier, 0); // On remet le curseur au début du fichier
fputs($monfichier, $_GET['j']); // On écrit le nouveau ban
fputs($monfichier, $retour); // On écrit le retour à la ligne
fclose($monfichier);

header('Location:'.WEBROOT);
?>