<?php
	
	require ('pages/site/model/model.php');
	
	/**
	 * [affichageMenu description]
	 * @return [type] [description]
	 */
	function afficherFiche()
	{
		$fiche = $_GET['fiche'];
		ob_start();
			if (file_exists("pages/site/albums/fiches_albums/" . $fiche . ".php"))
			{ require("pages/site/albums/fiches_albums/" . $fiche . ".php");}
			else
			{ require("pages/site/albums/fiches_albums/fiche_inconnue.php");}
		return ob_get_clean();

		return $corpspage;
	}

	function afficherAccueil()
	{
		ob_start();
			require("pages/site/views/accueil/accueil_inc.php");
		return ob_get_clean();
	}

	function afficherDecennie($bdd)
	{
		ob_start();
			 require("pages/site/albums/liste_albums.php");
		return ob_get_clean();
	}

	/**
	 * [demandeConnexion() Affiche le formulaire de connexion. Traite également le retour 
	 * du formulaire de connexion.]
	 * @return [type] [description]
	 */
	function demandeConnexion($pseudo='', $password='')
	{
		ob_start();
		if (isset($_SESSION['noutil'])) 
		{
			?>
			<br>
			<p class="jumbotron">Mais.. Dites moi.. Vous êtes déjà connecté !</p>
			<?php
		}
		else if (isset($_POST['pseudo']) and isset($_POST['motdepasse'])) //retour formulaire de connexion utilisateur
		{
		    
		    $connection = connexionUtilisateur($_POST['pseudo'],$_POST['motdepasse']);

		    if ($connection) 
		    {
		    	if($_SESSION['actif']==1){header('location:index.php?acces_membre');}
		    	else 
		    	{
		    		$_SESSION=[];
		    		ob_start(); ?>
		    		
		    		<h3 class="jumbotron"> 
		    			Votre compte n'est pas activé ou celui ci a été désactivé.
		    			Veuillez vous rapprocher si nécessaire de l'administrateur.
		    		</h3>
		    		<?php
		    		return ob_get_clean();
		    	}
		    }
		    //les paramètres de connexion ne sont pas valables
		    else 
		    {
		    	?> <h3>Identifiants non valables</h3><?php
		    	$pseudo = $_POST['pseudo'];
		    	$password = $_POST['motdepasse'];
		    	require ('pages/site/views/forms/form_connexion.php');
		    }
		}
		else
		{
			require ('pages/site/views/forms/form_connexion.php'); 
		}
		return ob_get_clean();
	}

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

	function afficherMenu($page)
	{
		//*****
		//	Menu
		//*****
			ob_start();
			if($_SESSION['current_page'] = 'acces_membre')
			{
				?><ul id="menu_principal" class="nav navbar-nav">
				<?php include ("pages/site/albums/menu_inc.php")
				?></ul><?php		
			}
									
			//** CONNEXION UTILISATEUR 				
			// ici on affiche le nom du pseudo, et un menu lié au pseudo
			// ou le bouton de connexion si on est pas connecté

			if(isset($_SESSION['noutil'])) //déjà connecté
			{
					?>
					<!-- affichage du pseudo, et bouton déconnexion -->
					<ul class="nav navbar-nav navbar-right hidden-xs">
						<li class="dropdown"> 
							<a data-toggle="dropdown"><?php echo "<span id='nom_utilisateur'>Bienvenue " . $_SESSION['pseudo'] . "</span>";?> <b class="caret"></b>
							</a>

							<ul class="dropdown-menu">
								
								<?php
									if ($page=="acces_membre") {
										?> <li id="retourausite"><a href="index.php?accueil">Retour au site</a></li> <?php
									}
									else
									{
										?> <li id="acces_membre"><a href="index.php?acces_membre">Acces Membres</a></li>
									<?php } 
								if (isset($_SESSION['administrateur']))
								{
									if($_SESSION['administrateur']==1)
									{
										?><li id="acces_membre"><a href="index.php?gestionsite">Gestion du site</a></li><?php
									}
								}?>
								<li id="acces_membre"><a href="index.php?parametres">Paramètres</a></li>
								<li><a href="index.php?deconnexion">Déconnexion</a></li>
							</ul>
						</li>
					</ul>
					<?php
			}
			else
			{
				?>
				<div class="text-right">
					<a href="index.php?demandeconnexion">
						<button type="button" class="btn btn-primary btn-sm hidden-xs"><span class="glyphicon glyphicon-user"></span></button>
					</a>
				</div>
				<?php
			}
			$menu = ob_get_clean();
			return $menu;
	}

	function afficherErreur($e)
	{
		ob_start();
			echo "<h3>" . $e->getMessage() ."</h3>";
		return ob_get_clean();
	}

	/**
	 * afficherInscription()
	 * fonction qui affiche le formulaire d'inscription
	 * fonction qui traite également de la validation du formulaire d'inscription ( controles des champs, ajout à la bdd)
	 * @return [type] [description]
	 */
	function afficherInscription()
	{
		if (isset($_POST['pseudo']) and isset($_POST['nom']) and isset($_POST['prenom']) and isset($_POST['email']) and isset($_POST['motdepasse']) and isset($_POST['confirm_motdepasse']))
		{
			//protection des champs contre injection
			$pseudo = trim(sanitizeString($_POST['pseudo']));
			$nom = trim(sanitizeString($_POST['nom']));
			$prenom = trim(sanitizeString($_POST['prenom']));
			$email = trim(sanitizeString($_POST['email']));
			$email = strtolower($email);
			$password = trim(sanitizeString($_POST['motdepasse']));
			$confirmPassword = trim(sanitizeString($_POST['confirm_motdepasse']));

			//vérification concordance des mots de passe
			if ($password != $confirmPassword) { throw new Exception("Les mots de passe ne sont pas identiques");
			}

			//vérifications champs non vident
			if ($pseudo == '') { throw new Exception("pseudo non valide");}
			if ($nom == '') { throw new Exception("nom non valide");}
			if ($prenom == '') { throw new Exception("prenom non valide");}
			if ($email == '') { throw new Exception("email non valide");}
			if ($password == '') { throw new Exception("motdepasse non valide");}

			//Vérification format email
			if (!validationemail($email)) {throw new Exception("Format email non valide");
			}

			//vérification critères password
			if (!validationmotdepasse($password)) {throw new Exception("Mot de passe refusé. Critères non respectés");
			}
				
			//vérification pseudo unique
			$exist = findPseudo($pseudo);
			if ($exist) {throw new Exception("Le pseudo existe déjà");
			}

			//vérification email unique
			$exist = findEmail($email);
			if($exist) {throw new Exception("Cette adresse mail existe déjà");
			}
			//
			$password = cryptagemotdepasse($password);
			$cle = md5(microtime(TRUE)*10000);
			$actif = 0;

			//enregistrement de l'utilisateur dans la bdd
			ajouterUtilisateur ($prenom, $nom, $pseudo, $password, $email, $cle, $actif);

			//preparation et envoie du mail
			$sujet = "Activer votre compte Halliday.fr";
			$entete = "From: inscription@halliday.fr";
			$message = 'Bienvenue sur le site Halliday.fr. Pour activer votre compte, veuillez cliquer sur le lien ci dessous ou copier/coller celui ci dans votre navigateur internet

			https://halliday.fr/index.php?activation&log='. urlencode($pseudo) . '&cle=' . urlencode($cle) .'



			--------------------------------------------------------
			Ceci est un mail automatique, Merci de na pas y répondre.';

			mail($email, $sujet, $message, $entete);
			mail('jmtentelier@gmail.com','nouvelle inscription','nouvelle inscription sur halliday.fr',$entete);

			//retour vers l'accueil
			ob_start();
			require "pages/site/views/waitinscription.php";
			return ob_get_clean();
				
		}
		else
		{ 
			ob_start();
			require "pages/site/views/forms/form_inscription.php"; 
			return ob_get_clean();
		}
		
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
					$exist = findEmail($email);
					if($exist) {$error=1; $_SESSION['message']="Cette adresse mail existe déjà";}
				}
				
				//enregistrement des donnees utilisateurs
				if ($error==0) 
				{
					if ($password!='') {$password = cryptagemotdepasse($password);}
					$util = modifierUtilisateur($_SESSION['noutil'], $prenom, $nom, $pseudo, $password, $email);
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

	//fonction d'activation utilisateur suite au retour du lien dans mail de validation
	function activation()
	{
		if(isset($_GET['log']) and isset($_GET['cle']))
		{
			$pseudo = $_GET['log'];
			$cle = $_GET['cle'];

			//instanciation de l'utilisateur
			$utilisateur = util($pseudo);
			$actif = $utilisateur->getActif();
			$cleutil = $utilisateur->GetCle();
			
			if ($actif==1) //déjà activé
			{
				ob_start();
				echo "<h3 class='jumbotron'>Vous êtes déjà activé</h3>";
				return ob_get_clean();
			}
			else
			{	
				if($cleutil==$cle)
				{
					//la cle est valable, on active le compte
					activerUtilisateur($pseudo);
					
					ob_start();
					echo("<h3 class='jumbotron'>Votre compte vient d'être activé.<br> Bienvenue sur halliday.fr<br>Merci de vous reconnecter pour profiter des services du site</h3>");
					return ob_get_clean();
				}
				else
				{
					ob_start();
					echo("<h3 class='jumbotron'>Opération impossible. Merci de contacter l'administrateur</h3>");
					return ob_get_clean();
				}
			}
		}
		else
		{
			header("location:index.php");
		}
	}

	function template($page)
	{
		global $bdd;
		global $pseudo;
		global $password;
		global $e;
		
		switch ($page) 
		{
			case 'fiche':
				$_SESSION['current_page'] = 'fiche';
				$corpspage = afficherFiche();
				break;
			case 'accueil':
				$_SESSION['current_page'] = 'accueil';
				$corpspage = afficherAccueil();
				break;
			case 'decennie':
				$_SESSION['current_page'] = 'decennie';
				$corpspage = afficherDecennie($bdd);
				break;
			case 'demandeconnexion':
				$_SESSION['current_page'] = 'demandeconnexion';
				$corpspage = demandeConnexion($pseudo, $password);
				break;
			case 'acces_membre':
				$_SESSION['current_page'] = 'acces_membre';
				$corpspage = afficherAccesMembre();
				break;
			case 'error':
				$_SESSION['current_page'] = 'error';
				$corpspage = afficherErreur($e);
				break;
			case 'deconnexion':
				$_SESSION = array();
				$_SESSION['current_page'] = 'accueil';
				$corpspage = afficherAccueil();
				break;
			case 'gestionsite':
				$_SESSION['current_page'] = 'gestionsite';
				$corpspage = afficherGestionsite();
				# code...
				break;
			case 'inscription':
				$_SESSION['current_page'] = 'inscription';
				$corpspage = afficherInscription();
				break;
			case 'parametres':
				$_SESSION['current_page'] = 'parametres';
				$corpspage = afficherParametres();
				break;
			case 'activation':
				$_SESSION['current_page'] = 'activation';
				$corpspage = activation();
				break;
			default:
				$_SESSION['current_page'] = 'accueil';
				$corpspage = afficherAccueil();
				break;
		}

		//$menu = afficherMenu($page);
		require ('pages/site/views/template.php');
	}
	

	
	