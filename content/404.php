<?php
if(!Auth::isLogged()){
	header('Location:'.WEBROOT);
}
?>
<div class="row">
	<div class="col-lg-10">
		<div class="page-header">
			<h1 id="type">404...</h1>
		</div>
		<p>La page que vous cherchez n'est plus disponible ...</p>
	</div>
</div>