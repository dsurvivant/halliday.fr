<!-- FORMULAIRE D'INSCRIPTION NOUVEAU MEMBRE' -->
<?php	
	//enregistrement de l'utilisateur
	if ( isset($_POST['pseudo_inscription']) and isset($_POST['password_inscription']) and isset($_POST['nom_inscription']) and isset($_POST['prenom_inscription']) and isset($_POST['email_inscription']))
	{
		$mdp = cryptagemotdepasse($_POST['password_inscription']);
		//instanciation de l'utilisateur avec le pseudo saisi
	    $util = new Utilisateur([
	    							'prenom'=>sanitizeString(trim($_POST['prenom_inscription'])),
	    							'nom'=>sanitizeString(trim($_POST['nom_inscription'])),
	    							'pseudo'=>sanitizeString(trim($_POST['pseudo_inscription'])),
	    							'motdepasse'=>sanitizeString(trim($mdp)),
	    							'droits'=>'2',
	    							'email'=>sanitizeString(trim($_POST['email_inscription'])),
	    						]);

	    $bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
	    $manager = new UtilisateursManager($bdd);

	    //****
	    //** vérifications des critères (pseudo inexistant, mdp au bon format, email au bon format, longueurs des champs)
	    //****
	    	$valide = true;
	    	$msgerror ='';
	    	if (($manager->existPseudo($util))){ $msgerror = "Le pseudo existe déjà"; $valide = false;}
	    	elseif (!validationemail($util->getEmail())) { $msgerror = "L'email n'est pas valide"; $valide = false;}
			elseif(!validationmotdepasse(trim($_POST['password_inscription']))) { $msgerror =  "Le mot de passe ne respecte pas les critères"; $valide = false;}
	    //****
	    //**
	    //****
	    if ($valide==true)
	    {
	    	//les critères sont correctes, ajout du nouvel utilisateur en bdd
	    	//envoi d'un mail à l'admin
	    	echo "ok tout est bon: ";
	    	//$manager->add($util);
	    }
	    else
	    {
	    	echo($msgerror);
	    	require('pages/site/views/forms/form_inscription.php');
	    }	    
	}
	else
	{
		require('pages/site/views/forms/form_inscription.php');
	}
?>