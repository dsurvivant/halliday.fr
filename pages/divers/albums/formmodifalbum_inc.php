<div id="fichemodifalbum" class="container">
<?php
//
//michemuche62
//made in rock'n'roll

require_once '../login/login.php'; //parametres de connexion et connexion à la bdd
require_once '../fonctions/fonctions.php'; //fonction de sécurité des saisies

require_once '../classes/Album.class.php';
require_once '../classes/AlbumsManager.class.php';
require_once '../classes/LiaisonAlbumsTitresManager.class.php';
require_once '../classes/LiaisonAlbumsTitres.class.php';
require_once '../classes/TitresManager.class.php';
require_once '../classes/Titre.class.php'; 

    /** variables d'entrees **/

    if (isset($_GET['noalbum'])){$noAlbum = $_GET['noalbum'];}
    //else { $noAlbum = 1;}

    if (isset($_GET['noutilisateur'])) { $noutilisateur = $_GET['noutilisateur'];}
    else { $noutilisateur = "1";}
    //connexion à la base de donnees
    $bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    //=====RECUPERATION DES ELEMENTS DE LA TABLE ALBUM
            $album = new Album(['noalbum' => $noAlbum]);
            $manager = new AlbumsManager($bdd);
            $manager-> findNoAlbum($album); //hydratation de la classe album

            $nomAlbum = $album->getnomAlbum();
            $datesortieAlbum = $album->getdatesortieAlbum();
            $typeAlbum = $manager->libelletypeAlbum($album);
            $formatAlbum = $manager->libelleformatAlbum($album);
            $producteurAlbum = $album->getproducteurAlbum();
            $referenceAlbum = $album->getreferenceAlbum();
            $labelAlbum = $album->getlabelAlbum();
            $descriptionAlbum = $album->getDescriptionAlbum();
            $pochetteAlbum = $album->getPochetteAlbum();
            $certificationsAlbum = $album->getCertificationsAlbum();
            $musiciensAlbum = $album->getMusiciensAlbum();
            $enregistrementAlbum = $album->getEnregistrementAlbum();

            //====== RECHERCHE DES TITRES DE L'ALBUM
            $managerliaison = new LiaisonAlbumsTitresManager($bdd);
            $liaisontitres = $managerliaison->getTitres($album); //recherche les titres associés à l'album dans la table de liaison
            $managertitre = new TitresManager($bdd);
