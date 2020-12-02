<?php

$time = $value["timer"] - time();   //On calcule la différence avec le temps de fin avec le temps actuel
$h = (int)($time / 3600);   //On convertit la différence en heures
$m = (int)(($time %3600) / 60);     //On convertit la différence en minutes
$s = (int)(($time % 3600) % 60);    //On convertit la différence en secondes

if ($h < 10) {$h_txt = '0'.$h;} else {$h_txt = $h;} //Si les heures sont inférieures à 10, on rajoute un 0 pour faire joli, exemple: 1 => 01
if ($m < 10) {$m_txt = '0'.$m;} else {$m_txt = $m;} //De même pour les minutes
if ($s < 10) {$s_txt = '0'.$s;} else {$s_txt = $s;} //Et les secondes

if ($time === 0){
    echo 'OFFRE EXPIREE'; //Si le timer arrive à 0, l'enchère est expirée
}
else {
echo $h_txt . ':' . $m_txt . ':' . $s_txt;  //On affiche le temps restant
}



?>
