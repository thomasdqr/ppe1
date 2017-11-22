<?php

$BaseDeDonnees = new PDO('mysql:host=localhost;dbname=gsb', 'root','');

$id_user = $_GET['id_user'];
$nuits = $_GET['nuits'];
$repas = $_GET['repas'];
$km = $_GET['km'];

$BaseDeDonnees->query("UPDATE frais_forfait SET nuits='$nuits', repas='$repas', kilometres='$km' WHERE id_visiteur='$id_user'");

?>