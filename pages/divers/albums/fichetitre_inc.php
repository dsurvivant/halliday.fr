<?php
//
//michemuche62
//made in rock'n'roll
//*****************************************************************************************************
//**                                                                                                 **
//** affiche les détails du titre                            			                             **
//**  ENTREE      $_POST['notitre'] pour affichage de la fiche du titre 							 **
//**                                                                                                 **   
//**   Gérée par ajout_modif_Titre.js                                                                ** 
//*****************************************************************************************************

if (isset($_POST['ajax']))
{
	require_once '../login/login.php'; //parametres de connexion et connexion à la bdd
	require_once '../fonctions/fonctions.php'; //fonction de sécurité des saisies

	require_once '../classes/Titre.class.php';
	require_once '../classes/Album.class.php';
	require_once '../classes/AlbumsManager.class.php';
	require_once '../classes/LiaisonAlbumsTitres.class.php';
	require_once '../classes/LiaisonAlbumsTitresManager.class.php';
	require_once '../classes/TitresManager.class.php';
	require_once '../classes/Droits.class.php';
	require_once '../classes/DroitsManager.class.php';
}

if (isset($_SESSION['notitre'])) {$notitre = $_SESSION['notitre'];}
if (isset($_POST['notitre'])) {$notitre = $_POST['notitre'];}

//connexion à la base de donnees
$bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
//instanciation du titre
$titre = new Titre(['notitre' => $notitre]);
$manager = new TitresManager($bdd);

//HYDRATATION DU TITRE
$manager->hydrateTitre($titre);
//Récupération des informations du titre
$nomTitre = $titre->getNomTitre();
$parolesTitre = $titre->getParolesTitre();
$musiqueTitre = $titre->getMusiqueTitre();
$texteTitre = $titre->getTexteTitre();


//récupération des droits (RETOUR AJAX)
	if(isset($_POST['noutil'])) //retour Ajax
	{
		$droits = new Droits(['noutil'=>$_POST['noutil']]);
		$managerdroits = new DroitsManager($bdd);
		$managerdroits->findDroits($droits);

		$managerdroits->findDroits($droits);
		$modifierinfostitres = $droits->getModifierinfostitre();
		$modifierparolestitres = $droits->getModifierparolestitre();
	}
	else
	{
		$modifierinfostitres = 0;
		$modifierparolestitres = 0;
	}

	if (isset($_SESSION['modifierinfostitre'])) { $modifierinfostitres = $_SESSION['modifierinfostitre']; }
	if (isset($_SESSION['modifierparolestitre'])) { $modifierparolestitres = $_SESSION['modifierparolestitre']; }
 
?>


