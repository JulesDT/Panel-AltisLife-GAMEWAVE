<?php
if(!Auth::isAdmin()){
	header('Location:'.WEBROOT);
}
?>
<div class="container">
    <div class="row">
		<div class="col-lg-12">
			<div class="page-header">
            <?php 
                $count_members = $DB->query("SELECT DISTINCT COUNT(id) AS totalMembers FROM users WHERE role = '1' OR role = '2' OR role = '3'");
            ?>
            <?php while($row2 = $count_members->fetch(PDO::FETCH_OBJ)){ ?>
				<h3 id="type" style="text-transform:uppercase;">Liste des <?php echo $row2->totalMembers; ?> utilisateurs du panel admin</h3>
            <?php } ?>
			</div>
            <?php include "recherche.php"; ?>
			<form action="<?=WEBROOT?>joueur" method="post">
				<a href="<?=WEBROOT?>users" class="list-group-item" style="background-color:#F8F8F8; color:#000;"><b>Liste des membre du panel administration</b></a>
        <ul class="list-group" style="min-height: 298px; overflow: auto" name="search"> <!-- Permet d'afficher la liste de tout les joueurs (si pas de limit dans la requetes SQL) -->
        <?php

		$search = $DB->query("SELECT * FROM users WHERE role = '1' OR role = '2' OR role = '3' ORDER BY username ASC"); //Affiche les membres du panel admin

        echo '<table style="width:100%;">';         
				while($row2 = $search->fetch(PDO::FETCH_OBJ)){
            //Nom du joueur
				echo '<a style="" class="list-group-item" href="#" value="'.$row2->username.'">'.$row2->username.'';
			//Variables pour les infos
            $admin_lvl=$row2->role;

            if ($admin_lvl == '1') {
                echo '<span class="badge" style="background:#5BC0DE; width:90px;">visiteur</span>';}
            if ($admin_lvl == '2') {
                echo '<span class="badge" style="background:#F0AD4E; width:90px;">modérateur</span>';}
            if ($admin_lvl == '3') {
                echo '<span class="badge" style="background:#D9534F; width:90px;">admin</span>';}

            //Fin de la ligne infos
            }
            echo '</a>';
					$search->closeCursor();					
					?>
					</ul>
				</div>
			</form>
		</div>
	</div>
</div>