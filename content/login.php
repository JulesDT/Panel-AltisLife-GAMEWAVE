<?php
if(Auth::isLogged()){
	header('Location:'.WEBROOT);
}
?>
<div class="row">
	<div class="col-lg-12">
	<!-- <img src="http://admin.altislife.fr/pictures/back_login.jpg" alt="background admin altislife" style="display:inline-block;" /> -->
	</div>
	<div class="center-block" style="width:390px; margin-top:10%;">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title text-center">Se connecter</h3></div>
			<div class="panel-body">
		<?php
    error_reporting(0);
		if(empty($_POST) && empty($_POST['password']) && empty($_POST['username'])){
			// include WEBROOT.'error.php';
			?>
			<div class="alert alert-info fade in text-center" role="alert">
      	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
      	<strong><span class="glyphicon glyphicon-fire"></span>
      	<span>&nbsp;&nbsp;Remplir tous les champs du formulaire</span></strong>
    	</div>
    	<div class="alert alert-success fade in text-center" role="alert">
      	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
      	<strong>
      		Connexion joueur avec l'identifiant "<i>user</i>"<br>et le mot de passe "<i>userpass</i>"
      	</strong>
    	</div>
			<?php
		}
		else{
			$username = $_POST['username'];
			$password = sha1($_POST['password']);	
			if(!empty($username) && !empty($password)){
				$tab_co = array(
					'username' => $username,
					'password' => $password
				);	
				$requ = $DB->prepare('SELECT * FROM users WHERE username=:username AND password=:password');
				$requ->execute($tab_co);
        $row = $requ->fetch(PDO::FETCH_OBJ);
				if($row->id>0){
					$_SESSION['Auth'] = array(
						'id' => $row->id,
						'username' => $row->username,
						'password' => $row->password,
						'role' => $row->role
					);
					header('Location:'.WEBROOT);
          include WEBROOT.'success.php';
				}
				else{
					?>
					<div class="alert alert-warning fade in text-center" role="alert">
		      	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		      	<strong><span class="glyphicon glyphicon-ban-circle"></span>
		      	<span>&nbsp;&nbsp;Utilisateur non reconnu</span></strong>
		    	</div>
					<?php
				}
			}
		}
		if(!empty($error)){
			echo '<p>'.$error.'</p>';
		}
		?>
				<form action="<?=WEBROOT?>login" method="post" autocomplete="off" class="bs-example form-horizontal">
					<div class="input-group">
		  			<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
						<input type="text" name="username" placeholder="Nom d'utilisateur" class="form-control">
					</div>
					<br>
					<div class="input-group">
		  			<span class="input-group-addon"><span class="glyphicon glyphicon-eye-close"></span></span>
						<input type="password" name="password" placeholder="Mot de passe" class="form-control">
					</div>
					<br>
					<div style="float:right;">
						<button type="reset" value="" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Effacer</button>
						<button type="submit" value="" class="btn btn-primary"><span class="glyphicon glyphicon-play"></span> Connexion</button>
					</div>
				</form>
			</div>
			</div>
	</div>
</div>