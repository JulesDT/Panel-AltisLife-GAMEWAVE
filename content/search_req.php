<?php
  ///////////////////////////// Requète préparé //////////////////////////////////////
  
  /* TESTS
  echo '<pre>';
  print_r($_POST);
  echo '</pre>';
  */

  $search = $DB->prepare("SELECT DISTINCT * FROM players WHERE name LIKE :search_value OR playerid LIKE :search_value OR aliases LIKE :search_value");
  $search->bindValue(':search_value', '%'. $search_value . '%');
  $search->execute();
 
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
    // Fermeture des résultats
    $search->closeCursor(); 
?>