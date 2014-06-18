<?php
if(!Auth::isLogged()){
	header('Location:'.WEBROOT);
}
?>
<?php
if(isset($_GET['j']) && isset($_POST) && isset($_POST['cash']) && isset($_POST['bankacc']) && isset($_POST['adminlevel']) && isset($_POST['coplevel']) && isset($_POST['donatorlvl'])){
	if(Auth::isAdmin()){
		$joueur = $_GET['j'];
		$cash = $_POST['cash'];
		$bankacc = $_POST['bankacc'];
		$adminlevel = $_POST['adminlevel'];
		$coplevel = $_POST['coplevel'];
		$donatorlvl = $_POST['donatorlvl'];	
		$sqlupdate = "UPDATE players SET cash='$cash', bankacc='$bankacc', adminlevel='$adminlevel', coplevel='$coplevel', donatorlvl='$donatorlvl' WHERE name='$joueur'";
		$update = $DB->exec($sqlupdate);
		include WEBROOT.'success.php';
	}
	elseif(Auth::isModo()){
		$joueur = $_GET['j'];
		$coplevel = $_POST['coplevel'];
		$donatorlvl = $_POST['donatorlvl'];	
		$sqlupdate = "UPDATE players SET coplevel='$coplevel', donatorlvl='$donatorlvl' WHERE name='$joueur'";
		$update = $DB->exec($sqlupdate);
		include WEBROOT.'success.php';
	}
	elseif(Auth::isGuest()){
		header('Location:'.WEBROOT);
	}
}
?>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h2 id="type" style="text-transform:uppercase;">Résultats</h2>
			</div>

				<?php
				if(isset($_POST['search'])){
					$search = $_POST['search'];
					if(!empty($search)){
						$res = $DB->query("SELECT * FROM players WHERE name='$search'");
						$rows = $res->fetch(PDO::FETCH_OBJ);
						if($rows->adminlevel==2){
							$rows->adminlevel='Modérateur';
						}
						elseif($rows->adminlevel==3){
							$rows->adminlevel='Administrateur';
						}
						else{
							$rows->adminlevel='Joueur';
						}
						if($rows->coplevel==1){
							$rows->coplevel='Recrue';
						}
						elseif($rows->coplevel==2){
							$rows->coplevel='Agent';
						}
						elseif($rows->coplevel==3){
							$rows->coplevel='Caporal';
						}
						elseif($rows->coplevel==4){
							$rows->coplevel='Sergent';
						}
						elseif($rows->coplevel==5){
							$rows->coplevel='Sergent-chef';
						}
						elseif($rows->coplevel==6){
							$rows->coplevel='Commandant';
						}
						elseif($rows->coplevel==7){
							$rows->coplevel='Colonel';
						}
						else{
							$rows->coplevel='Civil';
						}
						if($rows->donatorlvl==5){
							$rows->donatorlvl='Oui';
						}
						else{
							$rows->donatorlvl='Non';
						}
						if($rows->blacklist==5){
							$rows->blacklist='Oui';
						}
						else{
							$rows->blacklist='Non';
						}
						echo '<div class="panel panel-default"><a class="list-group-item active" href="/modifier?j='.$rows->name.'"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;&nbsp;Fiche de <b style="text-transform:uppercase;">'.$rows->name.' (#'.$rows->uid.')</b></a>';
						echo '<div class="panel-b