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

$bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    
//var listetitres=array(); //contient le nom de l'ensemble des titres
//acces autorisé si connecté
    if (isset($_SESSION['pseudo']))
    //if (isset($_SESSION['pseudo']) || isset($_POST['pseudo'])) //retour d'Ajax (menu.js) - TRAITEMENT DES ELEMENTS SAISIS
        {
        ?>
            <div id="page_membre" class="container-fluid">

                <!-- Onglets -->
                <ul id="barre_onglets" class="nav nav-pills nav-justified">
                    <li class="active"><a href="#albums" data-toggle="tab">Albums</a></li>
                    <li><a href="#titres" data-toggle="tab">Titres</a></li>
                    <li><a href="#singles" data-toggle="tab">Singles</a></li>
                </ul>

                <!-- Actions des onglets bootstrap -->
                <div class="tab-content">

                    <!-------------->
                    <!-- PANNEAU 1 -->
                    <!-------------->
                        <div class="tab-pane active" id="albums">
                            <section id="section_gauche" class="col-xs-5">
                                <!-- ** LISTE DES ALBUMS -->
                                <?php include ('albums/listealbums_inc.php');?>
                            </section> <!-- section_gauche -->
                      
                            <section id="section_centrale" class="col-xs-7">
                                <div id="boutons_fiche_album" class="text-right">
                                </div> <!-- #boutons_fiche_album -->
                
                            </section> <!-- section_centrale -->
                        </div>

                    <!-------------->
                    <!-- PANNEAU 2 -->
                    <!-------------->
                            <div class="tab-pane" id="titres">
                                <section id="section_gauche_titres" class="col-sm-4">
                                    <!-- ** LISTE DES TITRES -->
                                    <?php include ('albums/listetitres_inc.php');?>
                                </section> <!-- section_gauche -->
                      
                                <section id="section_centrale_titres" class="col-sm-8">
                                    <?php require ('albums/fichetitre_inc.php'); ?>
                                </section> <!-- section_centrale -->
                            </div>

                    <!-------------->
                    <!-- PANNEAU 3 -->
                    <!-------------->

                            <div class="tab-pane" id="singles">
                                <div class="container-fluid">
                                    <div class="row">
                                        <h2 class="col-lg-12 text-center" style="background-color: grey; color:white;">En cours de programmation</h2>
                                    </div>
                                </div>
                            </div>

                </div>

                </div>

                <div id="gestion_album">
                    <!--cadre destiné à l'ajout ou suppression -->
                </div>
        <?php
        dd($_SESSION);
        }
    else
        //acces direct à la page admin non autorisé
    	{
    		echo ('<p class="jumbotron text-center">Vous n\'êtes pas autorisé à cette page</p>');
    	}
?>

