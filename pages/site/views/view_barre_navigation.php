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
				<li class="nav-item active"> <a class="nav-link" href="index.php"> Accueil</a> </li>

	        	<li class="nav-item">
	            	<a data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-music"> Discographie</span> <b class="caret"></b></a>
					<ul id="liste_decennie" class="dropdown-menu">
						<li><a href="index.php?decennie=1960"><span class="glyphicon glyphicon-cd"> 1960 - 1969</span></a></li>
						<li><a href="index.php?decennie=1970"><span class="glyphicon glyphicon-cd"> 1970 - 1979</span></a></li>
						<li><a href="index.php?decennie=1980"><span class="glyphicon glyphicon-cd"> 1980 - 1989</span></a></li>
						<li><a href="index.php?decennie=1990"><span class="glyphicon glyphicon-cd"> 1990 - 1999</span></a></li>
						<li><a href="index.php?decennie=2000"><span class="glyphicon glyphicon-cd"> 2000 - 2009</span></a></li>
						<li><a href="index.php?decennie=2010"><span class="glyphicon glyphicon-cd"> 2010 - 2018</span></a></li>
						<li class="divider"></li>
						<li><a href="index.php?decennie=tous"><span class="glyphicon glyphicon-cd"> Tous</span></a></li>
					</ul>
	        	</li>

	           <li class="nav-item">
	             <a href="#" class="nav-link">Contact</a>
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