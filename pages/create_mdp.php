<?php
	require_once 'divers/fonctions/fonctions.php'; //fonction de sécurité des saisies
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="content_language" content="fr" />
		<meta name="viewport" content="width=device-width" />
		<meta name="description" content="johnny hallyday" />
		<meta name="author" content="michemuche62"/>
		<!-- CSS-->
			<link rel="stylesheet" href="css/design.css">
		<title>Johnny hallyday</title>
	</head>
	<body>

		<?php
			if (isset($_POST['pseudo']) and isset($_POST['motdepasse']))
			{
				$erreur=false; //pas d'erreur par défaut

				$pseudo = trim(sanitizeString($_POST['pseudo']));
                $motdepasse = trim(sanitizeString($_POST['motdepasse']));

                if (empty($pseudo)) {$erreur=true;echo("vous n'avez pas saisi de pseudo.<br/>"); }
                if (empty($motdepasse)) {$erreur=true;echo("vous n'avez pas saisi de motdepasse.<br/>");}

                // Vérification des critères mots de passe
                if (!validationmotdepasse($motdepasse))
                {
                    echo "le mot de passe ne remplit pas les critères</br>";
                    $erreur=true;
                }

                if ($erreur==false)
                {
                	// cryptage du mot de passe
                    $motdepasse1 = cryptagemotdepasse($motdepasse);

                    echo ("pseudo: <strong>" . $pseudo . "</strong><br/>");
                    echo ("motdepasse avant cryptage: <strong>" . $motdepasse . "</strong><br/>");
                    echo ("motdepasse après cryptage: <strong>" . $motdepasse1 . "</strong><br/>");

                }
			}
		//Un mot de passe valide aura
		//      - de 8 à 15 caractères
		//      - au moins une lettre minuscule
		//      - au moins une lettre majuscule
		//      - au moins un chiffre
		//      - au moins un de ces caractères spéciaux: $ @ % * + - _ !
		//      - aucun autre caractère possible: pas de & ni de { par exemple) 
		?>

		<h1>création du mot de passe</h1>

		<form method="POST" action="create_mdp.php">
			<label for="pseudo">Pseudo: </label><input type="text" name="pseudo"/><br/>
			<label for="motdepasse">Mot de passe: </label><input type="text" name="motdepasse"/>

			<input type="submit" name="Valider"/>
		</form>

		<p>
			<strong>mot de passe:</strong> <br/>
			- 8 à 15 caractères<br/>
			- 1 minuscule mini, 1 majuscule mini<br/>
			- 1 chiffre<br/>
			- au moins un de ces caractères spéciaux: $ @ % * + - _ !<br/>
			- aucun autre caractère possible: pas de & ni de { par exemple)
		</p>
		
	</body>
</html>