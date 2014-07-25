<?php
include '../content/inc/SourceQuery/SourceQuery.class.php'; 

define( 'SQ_SERVER_ADDR', '37.187.160.131' );
define( 'SQ_SERVER_PORT', 2303 );
define( 'SQ_TIMEOUT',     1 );
define( 'SQ_ENGINE',      SourceQuery :: SOURCE );

$Timer = MicroTime( true );

$Query = new SourceQuery( );

$Info    = Array( );
$Rules   = Array( );
$Players = Array( );

try
{
	$Query->Connect( SQ_SERVER_ADDR, SQ_SERVER_PORT, SQ_TIMEOUT, SQ_ENGINE );
	
	$Info    = $Query->GetInfo( );
	$Players = $Query->GetPlayers( );
	$Rules   = $Query->GetRules( );
}
catch( Exception $e )
{
	$Exception = $e;
}

$Query->Disconnect( );

$Timer = Number_Format( MicroTime( true ) - $Timer, 4, '.', '' );
?>
<script src="../js/jquery.knob.js"></script>
<script src="../js/start.knob.js"></script>

<div id="player1" class="jumbotron col-lg-12" style="background:#FCFAFA; padding:30px;">
	<div class="col-lg-3 text-center">
		<input class="knob" data-width="150" data-height="150" data-min="0" data-max="<?php print_r($Info['MaxPlayers']); ?>" data-displayPrevious=true data-fgColor="#f1c40f" data-skin="tron" data-readOnly=true  data-thickness=".2" value="<?php print_r($Info['Players']); ?>">
		<h4>Joueurs connectés</h4>
		<span class="text-muted">Nous avons en ce moment <b><?php print_r($Info['Players']); ?></b> joueurs connectés sur le serveur pour un total de <b><?php print_r($Info['MaxPlayers']); ?></b> slots civils / policiers.</span>
	</div>

<?php

// Connection BDD
include '../bdd.php';

// Premiere requete à refresh
$search1 = $DB->query("SELECT COUNT(playerid) AS totplayer, SUM(bankacc + cash) AS totmoney FROM `players` where adminlevel = '0'"); //Affiche l'argent total du serveur (masse monetaire)
while($row = $search1->fetch(PDO::FETCH_OBJ)){
	//Variables
	$totmoney = $row->totmoney;
	$totplaye = $row->totplayer;
	//Opérations
	$midmoney = ($totmoney / $totplaye);
	$midmoney = number_format(($midmoney),0,",",".");
	$savmoney = number_format(($totmoney),0,",",".");
	$totmoney = round($totmoney, -8);
	$startmon = number_format(($totmoney),0,",",".");
?>
<div class="col-lg-3 text-center">
	<input class="knob" data-width="150" data-height="150" data-min="0" data-max="5" data-displayPrevious=true data-fgColor="#2ecc71" data-skin="tron" data-readOnly=true  data-thickness=".2" value="<?php echo $startmon; ?>">
	<h4>Masse monétaire</h4>
	<span class="text-muted">En tout, les joueurs ont accumulé un total de <b><span id="money1"><?php echo $savmoney; ?></span> €</b> soit un montant de <b><span id="money2"><?php echo $midmoney; ?></span> €</b> par joueur.</span>
</div>
<?php
}
// Fermeture de la connexion à la BDD
$search1->closeCursor();

$search2 = $DB->query("SELECT COUNT(id) AS tothouse FROM `houses`"); //Affiche le nombre de membre vivant sur le serveur
while($row2 = $search2->fetch(PDO::FETCH_OBJ)){
	//Variables
	$tothouse = $row2->tothouse;
	?>
	<div class="col-lg-3 text-center">
		<input class="knob" data-width="150" data-height="150" data-min="0" data-max="850" data-displayPrevious=true data-fgColor="#3498db" data-skin="tron" data-readOnly=true  data-thickness=".2" value="<?php echo $tothouse; ?>">
		<h4>L'immobilier sur Altis</h4>
		<span class="text-muted">Les résidents d'Altis possèdent <b><?php echo $tothouse; ?></b> petits pieds-à-terre leurs permetant de stocker toutes sortes de choses.</span>
	</div>
	<?php
}
// Fermeture de la connexion à la BDD
$search2->closeCursor();

