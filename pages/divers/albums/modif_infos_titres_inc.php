<?php
//***********************************************************************************************
//** CREE PAR JMT JANV 2021
//**
//** Entree: $_POST['noTitre'], $_POST['parolesTitre'] et $_POST['musiqueTitre']
//** SORTIE: rien
//**
//** Modification des infos générales (envoyé en entrée) du titre ayant le numéro envoyé en entrée
//**
//************************************************************************************************

require_once '../login/login.php'; //parametres de connexion et connexion à la bdd
require_once '../classes/Titre.class.php';
require_once '../classes/TitresManager.class.php';
require_once '../fonctions/fonctions.php';

//connexion à la base de donnees
$bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
//variable $erreur: false si tout les champs sont valides (par défaut)
$erreur = false;

//=== SECURISATION DES CHAMPS
if (isset($_POST['noTitre']) and isset($_POST['parolesTitre']) and isset($_POST['musiqueTitre']))
    {
        $noTitre = $_POST['noTitre'];
        $parolesTitre = sanitizeString($_POST['parolesTitre']);
        $musiqueTitre = sanitizeString($_POST['musiqueTitre']);
        
        //instanciation du titre
        $titre = new Titre(['noTitre' => $noTitre]);
        
        $manager = new TitresManager($bdd);
        $manager-> hydrateTitre($titre); //hydratation de la classe titre

        //récupération des éléments
        $nomTitre =  $titre->getNomTitre();
        $texteTitre = $titre->getTexteTitre();

        $titre = new Titre (
        	[
        		'noTitre' => $noTitre,
        		'nomTitre' => $nomTitre,
        		'parolesTitre' => $parolesTitre,
        		'musiqueTitre' => $musiqueTitre,
        		'texteTitre' => $texteTitre
        	]);

        $manager->update($titre);

        echo ($texteTitre);     
    }