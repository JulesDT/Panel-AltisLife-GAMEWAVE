<div class="container">
      <div class="row">
		<?php
		if(Auth::isLogged()){
		?>
		<div class="col-lg-12">
			<div class="page-header">	
			  <?php $tot_players = $DB->query("SELECT COUNT(playerid) AS totalPlayer FROM players");?>
			  <?php while($row = $tot_players->fetch(PDO::FETCH_OBJ)){ ?>
			  <h3 id="type" style="text-transform:uppercase;">Les logs du serveur (morts)</h3>
			  <?php } ?>
			</div>

			<?php
				// Recherche et gametracker
				include 'search.php';
			?>
			<form action="<?=WEBROOT?>joueur" method="post">
        <?php
				if ($search_value == '') {
					?>
					<div class="panel panel-default">
						<!-- Default panel contents -->
						<div class="panel-heading"><b>Retrouvez les informations sur les actions du serveur</b></div>
						<?php
						$search = $DB->query("SELECT * FROM logdeath ORDER BY id  DESC LIMIT 0, 400");
						echo '<table class="table">';
						echo '<thead>';
						echo '<tr>';
						echo '<th>Meurtrier</th>';
						echo '<th>Victime</th>';
						echo '<th>Type de mort</th>';
						echo '<th>Date du décès</th>';
						echo '</tr>';
						echo '</thead>';
						echo '<tbody>';
						while($row = $search->fetch(PDO::FETCH_OBJ)){
							echo '<tr>';
								echo '<td><span class="badge" style="width:220px;" data-container="body" data-toggle="popover" data-placement="top" title="Infos" data-content="'. $row->Killer .' a tué '.$row->Killed.'"><a style="color:white;" href="modifier?j='. $row->uidKiller .'">'.$row->Killer.'</a></span></td>';
								echo '<td><span class="badge" style="width:220px;" data-container="body" data-toggle="popover" data-placement="top" title="'. $row->Killed .'" data-content="'. $row->Killed .' a été tué par '.$row->Killer.'"><a style="color:white;" href="modifier?j='. $row->uidKiller .'">'.$row->Killed.'</a></span></td>';
								if ($row->Killer == $row->Killed){
									echo '<td><span class="badge" style="width:180px; background:#D9534F;" data-container="body" data-toggle="popover" data-placement="top" title="Le joueur c\'est scuicidé" data-content="">Suicide ou Explosion</span></td>';
								}
								else{
									if (empty($row->Type)){
										echo '<td><span class="badge" style="width:180px; background:#D9534F;" data-container="body" data-toggle="popover" data-placement="top" title="Mort inexpliquée" data-content="">Mort inexpliquée</span></td>';
									}
									else{
										echo '<td><span class="badge" style="width:180px; background:#D9534F;" data-container="body" data-toggle="popover" data-placement="top" title="'. $row->Type .'" data-content="">'.$row->Type.'</span></td>';
									}
								}
									echo '<td><span class="badge" style="width:140px; background:#428BCA;" data-container="body" data-toggle="popover" data-placement="top" title="Infos" data-content="Meurtre le '.$row->heure.'">'.$row->heure.'</span></td>';
							echo '</tr>';
						}
						echo '</tbody>';
						echo '</table>';
						?>
					</div>
				<?php
				}
				else {
					?>
					<a href="/" class="list-group-item" style="background-color:#F8F8F8; color:#000;"><b>Liste des joueurs enregistrés sur le serveur ALTISLIFE</b></a>
						<ul class="list-group" style="min-height: 298px; overflow: auto" name="search"> <!-- Permet d'afficher la liste de tout les joueurs (si pas de limit dans la requetes SQL) -->
					<?php	
						include 'search_req.php';
				}
        // Fermeture de la connexion à la BDD
				$search->closeCursor();					
				?>
				</ul>
				</div>
			</form>
		 </div>	  
		<?php
		}
		?>
  	</div>
  </div>
<br>
<br>