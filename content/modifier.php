<?php
if(!Auth::isLogged()){
	header('Location:'.WEBROOT);
}
?>
<div class="container">
  <div class="row">
	<div class="col-lg-12">
	  <div class="page-header">
	  	<div style="margin-top:50px;">
      <?php
      // TEST POST 
      /*
      echo '<pre>';
      print_r($_POST);
      echo '</pre>';
      */
      // on initlisalise la valeur du champ de recherche
      $search_value = "";

     	if (isset($search_value)) {

				// C'est ici la source de tout probleme =D (dans le retour du $post)
				if(isset($_POST) && isset($_POST['cash']) && isset($_POST['bankacc'])){
					if(Auth::isAdmin()){
						$joueur = $_GET['j'];
						$cash = $_POST['cash'];
						$bankacc = $_POST['bankacc'];
						$adminlevel = $_POST['adminlevel'];
						$coplevel = $_POST['coplevel'];
						$donatorlvl = $_POST['donatorlvl'];
	          $times = $_POST['times'];
	          $mounthDon = $_POST['mounthDon'];
						$sqlupdate = "UPDATE players SET cash='$cash', bankacc='$bankacc', adminlevel='$adminlevel', coplevel='$coplevel', donatorlvl='$donatorlvl', timestamp='$times', duredon='$mounthDon' WHERE playerid='$joueur'";  //Timestamppermet de définir la date du don (mis à jour lors de l'update du don)
						$update = $DB->exec($sqlupdate);
						include WEBROOT.'success.php';
					}
					elseif(Auth::isModo()){
						$joueur = $_GET['j'];
						$cash = $_POST['cash'];
						$bankacc = $_POST['bankacc'];
						$sqlupdate = "UPDATE players SET cash='$cash', bankacc='$bankacc' WHERE playerid='$joueur'";
						$update = $DB->exec($sqlupdate);
						include WEBROOT.'success.php';
					}
					elseif(Auth::isGuest()){
						header('Location:'.WEBROOT);
					}
				}
			}
			// Récupération de l'id du joueur
			$j = $_GET['j'];
			$jLong = strlen($j);
			
			if(!is_numeric($j) || $jLong !== 17){
				exit('CACA MOU FDP !');
			}
			
			// Requetage
			$requete = 'SELECT * FROM players WHERE playerid = :joueur';
			$res = $DB->prepare($requete) or die(print_r($DB->errorInfo()));
			$res->bindParam(':joueur', $j, PDO::PARAM_STR);
			$res->execute();
			$rows = $res->fetch(PDO::FETCH_OBJ);

				if(empty($j) || empty($rows->uid)){
					echo '<h3 class="text-center">Le joueur n\'existe pas !</h3>';
					include WEBROOT.'error.php';
					//exit();
				}
        // L'id du joueur existe bien en BDD, on affiche donc les champs suivants
				else{
          // Affiche le contenu du garage, de manière distinct (1 seule catégorie de véhicule avec le nombre de véhicule du joueur / catégorie)
          $res3=$DB->query("SELECT COUNT(classname) AS nbr_doublon, classname FROM vehicles WHERE pid = '$j' GROUP BY classname HAVING COUNT(classname) > 0 ORDER BY nbr_doublon DESC");
          $res3->setFetchMode(PDO::FETCH_OBJ); 

          $j==$rows->name;
        ?>
				<h3 id="type" style="text-transform:uppercase; margin-top:-10px;"><span class="glyphicon glyphicon-wrench" style="font-size:18px;"></span> Modifier le profil de <?=$rows->name?> (#<?php echo $rows->uid;  ?>)</h3>
			</div>
		</div>



	  <div style="display:block;margin-top:-60px; margin-bottom:120px;">	
	    <?php
	    	// Recherche et gametracker
				include 'search.php';
			?>
		</div>

		<?php
			if ($search_value == '') {
		?>
 
    <form id="update_profil" name="update_profil" action="<?=WEBROOT?>modifier?j=<?=$j?>" method="post" autocomplete="off">
      <div style="float:right; margin-top:-110px; margin-right:-340px;">
        <!-- Mise à jour profil -->
        <?php if(Auth::isAdmin()){ ?><button type="submit" class="btn btn-success" style="font-weight:bold; text-transform:uppercase;"><span class="glyphicon glyphicon-download-alt"></span>&nbsp;&nbsp;&nbsp;Update</button><?php } ?>
        <?php if(Auth::isModo()){ ?><button type="submit" class="btn btn-success" style="font-weight:bold; text-transform:uppercase;"><span class="glyphicon glyphicon-download-alt"></span>&nbsp;&nbsp;&nbsp;Update</button><?php } ?>
        <?php if(Auth::isGuest()){ ?><button type="submit" class="btn btn-success" disabled style="font-weight:bold; text-transform:uppercase;"><span class="glyphicon glyphicon-download-alt"></span>&nbsp;&nbsp;&nbsp;Update</button><?php } ?>
        <!-- Suppression / Wipe -->
        <?php if(Auth::isAdmin()){ ?><a href="<?=WEBROOT?>delete_player?j=<?=$_GET['j']?>" class="btn btn-warning" style="font-weight:bold; text-transform:uppercase;"><span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;&nbsp;Delete</a><?php } ?>							
        <?php if(Auth::isModo()){ ?><a href="<?=WEBROOT?>delete_player?j=<?=$_GET['j']?>" disabled class="btn btn-warning" style="font-weight:bold; text-transform:uppercase;"><span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;&nbsp;Delete</a><?php } ?>
        <?php if(Auth::isGuest()){ ?><a href="#" disabled class="btn btn-warning" style="font-weight:bold; text-transform:uppercase;"><span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;&nbsp;Delete</a><?php } ?>
      </div>
      
      <br>
      
      <div class="alert alert-warning" style="border:1px solid #faebcc;">
        <h3 style="margin-top:0px;">Alias utilisés précédemment <span class="glyphicon glyphicon-info-sign" style="float:right;"></span></h3>
        <?php
          if(Auth::isGuest()){
            // Nothing, on masque les alias
            echo '<em> pseudo et alias antérieurs masqués, vous êtes un visiteur et n\'avez pas le niveau d\'accréditation requis. </em>';
          }
          else{
            //Affichage des autres pseudos du joueur, avec un substring pour supprimer le formatage de la BDD
            $suppr = array("\"", "`", "[", "]", "Error: No unit ,", "Error: No unit");
            $onlyPseudo = str_replace($suppr, " ", $rows->aliases);
            echo '<em>'.$onlyPseudo.'</em>';
          }
        ?>
      </div>
        <div style="float:left; width:48%">

          <!-- Identifiant joueur -->
          <div style="float:left; width:50%">
            <p>
            <strong>ID du joueur :</strong> 
              <div class="input-group">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-user"></span>
                </span>
                <input disabled type="text" name="j" value="<?=$rows->playerid?>" class="form-control">
              </div>
            </p>
          </div>

          <!-- Gestion de la durée du don -->
          <div style="float:right; width:44%; display:none;">
            <p>
            <strong>Timestamp</strong>
              <div class="input-group">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
                </span>
                <?php 
                  $tryIt=$rows->donatorlvl;
                  if ($tryIt==1 || $tryIt==2 || $tryIt==3 || $tryIt==5)
                    {echo '<input type="text" name="times" value="'.$rows->timestamp.'" class="form-control">';}
                  else
                    {echo '<input type="text" name="times" value="'.time().'" class="form-control">';}
                ?>
              </div>
            </p>
          </div>

          <!-- Argent liquide -->
          <?php if(Auth::isAdmin()){ ?>
          <div style="float:right; width:44%">
            <p>
            <strong>Liquidités (cash) :</strong>
              <div class="input-group">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-usd"></span>
                </span>
                <input type="text" name="cash" value="<?=$rows->cash?>" class="form-control">
              </div>
            </p>
          </div>
          <?php }?>

          <?php if(Auth::isModo()){ ?>
          <div style="float:right; width:44%">
            <p>
            <strong>Liquidités (cash) :</strong>
              <div class="input-group">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-usd"></span>
                </span>
                <input type="text" name="cash" value="<?=$rows->cash?>" class="form-control">
              </div>
            </p>
          </div>
          <?php }?>

          <?php if(Auth::isGuest()){ ?>
          <div style="float:right; width:44%">
            <p>
            <strong>Liquidités (cash) :</strong>
              <div class="input-group">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-usd"></span>
                </span>
                <input disabled  type="text" name="cash" value="cash masqué" class="form-control">
              </div>
            </p>
          </div>
          <?php }?>

          <!-- Compte en banque -->
          <?php if(Auth::isAdmin()){ ?>
          <div style="float:left; width:50%">
            <p>
            <strong>Compte en banque :</strong>
              <div class="input-group">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-home"></span>
                </span>
                <input type="text" name="bankacc" value="<?=$rows->bankacc?>" class="form-control">
              </div>
            </p>
          </div>
          <?php }?>

          <?php if(Auth::isModo()){ ?>
          <div style="float:left; width:50%">
            <p>
            <strong>Compte en banque :</strong>
              <div class="input-group">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-home"></span>
                </span>
                <input type="text" name="bankacc" value="<?=$rows->bankacc?>" class="form-control">
              </div>
            </p>
          </div>
          <?php }?>

          <?php if(Auth::isGuest()){ ?>
          <div style="float:left; width:50%">
            <p>
            <strong>Compte en banque :</strong>
              <div class="input-group">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-home"></span>
                </span>
                <input disabled type="text" name="bankacc" value="compte masqué" class="form-control">
              </div>
            </p>
          </div>
          <?php }?>


          <!-- Rang admin / non admin -->
          <?php if(Auth::isAdmin()){ ?>
          <div style="float:right; width:44%">
            <p>
            <strong>Admin level :</strong>
            <div>
              <select name="adminlevel" class="form-control">
                <option <?php if($rows->adminlevel==0){ echo 'selected="selected"'; } ?> value="0">Joueur</option>
                <option <?php if($rows->adminlevel==3){ echo 'selected="selected"'; } ?> value="3">Administrateur</option>
              </select>
            </div>
            </p>
          </div>
          <?php } ?>

          <?php if(Auth::isModo()){ ?>
          <div style="float:right; width:44%">
            <p>
            <strong>Admin level :</strong>
            <div>
              <select disabled name="adminlevel" class="form-control">
                <option <?php if($rows->adminlevel==0){ echo 'selected="selected"'; } ?> value="0">Joueur</option>
                <option <?php if($rows->adminlevel==3){ echo 'selected="selected"'; } ?> value="3">Administrateur</option>
              </select>
            </div>
            </p>
          </div>
          <?php } ?>

          <?php if(Auth::isGuest()){ ?>
          <div style="float:right; width:44%">
            <p>
            <strong>Admin level :</strong>
            <div>
              <select disabled name="adminlevel" class="form-control">
                <option <?php if($rows->adminlevel==0){ echo 'selected="selected"'; } ?> value="0">Joueur</option>
                <option <?php if($rows->adminlevel==3){ echo 'selected="selected"'; } ?> value="3">Administrateur</option>
              </select>
            </div>
            </p>
          </div>
          <?php } ?>

          <!-- Niveau flic -->
          <?php if(Auth::isAdmin()){ ?>
          <div style="float:left; width:50%">
            <p>
            <strong>Grade :</strong>
              <div>
                <select name="coplevel" class="form-control">
                  <option <?php if($rows->coplevel==0){ echo 'selected="selected"'; } ?> value="0">Civil</option>
                  <option <?php if($rows->coplevel==1){ echo 'selected="selected"'; } ?> value="1">Recrue</option>
                  <option <?php if($rows->coplevel==2){ echo 'selected="selected"'; } ?> value="2">Brigadier / Sergent</option>
                  <option <?php if($rows->coplevel==3){ echo 'selected="selected"'; } ?> value="3">Adjudant / Adjudant-chef</option>
                  <option <?php if($rows->coplevel==4){ echo 'selected="selected"'; } ?> value="4">Major / Aspirant</option>
                  <option <?php if($rows->coplevel==5){ echo 'selected="selected"'; } ?> value="5">Lieutenant</option>
                  <option <?php if($rows->coplevel==6){ echo 'selected="selected"'; } ?> value="6">Commandant</option>
                  <option <?php if($rows->coplevel==7){ echo 'selected="selected"'; } ?> value="7">Colonel</option>
								  <option <?php if($rows->coplevel==8){ echo 'selected="selected"'; } ?> value="8">Capitaine</option>
                </select>
              </div>
            </p>
          </div>
          <?php } ?>

          <?php if(Auth::isModo()){ ?>
          <div style="float:left; width:50%">
            <p>
            <strong>Grade :</strong>
              <div>
                <select disabled name="coplevel" class="form-control">
                  <option <?php if($rows->coplevel==0){ echo 'selected="selected"'; } ?> value="0">Civil</option>
                  <option <?php if($rows->coplevel==1){ echo 'selected="selected"'; } ?> value="1">Recrue</option>
                  <option <?php if($rows->coplevel==2){ echo 'selected="selected"'; } ?> value="2">Brigadier / Sergent</option>
                  <option <?php if($rows->coplevel==3){ echo 'selected="selected"'; } ?> value="3">Adjudant / Adjudant-chef</option>
                  <option <?php if($rows->coplevel==4){ echo 'selected="selected"'; } ?> value="4">Major / Aspirant</option>
                  <option <?php if($rows->coplevel==5){ echo 'selected="selected"'; } ?> value="5">Lieutenant</option>
                  <option <?php if($rows->coplevel==6){ echo 'selected="selected"'; } ?> value="6">Commandant</option>
                  <option <?php if($rows->coplevel==7){ echo 'selected="selected"'; } ?> value="7">Colonel</option>
									<option <?php if($rows->coplevel==8){ echo 'selected="selected"'; } ?> value="8">Capitaine</option>
                </select>
              </div>
            </p>
          </div>
          <?php } ?>

          <?php if(Auth::isGuest()){ ?>
          <div style="float:left; width:50%">
            <p>
            <strong>Grade :</strong>
              <div>
                <select disabled name="coplevel" class="form-control">
                  <option <?php if($rows->coplevel==0){ echo 'selected="selected"'; } ?> value="0">Civil</option>
                  <option <?php if($rows->coplevel==1){ echo 'selected="selected"'; } ?> value="1">Recrue</option>
                  <option <?php if($rows->coplevel==2){ echo 'selected="selected"'; } ?> value="2">Brigadier</option>
                  <option <?php if($rows->coplevel==3){ echo 'selected="selected"'; } ?> value="3">Sergent / Adjudant</option>
                  <option <?php if($rows->coplevel==4){ echo 'selected="selected"'; } ?> value="4">Major</option>
                  <option <?php if($rows->coplevel==5){ echo 'selected="selected"'; } ?> value="5">Lieutenant</option>
                  <option <?php if($rows->coplevel==6){ echo 'selected="selected"'; } ?> value="6">Commandant</option>
                  <option <?php if($rows->coplevel==7){ echo 'selected="selected"'; } ?> value="7">Colonel</option>
                </select>
              </div>
            </p>
          </div>
          <?php } ?>

          <!-- Donateur -->
          <?php if(Auth::isAdmin()){ ?>
          <div style="float:right; width:44%">
            <p>
            <strong>Donateur :</strong>
              <div style="width:35%; float:left;">
                <select name="donatorlvl" class="form-control">
                  <option <?php if($rows->donatorlvl==0){ echo 'selected="selected"'; } ?> value="0">Non</option>
                  <option <?php if($rows->donatorlvl==5){ echo 'selected="selected"'; } ?> value="5">Oui</option>
                </select>
              </div>
              <div style="width:60%; float:right;">
                <select name="mounthDon" class="form-control">
                  <option <?php if($rows->duredon==0){ echo 'selected="selected"'; } ?> value="0">Non donateur</option>
                  <option <?php if($rows->duredon==1){ echo 'selected="selected"'; } ?> value="1">1 mois</option>
                  <option <?php if($rows->duredon==2){ echo 'selected="selected"'; } ?> value="2">2 mois</option>
                  <option <?php if($rows->duredon==3){ echo 'selected="selected"'; } ?> value="3">3 mois</option>
                </select>
              </div>
            </p>
          </div>
          <?php } ?>

          <?php if(Auth::isModo()){ ?>
          <div style="float:right; width:44%">
            <p>
            <strong>Donateur :</strong>
              <div style="width:35%; float:left;">
                <select disabled name="donatorlvl" class="form-control">
                  <option <?php if($rows->donatorlvl==0){ echo 'selected="selected"'; } ?> value="0">Non</option>
                  <option <?php if($rows->donatorlvl==5){ echo 'selected="selected"'; } ?> value="5">Oui</option>
                </select>
              </div>
              <div style="width:60%; float:right;">
                <select disabled name="mounthDon" class="form-control">
                  <option <?php if($rows->duredon==0){ echo 'selected="selected"'; } ?> value="0">Non donateur</option>
                  <option <?php if($rows->duredon==1){ echo 'selected="selected"'; } ?> value="1">1 mois</option>
                  <option <?php if($rows->duredon==2){ echo 'selected="selected"'; } ?> value="2">2 mois</option>
                  <option <?php if($rows->duredon==3){ echo 'selected="selected"'; } ?> value="3">3 mois</option>
                </select>
              </div>
            </p>
          </div>
          <?php } ?>

          <?php if(Auth::isGuest()){ ?>
          <div style="float:right; width:44%">
            <p>
            <strong>Donateur :</strong>
              <div style="width:35%; float:left;">
                <select disabled name="donatorlvl" class="form-control">
                  <option <?php if($rows->donatorlvl==0){ echo 'selected="selected"'; } ?> value="0">Non</option>
                  <option <?php if($rows->donatorlvl==5){ echo 'selected="selected"'; } ?> value="5">Oui</option>
                </select>
              </div>
              <div style="width:60%; float:right;">
                <select disabled name="mounthDon" class="form-control">
                  <option <?php if($rows->duredon==0){ echo 'selected="selected"'; } ?> value="0">Non donateur</option>
                  <option <?php if($rows->duredon==1){ echo 'selected="selected"'; } ?> value="1">1 mois</option>
                  <option <?php if($rows->duredon==2){ echo 'selected="selected"'; } ?> value="2">2 mois</option>
                  <option <?php if($rows->duredon==3){ echo 'selected="selected"'; } ?> value="3">3 mois</option>
                </select>
              </div>
            </p>
          </div>
          <?php } ?>
        </div>

        <!-- Equipement civil visible par tous -->							
        <div style="float:right; width:48%;">
          <div>
            <p>
            <strong>Equipement civil :</strong>
              <div class="input-group" style="height:182px;">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-edit"></span>
                </span>
                <textarea disabled style="height:182px;" type="text" name="civ_gear" value="" class="form-control"><?=$rows->civ_gear?></textarea>
              </div>
            </p>
          </div>
        </div>

        <!-- Equipement police visible par tous -->
        <div style="float:right; width:48%;">
          <div>
            <p>
            <strong>Equipement police :</strong>
              <div class="input-group" style="height:250px;">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-pencil"></span>
                </span>
                <textarea disabled style="height:250px;" type="text" name="cop_gear" value="" class="form-control"><?=$rows->cop_gear?></textarea>
              </div>
            </p>
          </div>
        </div>
  
        
        <!-- Garage visible par tous -->
        <div style="float:left; width:48%;">
          <p>
            <strong>Garage :</strong>
          </p>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><b>Véhicules de <?=$rows->name?></b></h3>
            </div>
              <!-- Table -->
              <table class="table">
                <tbody>
                <?php
                  foreach ($res3->fetchAll() as $rows3)
                  {
                    echo (
                      '<tr><td><a href="https://community.bistudio.com/wiki/File:Arma3_CfgVehicles_'.$rows3->classname.'.jpg" onclick="window.open(this.href); return false;">'
                      .$rows3->classname.
                      '</a></td><td><span class="badge" style="background:#428BCA; width:auto; float:right;">'
                      .$rows3->nbr_doublon.
                      ' Examplaire(s)</span></td></tr>'
                      );
                  }
                ?>
                </tbody>
              </table>
          </div>
        </div>
      <!-- FIN -->
    </form>
		<?php
    // fin du if sur la recherche.
      }
    // Si le champs recherche n'est pas vide on effectue la recherche
      else {
        ?>
        <a href="/" class="list-group-item" style="background-color:#F8F8F8; color:#000; margin-top:140px;"><b>Liste des joueurs enregistrés sur le serveur ALTISLIFE</b></a>       
        <ul class="list-group" style="min-height: 298px; overflow: auto" name="search"> 
      <?php
        include 'search_req.php';
      }
		}
		?>
	</div>
  </div>