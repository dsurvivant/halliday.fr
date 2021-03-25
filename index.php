<?php
	session_start();
/* AFFICHAGE DES ERREURS PHP */
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	try 
	{
		
		require('pages/site/controllers/controller.php');
		require('pages/site/controllers/controller_connexion.php');
		
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
			if (isset($_GET['fiche'])) 
				{ 
					$_SESSION['current_page'] = 'fiche';
					afficherFiche();
				}
			elseif (isset($_GET['decennie'])) { template('decennie'); }
			elseif (isset($_GET['demandeconnexion'])) 
				{ 
					$_SESSION['current_page'] = 'demandeconnexion'; 
					demandeConnexion();
				}
			elseif (isset($_GET['acces_membre'])) { template('acces_membre'); }
			elseif (isset($_GET['deconnexion'])) 
				{ 
					$_SESSION = array();
					$_SESSION['current_page'] = 'accueil';
					$corpspage = afficherAccueil(); 
				}
			elseif (isset($_GET['inscription'])) 
				{ 
					$_SESSION['current_page'] = 'inscription'; 
					afficherInscription(); 
				}
			elseif (isset($_GET['gestionsite'])) { template('gestionsite'); }
			elseif (isset($_GET['parametres'])) { template('parametres'); }
			elseif (isset($_GET['activation'])) 
				{ 
					$_SESSION['current_page'] = 'activation';
					$titre = "Activation";
					$corpspage = activation(); 
					include ("pages/site/views/template.php");
				}
			else
				{
					$_SESSION['current_page'] = 'accueil';
					afficherAccueil();
				}

	} 
	catch (Exception $e) 
	{
		$_SESSION['current_page'] = 'error';
		$titre = "Erreur";

		$corpspage = "<h3>" . $e->getMessage() ."</h3>";
		include ("pages/site/views/template.php");
	}

	
	