<!DOCTYPE html>

<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="content_language" content="fr" />
		<!--<meta name="viewport" content="width=device-width" />-->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="johnny hallyday" />
		<meta name="author" content="michemuche62"/>
		<!-- CSS-->
            <link rel="stylesheet" href="css/design.css">
			<link rel="stylesheet" href="css/design_mobile.css">
            <link rel="stylesheet" href="css/design_screen.css">
            <link rel="stylesheet" href="css/design_page_admin.css">
            <link rel="stylesheet" href="css/design_gestionsite.css">
            <link rel="stylesheet" href="css/bootstrap-3.3.7-dist/Assets/css/bootstrap.min.css" >
            <!--<link rel="stylesheet" href="css/bootstrap4/bootstrap.min.css" >-->
            <link rel="stylesheet" href="jquery/jquery-ui-1.12.1.custom/jquery-ui.min.css">
            <link rel="stylesheet" href="jquery/jquery-ui-1.12.1.custom/jquery-ui.structure.min.css">
            <link rel="stylesheet" href="jquery/jquery-ui-1.12.1.custom/jquery-ui.theme.min.css">
    		

		<title>Johnny hallyday</title>
	</head>
	
	<body class="container-fluid">
		
		<header class="row">
			<h1 class="col-xs-8 col-xs-offset-2">JOHNNY HALLYDAY</h1>    
			<p class="col-xs-2 visible-xs"><img id="image_menu" src="pages/site/images/boutons/boutonmenu.png" alt="bouton_menu" title="menu"/></p>
		</header>

		<section class="row">
			<!-- Menu	-->
				<nav id="barre_navigation" class="navbar navbar-inverse">
					<div class="container-fluid">
						<?= $menu ?>
				</div>
				    </nav>

			<!-- PAGE PRINCIPALE	-->
				<div id="page_principale" class="col-lg-12">
					<?= $corpspage  ?>
				</div>		
		</section>

		<footer class="row">
				<div class="container">
					<section class="row">
						<div class="text-center">
							<img  alt="logo_philips" title="philips" src="pages/site/images/logos/philips.jpg">
							<img  alt="logo_universal" title="universal" src="pages/site/images/logos/universal.png">
							<img alt="logo_warner" title="warner" src="pages/site/images/logos/warner.png">
						</div>
					</section>

					<section class="row">
						Références: 
						<a href="https://johnnyhallyday.store/" target="_blank">Store Johnny</a> - 
						<a href="http://www.hallyday.com/" target="_blank">Johnny Hallyday le web</a> - 
						<a href="https://fr.wikipedia.org/wiki/Johnny_Hallyday" target="_blank">Wikipedia Johnny Hallyday</a> - 
						<a href="https://inoubliablejohnnyhallyday.wordpress.com/" target="_blank">Blog Inoubliable Johnny Hallyday</a>
					</section>

					<section class="row text-center">
						<a href="mailto:halliday.fr@yahoo.com"> ----- Contact -----</a>
					</section>

					<section class="row">
						<img src="pages/site/images/logos/youtube.png" alt="youtube" title="youtube" width="30px">
						<a href="https://www.youtube.com/channel/UC9wvnHwKWvE_unCTf1eLKHw" target="_blank">Chaine Officielle</a>
					</section>

					<section class="row" style="color:white">
						<?php 
							if(isset($_SESSION['noutil'])) //déjà connecté
							{
								$utilisateur = "<span id='pseudo'>" . $_SESSION['nomutil'] . " </span>";
								$utilisateur = $utilisateur . "<span id='nomutil'>" . $_SESSION['prenomutil'] . " </span>";
								/** ATTENTION LE NOUTIL UTILISE POUR D'AUTRE PAGES (JQUERY AJAX)  **/
								$utilisateur = $utilisateur . "<span id='noutil' style='visibility: hidden;'>" . $_SESSION['noutil'] . "</span>";
							}
							else
							{
								$utilisateur="Non connecté";
							}
						?>
						<p id="utilisateur" class="text-right"><?php echo $utilisateur;?></p>
					</section>
				</div>
		</footer>

		<!--			-->
		<!-- SCRIPTS	-->
		<!--			-->	
			<!-- inclusion des libraries jQuery et jQuery UI (fichier principal et plugins) -->
	        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
	        <script src="jquery/jquery-3.5.1.min.js"></script>
	        <!--<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>-->
	        <script src="jquery/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>

	        <!-- SITE -->
	        <script src="jQuery/fonctions.js"></script>
	        <script src="jquery/menu.js"></script>
	        <script src="jquery/inscription.js"></script>
	        <script src="jquery/discographie.js"></script>
	        <script src="jquery/fiche_album.js"></script>
	        <script src="bootstrap-3.3.7-dist/Assets/js/bootstrap.min.js"></script>

	        <!-- ADMINISTRATION -->
		    <script src="pages/divers/jquery/albums/listeAlbum.js"></script>
		    <script src="pages/divers/jquery/albums/listeTitres.js"></script>
		    <script src="pages/divers/jquery/albums/ajout_modif_Album.js"></script>
		    <script src="pages/divers/jquery/albums/ajout_modif_Titre.js"></script>
		    <script src="pages/divers/jquery/gestionsite/gestionutilisateur.js"></script>
		    <script src="pages/divers/jquery/parametres/parametres.js"></script>
	</body>
	
	<!--
			<article id="diaporama">
				<p>
				C'est son histoire<br/>
				C'est notre histoire<br/>
				Une star, une légende, un homme<br/>
				C'est notre vie, et la sienne<br/>
				Nos coeurs à tous réunis<br/>
				Dans une salle, un stade<br/>
				Même énergie, même peurs<br/>
				Et puis ... la folie... du rock<br/>
			 	</p>
	        </article>-->
</html>