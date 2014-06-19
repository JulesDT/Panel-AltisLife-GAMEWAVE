<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Administration AltisLife.fr</title>
	<!-- <link href="<?=WEBROOT?>css/bootswatch.min.css" rel="stylesheet"> -->
	<link href="<?=WEBROOT?>css/bootstrap.min.css" rel="stylesheet"> 
</head>
<body>
	<div class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<a href="<?=WEBROOT?>" class="navbar-brand"><span class="glyphicon glyphicon-home" style="font-size:16px;"></span>&nbsp;&nbsp;Administration</a>
				<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="navbar-collapse collapse" id="navbar-main">
				<ul class="nav navbar-nav">
					<?php
					if(!Auth::isLogged()){
					?>
						<li>
							<a href="<?=WEBROOT?>login" <?php if($_GET['p']=='login'){ echo 'class="current-nav"'; } ?>><span class="glyphicon glyphicon-log-in" style="font-size:14px;"></span> Se connecter</a>
						</li>
					<?php
					}
					?>
					<?php
					if(Auth::isAdmin()){
					?>
					<li class="dropdown">
		        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user" style="font-size:14px;"></span> Panel<b class="caret"></b></a>
			        <ul class="dropdown-menu">
								<li>
									<a href="<?=WEBROOT?>users"><span class="glyphicon glyphicon-th-large" style="font-size:14px;"></span> Liste des membre</a>
								</li>
								<li>
									<a href="#" data-toggle="modal" data-target="#ModalADDUSER"><span class="glyphicon glyphicon-plus" style="font-size:14px;"></span> Ajouter un membre</a>
								</li>
			        </ul>
		      	</li>
					<?php
					}
					?>
					<?php
					if(Auth::isLogged()){
					?>
						<li class="dropdown">
		        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog" style="font-size:14px;"></span> Informations <b class="caret"></b></a>
			        <ul class="dropdown-menu">
								<li>
									<a href="<?=WEBROOT?>money"><span class="glyphicon glyphicon-euro" style="font-size:14px;"></span> Les plus riches</a>
								</li>
								<li>
									<a href="<?=WEBROOT?>last"><span class="glyphicon glyphicon-eye-open" style="font-size:14px;"></span> Derniers joueurs</a>
								</li>
			        </ul>
		      	</li>
		      	<li class="dropdown">
		        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-list-alt" style="font-size:14px;"></span> Compléments <b class="caret"></b></a>
			        <ul class="dropdown-menu">
								<li>
									<a href="<?=WEBROOT?>police"><span class="glyphicon glyphicon-bell" style="font-size:14px;"></span> Liste des policiers</a>
								</li>
								<li>
									<a href="<?=WEBROOT?>admins"><span class="glyphicon glyphicon-star" style="font-size:14px;"></span> Liste des admins</a>
								</li>
								<li>
									<a href="<?=WEBROOT?>donators"><span class="glyphicon glyphicon-heart-empty" style="font-size:14px;"></span> Liste des donateurs</a>
								</li>	
			        </ul>
		      	</li>
		      	<li>							
							<a href="<?=WEBROOT?>disconnect" <?php if($_GET['p']=='disconnect'){ echo 'class="current-nav"'; } ?>><span class="glyphicon glyphicon-log-out" style="font-size:14px;"></span> Déconnexion </a>
						</li>
					<?php
					}
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="http://gamewave.fr/" target="_blank">GAMEWAVE &nbsp;&nbsp;<span class="glyphicon glyphicon-heart" style="font-size:14px; color:red;"></span></a></li>
				</ul>
			</div>
		</div>
	</div>
	<br><br>
	<div class="container">
    <div class="row">
			<?php
			if(Auth::isLogged()){
			?>

			<!-- Modal Ajout utilisateur -->
			<div class="modal fade" id="ModalADDUSER" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title" id="myModalLabel">Ajouter un membre au panel</h4>
			      </div>
			      <form method="post" autocomplete="off">
			      <div class="modal-body">
						<?php
						if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])){
							$username=$_POST['username'];
							$password=md5($_POST['password']);
							$role=$_POST['role'];
							if(!empty($username) && !empty($password) && !empty($role)){
								$d = array(
									'username' => $username,
									'password' => $password,
									'role' => $role
								);
								$requ = $DB->prepare('INSERT INTO users (username,password,role) VALUE (:username,:password,:role)');
								$requ->execute($d);
								include WEBROOT.'content/success.php';
							}
				      else {
				      include WEBROOT.'content/error.php';
				      }
						}
						?>
						<div class="input-group">
						  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
						  <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur">
						</div>
						<br>
						<div class="input-group">
						  <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
						  <input type="text" class="form-control" name="password" placeholder="Mot de passe">
						</div>
						<br>
						<select name="role" class="form-control">
							<option value="1">Visiteur</option>
							<option value="2">Moderateur</option>
							<option value="3">Administrateur</option>
						</select>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
			        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Ajouter</button>
			      </div>
			      </form>
			    </div>
			  </div>
			</div>

			<?php
			// Si l'URL récupéré par le navigateur est différente des URL définis ci dessous, alors on affiche la liste des joueurs aléatoires. 
			// En gros, si on est sur une page dont l'URL est définir ci dessous, on affiche pas la liste aléatoire des joueurs du serveur.
			$basicUrl = "http://".$_SERVER['HTTP_HOST'];
			$currentUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
			$lastUrl = $basicUrl."/last";
			$moneyUrl = $basicUrl."/money";
			$etaUrl = $basicUrl."/eta";
			$police = $basicUrl."/police";
			$admins = $basicUrl."/admins";
			$donators = $basicUrl."/donators";
			$users = $basicUrl."/users";
			if ($currentUrl !== $lastUrl && $currentUrl !== $moneyUrl  && $currentUrl !== $etaUrl && $currentUrl !== $police && $currentUrl !== $admins && $currentUrl !== $donators && $currentUrl !== $users) {
				include 'content/liste.php';
			}
			?>

			<?php
			}	
			else{
			?>
			<br>
			<div class="col-lg-12">
				<h1 id="type">Connectez-vous pour accéder aux fonctionnalités du panel.</h1>
			</div>
			<?php
			}
			?>
    	</div>

    	<div class="row">
      	<?= $content; ?>
    	</div>
    </div>
	<br>
	<br>
	<!-- JS panel -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</body>
</html>