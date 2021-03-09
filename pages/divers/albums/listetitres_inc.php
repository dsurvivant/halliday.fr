<?php
//
//michemuche62
//Johnny Hallyday
//
// création de la liste des titres
//
//

/** appel de la feuille par une requête ajax **/
if (isset($_POST['ajax']))
{
    require_once '../login/login.php'; //parametres de connexion et connexion à la bdd
    require_once '../classes/Titre.class.php';
    require_once '../classes/TitresManager.class.php';
}
//connexion à la base de donnees
$bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
//recherche du nombre total d'album
$manager = new TitresManager($bdd);
$nombreTitres = $manager->getnombreTitres();

//*****
//***** DETERMINATION DE L'ORDRE DES INFOS DANS LE TABLEAU ****
//*****

    /** TRI PAR DEFAUT **/
    $titres = $manager->getList();
    /**************************/
    /** TRI PAR NOM DE TITRE **/
    /**************************/
        if (isset($_POST['ordreTitre'])) //classement par année
        {
            if ($_POST['ordreTitre']=="croissant")
            {$titres = $manager->getList();}
            else
            {$titres = $manager->getListDesc();}
        }

    /**************************/
    /** TRI PAR NO DE TITRE  **/
    /**************************/
        if (isset($_POST['ordreNo'])) //classement par année
        {
            if ($_POST['ordreNo']=="croissant")
            {$titres = $manager->getListNoAsc();}
            else
            {$titres = $manager->getListNoDesc();}
        }

    /******************************/
    /** TRI PAR ANNEE DU TITRE  **/
    /****************************/

        
//*****
//***** AFFICHAGE DE LA LISTE DE TITRES ****
//*****
?>

    <div class="container-fluid" style="background-color: aliceblue";>
        
        <!--------------------->
        <!-- ENTETE DE LISTE -->
        <!--------------------->

            <div class="row entete">
                <span class="col-lg-1 entetetitre text-center" style="border-right: solid lightgrey;display: none;">No</span>
                <span class="col-lg-9 entetetitre" style="border-right: solid lightgrey;">Titre</span>
                <span class="col-lg-2 entetetitre" >Année</span>
            </div>

        <!--------------------->
        <!-- CORPS DE LISTE  -->
        <!--------------------->
            <div id="divlisteTitres" class="row container-fluid" style="font-size: 16px;">
                <?php
                    $i=0;
                    foreach ($titres as $titre)
                    {
                        $i++;
                        ?>
                        <div class="row lignetitre" style="border-bottom: 0.1em solid lightgrey;height: 30px;line-height: 30px;">
                            <span class="col-lg-1" style="border-right: solid lightgrey; display: none;"><?php echo($titre->getNoTitre()); ?></span>
                            <span class="col-lg-9" style="border-right: solid lightgrey;" title="Titre no <?php echo($titre->getNoTitre()); ?>"><?php echo($titre->getNomTitre()); ?></span>
                            <span class="col-lg-2">xxxx</span>

                            <?php 
                                if($i==1) { $_SESSION['notitre'] = $titre->getNoTitre();}
                            ?>
                        </div>
                <?php
                    }?>
            </div>

        <strong>total: <?php echo $nombreTitres; ?></strong>
    </div>