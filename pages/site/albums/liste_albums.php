<?php

// appelée en incude par index.php ou
// appelée par ajax par jquery/listeAlbum.js
//
// page qui affiche une liste d'albums par décennie
// affiche par défaut la décennie des années 60
// mis à jour par ajax lors des changements des critères d'affichage 

/**
if (isset($_GET['ajax']))
{
    include_once '../../divers/login/login.php';
    include_once '../../divers/fonctions/fonctions.php'; //fonction de sécurité des saisies

    include_once '../../divers/classes/Album.class.php';
    include_once '../../divers/classes/AlbumManager.class.php';

    include_once '../../divers/classes/Titre.class.php';
    include_once '../../divers/classes/TitreManager.class.php';
    include_once '../../divers/classes/LiaisonAlbumsTitres.class.php';
    include_once '../../divers/classes/LiaisonAlbumsTitresManager.class.php';
}
**/

//connexion à la base de donnees
//$bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
//=====
//== CADRE LISTE DES ALBUMS : #liste_albums-->contient la liste des albums. Un cadre par album
//=====          
?> 

	<?php
	
	//recherche du nombre total d'album
    $manager = new AlbumsManager($bdd);
    $nombreAlbums = $manager->getnombreAlbums();
    
    //si pas d'album, pas d'affichage de liste
    if ( $nombreAlbums == 0 )
    {
    	?><div class="cadre_album"><?php
   		echo("<p>Aucun album</p>");
   		?></div> <!-- #cadre_album" --><?php
    }
    //=====
    //== AFFICHAGE LISTE DES ALBUMS
    //=====
    else
    {
        ?> <div id="cadre_principal"> <?php
            $albums = $manager->getListAnneeAsc();
                
            foreach ($albums as $album)
            {
                //récupération du libellé typealbum
                $libelletypeAlbum = $manager->libelletypeAlbum($album);
                $libelleformatAlbum = $manager->libelleformatAlbum($album);
            		
                $labelAlbum = $album->getlabelAlbum($album);
                $referenceAlbum = $album->getreferenceAlbum($album);
                $producteurAlbum = $album->getproducteurAlbum($album);
            	//=====
            	// CADRE ALBUM : cadre qui contient les éléments d'un album 
            	//=====

                $date_sortie_album = $album->getdatesortieAlbum();
                $annee_album = substr($album->getdatesortieAlbum(),0,4);
                if (isset($_GET['decennie']))
                    {$decennie = $_GET['decennie'];}
                else
                    {$decennie = "1960";}

                //sélection de la décennie à afficher
                // si l'album est inclu dans la décennie, on le traite. 
                // dans le cas contraire on passe à l'album suivant
                if ((($annee_album>=$decennie) && ($annee_album<=$decennie+9)) || ($decennie=="tous"))
                {
            	   ?>

            	   <div class="cadre_album">

                        <div class="entete_cadre_album">
                            <?php
                                $nom_album = $album->getNomAlbum();
                                $nom_album = html_entity_decode($nom_album);
                                //récupération du nombre de support de l'album
                                $managerliaison = new LiaisonAlbumsTitresManager($bdd);
                                $nombrededisque= $managerliaison->getnombredisqueAlbums($album);
                                
                                if ($nombrededisque <=1 )
                                {
                                    echo ( 
                                    $annee_album . " - " .
                                    $nom_album . " (" .
                                    $nombrededisque . " disque)" //gestion de la pluralité
                                    );
                                }
                                else
                                {
                                    echo ( 
                                    $annee_album . " - " .
                                    $nom_album . " (" .
                                    $nombrededisque . " disques)" //gestion de la pluralité
                                    );
                                }

                                //récupération du nombre de support de l'album
                                $managerliaison = new LiaisonAlbumsTitresManager($bdd);
                                $nombrededisque= $managerliaison->getnombredisqueAlbums($album);

                            ?>
                        </div>

                        <div class="detail_album">

    			             <div class="jaquette_album">
                                <?php 
                                $nom_album = skip_accents($nom_album);
                                $source= "pages/divers/images/" . $libelletypeAlbum . "/" . $nom_album . "-avant.jpg";
                                ?>
                                <!-- echo time est ici pour un probleme de cache des navigateurs qui reprennent l'ancienne image -->
                                <span class="grossissement"><img class="jaquette_avant" alt="<?php echo $nom_album; ?>" title="<?php echo $nom_album; ?>" src="<?php echo $source;?>?time=<?php echo time(); ?>" /></span>
    			             </div> <!-- .jaquette_album -->

                            <div class="liste_titres">
                                <!--<div class="cadre_disque"> -->
                                <?php
                                //======AFFICHAGE DES TITRES
                                $managerliaison = new LiaisonAlbumsTitresManager($bdd);
                                $liaisontitres = $managerliaison->getTitres($album); //recherche les no titres associés à l'album dans la table de liaison
                                $managertitre = new TitresManager($bdd);
                                $memo_no_disque=1;
                                $i=1;
                                //echo  "<p>" . $source . "</P>";

                                
                            /****** ONGLETS DISQUES  *******/
                                //mis en place d'onglet si plusieurs disques
                                if ($nombrededisque>1)
                                {
                                    ?>
                                    <ul><?php

                                    for ($i=1; $i<=$nombrededisque; $i++){ echo("<li>Disque " . $i . "</li>");}

                                    ?>
                                    </ul><?php
                                }

                                ?>
                                <div class="detail_disque" id="detail_disque1"> <!-- encadrement de la liste des titres par disque-->
                                <?php
                                $i=1;
                                foreach ($liaisontitres as $liaisontitre ) 
                                {
                                    //=====
                                    //=== Récupération des éléments du titre (nom, duree, etc...)
                                    //=====
                                    $notitre = $liaisontitre->getNoTitre();
                                    $dureetitre = $liaisontitre->getDureeTitre();
                                    $nodisque = $liaisontitre->getNoDisque();
                                    $nopiste = $liaisontitre->getNoPiste();
                                    //instanciation du titre
                                    $titre = new Titre(['noTitre' => $notitre]);
                                    $nomtitre = $managertitre->findNomTitre($titre);

                                    //si changement de disque
                                    if($nodisque!=$memo_no_disque)
                                    {
                                        $i++;
                                        echo ("</div>"); //fermeture de la div .detail_disque
                                        $memo_no_disque = $nodisque;
                                        echo ('<div class="detail_disque" id="detail_disque' . $i . '">');
                                    }
                                    //=====
                                    //=== Affichage des titres
                                    //=====
                                    /**
                                    if ($memo_no_disque!=$nodisque)
                                    {
                                        //Hors permier passage (dans le cas de plusieurs disques)
                                        if ($nodisque != 1){echo ('<br/></div><div class="cadre_disque">');}
                                        echo ("<strong class='label_disque'>disque " . $nodisque . "</strong>");

                                    } 010919 **/
                                    
                                    echo  "<p>" . $nopiste . ". " . $nomtitre . " "  . "</p>";

                                    //$memo_no_disque = $nodisque;
                                }
                                ?>
                                </div> <!-- .detail_disque -->
                                <!--</div> cadre_disque -->

                            </div> <!-- .liste_titres -->
                        </div> <!-- detail_album -->
                         
                        <div class="infos_album" >
                            <!-- infos diverses -->
                                <p>
                                    <?php
                                        if ($labelAlbum!='') {echo "<strong>Label:</strong> " . $labelAlbum . "<br>";}
                                        if ($referenceAlbum!='') {echo "<strong>Reference:</strong> " . $referenceAlbum . " <br/>";}
                                        if ($producteurAlbum!='') {echo "<strong>Producteur:</strong> " . $producteurAlbum . "<br/>";}
                                    ?>
                                </p>
                        </div> 

                        <div class="pied_cadre_album">
                            <?php
                            //calcul age de johnny à la sortie de l'album
                                if ($annee_album<2018)
                                {
                                    $datetime1 = new DateTime('1943-06-15'); //date naissance de Johnny
                                    $datetime2 = new DateTime($date_sortie_album); 
                                    $interval = $datetime1->diff($datetime2);

                                    // selon le serveur c'est fr ou fr_FR ou fr_FR.ISO8859-1 qui est correct.
                                    setlocale (LC_TIME, 'fr_FR.utf8','fra');
                                    
                                    //$agejohnny = intval($annee_album) - 1943;
                                    //echo("Album sorti le " . $date_sortie_album . "<br>");
                                    echo ("Sortie le " . strftime("%A %d %B %G",strtotime($date_sortie_album))  . "<br>");
                                    echo("Johnny avait " . $interval->format('%y ans'));
                                 }
                                else
                                {
                                    echo("--------");
                                }
                            ?>
                        </div>

                    </div> <!-- .cadre_album -->
    	            <?php
                } //test si album dans la décennie sélectionnée
            } //foreach $albums    
        ?></div><?php   
    }?>