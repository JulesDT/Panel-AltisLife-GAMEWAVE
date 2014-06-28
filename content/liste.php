			<div class="col-lg-12">
				<div class="page-header">	
				  <?php $tot_players = $DB->query("SELECT COUNT(playerid) AS totalPlayer FROM players");?>
				  <?php while($row = $tot_players->fetch(PDO::FETCH_OBJ)){ ?>
				  <h3 id="type" style="text-transform:uppercase;">Chercher parmis les <?php echo number_format(($row->totalPlayer),0,",","."); ?> joueurs enregistrés</h3>
				  <?php } ?>
				</div>
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
				<form action="<?=WEBROOT?>joueur" method="post">
				<div class="list-group">
					<a href="/" class="list-group-item" style="background-color:#F8F8F8; color:#000;"><b>Liste des joueurs enregistrés sur le serveur ALTISLIFE</b></a>
          
          
          <ul class="list-group" style="min-height: 298px; overflow: auto" name="search"> <!-- Permet d'afficher la liste de tout les joueurs (si pas de limit dans la requetes SQL) -->
          <?php
					if ($search_value == '') {
						$search = $DB->query("SELECT DISTINCT * FROM players ORDER BY rand() LIMIT 0, 7"); //Affiche des joueurs de manière aléatoire (limite de 7 résultats)
						}
					else {
						$search = $DB->query("SELECT DISTINCT * FROM players WHERE name LIKE '%$search_value%' OR playerid LIKE '%$search_value%' OR aliases LIKE '%$search_value%'" ); // Fait une recherche sur le "name" et l'alias "alias" (si ajout de : "OR aliases" dans la requête) du joueur
						echo '<li class="list-group-item" disabled style="background-color:#DEE5EA;" value="'.$search_value.'">  Résultat de la recherche pour <b>'.$search_value.'</b></li>';
					}
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