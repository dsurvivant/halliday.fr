<?php
//***********************************************************************************************
//** CREE PAR JMT NOV 2020
//**
//** Entree: $_POST['noTitre'] et $_POST['texteTitre']
//** SORTIE: echo pour le retour du texte suite appel AJAX
//**
//** Modification des paroles (envoyé en entrée) du titre ayant le numéro envoyé en entrée
//**
//************************************************************************************************
require_once '../login/login.php'; //parametres de connexion et connexion à la bdd
require_once '../classes/Titre.class.php';
require_once '../classes/TitreManager.class.php';

//connexion à la base de donnees
$bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
//variable $erreur: false si tout les champs sont valides (par défaut)
$erreur = false;

//=== SECURISATION DES CHAMPS
if (isset($_POST['noTitre']) and isset($_POST['texteTitre']))
    {
        $noTitre = $_POST['noTitre'];
        $texteTitre = $_POST['texteTitre'];
        $texteTitre = nl2br($texteTitre);
        
        //instanciation du titre
        $titre = new Titre(['noTitre' => $noTitre]);
        
        $manager = new TitresManager($bdd);
        $manager-> hydrateTitre($titre); //hydratation de la classe album

        //récupération des éléments
        $nomTitre =  $titre->getNomTitre();
        $parolesTitre = $titre->getParolesTitre();
        $musiqueTitre = $titre->getMusiqueTitre();

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