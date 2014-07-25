<div class="container">
    <div class="row">
		
		<script type="text/javascript">

		//Refresh Jquery Ajax
		var auto_refresh = setInterval(
		function ()
		{
		$('#player1').load('ajax/refreshPlayer1.php').fadeIn("slow");
		}, 5000); // refresh every 1000 milliseconds -> 1 seconde
		</script>
		
		
		<?php
		if(Auth::isLogged()){
		?>
		<!-- Include rCon PHP -->
		<?php 
			include 'inc/SourceQuery/SourceQuery.class.php'; 

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
		<div class="col-lg-12">
			<div class="page-header">	
			  <h3 id="type" style="text-transform:uppercase;">Informations utiles sur le serveur</h3>
			</div>

			<?php
				// Recherche et gametracker
				include 'search.php';
			?>
        
        <?php
				if ($search_value == '') {
				?>
				
				<!-- Refresh auto de la page via Jquery / Ajax -->
				<div id="player1">
					<?php include 'ajax/refreshPlayer1.php'; ?>
				</div>
				<?php
				}
				else {
					 include 'search_req.php';
				}				
				?>
				</div>
		 </div>	  
		<?php
		}
		?>
  	</div>
  </div>
<br>
<br>