$search3 = $DB->query("SELECT SUM(total_vendu) AS totressources FROM `bourses`"); //Affiche le nombre total de vente illegale (en millions)
while($row3 = $search3->fetch(PDO::FETCH_OBJ)){
	//Variables
	$totnolegacy = $row3->totressources;
	$savnotlegal = number_format(($totnolegacy),0,",",".");
	$datnolegacy = substr($totnolegacy, -strlen($totnolegacy), 3);
	?>
	<div class="col-lg-3 text-center">
		<input class="knob" data-width="150" data-height="150" data-min="0" data-max="650" data-displayPrevious=true data-fgColor="#e74c3c" data-skin="tron" data-readOnly=true  data-thickness=".2" value="<?php echo $datnolegacy; ?>">
		<h4>Ressources illégales</h4>
		<span class="text-muted">Nos farmeurs préféres ont déjà transformé <b><?php echo $savnotlegal ; ?></b> tonnes de produits illicites, que fait la police ?!</span>
	</div>
	<?php
}
// Fermeture de la connexion à la BDD
$search3->closeCursor();
?>
</div>
<?php if( isset( $Exception ) ): ?>
						<div class="panel panel-primary">
							<div class="panel-heading"><?php echo Get_Class( $Exception ); ?> at line <?php echo $Exception->getLine( ); ?></div>
							<p><b><?php echo htmlspecialchars( $Exception->getMessage( ) ); ?></b></p>
							<p><?php echo nl2br( $e->getTraceAsString(), false ); ?></p>
						</div>
				<?php else: ?>
						<div class="row">
							<div class="col-sm-6">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th colspan="2">Informations serveur récupérés en <span class="label label-<?php echo $Timer > 1.0 ? 'danger' : 'info'; ?>"><?php echo $Timer; ?>s</span></th>
										</tr>
									</thead>
									<tbody>
				<?php if( Is_Array( $Info ) ): ?>
				<?php foreach( $Info as $InfoKey => $InfoValue ): ?>
										<tr>
											<td><?php echo htmlspecialchars( $InfoKey ); ?></td>
											<td><?php
					if( Is_Array( $InfoValue ) )
					{
						echo "<pre>";
						print_r( $InfoValue );
						echo "</pre>";
					}
					else
					{
						if( $InfoValue === true )
						{
							echo 'true';
						}
						else if( $InfoValue === false )
						{
							echo 'false';
						}
						else
						{
							echo htmlspecialchars( $InfoValue );
						}
					}
				?></td>
										</tr>
				<?php endforeach; ?>
				<?php else: ?>
										<tr>
											<td colspan="2">Pas d'information(s) reçue(s)</td>
										</tr>
				<?php endif; ?>
									</tbody>
								</table>
							</div>
							<div class="col-sm-6">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Liste des joueurs connectés</th>
											<th>Frags</th>
											<th>Temps de jeu</th>
										</tr>
									</thead>
									<tbody>
				<?php if( Is_Array( $Players ) ): ?>
				<?php foreach( $Players as $Player ): ?>
										<tr>
											<td><a href="modifier?j=<?php echo htmlspecialchars( $Player[ 'Name' ] ); ?>"><?php echo htmlspecialchars( $Player[ 'Name' ] ); ?></a></td>
											<td><?php echo $Player[ 'Frags' ]; ?></td>
											<td><?php echo $Player[ 'TimeF' ]; ?></td>
										</tr>
				<?php endforeach; ?>

				<?php else: ?>
										<tr>
											<td>Pas de joueur(s) connecté(s)</td>
										</tr>
				<?php endif; ?>
									</tbody>
								</table>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<table class="table table-bordered table-striped">
										<thead>
											<tr>
												<th colspan="2">Règles et configuration</th>
											</tr>
										</thead>
										<tbody>
					<?php if( Is_Array( $Rules ) ): ?>
					<?php foreach( $Rules as $Rule => $Value ): ?>
											<tr>
												<td><?php echo htmlspecialchars( $Rule ); ?></td>
												<td><?php echo htmlspecialchars( $Value ); ?></td>
											</tr>
					<?php endforeach; ?>
					<?php endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<?php endif;