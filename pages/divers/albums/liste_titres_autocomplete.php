<?php
//
//michemuche62
//made in rock'n'roll
//*********************************
//*****
//***** Page utilisée par ajoutAlbum.js pour l'autocompletion des titres
//***** 
//*****
//*********************************

require_once '../login/login.php'; //parametres de connexion et connexion à la bdd
require_once '../classes/Titre.class.php';
require_once '../classes/TitresManager.class.php';
require_once '../fonctions/fonctions.php'; //fonction de sécurité des saisies

//tableau des titres
$titres = [];

//connexion à la base de donnees
$bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));

//$term = $_GET['term'];
//$term = htmlentities($term);

// appel par ligne de commande
if (isset($_GET['term'])) { $term = htmlentities($_GET['term']); }
// 
$requete = $bdd->prepare('SELECT * FROM titres WHERE nomTitre LIKE :term'); // j'effectue ma requête SQL grâce au mot-clé LIKE
$requete->execute(array(':term' => $term.'%'));

$array = array(); // on créé le tableau

while($donnee = $requete->fetch()) // on effectue une boucle pour obtenir les données
{
	$titre = html_entity_decode($donnee['nomTitre']); //pour autocomplete
    array_push($array, $titre); // et on ajoute celles-ci à notre tableau

    $titres[] = new Titre($donnee); //pour tableau des titres
}

//echo json_encode($array); // il n'y a plus qu'à convertir en JSON
$titresligne = implode ("-", $array);

//retour
// si appel par la feuille listetitres_inc.php alors $_POST['recherchetitre'] existe sinon il n'existe pas
if (!isset($_POST['recherchetitre'])) { echo $titresligne; } 
?>