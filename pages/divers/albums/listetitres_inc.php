<?php
//
//michemuche62
//Johnny Hallyday
//
// création de la liste des titres
//
//


$checkparolestitres= "all";
/** appel de la feuille par une requête ajax **/
if (isset($_POST['ajax']))
{
    require_once '../login/login.php'; //parametres de connexion et connexion à la bdd
    require_once '../classes/Titre.class.php';
    require_once '../classes/TitresManager.class.php';
    require_once '../fonctions/fonctions.php';
    $checkparolestitres = $_POST['checkparolestitres']; //with, without, ou all (avec paroles, sans paroles, tout)
}

if (isset($_GET['paroles'])) { $checkparolestitres= $_GET['paroles']; }

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

    /**
     * CHAMP DE RECHERCHE TITRE (retour ajax listeTitre.js)
     */
    if (isset($_POST['recherchetitre'])) 
    {
        if($_POST['recherchetitre']!='')
        {
            $term = trim($_POST['recherchetitre']);
            $term = htmlentities($term);

            if (isset($_POST['ordreTitre'])) //classement par année
            {
                if ($_POST['ordreTitre']=="croissant")
                    {$order = "croissant";}
                else
                    {$order = "decroissant";}
            }
            include('liste_titres_autocomplete.php');
        }
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
            <?php $i=0; ?>

            <div id="listeTitres" class="row mb-2" style="font-size: 16px;">
                
                <!--- LISTE DES TITRES SUR PETIT ECRAN -->               
                <select class="p-1 col-12 d-md-none" name="testselect" id="testselect" size=5>
                       
                    <?php foreach ($titres as $titre):
                        if ( ($checkparolestitres=="without" and $titre->getTexteTitre()==null) or ($checkparolestitres=="with" and $titre->getTexteTitre()!=null) or ( $checkparolestitres=="all" ))
                        {
                            $i++;
                    ?>
                            <option class="lignetitre" name="<?= $titre->getNoTitre(); ?>" <?php if($i==1) { echo "selected"; } ?>><?= $titre->getNomTitre() ?></option>
                    <?php
                            if($i==1) { $_SESSION['notitre'] = $titre->getNoTitre();}
                        } 
                        endforeach; 
                    ?>
                </select>

                <!--- LISTE DES TITRES SUR ECRAN MOYEN ET PLUS -->
                <select class="p-1 col-12 d-none d-md-block" name="testselect" id="testselect" size=15>
                       
                    <?php foreach ($titres as $titre):
                        if ( ($checkparolestitres=="without" and $titre->getTexteTitre()==null) or ($checkparolestitres=="with" and $titre->getTexteTitre()!=null) or ( $checkparolestitres=="all" ))
                        {
                            $i++;
                    ?>
                            <option class="lignetitre" name="<?= $titre->getNoTitre(); ?>" <?php if($i==1) { echo "selected"; } ?>><?= $titre->getNomTitre() ?></option>
                    <?php
                            if($i==1) { $_SESSION['notitre'] = $titre->getNoTitre();}
                        } 
                        endforeach; 
                    ?>
                </select>
            </div>

        <strong>total: <?php echo $i; ?></strong>
    </div>