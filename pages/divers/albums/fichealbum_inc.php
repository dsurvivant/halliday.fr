<?php
//
//michemuche62
//made in rock'n'roll
//*****************************************************************************************************
//**                                                                                                 **
//** affiche les détails de l'album concerné                                                         **
//**  ENTREE  $_GET['noAlbum'] pour affichage de la fiche de l'album numero $_GET['noAlbum']          **
//**                                                                                                 **   
//** recherche à l'aide de la partie qui nous interresse:                                            **
//** - PARTIE 1 - RECUPERATION DES ELEMENTS DE L'ALBUM                                               ** 
//** - PARTIE 2 - AFFICHAGE HTML DE LA FICHE DE L'ALBUM                                              **   
//**                                                                                                 **   
//*****************************************************************************************************


/** - PARTIE 1 - **/
require_once '../fonctions/fonctions.php'; //fonction de sécurité des saisies
require_once '../login/login.php'; //parametres de connexion et connexion à la bdd

require_once '../classes/Album.class.php';
require_once '../classes/AlbumsManager.class.php';
require_once '../classes/Titre.class.php';
require_once '../classes/TitresManager.class.php';
require_once '../classes/LiaisonAlbumsTitres.class.php';
require_once '../classes/LiaisonAlbumsTitresManager.class.php';
require_once '../classes/TypesAlbum.class.php';
require_once '../classes/TypesAlbumManager.class.php';

//connexion à la base de donnees
$bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));

//recherche du nombre total d'album
$manager = new AlbumsManager($bdd);
$nombreAlbum = $manager->getnombreAlbums();

//recherche des droits

    
//si pas d'album, pas d'affichage de liste
if ( $nombreAlbum != 0 )
{

if(isset($_GET['noAlbum'])) {$noAlbum = $_GET['noAlbum'];}

//=====RECUPERATION DES ELEMENTS DE LA TABLE ALBUM
    $album = new Album(['noAlbum' => $noAlbum]);
    $manager = new AlbumsManager($bdd);
    $manager-> findNoAlbum($album);
    $nomAlbum = $album->getnomAlbum();
    $datesortieAlbum = $album->getdatesortieAlbum();
    $typeAlbum = $manager->libelletypeAlbum($album);
    $formatAlbum = $manager->libelleformatAlbum($album);
    $producteurAlbum = $album->getproducteurAlbum();
    $referenceAlbum = $album->getreferenceAlbum();
    $labelAlbum = $album->getlabelAlbum();

/** - PARTIE 2 - **/

//****************************************************************************************************
//** AFFICHAGE FICHE DE L'ALBUM
//****************************************************************************************************
        //=====jaquettes
        $sourceavant = "pages/divers/images/" . $typeAlbum . "/" . nettoyerChaine(skip_accents(html_entity_decode($nomAlbum)) . "-avant.jpg");
        $sourcearriere = "pages/divers/images/" . $typeAlbum . "/" . nettoyerChaine(skip_accents(html_entity_decode($nomAlbum)) . "-arriere.jpg");
        //if (!file_exists($sourceavant)){$sourceavant="pages/divers/images/johnny.jpg";}
        //if (!file_exists($sourcearriere)){$sourcearriere="pages/divers/images/johnny.jpg";}
        ?>
        <div id="fichealbum" class="container-fluid">

            <div class="row">
                <?php
                    //!!!! noalbum: ne pas supprimer, sert pour les autres pages !!!!              
                    echo ("<span id='noAlbum'>No album : " . $noAlbum . "</span>");
                    //!!!!!!
                    echo("<div class='entete'>" . dateToFrench($datesortieAlbum,'Y') . "<br><span id='spannomAlbum'>" . $nomAlbum . " </span>(" . $typeAlbum . ")</div>" ); 
                    //
                    ?><div id="divers"><?php
                    echo("<span>sorti le : " . dateToFrench($datesortieAlbum,'d F Y') . "</span><br>");
                    echo("<span>" . $producteurAlbum . "-" . $referenceAlbum . "-" . $labelAlbum . "</span>");
                    ?></div>
            </div>

            <div class="row">

                <div id="jaquettes" class="col-md-3">
                    <!-- echo time est ici pour un probleme de cache des navigateurs qui reprennent l'ancienne image -->
                    <p><img src="<?php echo $sourceavant ?>?time=<?php echo time(); ?>" alt="pochette avant" title="pochette avant"/></p>
                    <?php
                    if (file_exists("../" . $sourcearriere)){?>
                        <p><img src="<?php echo $sourcearriere ?>?time=<?php echo time(); ?>" alt="pochette arrière" title="pochette arrière"/></p>
                    <?php }

                    if (isset($_GET['choix']))// cas ou la fiche album est affichée après un ajout ou une modification
                    {
                        ?>
                        <button class="btn btn-primary" id="bouton_annuler">OK</button>
                        <button class="btn btn-primary" id="bouton_modifier">Modifier</button>
                        <?php
                    }
                        ?>
                </div> <!-- #jaquettes -->

                <div id="detailAlbum" class="col-md-9">
                    <?php
                    //======AFFICHAGE DES TITRES
                    $managerliaison = new LiaisonAlbumsTitresManager($bdd);
                    $liaisontitres = $managerliaison->getTitres($album); ////recherche les titres associés à l'album dans la table de liaison
                    $managertitre = new TitresManager($bdd);
                    $memonodisque=0;
                    foreach ($liaisontitres as $liaisontitre ) 
                    {
                        $passage=0;
                        $notitre = $liaisontitre->getNoTitre();
                        $dureetitre = $liaisontitre->getDureeTitre();
                        $nodisque = $liaisontitre->getNoDisque();
                        $nopiste = $liaisontitre->getNoPiste();
                        //instanciation du titre
                        $titre = new Titre(['noTitre' => $notitre]);
                        $nomtitre = $managertitre->findNomTitre($titre);

                        if ($nodisque!=$memonodisque) 
                        {
                            $passage++;
                            $memonodisque=$nodisque;
                              
                            //premier passage on ferme pas le tableau
                            if ($passage!=1) {echo("</tbody></table></div></div>");}
                            ?>
                               <div id="tableauxtitres">
                                <table id="tableTitres1" class="tableTitres table table-condensed">
                                 <caption id="disque1"><?php echo ($formatAlbum . $nodisque); ?> </caption>
                                    <tbody>
                                    <?php //ligne du tableau
                                    echo("<tr class=\"ligneTitre\"><td>" . $nopiste . "</td><td>" . $nomtitre . "</td><td> " . $dureetitre . "</td></tr>");
                        }
                        else
                        {
                            echo("<tr class=\"ligneTitre\"><td>" . $nopiste . "</td><td>" . $nomtitre . "</td><td>" . $dureetitre . "</td></tr>");
                        }
                    } //foreach
                    //fermeture du dernier tableau
                    ?>
                                    </tbody>
                                </table>
                                </div> <!-- #tableauxtitres -->
                </div> <!-- #detailAlbum -->
            </div>
        </div>

<?php
}
    ?>