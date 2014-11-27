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

    <?php
      // Recher et gametracker
      include 'search.php';
    ?>
	  <form action="<?=WEBROOT?>joueur" method="post">
		<a href="<?=WEBROOT?>users" class="list-group-item" style="background-color:#F8F8F8; color:#000;"><b>Liste des membre du panel administration</b></a>
      <!-- Permet d'afficher la liste de tout les joueurs (si pas de limit dans la requetes SQL) -->
      <ul class="list-group" name="search">
        <?php
	      if ($search_value == ''){  
          $search = $DB->query("SELECT * FROM users WHERE role = '1' OR role = '2' OR role = '3' ORDER BY role DESC"); //Affiche les membres du panel admin
            echo '<table style="width:100%;">';
          while($row2 = $search->fetch(PDO::FETCH_OBJ)){
          //Nom du joueur
          echo '<a style="" class="list-group-item" href="#" value="'.$row2->pseudo.'">'.$row2->pseudo.' (<i>'.$row2->username.' #'.$row2->id.'</i>)';
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
        }
        else {
          include 'search_req.php';
        }
		    $search->closeCursor();					
		    ?>
		  </ul>
		</form>
	</div>
  </div>
</div>