?>



    <div id="blocentete" class="row entete">
        <div id="titre_entete" class="col-12 text-center p-2">MODIFIER UN ALBUM</div>
    </div>

    <div class="row">
        <!-- FORMULAIRE DE SAISI DES ELEMENTS DE L'ALBUM -->
        <form id="formAlbum" method="post"  enctype="multipart/form-data"> <!-- action géré par jQuery -->
        <div class="container-fluid">    
                <!--=====               -->
                <!--== ALBUM            -->
                <!--=====               -->
            <div class="row">
                <div id="blocJaquettes" class="col-md-2 container-fluid">
                    <div class="row">
                        <!-- taille des fichiers maxi 1mo -->
                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                        <!--<div class="jaquette" id="xxxxxxxxx">-->
                        <div id="jaquette_avant" class="col-md-offset-0 col-md-12 col-sm-offset-3 col-sm-3 jaquette">
                            <?php 
                                $source="pages/divers/images/" . $typeAlbum . "/" . nettoyerChaine(skip_accents(html_entity_decode($nomAlbum)) . "-avant.jpg");
                                //if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $source)) {$source="pages/divers/images/johnny.jpg";}
                            ?>
                            <!-- echo time est ici pour un probleme de cache des navigateurs qui reprennent l'ancienne image --> 
                            <img src="<?php echo $source; ?>?time=<?php echo time(); ?>" alt="pochette avant" title="pochette avant" width="150px" height="150px"/>
                            <input id="fileJaquetteAvant" type="file" class="input-file" name="fileJaquetteAvant" value="<?php echo $source; ?>" style="position: absolute; visibility: hidden;" />
                        </div>
                            
                        <!--<div class="jaquette" id="testid">-->
                        <div id="jaquette_arriere" class="col-md-12 col-sm-3 jaquette">
                            <?php 
                                $source="pages/divers/images/" . $typeAlbum . "/" . nettoyerChaine(skip_accents(html_entity_decode($nomAlbum)) . "-arriere.jpg");
                                
                                //if (!is_file($_SERVER['DOCUMENT_ROOT'] .$source)) {$source="pages/divers/images/johnny.jpg";}
                            ?>
                            <!-- echo time est ici pour un probleme de cache des navigateurs qui    reprennent l'ancienne image -->
                            <img src="<?php echo $source; ?>?time=<?php echo time(); ?>" alt="pochette arrière" title="pochette arrière" width="150px" height="150px"/>
                            <input id="fileJaquetteArriere" type="file" class="input-file" name="fileJaquetteArriere" value="<?php echo $source; ?>" style="position: absolute; visibility: hidden;" />
                        </div> 
                    </div>     
                </div>

                <!-- bloc noalbum, nomalbum, annneealbum, typealbum, formatalbum -->
                <div id="blocalbum" class="col-md-5">
                    <!-- ONGLETS -->
                        <nav class="nav nav-tabs" >
                            <a href="#general" class="nav-item nav-link active" data-toggle="tab">Infos</a>
                            <a href="#description" class="nav-item nav-link " data-toggle="tab">Description</a>
                            <a href="#musiciens" class="nav-item nav-link " data-toggle="tab">Musiciens</a>
                            <a href="#enregistrement" class="nav-item nav-link " data-toggle="tab">Enregistrement</a>
                        </nav>
                    

                    <!-- TABLEAUX -->
                    <div class="tab-content">
                        <!-- ONGLET INFOS -->
                        <div id="general" class="tab-pane active">
                            <!-- No d'album -->
                                <label for="noAlbum">No</label>
                                <input type="text" id="noAlbum" name="noAlbum" value="<?php echo $noAlbum; ?>" readonly /><br/>
                            <!-- Nom album -->
                                <label for="nomAlbum">Nom</label>
                                <input type="text" id="nomAlbum" name="nomAlbum" value="<?php echo $nomAlbum; ?>" maxlength="100" placeholder="<?php echo $nomAlbum; ?>"/><br/>
                            <!-- Date de sortie -->
                                <label for="datesortieAlbum">Date de sortie</label>
                                <input type="text" id="datesortieAlbum" name="datesortieAlbum" value="<?php echo dateconv2($datesortieAlbum); ?>" maxlength="10" placeholder="jj/mm/yyyy">
                                <br>
                            <!-- Type -->
                                <label for="typeAlbum">Type</label>
                                <select id="typeAlbum" name="typeAlbum">
                                    <?php
                                    //remplissage du select droits
                                    try
                                    {
                                        $i=0;
                                        $reponse = $bdd->query('SELECT * FROM typesalbum');

                                        while ($donnees = $reponse->fetch())
                                        {
                                            if ($donnees['typeAlbum']==$typeAlbum) {$focus = "selected";} else {$focus = "";}
                                            echo ("<option value=" . $donnees['notypeAlbum'] . " " . $focus . ">" . $donnees['typeAlbum']  . "</option>");

                                        }

                                        $reponse->closeCursor(); // Termine le traitement de la requête

                                    }
                                    catch (Exception $e)
                                    {
                                        die('Erreur : ' . $e->getMessage());
                                    }
                                    ?>                         
                                </select>
                                <br>
                            <!-- Format -->
                                <label for="Format">Format</label>
                                <select id="formatAlbum" name="formatAlbum">
                                    <?php
                                        //remplissage du select droits
                                    try
                                    {
                                        $i=0;
                                        $reponse = $bdd->query('SELECT * FROM formatalbum');
                                            
                                        while ($donnees = $reponse->fetch())
                                        {
                                            if ($donnees['formatAlbum']==$formatAlbum) {$focus = "selected";} else {$focus = "";}
                                            echo ("<option value=" . $donnees['noformatAlbum'] . " " . $focus . ">" . $donnees['formatAlbum']  . "</option>");
                                                        
                                        }

                                        $reponse->closeCursor(); // Termine le traitement de la requête

                                    }
                                    catch (Exception $e)
                                    {
                                        die('Erreur : ' . $e->getMessage());
                                    }
                                    ?>                         
                                </select>
                                <br>
                            <!-- Producteur -->
                                <label for="producteurAlbum">Producteur</label>
                                <input type="text" id="producteurAlbum" name="producteurAlbum" value="<?php echo $producteurAlbum ?>" maxlength="1000">
                                <br>
                            <!-- Reference -->
                                <label for="referenceAlbum">Reference</label>
                                <input type="text" id="referenceAlbum" name="referenceAlbum" value="<?php echo $referenceAlbum ?>" maxlength="50">
                                <br>
                            <!-- Label -->
                                <label for="labelAlbum">Label</label>
                                <input type="text" id="labelAlbum" name="labelAlbum" value="<?php echo $labelAlbum ?>" maxlength="50">
                                <br>
                            <!-- Certifications -->
                                <label for="certificationsAlbum">Certifications</label>
                                <input type="text" id="certificationsAlbum" name="certificationsAlbum" value="<?php echo $certificationsAlbum ?>" maxlength="255">
                                <br>
                            <!-- Pochette -->
                                <label for="pochetteAlbum">Pochette</label>
                                <input type="text" id="pochetteAlbum" name="pochetteAlbum" value="<?php echo $pochetteAlbum ?>"  maxlength="100">
                                <br>
                            <!-- Utilisateur connecté -->
                            <input id="inputnoutil" type="text" name="noutil" value="<?php echo $noutilisateur; ?>" placeholder="noutilisateur" style="visibility: hidden;" disabled>
                             <!-- -->
                        </div>

                        <!-- ONGLET DESCRIPTION -->
                        <div id="description" class="tab-pane " >
                             <div class="form-group">
                               <label for="description">Description de l'album</label>
                               <textarea class="form-control" id="description" rows="8" name="descriptionAlbum"><?= $descriptionAlbum ?></textarea>
                             </div>
                        </div>

                        <!-- ONGLET MUSICIENS -->
                        <div id="musiciens" class="tab-pane " >
                            <div class="form-group">
                               <label for="musiciens">Musiciens</label>
                               <textarea class="form-control" id="musiciens" rows="8" name="musiciensAlbum"><?= $musiciensAlbum ?></textarea>
                             </div>
                        </div>

                        <!-- ONGLET ENREGISTREMENT -->
                        <div id="enregistrement" class="tab-pane " >
                            <div class="form-group">
                               <label for="enregistrements">Enregistrements</label>
                               <textarea class="form-control" id="enregistrements" rows="8" name="enregistrementAlbum"><?= $enregistrementAlbum ?></textarea>
                             </div>
                        </div>
                    </div>
                </div>
     
                <!--=====                -->
                <!--== TITRES DE L'ALBUM -->
                <!--=====                -->
                        
                <div id="bloctitres" class="col-md-5">

                    <!--                    -->
                    <!--TABLEAUX DES TITRES -->
                    <!--                    -->

                    <?php
                        //instanciation de l'album
                        $album = new Album(['noAlbum' => $noAlbum]);
                        //
                        $managerliaison = new LiaisonAlbumsTitresManager($bdd); //management de la table de liaison album/titres
                        $liaisontitres = $managerliaison->getTitres($album); //recherche les no titres associés à l'album
                        $managertitre = new TitresManager($bdd); //management de la table titres
                        $memo_no_disque=0;
                        $nombrededisque= $managerliaison->getnombredisqueAlbums($album);
                        $i=0;
                    ?>
                    <div id="infotitres">
                        <!-- -->
                        <span id="erreurtitre"></span><br/>
                        <span id="erreurformulaire"></span>

                        <!-- -->            
                        <ul id="onglettitres">
                            <?php
                                $y=0;
                                for ($i=0; $i<$nombrededisque; $i++)
                                {
                                    $y++;
                                    ?>
                                        <li class="onglettitre">Disque <?php echo $y; ?></li>
                                    <?php
                                }
                            ?>
                            
                            <!-- @whitespace-->
                            <li id="ongletplus" class="onglettitre">
                                <img id="bouton_plus_onglet" src="pages/divers/images/boutons/bouton-plus.png" alt="ajouter disque" title="ajouter disque" width="15px">
                            </li>
                        </ul>
                    </div>

                    <div id="bloctableaux">
                        <br/>
                        <table id="tableTitres1" class="table tableTitres">
                            <caption id="disque1">Disque 1</caption>

                            <thead> <!-- En-tête du tableau -->
                               <tr>
                                   <th>No</th>
                                   <th>Titre</th>
                                   <th>Durée</th>
                                   <th></th>
                                   <th>
                                        <img class="bouton_plus_titre_thead" src="pages/divers/images/boutons/bouton-plus.png" alt="ajouter titre" title="ajouter titre" width="15px">
                                    </th>
                               </tr>
                           </thead>

                           <tbody> <!-- Corps du tableau -->
                                <?php
                                $i=0;
                                foreach ($liaisontitres as $liaisontitre) 
                                {
                                    $i++;
                                    //=====
                                    //== Récupération des éléments du titre (nom, duree, etc..)
                                    //=====
                                    $notitre = $liaisontitre->getNoTitre();
                                    $dureetitre = $liaisontitre->getDureeTitre();
                                    $nodisque = $liaisontitre->getNoDisque();
                                    $nopiste = $liaisontitre->getNoPiste();
                                    //instanciation du titre
                                    $titre = new Titre(['noTitre' => $notitre]);
                                    $nomtitre = $managertitre->findNomTitre($titre);

                                    //=====
                                    //== Affichage des titres
                                    //=====
                                    if ($memo_no_disque!=$nodisque)
                                    {
                                        //Hors permier passage (dans le cas de plusieurs disques)
                                        if ($i!=1)
                                        {
                                            $nombrededisque++;
                                            //je ferme le tableau
                                            echo ("</tbody></table>");
                                            //j'ouvre le tableau suivant
                                            echo('<table id="tableTitres' . $nodisque . '" class="table tableTitres"><caption id="disque1">Disque ' . $nodisque . '<img  id="suppressionTableau" src="pages/divers/images/boutons/poubelle.png" alt="supprimer tableau" title="supprimer tableau" width="15px"></caption><thead><tr><th>No</th><th>Titre</th><th>Durée</th><th></th>
                                            <th><img class="bouton_plus_titre_thead" src="pages/divers/images/boutons/bouton-plus.png" alt="ajouter titre" title="ajouter titre" width="15px"></th></tr></thead><tbody>');
                                        }
                                    }
                                    ?>

                                   <tr class="ligne">
                                        <td class="notitre"><?php echo $nopiste ?></td>
                                        <td class="nomtitre">
                                            <input class="modifier_titre form-control" type="text" name="nomtitre"  value="<?php echo $nomtitre; ?>" placeholder="<?php echo $nomtitre; ?>"/>
                                        </td>

                                        <td class="dureetitre">
                                             <input class="modifier_duree form-control" type="text" name="dureetitre" value="<?php echo $dureetitre; ?>" maxlength="5" placeholder="<?php echo $dureetitre; ?>" />   
                                        </td>

                                        <td>
                                            <img class=" bouton_moins_titre" src="pages/divers/images/boutons/bouton-moins.png" alt="supprimer titre" title="supprimer titre" width="15px">
                                        </td>
                                        <td>
                                            <img class=" bouton_plus_titre" src="pages/divers/images/boutons/bouton-plus.png" alt="ajouter titre" title="ajouter titre" width="15px">
                                        </td>
                                   </tr> 

                                   <?php
                                   $memo_no_disque = $nodisque;
                                } //foreach
                                ?>

                           </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div> <!-- container-fluid -->
        </form>
    </div>

    <div class="row">
        <div id="#blocboutons" class="col-lg-12 text-center">
            <button class="btn btn-primary" id="bouton_valider">Modifier</button>
            <button class="btn btn-primary" id="bouton_annuler">Annuler</button>
        </div> 
    </div> 
</div>

<script src="pages/divers/jquery/albums/ajout_modif_Album.js"></script>