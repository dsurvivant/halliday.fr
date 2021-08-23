<?php
//
//JOHNNY HALLYDAY
//
//  Créé par JMT
//
// création du tableau contenant les albums
// surlignemant de l'album actif
// classement par année, no album ou type album
// affichage par type (studio , live, etc) ou de la totalité
//
//
    
    /** appel de la feuille par une requête ajax **/
    if (isset($_POST['ajax']))
    {
        require_once '../login/login.php'; //parametres de connexion et connexion à la bdd
        require_once '../classes/Album.class.php';
        require_once '../classes/AlbumsManager.class.php';
        require_once '../classes/Droits.class.php';
        require_once '../classes/DroitsManager.class.php';
    }

    //connexion à la base de donnees
    $bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    //recherche du nombre total d'album
    $manager = new AlbumsManager($bdd);
    $nombreAlbums = $manager->getnombreAlbums();

    //récupération des droits (RETOUR AJAX)
        if(isset($_POST['noutil'])) //retour Ajax
        {
            $droits = new Droits(['noutil'=>$_POST['noutil']]);
            $managerdroits = new DroitsManager($bdd);
            $managerdroits->findDroits($droits);

            $managerdroits->findDroits($droits);
            $modifieralbum = $droits->getModifieralbum();
            $ajouteralbum = $droits->getAjoutalbum();
            $supprimeralbum = $droits->getSupprimeralbum();
        }
        else
        {
            $modifieralbum = 0;
            $ajouteralbum = 0;
            $supprimeralbum = 0;
        }

        if (isset($_SESSION['modifieralbum'])) { $modifieralbum = $_SESSION['modifieralbum']; }
        if (isset($_SESSION['supprimeralbum'])) { $supprimeralbum = $_SESSION['supprimeralbum']; }
        if (isset($_SESSION['ajoutalbum'])) { $ajouteralbum = $_SESSION['ajoutalbum']; }

    //determination du numéro d'album à surligné
    if (isset($_POST['noAlbum'])) 
        { $noAlbum_saisi = $_POST['noAlbum'];}
    else
        { $noAlbum_saisi = '';}

    //filtre du type d'album
    if (isset($_POST['choixtype']))
        { $choixtype = $_POST['choixtype'];}
    else
        { $choixtype = "Tous";}
//*****
//***** DETERMINATION DE L'ORDRE DES INFOS DANS LE TABLEAU ****
//*****
    $albums = $manager->getListAnneeAsc(); //classement par année par défaut

    if (isset($_POST['ordreAnnee'])) //classement par année
    {
        if ($_POST['ordreAnnee']=="croissant")
        {$albums = $manager->getListAnneeAsc();}
        else
        {$albums = $manager->getListAnneeDesc();}
    }

    if (isset($_POST['ordreAlbum'])) //classement par nom album
    {
        if ($_POST['ordreAlbum']=="croissant")
        {$albums = $manager->getListNomAlbumAsc();}
        else
        {$albums = $manager->getListNomAlbumDesc();}
    }

    if (isset($_POST['ordreNoALbum'])) //classement par numéro d'album
    {
        if ($_POST['ordreNoALbum']=="croissant")
        {$albums = $manager->getListNoAsc();}
        else
        {$albums = $manager->getListNoDesc();}
    }

//*****
//***** REMPLISSAGE DU TABLEAU
//*****
?>  

<div class="entete">
    <caption> Liste des albums (total: <?php echo $nombreAlbums; ?>)</caption>
        <?php
        /**
         * CRUD (create, read, update, delete) si autorisations
         */
            ?>
        <div class="float-right">
            <?php
            //create
            if ($ajouteralbum == 1):?>
                <span id="bouton_ajout_album" title="Ajouter un album" class="boutons_album pull-right" style="margin-right: 5px"><img src="pages/divers/images/boutons/bouton-plus-blanc.png" alt="ajouter" title="Ajouter un album" width="20px"></span>
            <?php endif; 

            // update
            if ($modifieralbum == 1):?>
                <span id="bouton_modifier_album" title="Modifier un album" class="boutons_album pull-right" style="margin-right: 5px"><img src="pages/divers/images/boutons/document2.png" alt="modifier" title="Modifier" width="20px"></span>
            <?php endif;

            if ($supprimeralbum == 1):?>
                <span id="bouton_supprimer_album" title="Supprimer un album" class="boutons_album  pull-right" style="margin-right: 5px"><img src="pages/divers/images/boutons/poubelle2.png" alt="supprimer" title="Supprimer" width="20px"></span>
            <?php endif; ?>
        </div>
</div>

<table id="tablelisteAlbums" class="table table-bordered table-striped table-condensed" style="margin:0;background-color: aliceblue";>
    <thead>
        <tr>
            <th class="d-none" width="37px">No</th>
            <th class="d-none" width="36px">Type</th>
            <th width="36px">Année</th>
            <th width="210px">Albums</th>
        </tr>
    </thead>
</table>

<div id="divlisteAlbums" style="background-color: aliceblue";>

    <table id="tablelisteAlbums" class="table table-bordered table-striped table-condensed" >
        <tbody>
            <?php
            foreach ($albums as $album)
            {
                //récupération du libellé typealbum
                $libelletypeAlbum = $manager->libelletypeAlbum($album);
                $libelleformatAlbum = $manager->libelleformatAlbum($album);
                $noAlbum = $album->getnoAlbum();
                
                if (($choixtype==$libelletypeAlbum) or ($choixtype=="Tous")) //filtre sur le type d'album
                {
                    if ($noAlbum == $noAlbum_saisi) //utilisé pour le surlignement
                    {
                        ?>
                        <tr class="surlignement">
                            <td class="d-none" width="37px"><?php echo $noAlbum; ?></td>
                            <td class="d-none" width="36px"><?php echo substr($libelletypeAlbum, 0, 1) ?></td>
                            <td width="36px"><?php echo substr($album->getdatesortieAlbum(),0,4); ?></td>
                            <td width="210px"><?php echo $album->getnomAlbum(); ?></td>
                        </tr>
                        <?php
                    }
                    else
                    {
                        ?>
                        <tr>
                            <td class="d-none" width="37px"><?php echo $noAlbum; ?></td>
                            <td class="d-none" width="36px"><?php echo substr($libelletypeAlbum, 0, 1) ?></td>
                            <td width="36px"><?php echo substr($album->getdatesortieAlbum(),0,4); ?></td>
                            <td width="210px"><?php echo $album->getnomAlbum(); ?></td>
                        </tr>
                        <?php
                    }
                }             
            }
            ?>
        </tbody>
    </table>
</div>
<!--
<form id="formradioType" class="form-control" style="position: relative;">
    <fieldset>
        <input class="radioType" type="radio" name="radio_type_album" value="Studio">
        <label>Studio</label>
        <input class="radioType" type="radio" name="radio_type_album" value="Live">
        <label>Live</label>
        <input class="radioType" type="radio" name="radio_type_album" value="Compilation">
        <label>Compilation</label>
        <input class="radioType" type="radio" name="radio_type_album" value="Tous" checked>
        <label>Tous</label>
    </fieldset>
</form>
-->
<strong style="right: 0">total: <?php echo $nombreAlbums; ?> albums</strong>

    
