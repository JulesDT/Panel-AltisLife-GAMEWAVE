<?php
if(!Auth::isLogged()){
	header('Location:'.WEBROOT);
}
?>

<div class="col-lg-12">
	<h2 class="text-center">Erreur 404, la page que vous avez essayé d'atteindre n'existe plus.</h2>
</div>