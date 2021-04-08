<?php

/**
 *  CREE PAR JMT AVRIL 2021
 */

/**
 * recherche des albums par annee asc
 * @return [objet albums] [retourne une liste d'objet albums classés par années]
 */
function rechercheAlbumsByDate()
{
	global $bdd;
	    
	$manager = new AlbumsManager($bdd);
	                                                    
	return  $manager->getListAnneeAsc();
}

/**
 * recherche des albums par annee asc
 * @return [objet albums] [retourne une liste d'objet albums classés par années]
 */
function rechercheLiaisonTitresAlbums()
{
	global $bdd;
	    
	$manager = new LiaisonAlbumsTitresManager($bdd);
	                                                    
	return  $manager->getListLiaisonTitresAlbums();
}

?>