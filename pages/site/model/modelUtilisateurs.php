<?php

//autochargement des classes
	function chargerClasse($classe)
	{
		require 'pages/divers/classes/' . $classe . '.class.php';
	}
	spl_autoload_register('chargerClasse');
	
require("pages/site/fonctions/login.php");
require("pages/divers/fonctions/fonctions.php");

$bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));


/*** 			 		   ***/
/** CONNEXION UTILISATEUR  **/
/***		  			 ***/
	function connexionUtilisateur($pseudo, $password)
	{
	    global $bdd;
	   
	    //=== SECURISATION DES CHAMPS
	    $pseudo = trim(sanitizeString($pseudo));
	    $motdepasse = trim(sanitizeString($password));

	    //instanciation de l'utilisateur avec le pseudo saisi
	    $util = new Utilisateur(['pseudo'=>$pseudo]);
	    $manager = new UtilisateursManager($bdd);
	                                                    
	    $utilisateur = $manager->findPseudoUtilisateur($util);
	                                                    
	    if ($utilisateur)
	    {
	    	// VERIFICATION DE LA VALIDITE DU MOT DE PASSE
		    $motdepassecrypte = cryptagemotdepasse($motdepasse);

		    if ($motdepassecrypte == $util->getMotdepasse()) 
		    { 
		        // CONNEXION AUTORISEE
		        $_SESSION['noutil'] =$util->getNoutil();
		        $_SESSION['nomutil']=$util->getNom();
		        $_SESSION['prenomutil']=$util->getPrenom();
		        $_SESSION['pseudo']= $util->getPseudo();
		        $_SESSION['email']= $util->getEmail();
		        $_SESSION['dateinscription']= $util->getDateinscription();
		        $_SESSION['cle']= $util->getCle();
		        $_SESSION['actif']= $util->getActif();

		        //récupération des droits
		        $droits = new Droits(['noutil'=>$_SESSION['noutil']]);
		        $managerdroits = new DroitsManager($bdd);
		        $managerdroits->findDroits($droits);

		        $_SESSION['ajoutalbum'] = $droits->getAjoutalbum();
		        $_SESSION['modifieralbum'] = $droits->getModifieralbum();
		        $_SESSION['supprimeralbum'] = $droits->getSupprimeralbum();
		        $_SESSION['modifierinfostitre'] = $droits->getModifierinfostitre();
		        $_SESSION['modifierparolestitre'] = $droits->getModifierparolestitre();
		        $_SESSION['administrateur'] = $droits->getAdministrateur();

		        return true;
		    }
		    else { return false; }
		} 
	    else
	    {
	    	return false;
	    }
	   
	}

/***					   										***/
/*** Retourne mot de passe d'un utilisateur à partir du noutil ***/
/***														   ***/
	function getMdp($noutil)
	{
		global $bdd;

	    //instanciation de l'utilisateur avec le pseudo saisi
	    $util = new Utilisateur(['noutil'=>$noutil]);
	    $manager = new UtilisateursManager($bdd);
	                                                    
	    $utilisateur = $manager->findNoUtilisateur($util);

	    return $utilisateur->getMotdepasse();
	}

/***					   										***/
/*** Retourne mot de passe d'un utilisateur à partir du pseudo ***/
/***														   ***/
	function getpassword($pseudo)
	{
		global $bdd;

	    //instanciation de l'utilisateur avec le pseudo saisi
	    $util = new Utilisateur(['pseudo'=>$pseudo]);
	    $manager = new UtilisateursManager($bdd);
	    $manager->findPseudoUtilisateur($util);
	   
	    return $util->getMotdepasse();
	}

/**
 * retourne l'état actif on non actif de l'utilisateur
 * ENTREE: $pseudo: pseudo de l'utilisateur
 */
	function util($pseudo)
	{
		global $bdd;
		$util = new Utilisateur(['pseudo'=>$pseudo]);
		$manager = new UtilisateursManager($bdd);
		$manager->findPseudoUtilisateur($util);

		return $util;
	}

/**
 * [activation d'un utilisateur]
 * @param  [type] $pseudo [pseudo de l'utilisateur à activer]
 * @return [type]         [description]
 */
	function activerUtilisateur($pseudo)
	{
		global $bdd;
		$util = new Utilisateur(['pseudo'=>$pseudo]);
		$manager = new UtilisateursManager($bdd);
		$manager->activer($util);
	}
/*** 			 		   ***/
/** RECHERCHE SI LE PSEUDO UTILISATEUR EXISTE DEJA: retourne true ou false  **/
/***		  			 ***/
	function findPseudo($pseudo)
	{
	    global $bdd;
	   
	    //=== SECURISATION DES CHAMPS
	    $pseudo = trim(sanitizeString($pseudo));

	    //instanciation de l'utilisateur avec le pseudo saisi
	    $util = new Utilisateur(['pseudo'=>$pseudo]);
	    $manager = new UtilisateursManager($bdd);
	                                                    
	    $utilisateur = $manager->findPseudoUtilisateur($util);
	                                                    
	    if ($utilisateur) { return true; }
	    else { return false; }
	   
	}

