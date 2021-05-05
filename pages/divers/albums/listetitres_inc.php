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
    require_once '../fonctions/fonctions.php';
    $checkparolestitres = $_POST['checkparolestitres'];
}

if(!isset($checkparolestitres)){$checkparolestitres= false;}

$titres = array();
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
//*****
//***** AFFICHAGE DE LA LISTE DE TITRES ****
//*****
?>

    <div class="container-fluid" style="background-color: aliceblue";>
        
        <!--------------------->
        <!-- ENTETE DE LISTE -->
        <!--------------------->

            <div class="row entete text-center">
                <span class="entetetitre text-center" style="border-right: solid lightgrey;display: none;">No</span>
                <span class="col-12 entetetitre">Titres</span>
            </div>

        <!--------------------->
        <!-- CORPS DE LISTE  -->
        <!--------------------->
            <div id="divlisteTitres" class="row" style="font-size: 16px;">
                <?php
                    $i=0;

                    foreach ($titres as $titre)
                    {
                        if (($checkparolestitres==true and $titre->getTexteTitre()==null) or ($checkparolestitres == false))
                        {
                            $i++;
                            ?>
                            <div class="lignetitre col-12" style="border-bottom: 0.1em solid lightgrey;height: 30px;line-height: 30px;">
                                <p>
                                    <span style="border-right: solid lightgrey; display: none;"><?php echo($titre->getNoTitre()); ?></span>
                                    <span title="Titre no <?php echo($titre->getNoTitre()); ?>"><?php echo($titre->getNomTitre()); ?></span>
                                    <br>
                                </p>
                                <?php 
                                    if($i==1) { $_SESSION['notitre'] = $titre->getNoTitre();}
                                ?>
                            </div>

                <?php }
                    }?>
            </div>

        <strong>total: <?php echo $i; ?></strong>
    </div>