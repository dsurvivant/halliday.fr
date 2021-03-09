<div id="ficheajoutalbum" class="container">
<?php
//
// *** formulaite d'ajout pour un album ***
//michemuche62
//made in rock'n'roll

    require_once '../login/login.php'; //parametres de connexion et connexion à la bdd

    /** variables d'entrees **/

    if (isset($_GET['noutilisateur'])) { $noutilisateur = $_GET['noutilisateur'];}
    else {$noutilisateur = "1";}

    //connexion à la base de donnees
    $bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));

?>

    <div id="blocentete" class="row entete">
        <div id="titre_entete" class="col-xs-12">AJOUTER UN ALBUM</div>
    </div>

    <div class="row">
        <!-- FORMULAIRE DE SAISI DES ELEMENTS DE L'ALBUM -->
        <form id="formAlbum" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;"> <!-- action géré par jQuery -->

        <div class="container-fluid">
                <!--=====               -->
                <!--== ALBUM            -->
                <!--=====               -->
            <div class="row">
                <div id="blocJaquettes" class="col-md-2 container-fluid">

                    <!-- taille des fichiers maxi 1mo -->
                    <!--<input type="hidden" name="MAX_FILE_SIZE" value="1000000">-->
                    <div class="row">
                        <div id="jaquette_avant" class="col-md-offset-0 col-md-12 col-sm-offset-3 col-sm-3 jaquette">
                            <img src="pages/divers/images/johnny.jpg" alt="pochette avant" title="pochette avant" width="150px"/>
                            <input id="fileJaquetteAvant" type="file" class="input-file" name="fileJaquetteAvant" style="position: absolute; visibility: hidden;" />
                        </div>

                        <div id="jaquette_arriere" class="col-md-12 col-sm-3 jaquette">
                            <img src="pages/divers/images/johnny.jpg" alt="pochette arrière" title="pochette arrière" width="150px"/>
                            <input id="fileJaquetteArrière" type="file" class="input-file" name="fileJaquetteArriere" style="position: absolute; visibility: hidden;" />
                        </div>
                    </div>

                </div>

                <div id="blocalbum" class="col-md-5">
                    
                    <!-- -->
                    <label for="nomAlbum">Nom</label><input type="text" id="nomAlbum"  name="nomAlbum" maxlength="100"/><br/>
                    <!-- -->
                    <label for="datesortieAlbum">Date de sortie</label><input type="text" id="datesortieAlbum" name="datesortieAlbum" maxlength="10" placeholder="jj/mm/yyyy"/><br/>
                    <!-- -->
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
                                    if ($donnees['typeAlbum']=="studio") {$focus = "selected";} else {$focus = "";}
                                    echo ("<option value=" . $donnees['notypeAlbum'] . " " . $focus . ">" . $donnees['typeAlbum']  . "</option>");

                                }

                                $reponse->closeCursor(); // Termine le traitement de la requête

                            }
                            catch (Exception $e)
                            {
                                die('Erreur : ' . $e->getMessage());
                            }
                            ?>
                        </select><br/>
                        <!-- -->
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
                                    if ($donnees['formatAlbum']=="CD") {$focus = "selected";} else {$focus = "";}
                                    echo ("<option value=" . $donnees['noformatAlbum'] . " " . $focus . ">" . $donnees['formatAlbum']  . "</option>");

                                }

                                $reponse->closeCursor(); // Termine le traitement de la requête

                            }
                                catch (Exception $e)
                            {
                                die('Erreur : ' . $e->getMessage());
                            }
                                ?>
                        </select><br/>
                         <!-- -->
                         <label for="producteurAlbum">Producteur</label><input type="text" id="producteurAlbum" name="producteurAlbum" maxlength="50"/><br/>
                         <!-- -->
                         <label for="referenceAlbum">Reference</label><input type="text" id="referenceAlbum" name="referenceAlbum" maxlength="50"/><br/>
                         <!-- -->
                         <label for="labelAlbum">Label</label><input type="text" id="labelAlbum" name="labelAlbum" maxlength="50"/><br/>
                         <!-- -->
                         <label for="inputnoutil" style="visibility: hidden;">Utilisateur</label><input id="inputnoutil" type="text" name="noutil" value="<?php echo $noutilisateur; ?>" style="visibility: hidden;" disabled/>

                </div>
            
                <!--=====                -->
                <!--== TITRES DE L'ALBUM -->
                <!--=====                -->
                <div id="bloctitres" class="col-md-5">

                    <div id="infotitres">
                        <!-- -->
                        <span id="erreurtitre"></span><br/>
                        <span id="erreurformulaire"></span>

                        <!-- -->
                        <ul id="onglettitres">
                            <li class="onglettitre">Disque 1</li>
                            <!-- @whitespace-->
                            <li id="ongletplus" class="onglettitre"><span id="bouton_plus_onglet" class="glyphicon glyphicon-plus bouton_plus_onglet" title="ajouter disque"></span></li>
                        </ul>
                    </div>

                    <!--tableaux des titres -->
                    <div id="bloctableaux">
                        <table id="tableTitres1" class="table tableTitres">
                            <caption id="disque1">Disque 1</caption>

                            <thead> <!-- En-tête du tableau -->
                                <tr>
                                    <!-- <th class="effacer_colonne">No</th> -->
                                    <th style="width:20px;">No</th>
                                    <th>Titre</th>
                                    <th style="width:100px;">Durée</th>
                                    <th style="width:20px;"></th>
                                    <th style="width:20px;"><span class="glyphicon glyphicon-plus bouton_plus_titre_thead" title="ajouter"></span></th>
                                </tr>
                            </thead>

                            <tbody> <!-- Corps du tableau -->
                                <tr class="ligne">
                                    <td class="notitre">1</td>
                                    <td><input class="modifier_titre form-control" type="text" name="nomtitre"/></td>
                                    <td><input class="modifier_duree form-control" type="text" name="dureetitre"  maxlength="5" /></td>
                                    <td><span class="glyphicon glyphicon-minus bouton_moins_titre" title="supprimer"></span></td>
                                    <td><span class="glyphicon glyphicon-plus bouton_plus_titre" title="ajouter"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div id="#blocboutons" class="col-lg-12 text-center">
                    <button class="btn btn-primary" id="bouton_valider">Valider</button>
                    <button class="btn btn-primary" id="bouton_annuler">Annuler</button>
                </div>
            </div>
    
        </div> <!-- container-fluid -->
        </form>
    </div>

</div>


<script src="pages/divers/jquery/albums/ajout_modif_Album.js"></script>
