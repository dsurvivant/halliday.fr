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

						<div id="liste_fiches_albums" class="dropdown-menu">
							<a class="dropdown-item" href="index.php?fiche=1960-hello_johnny"> 1960 - Hello Johnny</a>
							<a class="dropdown-item" href="index.php?fiche=1961-nous_les_gars_nous_les_filles"> 1961 - Nous les gars, nous les filles</a>
							<a class="dropdown-item" href="index.php?fiche=1961-tete_a_tete_avec_johnny"> 1961 - Tête à tête avec Johnny</a>
							<a class="dropdown-item" href="index.php?fiche=1961-viens_danser_le_twist"> 1961 - Viens danser le twist</a>
							<a class="dropdown-item" href="index.php?fiche=1961-salut_les_copains"> 1961 - Salut les copains!</a>
							<a class="dropdown-item" href="index.php?fiche=1962-sings_america_s_rock_in_hits"> 1962- Sings America's Rock'in'hits</a>
							<a class="dropdown-item" href="index.php?fiche=1962-retiens_la_nuit"> 1962- Retiens la nuit</a>
							<a class="dropdown-item" href="index.php?fiche=1968-jeune_homme"> 1968 - Jeune Homme</a>
							<a class="dropdown-item" href="index.php?fiche=1968-reve_et_amour"> 1968 - Rêve et amour</a>
							<a class="dropdown-item" href="index.php?fiche=1970-vie"> 1970 - Vie</a>
							<a class="dropdown-item" href="index.php?fiche=1971-flagrant_delit"> 1971 - Flagrant Délit</a>
							<a class="dropdown-item" href="index.php?fiche=1973-insolitudes"> 1973 - Insolitudes</a>
							<a class="dropdown-item" href="index.php?fiche=1974-rockandslow"> 1974 - Rock'n'slow</a>
							<a class="dropdown-item" href="index.php?fiche=1976-derriere_l_amour"> 1976 - Derrière L'amour</a>
							<a class="dropdown-item" href="index.php?fiche=1976-hamlet"> 1976 - Hamlet</a>
							<a class="dropdown-item" href="index.php?fiche=1977-c'est_la_vie"> 1977 - C'est la vie</a>
							<a class="dropdown-item" href="index.php?fiche=1978-solitudes_a_deux"> 1978 - Solitudes à deux</a>
							<a class="dropdown-item" href="index.php?fiche=1979-hollywood"> 1979 - Hollywood</a>
							<a class="dropdown-item" href="index.php?fiche=1980-a_partir_de_maintenant"> 1980 - A partir de maintenant</a>
							<a class="dropdown-item" href="index.php?fiche=1981-en_pieces_detachees"> 1981 - En pièces détachées</a>
							<a class="dropdown-item" href="index.php?fiche=1981-pas_facile"> 1981 - Pas facile</a>
							<a class="dropdown-item" href="index.php?fiche=1982-quelque_part_un_aigle"> 1982 - Quelque part un aigle</a>
							<a class="dropdown-item" href="index.php?fiche=1982-la_peur"> 1982 - La peur</a>
							<a class="dropdown-item" href="index.php?fiche=1989-cadillac"> 1989 - Cadillac</a>
							<a class="dropdown-item" href="index.php?fiche=2007-le_coeur_d_un_homme"> 2007 - Le coeur d'un homme</a>
							<a class="dropdown-item" href="index.php?fiche=2008-ca_ne_finira_jamais"> 2008 - Ca ne finira jamais</a> 
						</div>
		        	</li>
		         </ul>

		    <!-- FORMULAIRE DE RECHERCHE -->
				<form class="form-inline">
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