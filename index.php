<?php
	session_start();
/* AFFICHAGE DES ERREURS PHP */
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	try 
	{
		
		require('pages/site/controllers/controller.php');
		
		//contient la description de la page à afficher
		$page='accueil';
		//données de connection membre
		$pseudo='';
		$password='';
		//page courante
		$_SESSION['current_page'] = 'accueil';

		/*** 				 		  ***/
		/** CHOIX DE PAGE - ENTREES   **/
		/***						***/
		    
			//cas de mis à jour du mot de passe. Controle de validité
			if(isset($_POST['oldpassword'])) {verifierpassword($_POST['oldpassword']);exit;}

			//fiche album
			if (isset($_GET['fiche'])) { template('fiche'); }
			elseif (isset($_GET['decennie'])) { template('decennie'); }
			elseif (isset($_GET['demandeconnexion'])) { template('demandeconnexion');}
			elseif (isset($_GET['acces_membre'])) { template('acces_membre'); }
			elseif (isset($_GET['deconnexion'])) { template('deconnexion'); }
			elseif (isset($_GET['inscription'])) { template('inscription'); }
			elseif (isset($_GET['gestionsite'])) { template('gestionsite'); }
			elseif (isset($_GET['parametres'])) { template('parametres'); }
			elseif (isset($_GET['activation'])) { template('activation'); }
			else{template('accueil');}

	} 
	catch (Exception $e) 
	{
		template('error');
	}

	
	