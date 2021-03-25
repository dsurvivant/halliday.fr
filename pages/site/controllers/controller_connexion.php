<?php
/**
 * CREE PAR JMT 25 mars 2021
 *
 * controlleur de connexion, deconnexion, inscription, activation du compte
 */
require_once ('pages/site/model/model.php');

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
			require "pages/site/views/waitinscription.php";
		}
		else
		{ 
			require "pages/site/views/forms/form_inscription.php"; 
		}
		
	}

	function demandeConnexion($pseudo='', $password='')
	{
		if (isset($_SESSION['noutil'])) 
		{
			?>
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
		    		$_SESSION=[];?>
		    		
		    		<h3 class="jumbotron"> 
		    			Votre compte n'est pas activé ou celui ci a été désactivé.
		    			Veuillez vous rapprocher si nécessaire de l'administrateur.
		    		</h3>
		    		<?php
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
?>