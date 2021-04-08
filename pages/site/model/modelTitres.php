<?php

/**
 *  CREE PAR JMT AVRIL 2021
 */

/**
 * recherche des albums par annee asc
 * @return [objet albums] [retourne une liste d'objet albums classés par années]
 */
function rechercheTitres()
{
	global $bdd;
	    
	$manager = new TitresManager($bdd);
	                                                    
	return  $manager->getList();
}

?>