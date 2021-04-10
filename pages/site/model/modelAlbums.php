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

/**
 * recherces des types d'albums
 * @return $tabtype : tabeau contenant les types ('Studio', 'Live', etc..)
 */
function rechercheTypesAlbums()
{
	global $bdd;

	$manager = new TypesAlbumManager($bdd);
	$types = $manager->getList();
	
	$tabtype = [];
	foreach ($types as $type) { array_push($tabtype, $type->getTypealbum()); }

	return $tabtype;
}

?>