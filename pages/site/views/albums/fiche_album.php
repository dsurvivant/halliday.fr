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
				echo $value['nomTitre'] . " ( " . $value['musiqueTitre'] . " / " . $value['parolesTitre'] . " )<br>";
			}
			?>
		</div>
	</div>


	<!--			  -->
	<!--- DESCRIPTION -->
	<!--			  -->
		<h3 class="row" id="description">Description <img class="chevron_bas" alt="chevron_bas" src="pages/site/images/boutons/chevron_bas.png"><img class="chevron_droite" alt="chevron_droite" src="pages/site/images/boutons/chevron_droite.png"></h3>

		<div class="row border m-2 p-2" style="background-color: #ecf0f1;">
			label : <?= $label; ?> <br>
			réalisation : <?= $producteur; ?> <br>
			pochette : <?= $pochette; ?> <br>
			certifications : <?= $certification ?>
		</div>
		<div class="row border m-2 p-2" style="background-color: #ecf0f1;">
			<p class="contenu">
				Il s'agit en fait d'une compilation des 3 premiers EP.<br>
				Dix des douzes titres déjà édités se retrouve sur ce format 25cm. Seuls <em>Oh! oh! Baby</em> et <em>Le plus beau des jeux</em> n'y figurent pas.
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
		<h3  class="row" id="singles">Singles 1960<img class="chevron_bas" alt="chevron_bas" src="pages/site/images/boutons/chevron_bas.png"><img class="chevron_droite" alt="chevron_droite" src="pages/site/images/boutons/chevron_droite.png"></h3>

		<div class="row border m-2 p-2" style="background-color: #ecf0f1;">
			<div class="contenu">
				<div>
					<p class="col-sm-3 col-xs-6"><img src="pages/divers/images/EP/1960/1960ep7750.jpg" alt="T'aimer follement" title="T'aimer follement / J'étais fou / Oh! oh! Baby / Laisse les filles" style="width: 100%"></p>
					<p class="col-sm-9 col-xs-12"><em>14 mars 1960 :</em><br> EP Vogue EPL 7750: <br>- T'aimer follement <br>- J'étais fou <br>- Oh! oh! Baby <br>- Laisse les filles<br><br>
									- réédition Maxi CD Vogue 191030 -<br>
									- réédition Dial Maxi CD 931038 -
					</p>
				</div>

				<div class="row well">
					<p class="col-sm-3 col-xs-6"><img src="pages/divers/images/EP/1960/1960ep7755.jpg" alt="Souvenirs, souvenirs" title="Souvenirs, souvenirs / Pourquoi cet amour / Je cherche une fille / J'suis mordu" style="width: 100%"></p>
					<p class="col-sm-9 col-xs-12"><em>3 juin 1960 :</em><br> EP Vogue EPL 7755: <br>- Souvenirs, souvenirs <br>- Pourquoi cet amour <br>- Je cherche une fille <br>- J'suis mordu</p>
				</div>

				<div class="row well">
					<p class="col-sm-3 col-xs-6"><img src="pages/divers/images/EP/1960/1960ep7800.jpg" alt="Itsy bitsy petit bikini" title="Itsy bitsy petit bikini / Depuis qu'ma môme / Le plus beau des jeux / Je veux me promener" style="width: 100%"></p>
					<p class="col-sm-9 col-xs-12"><em>11 octobre 1960 :</em><br> EP Vogue EPL 7800: <br>- Itsy bitsy petit bikini <br>- Depuis qu'ma môme <br>- Le plus beau des jeux <br>- Je veux me promener<br><br>
					- réédition Dial Maxi CD 933038 -
					</p>
				</div>

				<div class="row well">
					<p class="col-sm-3 col-xs-6"><img src="pages/divers/images/EP/1960/1960ep7812.jpg" alt="Le p'tit clown de ton coeur" title="Le p'tit clown de ton coeur / Oui j'ai / Kili watch / Ce s'rait bien" style="width: 100%"></p>
					<p class="col-sm-9 col-xs-12"><em>24 novembre 1960 :</em><br> EP Vogue EPL 7812: <br>- Le p'tit clown de ton coeur <br>- Oui j'ai <br>- Kili watch <br>- Ce s'rait bien<br>
						voir album "Nous les gars, nous les filles - 1961"<br><br>

						- réédition Maxi CD Vogue 191039 - <br>
						- réédition Dial Maxi CD 934038 -
					</p>
				</div>
			</div>
		</div>

	<!--		      -->
	<!--- REEDITIONS  -->
	<!--  			  -->
		<h3 class="row" id="reeditions">Rééditions<img class="chevron_bas" alt="chevron_bas" src="pages/site/images/boutons/chevron_bas.png"><img class="chevron_droite" alt="chevron_droite" src="pages/site/images/boutons/chevron_droite.png"></h3>

		<div class="row border m-2 p-2" style="background-color: #ecf0f1;">
			<div class="contenu">
				<p> - réédition Dial CD 900 035</p>
			</div>
		</div>

	<!--			  -->
	<!--- PODCAST	  -->
	<!--			  --> 
		
	<!--			  -->
	<!---ECOUTES 	  -->
	<!--			  -->
		<h3 class="row" id="ecoutes">Ecoutes<img class="chevron_bas" alt="chevron_bas" src="pages/site/images/boutons/chevron_bas.png"><img class="chevron_droite" alt="chevron_droite" src="pages/site/images/boutons/chevron_droite.png"></h3>

		<div class="row border m-2 p-2" style="background-color: #ecf0f1;">
			<div class="contenu container-fluid">
				<div class="row">
					<div>
						<h5>Playlist</h5>
						<iframe width="100%" src="https://www.youtube.com/embed/videoseries?list=PLD0Sl17vClRx81VoewmVvjv7M00onPpLu" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<h5>Souvenirs, souvenirs</h5>
						<iframe width="100%" src="https://www.youtube.com/embed/F2SQX_xUvdI" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>

					<div class="col-md-3">
						<h5>Depuis qu'ma môme</h5>
						<iframe width="100%" src="https://www.youtube.com/embed/4_rLkvF8YQE" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>

					<div class="col-md-3">
						<h5>Je cherche une fille</h5>
						<iframe width="100%" src="https://www.youtube.com/embed/0RD3B6_nBRk" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>

					<div class="col-md-3">
						<h5>Pourquoi cet amour</h5>
						<iframe width="100%" src="https://www.youtube.com/embed/NSedIyQkWG8" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>

					<div class="col-md-3">
						<h5>J'suis mordu</h5>
						<iframe width="100%" src="https://www.youtube.com/embed/NrBhPHl8M50" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>

					<div class="col-md-3">
						<h5>Laisse les filles</h5>
						<iframe width="100%" src="https://www.youtube.com/embed/PMz4VwTms6Y" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>

					<div class="col-md-3">
						<h5>Itsy bitsy petit bikini</h5>
						<iframe width="100%" src="https://www.youtube.com/embed/nLCFv2oGl5Q" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>

					<div class="col-md-3">
						<h5>J'étais fou</h5>
						<iframe width="100%" src="https://www.youtube.com/embed/y46Jwr4B33s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>

					<div class="col-md-3">
						<h5>Je veux me promener</h5>
						<iframe width="100%" src="https://www.youtube.com/embed/TXqkGHr3ZiI" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>

					<div class="col-md-3">
						<h5>T'aimer follement</h5>
						<iframe width="100%" src="https://www.youtube.com/embed/hxPLIhZMuYo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>

					<div class="col-md-3">
						<h5>Oh! Oh! Baby</h5>
						<iframe width="100%" src="https://www.youtube.com/embed/88ByNZYWJ3E" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>

					<div class="col-md-3">
						<h5>Le plus beau des jeux</h5>
						<iframe width="100%" src="https://www.youtube.com/embed/-aHawL5RgDo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</div>
</div>