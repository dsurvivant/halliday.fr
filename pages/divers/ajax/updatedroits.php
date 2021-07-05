<?php
/**
 * juillet 2021
 * script de mis à jour des droits de l'utilisateur
 * appelé par ajax
 *
 * ENTREE: 
 * 	$_POST['choix'] => contient le paramètre qui doit être modifié (ajout album, modification album, ..)
 * 	$_POST['valeur'] => contient la valeur de modification
 * 	$_POST['noutilisateur'] => l'utilisateur concerné par les modifications
 * 	
 */

require "../classes/Droits.class.php";
require "../classes/DroitsManager.class.php";
require "../classes/Utilisateur.class.php";
require "../classes/UtilisateursManager.class.php";
require "../login/login.php";
$bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));

if(isset($_POST['choix']) and isset($_POST['valeur']) and isset($_POST['noutilisateur']))
{
	$choix = trim($_POST['choix']);
	$valeur = trim($_POST['valeur']);
	$noutilisateur = trim($_POST['noutilisateur']);

	switch ($choix)
	{
		case "addalbum":
			
			if ($valeur=="Autorisé") { $ajouteralbum=1; }
			if ($valeur=="Interdit") { $ajouteralbum=0; }

			$droits = new Droits([ 'noutil'=>$noutilisateur, 
								   'ajoutalbum'=>$ajouteralbum
								    ]);
			$manager = new DroitsManager($bdd);
			$manager->updateajouteralbum($droits);
			break;
		case "updatealbum":

			if ($valeur=="Autorisé") { $modifieralbum=1; }
			if ($valeur=="Interdit") { $modifieralbum=0; }

			$droits = new Droits([ 'noutil'=>$noutilisateur, 
								   'modifieralbum'=>$modifieralbum
								    ]);
			$manager = new DroitsManager($bdd);
			$manager->updatemodifalbum($droits);
			
			break;
		case "deletealbum":
			
			if ($valeur=="Autorisé") { $supprimeralbum=1; }
			if ($valeur=="Interdit") { $supprimeralbum=0; }

			$droits = new Droits([ 'noutil'=>$noutilisateur, 
								   'supprimeralbum'=>$supprimeralbum
								    ]);
			$manager = new DroitsManager($bdd);
			$manager->updatesupprimeralbum($droits);
			
			break;
		case "updatetitres":
			
			if ($valeur=="Autorisé") { $modifierinfostitre=1; }
			if ($valeur=="Interdit") { $modifierinfostitre=0; }

			$droits = new Droits([ 'noutil'=>$noutilisateur, 
								   'modifierinfostitre'=>$modifierinfostitre
								    ]);
			$manager = new DroitsManager($bdd);
			$manager->updatemodifierinfostitre($droits);
			
			break;
		case "updateparoles":
			
			if ($valeur=="Autorisé") { $modifierparolestitre=1; }
			if ($valeur=="Interdit") { $modifierparolestitre=0; }

			$droits = new Droits([ 'noutil'=>$noutilisateur, 
								   'modifierparolestitre'=>$modifierparolestitre
								    ]);
			$manager = new DroitsManager($bdd);
			$manager->updatemodifierparolestitre($droits);
			
			break;
		case "administrateur":
			
			if ($valeur=="Oui") { $administrateur=1; }
			if ($valeur=="Non") { $administrateur=0; }
			
			$droits = new Droits([ 'noutil'=>$noutilisateur, 
								   'administrateur'=>$administrateur
								    ]);
			$manager = new DroitsManager($bdd);
			$manager->updateadministrateur($droits);

			break;

		case "actif":

			if ($valeur=="Oui") { $actif=1; }
			if ($valeur=="Non") { $actif=0; }
			
			$utilisateur = new Utilisateur([ 'noutil'=>$noutilisateur, 
								   'actif'=>$actif
								    ]);
			$manager = new UtilisateursManager($bdd);
			$manager->activerbynoutil($utilisateur);

			break;
	}
}
?>