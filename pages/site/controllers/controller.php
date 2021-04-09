<?php
	
	require_once ('pages/site/model/modelUtilisateurs.php');
	require_once ('pages/site/model/modelAlbums.php');
	require_once ('pages/site/model/modelTitres.php');
	
	/**
	 * initialisation des donnees retourne un tableau contenant
	 * les objets albums par annees et les titres
	 * @return [array] (objetsalbums, objetstitres)
	 */
	function initdonnees()
	{
		$reponse = array();

		$_SESSION['albums'] = rechercheAlbumsByDate();
		$_SESSION['titres'] = rechercheTitres();
		$_SESSION['liaisonAlbumsTitres'] = rechercheLiaisonTitresAlbums();
	}

	/**
	 * [affichageMenu description]
	 * @return [type] [description]
	 */
	function afficherFiche()
	{
		$noalbum = $_GET['noalbum'];
		ob_start();
			require("pages/site/views/albums/fiche_album.php");
		return  ob_get_clean();
	}

	function afficherAccueil()
	{
		require("pages/site/views/accueil/accueil_inc.php");
	}

	function afficherDecennie($bdd)
	{
		ob_start();
			 require("pages/site/views/albums/liste_albums.php");
		return ob_get_clean();
	}

	/**
	 * [demandeConnexion() Affiche le formulaire de connexion. Traite également le retour 
	 * du formulaire de connexion.]
	 * @return [type] [description]
	 */
	

	function afficherAccesMembre()
	{
		ob_start();
			if (isset($_SESSION['noutil'])) 
			{
		    	require ("pages/divers/admin.php");
		    }
		    else
		    {
		    	throw new Exception("Merci de passer par le formulaire pour vous identifier");
		    }
		return ob_get_clean();
	}

	function afficherGestionsite()
	{
		$_SESSION['message']='';
		//accessible uniquement aux administrateurs
		if ($_SESSION['administrateur']==1)
		{
			//cas d'une modification
			if (isset($_POST['btn_modifier']))
			{
				//récupération et sécurisation des champs
				$noutilisateur = $_POST['noutilisateur'];
				$pseudo = sanitizeString(trim($_POST['pseudo']));
				$nom = sanitizeString(trim($_POST['nom']));
				$prenom = sanitizeString(trim($_POST['prenom']));
				$email = sanitizeString(trim($_POST['email']));
				$password = sanitizeString(trim($_POST['password']));
				$confirmpassword = sanitizeString(trim($_POST['confirmpassword']));
				$ajouteralbum = sanitizeString(trim($_POST['ajouteralbum']));
				$modifieralbum = sanitizeString(trim($_POST['modifieralbum']));
				$supprimeralbum = sanitizeString(trim($_POST['supprimeralbum']));
				$modifierinfostitre = sanitizeString(trim($_POST['modifierinfostitre']));
				$modifierparolestitre = sanitizeString(trim($_POST['modifierparolestitre']));
				$actif = sanitizeString(trim($_POST['actif']));

				//vérification des champs
				if ($pseudo=='' or $nom=='' or $prenom=='' or $email=='') {$_SESSION['message']="Tous les champs doivent être remplis. (sauf Les champs mots de passe, éventuellement)";}
				elseif(!validationemail($email)) {$_SESSION['message']= "l'adresse email n'est pas valide" ;}
				elseif ($password != $confirmpassword) { $_SESSION['message']="Les mots de passe ne sont pas identiques";}
				elseif($password!='' and !validationmotdepasse($password)) { $_SESSION['message']="Le mot de passe ne respecte pas les critères";}
				else //enregistrement de la mis à jour
				{
					if($password!='') { $password = cryptagemotdepasse($password); }
					//enregistrement de l'utilisateur dans la bdd
					modifierUtilisateur ($noutilisateur, $prenom, $nom, $pseudo, $password, $email, $actif);
					modifierDroitsUtilisateur($noutilisateur, $ajouteralbum, $modifieralbum, $supprimeralbum, $modifierinfostitre, $modifierparolestitre);

					$_SESSION['message'] = "MIS A JOUR EFFECTUEE AVEC SUCCESS";
				}

				

				//modification
			}
			//cas d'une suppression
			if(isset($_POST['btn_supprimer']))
			{
				echo ("suppression");
				exit;
			}
			//affichage de la page
			ob_start();
				//récupération de la liste des utilisateurs
				$utilisateurs = listUtilisateurs();
				//récupération des droits de l'utilisateur affiché
				if (isset($_GET['noutilisateur'])) 
					{ $noutilisateur = $_GET['noutilisateur']; }
				else 
					{
						$utilisateur = $utilisateurs[0];
						$noutilisateur=$utilisateur->getNoutil();
					}

				$droits = droitsUtilisateur($noutilisateur);
				$ajouteralbum = $droits->getAjoutalbum();
				$modifieralbum = $droits->getModifieralbum();
				$supprimeralbum = $droits->getSupprimeralbum();
				$modifierinfostitre = $droits->getModifierinfostitre();
				$modifierparolestitre = $droits->getModifierparolestitre();

				require("pages/divers/views/gestionsite.php");
			return ob_get_clean();
		}
		else{throw new Exception("Page inexistante");}
	}

	function afficherParametres()
	{
		$_SESSION['message']='';
		$error = 0;
		if (isset($_SESSION['noutil']))
		{
			if(isset($_GET['modifierprofil']))
			{
				//sécurisation des champs
				$pseudo = sanitizeString(trim($_POST['pseudo']));
				$nom= sanitizeString(trim($_POST['nom']));
				$prenom = sanitizeString(trim($_POST['prenom']));
				$email = sanitizeString(trim($_POST['email']));
				$old_password = sanitizeString(trim($_POST['old_password']));
				$password = sanitizeString(trim($_POST['password']));
				$confirm_password = sanitizeString(trim($_POST['confirm_password']));

				//champs non vident
				if($pseudo=='' or $nom=='' or $prenom=='' or $email=='')
				{$error=1; $_SESSION['message']='Modification non valable. Merci de remplir tous les champs';}

				//vérification concordance des mots de passe
				if ($password != $confirm_password) {$error=1; $_SESSION['message']='Les mots de passe ne sont pas identiques';}
				//controle mots de passes
				if($password!='')
				{
					//vérification critères password
					if (!validationmotdepasse($password)) {$error=1; $_SESSION['message']="Mot de passe refusé. Critères non respectés";}
					//vérification ancien mot de passe
					$password_bdd = getMdp($_SESSION['noutil']);
					if ($password_bdd != cryptagemotdepasse($old_password)){$error=1; $_SESSION['message']="L'ancien mot de passe n'est pas valide";}

					//vérification si nouveau de passe différent
					if($password_bdd==cryptagemotdepasse($password)){$error=1; $_SESSION['message']="Le nouveau mot de passe est identique à l'ancien";}
				}
				//Vérification format email
				if (!validationemail($email)) {$error=1; $_SESSION['message']='Format email non valide';}
				
				//vérification pseudo unique
				if($pseudo!=$_SESSION['pseudo'])
				{
					$exist = findPseudo($pseudo);
					if ($exist) {$error=1; $_SESSION['message']="Le pseudo existe déjà";}
				}
				//vérification email unique
				if($email!=$_SESSION['email'])
				{
					$util = new Utilisateur(['email'=>$email]);
					$exist = findEmail($util);
					if($exist) {$error=1; $_SESSION['message']="Cette adresse mail existe déjà";}
				}
				
				//enregistrement des donnees utilisateurs
				if ($error==0) 
				{
					if ($password!='') {$password = cryptagemotdepasse($password);}
					$util = modifierUtilisateur($_SESSION['noutil'], $prenom, $nom, $pseudo, $password, $email,'1');
					$_SESSION['message'] = "Informations mis à jour avec succes";

					$_SESSION['nomutil'] = $util->getNom();
					$_SESSION['prenomutil'] = $util->getPrenom();
					$_SESSION['pseudo'] = $util->getPseudo();
					$_SESSION['email'] = $util->getEmail();
				}

			}

			ob_start();
			require('pages/divers/views/parametres.php');
			return ob_get_clean();
		}
		else
		{
			header('location: index.php');
		}
		
	}

	//verifie si l'ancien mot de passe est valable (utile pour modifier mot de passe)
	function verifierpassword($old_password)
	{
		$password_bdd = getMdp($_SESSION['noutil']);
		if ($password_bdd == cryptagemotdepasse($old_password)){echo "valide";}
		else { echo "non valide";}
	}


	function template($page)
	{
		global $bdd;
		global $pseudo;
		global $password;
		global $e;
		
		switch ($page) 
		{
			case 'decennie':
				$_SESSION['current_page'] = 'decennie';
				$corpspage = afficherDecennie($bdd);
				break;
			case 'acces_membre':
				$_SESSION['current_page'] = 'acces_membre';
				$corpspage = afficherAccesMembre();
				break;
			case 'gestionsite':
				$_SESSION['current_page'] = 'gestionsite';
				$corpspage = afficherGestionsite();
				# code...
				break;
			case 'parametres':
				$_SESSION['current_page'] = 'parametres';
				$corpspage = afficherParametres();
				break;
		}

		//$menu = afficherMenu($page);
		require ('pages/site/views/template.php');
	}
	

	
	