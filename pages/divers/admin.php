<!-- JOHNNY HALLYDAY -->
<!-- michemuche62 -->
<?php

    
    require_once 'pages/divers/login/login.php'; //parametres de connexion et connexion à la bdd
    require_once 'pages/divers/fonctions/fonctions.php'; //fonction de sécurité des saisies

    require_once 'pages/divers/classes/Album.class.php';
    require_once 'pages/divers/classes/AlbumsManager.class.php';
    require_once 'pages/divers/classes/Utilisateur.class.php';
    require_once 'pages/divers/classes/UtilisateursManager.class.php';
    require_once 'pages/divers/classes/Titre.class.php';
    require_once 'pages/divers/classes/TitresManager.class.php';
    require_once 'pages/divers/classes/LiaisonAlbumsTitres.class.php';
    require_once 'pages/divers/classes/LiaisonAlbumsTitresManager.class.php';
    require_once 'pages/divers/classes/TypesAlbum.class.php';
    require_once 'pages/divers/classes/TypesAlbumManager.class.php';

if(isset($_SESSION['modifierparolestitre'])) { $droits_modifierparolestitre = $_SESSION['modifierparolestitre'];}
else { $droits_modifierparolestitre = 0; }

$bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
 
//choix de l'onglet
if (isset($_GET['onglet'])) { $onglet = $_GET['onglet'];}
else { $onglet = 'Albums'; }
//var listetitres=array(); //contient le nom de l'ensemble des titres
//acces autorisé si connecté
    if (isset($_SESSION['pseudo']))
    //if (isset($_SESSION['pseudo']) || isset($_POST['pseudo'])) //retour d'Ajax (menu.js) - TRAITEMENT DES ELEMENTS SAISIS
        {
        ?>
            <div id="page_membre" class="container-fluid">

                <!-- Onglets -->
                <nav class="nav nav-pills">
                  <a class="nav-item nav-link <?php if($onglet=="Albums"){ echo 'active'; } ?> col text-center" href="#albums" data-toggle="tab">Albums</a>
                  <a class="nav-item nav-link <?php if($onglet=="Titres"){ echo 'active'; } ?> col text-center" href="#titres" data-toggle="tab">Titres</a>
                  <a class="nav-item nav-link <?php if($onglet=="Singles"){ echo 'active'; } ?> col text-center" href="#singles" data-toggle="tab">Singles</a>
                </nav>

                <!-- Actions des onglets bootstrap -->
                <div class="tab-content row">

                    <!-------------->
                    <!-- PANNEAU 1 -->
                    <!-------------->
                        <div class="row tab-pane fade <?php if($onglet=="Albums"){ echo 'show active'; } ?> " id="albums">
                            <div class="container mt-2">
                                <div class="row">
                                    <section id="section_gauche" class="col-6">
                                        <!-- ** LISTE DES ALBUMS -->
                                        <?php include ('albums/listealbums_inc.php');?>
                                    </section> <!-- section_gauche -->
                          
                                    <section id="section_centrale" class="col-6">
                                        <div id="boutons_fiche_album" class="text-right">
                                        </div> <!-- #boutons_fiche_album -->
                        
                                    </section> <!-- section_centrale -->
                                </div>
                            </div>
                        </div>

                    <!-------------->
                    <!-- PANNEAU 2 -->
                    <!-------------->
                            <div class="row tab-pane fade <?php if($onglet=="Titres"){ echo 'show active'; } ?> " id="titres">
                                <div class="container">
                                    <div class="row">
                                        <?php
                                        //état du checkbox
                                        if (isset($_POST['checkParolesTitres'])) { $checkparolestitres = $_POST['checkParolesTitres']; }
                                            else { $checkparolestitres =0;}
                                        //barre de filtres
                                        if($droits_modifierparolestitre==1): ?>
                                            <div id="filtre_liste_titres" class="col-lg12">
                                                <form id="formfiltres" method="post" action="index.php?acces_membre&onglet=Titres">
                                                    <label for="checkParolesTitres"> Afficher titres sans paroles</label>
                                                    <input id="checkParolesTitres" type="checkbox" name="checkParolesTitres" <?php if($checkparolestitres==true) { echo "checked ";} ?> > 

                                                </form>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="row justify-content-center">
                                        <section id="section_gauche_titres" class="col-4">
                                            <!-- ** LISTE DES TITRES -->
                                            <?php include ('albums/listetitres_inc.php');?>
                                        </section> <!-- section_gauche -->
                                
                                        <section id="section_centrale_titres" class="col-8">
                                            <?php require ('albums/fichetitre_inc.php'); ?>
                                        </section> <!-- section_centrale -->
                                    </div>
                                </div>
                            </div>

                    <!-------------->
                    <!-- PANNEAU 3 -->
                    <!-------------->

                            <div class="row tab-pane fade <?php if($onglet=="Singles"){ echo 'show active'; } ?> " id="singles">
                                <div class="container-fluid">
                                    <div class="row">
                                        <h2 class="col-lg-12 text-center" style="background-color: grey; color:white;">En cours de programmation</h2>
                                    </div>
                                </div>
                            </div>

                </div>

                </div>

                <div id="gestion_album" class="row">
                    <!--cadre destiné à l'ajout ou suppression -->
                </div>
        <?php
        }
    else
        //acces direct à la page admin non autorisé
    	{
    		echo ('<p class="jumbotron text-center">Vous n\'êtes pas autorisé à cette page</p>');
    	}
?>

