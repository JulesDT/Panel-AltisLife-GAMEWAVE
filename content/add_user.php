<?php
if(!Auth::isAdmin()){
	header('Location:'.WEBROOT);
}
?>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h2 id="type" style="text-transform:uppercase;">Nouvel Utilisateur</h2>
			</div>
		</div>
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
				include WEBROOT.'success.php';
			}
      else {
      include WEBROOT.'error.php';
      }
		}
		?>
		<div class="col-lg-4">
			<form action="<?=WEBROOT?>add_user" method="post" autocomplete="off">
				<input type="text" name="username" placeholder="Nom d'utilisateur" class="form-control">
				<br>
				<input type="text" name="password" placeholder="Mot de passe" class="form-control">
				<br>
				<select name="role" class="form-control">
					<option value="1">Guest</option>
					<option value="2">Moderateur</option>
					<option value="3">Administrateur</option>
				</select>
				<br>
				<button type="submit" class="btn btn-success">Ajouter</button>
			</form>
		</div>
	</div>
</div>