<div class="container-fluid" id="fichetitre">
	<h3 class="entete row"><?php echo nl2br($nomTitre) ?></h3>
	<div id="contenu_ficheTitre" class="row">
		<!------------------------------------->
		<!-- PARTIE GAUCHE DE LA FICHE TITRE -->
		<!------------------------------------->
			<section id="section_detailsTitre" class="col-md-7">

				<section id="infostitre">
					<h5>
						Infos
						<?php if($modifierinfostitres==1): ?>
							<span id="modifierinfostitres" data-toggle="modal" data-backdrop="static" href="#infos" class="glyphicon glyphicon-pencil pull-right"></span>
						<?php endif; ?>
					</h5>

					<div style="padding-left: 5px;">
						<span style="text-decoration: underline;font-family: serif;">NO TITRE:</span> <span id='notitre' style="font-size: 1.2em;"><?php echo $notitre; ?></span><br>
				    	<span style="text-decoration: underline;font-family: serif;">PAROLES:</span> <span id="parolesTitre" style="font-size: 1.2em;"><?= nl2br($parolesTitre); ?></span><br>
				    	<span style="text-decoration: underline;font-family: serif;">MUSIQUE:</span> <span id="musiqueTitre" style="font-size: 1.2em;"><?= nl2br($musiqueTitre); ?></span><br>
			    	</div>
			    </section>
			       
			    <section id="albumstitre">   
			    	<?php
				        //Recherche des albums liés au numéro de titre
				        $managerliaison = new LiaisonAlbumsTitresManager($bdd);
	                    $liaisonalbums = $managerliaison->getAlbums($titre); 

	                    //Traitement pour chaque album
	                    $manageralbum = new AlbumsManager($bdd);
	                    foreach ($liaisonalbums as $liaisonalbum) 
	                    {
	                    	$noalbum = $liaisonalbum -> getNoAlbum();
	                    	//
	                    	$album = new Album(['noAlbum' => $noalbum]); 
	                    	$manageralbum->findNoAlbum($album);

	                    	$nomalbum = $album->getNomAlbum();
	                    	$typealbum = $album->getTypeAlbum();
	                    	$typealbum = $manageralbum->libelletypeAlbum($album);
	                    	$datesortie = $album->getdatesortieAlbum();

	                    	//Chemin de la pochette avant
	                    	$cheminpochette = 'pages/divers/images/' . $typealbum . "/";
	                        $nomfichier = skip_accents(html_entity_decode($nomalbum)) . "-avant.jpg";
	                        $nomfichier = nettoyerChaine($nomfichier);
	                        $cheminpochette = $cheminpochette . $nomfichier;
	                ?>
	                    	<section>
		                    	<img alt="<?php echo $nomalbum?>" title="<?php echo $nomalbum?>" src="<?php echo $cheminpochette ?>">
		                    	<strong><?php echo $nomalbum; ?></strong><br>
		                    	<span><?php echo ("Album " . $typealbum); ?></span><br> 
		                    	<span>Sorti le <?php echo dateToFrench($datesortie,'d F Y') ?></span>
		                    	<p class="clear">fin du float</p>
		                    </section>
	                    <?php
	                    		}
				        ?>
			    </section>
			</section>

		<!------------------------------------->
		<!-- PARTIE DROITE DE LA FICHE TITRE -->
		<!------------------------------------->
			<section id="section_parolesTitre" class="col-md-5">
				<h5>Paroles
					
					<?php if($modifierparolestitres==1): ?>
						<span id="modifierparolestitres" data-toggle="modal" data-backdrop="static" href="#paroles" class="glyphicon glyphicon-pencil pull-right"></span>
					<?php endif; ?>
				</h5>
				<div id="contenutexteTitre"><?php echo nl2br($texteTitre); ?></div>
			</section>
	</div>
</div> <!-- fichetitre -->


<!--
/**************************************
 * 				FENETRES MODALES
 **************************************/
-->

<!-- Infos générales du titres -->
<div class="modal" id="infos">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" style="background-color: red; color:white; padding: 5px;">X</button>
				<h3 class="modal-title"><?= $nomTitre ?></h3>
			</div>

			<div class="modal-body">
				<form id="forminfostitre" method="post" action="#">
					<div class="form-group">
						<span for="input_paroles" class="input-grout-addon">Paroles</span>
						<input id="input_paroles" type="text" class="form-control" value="<?= $parolesTitre; ?>">

						<span for="input_musique" class="input-grout-addon">Musique</span>
						<input id="input_musique" type="text" class="form-control" value="<?= $musiqueTitre; ?>">

						<span class="help-block">Si plusieurs noms, séparer par une virgule. Ex: Michel Mallory, Johnny Hallyday</span>		
					</div>
				</form>
			</div>

			<div class="modal-footer">
				<button id="validerinfostitre" class="btn btn-primary" type="submit">Valider</button>
				<button  class="btn btn-primary annulermodal" >Annuler</button>	
			</div>
		</div>
	</div>
</div>

<!-- Paroles des chansons -->
<div class="modal" id="paroles">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button id="fermeturemodal" type="button" class="close" data-dismiss="modal" style="background-color: red; color:white; padding: 5px;">X</button>
				<h3 class="modal-title"><?= $nomTitre ?></h3>
			</div>

			<div class="modal-body">
				<form id="formparolestitre" method="post" action="#">
					<textarea id="textareaparoles" placeholder="Saisir le texte ici"><?php echo strip_tags($texteTitre); ?></textarea>

					<div class="pull-right">
						<button id="validertexteTitre" class="btn btn-primary" type="submit">Valider</button>
						<button class="btn btn-primary annulermodal" >Annuler</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

