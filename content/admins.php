<div class="container">
      <div class="row">
		<?php
		if(Auth::isLogged()){
		?>
		<div class="col-lg-12">
			<div class="page-header">	
			  <?php 
			  	$tot_players = $DB->query("SELECT COUNT(playerid) AS totalPlayer FROM players");
			  	$count_admin = $DB->query("SELECT DISTINCT COUNT(playerid) AS totalAdmin FROM players WHERE adminlevel = '3'");
			  ?>
			  <?php while($row = $tot_players->fetch(PDO::FETCH_OBJ) && $row2 = $count_admin->fetch(PDO::FETCH_OBJ)){ ?>
			  <h3 id="type" style="text-transform:uppercase;">Liste des <?php echo $row2->totalAdmin; ?> admins du serveur</h3>
			  <?php } ?>
			</div>
			<?php include "recherche.php"; ?>
			<form action="<?=WEBROOT?>joueur" method="post">
				<a href="/" class="list-group-item" style="background-color:#F8F8F8; color:#000;"><b>Liste des joueurs enregistrés sur le serveur ALTISLIFE</b></a>
        
        
        <ul class="list-group" style="min-height: 298px; overflow: auto" name="search"> <!-- Permet d'afficher la liste de tout les joueurs (si pas de limit dans la requetes SQL) -->
        <?php
				if ($search_value == '') {
					$search = $DB->query("SELECT DISTINCT * FROM players WHERE adminlevel = '3' ORDER BY bankacc+cash DESC"); //Affiche les 150 joueurs les plus riches
					}
				else {
					$search = $DB->query("SELECT DISTINCT * FROM players WHERE name LIKE '%$search_value%' OR playerid LIKE '%$search_value%' OR aliases LIKE '%$search_value%'" ); // Fait une recherche sur le "name" et l'alias "alias" (si ajout de : "OR aliases" dans la requête) du joueur
					echo '<li class="list-group-item" disabled style="background-color:#DEE5EA;" value="'.$search_value.'">  Résultat de la recherche pour <b>'.$search_value.'</b></li>';
				}
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

            // Temps restant pour le don
            $nbrjour=($duredon*30); // Nombre de jour (30,60 ou 90)
            $tpsdons=((time())-($row->timestamp)); // date acctuelle moins la date du don (en timestamp)
            $tpsdons=($nbrjour-ceil($tpsdons / (60 * 60 * 24))); // Transformation de la difference en nombre de jour

 						//Donateur ou non
            if ($dntr_lvl==0){
                echo '<span class="badge" style="width:80px;" data-container="body" data-toggle="popover" data-placement="top" title="'. $pseudo .'" data-content="Membre non donateur"> non <span class="glyphicon glyphicon-heart" style="font-size:10px; float:right;"></span></span>';}
              else {
                echo '<span class="badge" style="background:#D9534F; width:80px;"data-container="body"  data-toggle="popover" data-placement="top" title="'. $pseudo .'" data-content="Membre donateur pour '. $duredon .' mois, il lui reste '. $tpsdons .' jours.">'. $tpsdons .' jours <span class="glyphicon glyphicon-heart" style="font-size:10px; float:right;"></span></span>';}
            //Compte en banque
            		echo '<span class="badge" style="width:100px;" data-container="body" data-toggle="popover" data-placement="top" title="'. $pseudo .'" data-content="Banque '. number_format(($bankacc),0,",",".").'€ | Cash '. number_format(($cash),0,",",".") .'€">'.number_format(($bankacc+$cash),0,",",".").' €</span>';          
            // Police ou non
            if ($coplevel==0){
                echo '<span class="badge" style="background-color:#5CB85C; width:48px;">civil</span>';}
              else {
                echo '<span class="badge" style="background:#428BCA; width:48px;">police</span>';}
            // Level du joueur
            if ($adminlevel==0){
                echo '';}
              else {
                echo '<span class="badge" style="background:#F0AD4E;">admin</span>';}
            //Fin de la ligne infos
            echo '</a>';
            }
					$search->closeCursor();					
					?>
					</ul>
				</div>
			</form>
		 </div>	  
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
  </div>
<br>
<br>