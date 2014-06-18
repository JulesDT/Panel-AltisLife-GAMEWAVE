<?php
if(Auth::isLogged()){
	header('Location:'.WEBROOT);
}
?>
<div class="row">
	<div class="col-lg-12">
		<div class="page-header">
			<h1 id="type">Se connecter</h1>
		</div>
	</div>
	<div class="col-lg-5">
		<?php
    error_reporting(0);
		if(isset($_POST) && isset($_POST['username']) && isset($_POST['password'])){
			$username = $_POST['username'];
			$password = md5($_POST['password']);
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
					include WEBROOT.'error.php';
				}
			}
		}
		if(!empty($error)){
			echo '<p>'.$error.'</p>';
		}
		?>
		<form action="<?=WEBROOT?>login" method="post" autocomplete="off" class="bs-example form-horizontal">
			<input type="text" name="username" placeholder="Nom d'utilisateur" class="form-control">
			<br>
			<input type="password" name="password" placeholder="Mot de passe" class="form-control">
			<br>
			<input type="submit" value="Se connecter" class="btn btn-primary">
		</form>
	</div>
</div>