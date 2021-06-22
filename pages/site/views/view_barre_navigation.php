<?php

/**
 * 	CREE PAR JMT MARS 2021
 * 	
 */

?>

<nav class="col navbar navbar-expand-sm navbar-dark bg-dark">
	<!-- LOGO -->
		<a href="index.php" class="navbar-brand"><img p-0 m-0" src="pages/site/images/logos/logo.png" alt="accueil" title="accueil" width="40px"></a>
	<!-- BOUTON RESPONSIVE -->
		<button class="navbar-toggler" data-toggle="collapse" data-target="#menu">
           <span class="navbar-toggler-icon"></span>
        </button>
	
	<!-- CONTENU RESPONSIVE --> 
		<div id="menu" class="collapse navbar-collapse">
			<!-- LIENS -->
				<ul class="navbar-nav mr-auto">
				<!-- CHOIX MENU ACCUEIL -->
					<li class="nav-item"> 
						<a class="nav-link" href="index.php"> Accueil</a> 
					</li>
				<!-- CHOIX MENU DISCOGRAPHIE -->
		        	<li  class="nav-item dropdown">
		            	<a id="menuDiscographie" class="nav-link dropdown-toggle"  href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Discographie
		            	</a>

						<div id="liste_decennie" class="dropdown-menu">
							<a class="dropdown-item" href="index.php?decennie=1960"> 1960 - 1969</a>
							<a class="dropdown-item" href="index.php?decennie=1970"> 1970 - 1979</a>
							<a class="dropdown-item" href="index.php?decennie=1980"> 1980 - 1989</a>
							<a class="dropdown-item" href="index.php?decennie=1990"> 1990 - 1999</a>
							<a class="dropdown-item" href="index.php?decennie=2000"> 2000 - 2009</a>
							<a class="dropdown-item" href="index.php?decennie=2010"> 2010 - 2018</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="index.php?decennie=tous"> Tous</span></a>
						</div>
		        	</li>
		        <!-- CHOIX MENU Fiches Albums-->
		           	<li  class="nav-item dropdown">
		            	<a id="menuFichesAlbums" class="nav-link dropdown-toggle"  href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Fiches Albums
		            	</a>

						<div id="liste_fiches_albums" class="dropdown-menu" style="height: 400px; overflow: auto;">
							<?php foreach ($_SESSION['albums'] as $album): 
								$datesortie = new DateTime( $album->getdatesortieAlbum() );
								$anneesortie = $datesortie->format('Y');
								$nomalbum = $album->getNomAlbum();
								$noalbum = $album->getNoAlbum();
							?>
								<a class="dropdown-item" href="index.php?fiche&noalbum=<?= $noalbum ?>"> <?= $anneesortie . " - " . $nomalbum; ?></a>
							<?php endforeach; ?>
						</div>
		        	</li>
		         </ul>

		    <!-- FORMULAIRE DE RECHERCHE -->
				<form class="form-inline d-none">
			         <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
			      <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Recherche</button>       
			    </form>
			<!-- BOUTON DE CONNEXION / MENU DU COMPTE -->
				<?php
				if (isset($_SESSION['noutil'])) //déjà connecté
				{?>
					<ul class="navbar-nav">
						<li class="nav-item dropdown">
							<a  class="nav-link dropdown-toggle"  href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							 <?= $_SESSION['pseudo']; ?>
		            		</a>

		            		<div id="liste_decennie" class="dropdown-menu dropdown-menu-right">
		            			<?php if(!isset($page)) {$page="accueil";} ?>
		            			<!-- 1ere OPTION -->
		            			<?php if ($page=="acces_membre"): ?>
		            				<a class="dropdown-item" href="index.php?accueil">Retour au site</a>
		            			<?php else: ?>
		            				<a class="dropdown-item" href="index.php?acces_membre">Acces Membres</a>
		            			<?php endif; ?>

		            			<!-- 2ème OPTION - uniquement administrateur -->
		            			<?php if ($_SESSION['administrateur']==1): ?>
									<a class="dropdown-item" href="index.php?gestionsite">Gestion du site</a>
								<?php endif; ?>

								<!-- 3ème OPTION -->
								<a class="dropdown-item" href="index.php?parametres">Paramètres</a>
								<!-- 4ème OPTION -->
								<a class="dropdown-item" href="index.php?deconnexion">Déconnexion</a>
							</div>
						</li>
					</ul>
				<?php
				}
				else // non connecté
				{?>
					<div class="text-right">
						<a href="index.php?demandeconnexion">
							<button class="btn btn-outline-info ml-1 my-2 my-sm-0">Connexion</button>
						</a>
					</div>
				<?php
				}?>
		</div>
</nav>