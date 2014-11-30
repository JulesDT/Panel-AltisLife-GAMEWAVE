<div class="col-lg-12">
	<div class="page-header">	
	  <?php $tot_players = $DB->query("SELECT COUNT(playerid) AS totalPlayer FROM players");?>
	  <?php while($row = $tot_players->fetch(PDO::FETCH_OBJ)){ ?>
	  <h3 id="type" style="text-transform:uppercase;">Chercher parmis les <?php echo number_format(($row->totalPlayer),0,",","."); ?> joueurs enregistrés</h3>
	  <?php } ?>
	</div>

	<?php
		// Recher et gametracker
		include 'search.php';
	?>
	<form action="<?=WEBROOT?>joueur" method="post">
	<div class="list-group">
		<a href="/" class="list-group-item" style="background-color:#F8F8F8; color:#000;"><b>Liste des joueurs enregistrés sur le serveur ALTISLIFE</b></a>
    
    
    <ul class="list-group" name="search"> <!-- Permet d'afficher la liste de tout les joueurs (si pas de limit dans la requetes SQL) -->
    <?php
		if ($search_value == '') {
			$search = $DB->query("SELECT DISTINCT * FROM players ORDER BY rand() LIMIT 0, 7"); //Affiche des joueurs de manière aléatoire (limite de 7 résultats)
		  echo '<table style="width:100%;">';
			while($row = $search->fetch(PDO::FETCH_OBJ)){
        //Nom du joueur
				echo '<a style="" class="list-group-item" href="modifier?j='.$row->playerid.'" value="'.$row->playerid.'">'.$row->name.'';
				//Variables pour les infos bdd
				$pseudo=$row->name;
        $dntr_lvl=$row->donatorlvl;
        $bankacc=$row->bankacc;
        $cash=$row->cash;
        $adminlevel=$row->adminlevel;
        $coplevel=$row->coplevel;
        $duredon=$row->duredon;

        // liste (boucle) des infos sur la ligne
        include 'badges.php';
      }
		}
		else {
			include 'search_req.php';
		}
  	// Fermeture de la connexion à la BDD
		$search->closeCursor();
		?>
	</ul>
	</div>
	</form>
</div>	  