/*** 			 		   ***/
/** RECHERCHE SI L'email UTILISATEUR EXISTE DEJA: retourne true ou false  **/
/***		  			 ***/
	function findEmail($email)
	{
	    global $bdd;
	   
	    //=== SECURISATION DES CHAMPS
	    $email = trim(sanitizeString($email));

	    //instanciation de l'utilisateur avec le pseudo saisi
	    $util = new Utilisateur(['email'=>$email]);
	    $manager = new UtilisateursManager($bdd);
	                                                    
	    $utilisateur = $manager->findEmailUtilisateur($util);
	                                                    
	    if ($utilisateur) { return true; }
	    else { return false; }
	   
	}

	/**
	 * ajouterUtilisateur($prenom, $nom, $pseudo, $password, $email)
	 * ajoute un utilisateur à la bdd.
	 * Les champs seront controlés avant l'appel à cette fonction
	 * Le mot de passe sera également crypté avant l'appel
	 * @param  [type] $prenom   [description]
	 * @param  [type] $nom      [description]
	 * @param  [type] $pseudo   [description]
	 * @param  [type] $password [description]
	 * @param  [type] $email    [description]
	 * @return   [<retourne le numéro d'utilisateur>]
	 */
	function ajouterUtilisateur ($prenom, $nom, $pseudo, $password, $email, $cle, $actif)
	{
		global $bdd;
		
		$util = new Utilisateur(['prenom'=> $prenom, 'nom' => $nom, 'pseudo' => $pseudo, 'motdepasse' => $password, 'email' => $email, 'cle' => $cle, 'actif' => $actif]);
	    $manager = new UtilisateursManager($bdd);
	    $idutilisateur = $manager->add($util);

	    //mis à jour de la table des droits (aucun droit par défaut)
	    $droits = new Droits(['noutil'=>$idutilisateur,'ajoutalbum'=>'0','modifieralbum'=>'0','supprimeralbum'=>'0','modifierinfostitre'=>'0','modifierparolestitre'=>'0','administrateur'=>'0']);
	    $managerdroits = new DroitsManager($bdd);
	    $managerdroits->add($droits);

	    return $idutilisateur;

	}

	function modifierUtilisateur($noutilisateur, $prenom, $nom, $pseudo, $password, $email, $actif)
	{
		global $bdd;
		
		if ($password=='') 
		{
			$util = new Utilisateur(['noutil'=>$noutilisateur, 'prenom'=> $prenom, 'nom' => $nom, 'pseudo' => $pseudo, 'email' => $email, 'actif' => $actif]);
	    	$manager = new UtilisateursManager($bdd);
	    	$idutilisateur = $manager->updatewithoutmdp($util);
		}
		else
		{
			$util = new Utilisateur(['noutil'=>$noutilisateur, 'prenom'=> $prenom, 'nom' => $nom, 'pseudo' => $pseudo, 'motdepasse' => $password, 'email' => $email, 'actif' => $actif]);
	    	$manager = new UtilisateursManager($bdd);
	    	$idutilisateur = $manager->update($util);
	    }

	    return $util;
	}

	/**
	 * récupère la liste des utilisateur
	 * @return [array] retourne un tableau contanant les objets utilisateurs
	 */
	function listUtilisateurs()
	{
		global $bdd;
		$manager = new UtilisateursManager($bdd);

		return $manager->getList();
	}

	function droitsUtilisateur($noutilisateur)
	{
		global $bdd;

		$droits = new Droits(['noutil' => $noutilisateur]);
		$manager = new DroitsManager($bdd);

		$manager->findDroits($droits);
		return $droits;
	}

/**
 * DROITS UTILISATEURS
 * 
 */
	function modifierDroitsUtilisateur($noutilisateur, $ajouteralbum, $modifieralbum, $supprimeralbum, $modifierinfostitre, $modifierparolestitre)
	{
		global $bdd;

		$droits = new Droits([ 'noutil'=>$noutilisateur, 
							   'ajoutalbum'=>$ajouteralbum, 
							   'modifieralbum'=>$modifieralbum, 
							   'supprimeralbum'=>$supprimeralbum,
							   'modifierinfostitre'=>$modifierinfostitre,
							   'modifierparolestitre'=>$modifierparolestitre
							    ]);
		$manager = new DroitsManager($bdd);
		$manager->update($droits);
	}


/***						***/
/*** RECUPERATION ALBUMS 	***/
/***						***/

	$manager = new AlbumsManager($bdd);
	$albums = $manager->getListAnneeTypeAsc();