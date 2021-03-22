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
	<!-- LIENS -->
		<div id="menu" class="collapse navbar-collapse">
			<ul class="navbar-nav">

			<!-- CHOIX MENU ACCUEIL -->
				<li class="nav-item active"> 
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
	            	<a id="menuDiscographie" class="nav-link dropdown-toggle"  href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Fiches Albums
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
	         </ul>
		</div>
	<!-- FORMULAIRE DE RECHERCHE -->
		<!--
		<form class="form-inline">
	         <input class="form-control mr-sm-2" type="search" placeholder="Search">
	      <button class="btn btn-primary" type="submit">Recherche</button>       
	    </form>
	-->

	<!-- FORMULAIRE DE CONNEXION -->
</nav>