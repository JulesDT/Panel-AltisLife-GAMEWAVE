<?php

function getcurrentpath()
{   $curPageURL = "";
    if ($_SERVER["HTTPS"] != "on")
            $curPageURL .= "http://";
     else
        $curPageURL .= "https://" ;
    if ($_SERVER["SERVER_PORT"] == "80")
        $curPageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
     else
        $curPageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        $count = strlen(basename($curPageURL));
        $path = substr($curPageURL,0, -$count);
    return $path ;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Administration AltisLife.fr</title>
	<link href="<?=WEBROOT?>css/bootstrap.min.css" rel="stylesheet">
	<link href="<?=WEBROOT?>css/style.css" rel="stylesheet"> 
	<!-- JS -->
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="/js/jquery.knob.js"></script>
	<script src="/js/start.knob.js"></script>
</head>
<?php
	if(!Auth::isLogged()){
?>
	<body background="http://admin.altislife.fr/pictures/texture1.png">
<?php
	}
	else{
?>
	<body>
	<?php 
		}
		if(!Auth::isLogged()){
	?>
	<div class="navbar navbar-default navbar-fixed-top navbar-inverse">
	<?php
	}
	else{
	?>
	<div class="navbar navbar-default navbar-fixed-top">
	<?php
		}
	?>
		<div class="container">
			<div class="navbar-header">
				<a href="<?=WEBROOT?>" class="navbar-brand"><span class="glyphicon glyphicon-home" style="font-size:16px;"></span>&nbsp;&nbsp;Administration</a>
				<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse" id="navbar-main">
				<ul class="nav navbar-nav">
					<?php
					if(!Auth::isLogged()){
					?>
						<li>
							<a href="<?=WEBROOT?>login" <?php if($_GET['p']=='login'){ echo 'class="current-nav"'; } ?>><span class="glyphicon glyphicon-log-in" style="font-size:14px;"></span> Connexion</a>
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
		        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog" style="font-size:14px;"></span> Infos <b class="caret"></b></a>
			        <ul class="dropdown-menu">
								<li>
									<a href="<?=WEBROOT?>money"><span class="glyphicon glyphicon-euro" style="font-size:14px;"></span> Les plus riches</a>
								</li>
								<li>
									<a href="<?=WEBROOT?>last"><span class="glyphicon glyphicon-eye-open" style="font-size:14px;"></span> Derniers joueurs</a>
								</li>
								<li>
									<a href="<?=WEBROOT?>serveur"><span class="glyphicon glyphicon-fire" style="font-size:14px;"></span> Infos serveur</a>
								</li>
								<li>
									<a href="<?=WEBROOT?>logs"><span class="glyphicon glyphicon-time" style="font-size:14px;"></span> Logs du serveur</a>
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
							<a href="<?=WEBROOT?>disconnect" <?php if($_GET['p']=='disconnect'){ echo 'class="current-nav"'; } ?>><span class="glyphicon glyphicon-log-out" style="font-size:14px;"></span> Déco </a>
						</li>
					<?php
					}
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="http://altislife.fr/" target="_blank"><img src="pictures/altislife.png" height="20" /></a></li>
				</ul>
			</div>
		</div>
	</div>
	<br><br>
	<div class="container">
    <div class="row">
			<?php
			if(Auth::isAdmin()){
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
							$password=sha1($_POST['password']);
							$pseudo = ($_POST['pseudo']);
							$role=$_POST['role'];
							if(!empty($username) && !empty($password) && !empty($role) && !empty($pseudo)){
								$d = array(
									'pseudo' => $pseudo,
									'username' => $username,
									'password' => $password,
									'role' => $role
								);
								$requ = $DB->prepare('INSERT INTO users (pseudo,username,password,role) VALUE (:pseudo,:username,:password,:role)');
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
						<div class="input-group">
						  <span class="input-group-addon"><span class="glyphicon glyphicon-tower"></span></span>
						  <input type="text" class="form-control" name="pseudo" placeholder="Pseudo en jeu">
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
			}
			if(Auth::isLogged()){
			// Si l'URL récupéré par le navigateur est différente des URL définis ci dessous, alors on affiche la liste des joueurs aléatoires. 
			// En gros, si on est sur une page dont l'URL est défini ci dessous, on affiche pas la liste aléatoire des joueurs du serveur.
			$basicUrl = getcurrentpath();
			$currentUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$location = $_SERVER['REQUEST_URI'];
			$lastUrl = $basicUrl."last";
			$moneyUrl = $basicUrl."money";
			$etaUrl = $basicUrl."eta";
			$police = $basicUrl."police";
			$admins = $basicUrl."admins";
			$donators = $basicUrl."donators";
			$users = $basicUrl."users";
			$serveur = $basicUrl."serveur";
			$logs = $basicUrl."logs";
			$modifier = $basicUrl."modifier";
			// strlen permet de calculer la longueur de l'URL $location courante. Si elle est égale à 29 (qui est le format de modification d'un profil -> /modifier?j=76561197960498085 alors on masque la liste.)
			if ($currentUrl != $lastUrl && $currentUrl != $moneyUrl  && $currentUrl != $etaUrl && $currentUrl != $police && $currentUrl != $admins && $currentUrl != $donators && $currentUrl != $users && $currentUrl != $serveur && $currentUrl != $logs && strlen($location) != 29 && substr($currentUrl, 0, -20) != $modifier ){
				include 'content/liste.php';
			}
			?>

			<?php
			}	
			else{
			?>
			<br>
			<?php
			$URLbase = "http://".$_SERVER['HTTP_HOST'];
			$URLactu = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$loginURL = $URLbase."/login";
			if ($URLactu == $loginURL) {
				// Nothing - On n'affiche pas la phrase de connexion au panel puisqu'on est sur la page de login
			}
			else{
			?>
			<div class="col-lg-12">
				<a href="/login" style="text-decoration:none;"><h1 id="type" class="text-center" style="margin-top:10%; color:#5d5350;">Connectez-vous pour accéder aux fonctionnalités du panel</h1></a>
			</div>
			<?php
			}
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
    <!-- Appel des tooltips par type de balise (a, button) et par classe (.tooltipsAffiche) -->
		<script>
			$(function (){
			   $('a').tooltip();
			   $('button').tooltip();
			   $('.tooltipsAffiche').tooltip();
			});
		</script>
		<!-- Appel des popup (popover) au passage de la souris -->
		<script>
      $(function () { $('.badge').popover({ trigger: "hover" });});
   </script>
   <!-- Code de suivit analitycs -->
   <script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-25526529-55', 'auto');
	  ga('send', 'pageview');

	</script>
</body>
</html>