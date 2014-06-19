<div style="float:left;">
		<a style="float:right; margin-top:5px;" href="http://www.gametracker.com/server_info/37.187.160.131:2302/" target="_blank"><img src="http://cache.www.gametracker.com/server_info/37.187.160.131:2302/b_350_20_FFFFFF_DBDBDB_1C1C1C_000000.png" border="0" width="350" height="20" alt=""/></a>
</div>
<div style="margin-top:20px; margin-bottom:80px;">
	<!-- ENVOIE DE LA RECHERCHE VIA POST -->
	<?php @$search_value = $_POST ['search_value']; ?>
	
	<form method="post" style="float:right;" role="search">
		<div class="input-group" style="float:right; width:252px;">
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-search"></span>
			</span>
			<input type="text" style="height:41px; width:300px;" class="form-control" name="search_value" 
				placeholder="<?php if ($search_value=='') {  
										echo "Recherchez par le nom ou par l'ID ..."; } 
                    else {
										echo $search_value; }	
								?>">
		</div>
	</form>
</div>