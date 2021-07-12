<?php 

/**
 * CREE PAR JMT AVRIL 2021	
 */

foreach ($_SESSION['albums'] as $album) {
	if($noalbum == $album->getNoAlbum() ) 
		{
			$nomalbum = $album->getNomAlbum();
			$nomalbum = skip_accents($nomalbum);
			//date de sortie
				$datesortiealbum = new DateTime($album->getdatesortieAlbum());
			//Age de johnny à la sortie
				$naissancejohnny = new DateTime('1943-06-15');
				$agedejohnny = date_diff($naissancejohnny,$datesortiealbum);
			//
			$type = $album->getTypeAlbum();
			$format = $album->getFormatAlbum();
			$producteur = $album->getProducteurAlbum();
			$reference = $album->getReferenceAlbum();
			$label = $album->getLabelAlbum();
			$description = $album->getDescriptionAlbum();
			$pochette = $album->getPochetteAlbum();
			$certification = $album->getCertificationsAlbum();
			$musiciens = $album->getMusiciensAlbum();
			$enregistrement = $album->getEnregistrementAlbum();

			$libelleTypeAlbum = $_SESSION['typesalbums'][$type-1];
			//chemin pochette
			$source= "pages/divers/images/" . $libelleTypeAlbum . "/" . $nomalbum . "-avant.jpg";
			//format (33t,cd ..)
			//dd($_SESSION['formatsalbums']);
			
			$libelleformat = $_SESSION['formatsalbums'][$format-1];
		}
}

$mois = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "novembre", "Décembre"];
?>

<div id="fiche_album" class="container" >

	<div class="row">
		<h1 class="col-12 my-4 text-center text-secondary"><?= $nomalbum; ?></h1>
	</div>

	
	<!--
	<nav id="navigation_ancres">
        <ul class="nav justify-content-center bg-dark">
          <li class="nav-item"><a class="nav-link" href="#description">Description</a></li>
          <li class="nav-item"><a class="nav-link" href="#enregistrements">Enregistrements</a></li>
          <?php if($musiciens!=''): ?><li class="nav-item"><a class="nav-link" href="#musiciens">Musiciens</a></li><?php endif ?>
          <li class="nav-item"><a class="nav-link " href="#singles">Singles</a></li>
          <li class="nav-item"><a class="nav-link " href="#reeditions">Rééditions</a></li>
          <?php if($musiciens!=''): ?><li class="nav-item"><a class="nav-link " href="#podcast">Podcast</a></li><?php endif ?>
          <li class="nav-item"><a class="nav-link " href="#ecoutes">Ecoutes</a></li>
          <?php if($musiciens!=''): ?><li class="nav-item"><a class="nav-link " href="#videos">Vidéos</a></li><?php endif ?>
        </ul>
    </nav>
    <br>
  -->
	
	<!--			  	 -->
	<!-- CADRE PRINCIPAL -->
	<!--			 	 -->
	<div class="row border m-2 p-2" style="background-color: #ecf0f1;">
		<div class="col-md-3 col-sm-4 col-xs-7">
			<img alt="Johnny hallyday - <?= $nomalbum ?>" title="Johnny Hallyday - <?= $nomalbum ?>" src="<?= $source; ?>" style="width: 100%">
		</div>

		<div class="col-md-9 col-sm-8 col-xs-12">
			<!-- ANNEE -->
				<h2><?= $datesortiealbum->format('Y'); ?></h2>
			<!-- FORMAT ET REFERENCE -->
				<p><?= $libelleformat . " - " . $label . " - " . $reference; ?><br>
			<!-- DATE DE SORTIE -->
				Sorti le <?=  $datesortiealbum->format('d'). " " . $mois[$datesortiealbum->format('m')-1] . " " . $datesortiealbum->format('Y');  ?> (Johnny avait <?= $agedejohnny->format('%Y ans'); ?>)</p>
			
			<!-- LISTE DES TITRES -->
				<?php 
			foreach ($detailsalbum as $key => $value) 
			{
				echo $key+1 . ". ";
				echo "<span class='font-weight-bold'>" . $value['nomTitre'] . "</span> ( <span class='font-italic'>" . $value['musiqueTitre'] . "</span> /<span class='font-italic'> " . $value['parolesTitre'] . "</span> )<br>";
			}
			?>
		</div>
	</div>


	<!--			  -->
	<!--- DESCRIPTION -->
	<!--			  -->
		<h3 class="row" id="description">Description <img class="chevron_bas" alt="chevron_bas" src="pages/site/images/boutons/chevron_bas.png"><img class="chevron_droite" alt="chevron_droite" src="pages/site/images/boutons/chevron_droite.png"></h3>

		<div class="row border m-2 p-2" style="background-color: #ecf0f1;">
			<div class="col-12">
				<?php if(trim($producteur)!='') { echo "Réalisation :" . $producteur . "<br>"; } ?>
				<?php if(trim($pochette)!='') { echo "Pochette : " . $pochette . "<br>"; } ?>
				<?php if(trim($certification)!='') { echo "Certifications : " . $certification . "<br><br>"; } ?>
			</div>

			<p class="col-12">
				<?= "<br>" . nl2br($description) ?>
			</p>
		</div>

	<!--			  	  -->
	<!--- ENREGISTREMENTS -->
	<!--			   	  -->
	<!--				  -->

	<!--			  -->
	<!--- MUSICIENS -->
	<!--			  -->
		
	<!--			  -->
	<!--- SINGLES 	  -->
	<!--			  -->
		

	<!--		      -->
	<!--- REEDITIONS  -->
	<!--  			  -->

	<!--			  -->
	<!--- PODCAST	  -->
	<!--			  --> 
		
	<!--			  -->
	<!---ECOUTES 	  -->
	<!--			  -->
		
</div>