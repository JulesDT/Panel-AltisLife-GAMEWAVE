<?php
	// Include de base
	include '../bdd.php';
	include '../connect.php';
	
	// Sécurité
	if(Auth::isModo() == false && Auth::isAdmin() == false){
		exit("bad request - level too low !");
	}
	
	// status
	$status = $_POST['type'];
	$pid = $_POST['pid'];
	$id = $_POST['id'];
	
	// Tests
	if(is_numeric($status) == false || is_numeric($pid) == false){
		echo "2;not a number !";
		exit();
	}
	
	// On inverse le choix à modifier
	if($status == 0){
		$status = $status + 1;
	}else{
		$status = $status - 1;
	}	

	// MAJ BDD
	$query = $DB->prepare("SELECT `civ_licenses` FROM `players` WHERE `playerid` =  :pid");
	$query->bindValue(':pid', $pid, PDO::PARAM_INT);
	$query->execute()or die(print_r($db->errorInfo(), true));
	$rows = $query->fetch(PDO::FETCH_OBJ);
	$query = null;
	
	// Gestion du parse
	$suppr = array("\"", "`", "[", "]");
	$lineLicenses = str_replace($suppr, "", $rows->civ_licenses);
	$arrayLicenses = preg_split("/,/", $lineLicenses);
	$totarrayLicenses = count($arrayLicenses);
	$y=0;
	$n=0;
	
	// test 
	for($i=1; $y < $totarrayLicenses; $i++){
		// Reconstruction du contenu de civ_licenses pour Arma
		
		// Début
		if($n == $id && $y == 0){
			$fdp_arma[] = "\"[[`".$arrayLicenses[$y]."`,".$status."],";
		}elseif($n == 0 && $id !== $n){
			$fdp_arma[] = "\"[[`".$arrayLicenses[$y]."`,".$arrayLicenses[$i]."],";
		}
		
		// Millieux
		if($n == $id && $n !== 0 && $y !== ($totarrayLicenses-2)){
			$fdp_arma[] = "[`".$arrayLicenses[$y]."`,".$status."],";
		}elseif($n !== $id && $y !== 0 && $y !== ($totarrayLicenses-2)){
			$fdp_arma[] = "[`".$arrayLicenses[$y]."`,".$arrayLicenses[$i]."],";
		}
		
		// Fin
		if($n == $id && $y == ($totarrayLicenses-2)){
			$fdp_arma[] = "[`".$arrayLicenses[$y]."`,".$status."]]\"";
		}elseif($n !== $id && $y == ($totarrayLicenses-2)){
			$fdp_arma[] = "[`".$arrayLicenses[$y]."`,".$arrayLicenses[$i]."]]\"";
		}
		
		// Pair
		$y=$y+2;
		// Impair
		$i=$i+1;
		// Normal
		$n=$n+1;
	}

	// transformation de l'array en chaîne
	$civ_licenses = implode($fdp_arma);

	// Maj
	$query = $DB->prepare("UPDATE `players` 
						   SET `civ_licenses` = 
						   :civ_licenses
						   WHERE `playerid` LIKE :pid
						");
	$query->bindParam(':civ_licenses', $civ_licenses, PDO::PARAM_STR);
	$query->bindValue(':pid', $pid, PDO::PARAM_INT);
	$query->execute();
	$query = null;
	
	// Retour 
	if($status == 0){
		echo $status.";non actif -> $pid | ID -> $id";
	}elseif($status == 1){
		echo $status.";actif -> $pid | ID -> $id";
	}elseif(empty($status)){
		exit("cass'toi fdp !");
	}
?>