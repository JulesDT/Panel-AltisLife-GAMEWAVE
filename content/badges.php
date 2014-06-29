<?php
// Temps restant pour le don
$nbrjour=($duredon*30); // Nombre de jour (30,60 ou 90)
$tpsdons=((time())-($row->timestamp)); // date acctuelle moins la date du don (en timestamp)
$tpsdons=($nbrjour-ceil($tpsdons / (60 * 60 * 24))); // Transformation de la difference en nombre de jour

				//Donateur ou non
if ($dntr_lvl==0){
    echo '<span class="badge" style="width:80px;" data-container="body" data-toggle="popover" data-placement="top" title="'. $pseudo .'" data-content="Membre non donateur"> non <span class="glyphicon glyphicon-heart" style="font-size:10px;"></span></span>';}
  else {
    echo '<span class="badge" style="background:#D9534F; width:80px;"data-container="body"  data-toggle="popover" data-placement="top" title="'. $pseudo .'" data-content="Membre donateur pour '. $duredon .' mois, il lui reste '. $tpsdons .' jours.">'. $tpsdons .' jours <span class="glyphicon glyphicon-heart" style="font-size:10px;"></span></span>';}
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
?>