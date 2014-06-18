<?php
// ÉTAPE 1 : Connexion en mysql connect au SGBD 
mysql_connect("37.187.160.131", "ID_Utilisateur", "MDP_Utilisateur") or die('<h2 style="color:red; font-family:Calibri;">Connexion BDD impossible</h2>');
mysql_select_db("arma3life");
//------------------------------
//
//			DONATEUR 1 MOIS
//
//------------------------------
// ÉTAPE 2 : on supprime toutes les entrées dont le timestamp est plus vieux que 30 jours
$timestamp1 = time() - (60 * 60 * 24 * 30); // = nombre de secondes écoulées en 30 jours :D)
// ÉTAPE 3 ; Update de tous les donateurs des + de 30 jours
mysql_query("UPDATE players SET donatorlvl = 0, duredon = 0 WHERE timestamp < " . $timestamp1 . " AND duredon = '1'");
//------------------------------
//
//			DONATEUR 2 MOIS
//
//------------------------------
// ÉTAPE 2 : on supprime toutes les entrées dont le timestamp est plus vieux que 60 jours
$timestamp2 = time() - (60 * 60 * 24 * 60); // = nombre de secondes écoulées en 60 jours :D)
// ÉTAPE 3 ; Update de tous les donateurs des + de 60 jours
mysql_query("UPDATE players SET donatorlvl = 0, duredon = 0 WHERE timestamp < " . $timestamp2 . " AND duredon = '2'");
//------------------------------
//
//			DONATEUR 3 MOIS
//
//------------------------------
// ÉTAPE 2 : on supprime toutes les entrées dont le timestamp est plus vieux que 90 jours
$timestamp3 = time() - (60 * 60 * 24 * 90); // = nombre de secondes écoulées en 90 jours :D)
// ÉTAPE 3 ; Update de tous les donateurs des + de 90 jours
mysql_query("UPDATE players SET donatorlvl = 0, duredon = 0 WHERE timestamp < " . $timestamp3 . " AND duredon = '3'");

// Fermeture de la connexion au SGBD
mysql_close();
echo '<h2 style="color:green; font-family:Calibri;">Travail CRON update donateur OK</h2>'
?>