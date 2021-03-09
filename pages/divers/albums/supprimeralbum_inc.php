<?php
//
//michemuche62
//made in rock'n'roll
//autochargement des classes

if (isset($_POST['noAlbum']))
{
    require_once '../login/login.php'; //parametres de connexion et connexion à la bdd
    require_once '../classes/Album.class.php';
    require_once '../classes/AlbumsManager.class.php'; 
    require_once '../fonctions/fonctions.php'; //fonction de sécurité des saisies
    //connexion à la base de donnees
    $bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));     
            
    $noAlbum = $_POST['noAlbum'];
    echo ("no album: " . $noAlbum);
    
    $album = new Album(['noAlbum' => $noAlbum]);
    $manager = new AlbumsManager($bdd);
    $manager-> findNoAlbum($album);                    
    
    $libelletypeAlbum = $manager->libelletypeAlbum($album);
    $nomAlbum = $album->getNomAlbum();
                
    //chemin de la jaquette avant
    $dossier = "../images/" . $libelletypeAlbum . "/";
    $fichier = skip_accents(html_entity_decode($nomAlbum)) . "-avant.jpg";
    $chemin = $dossier . $fichier;
    //suppression de la jaquette avant
    if (file_exists($chemin)){unlink($chemin);}
                
    //chemin de la jaquette arriere
    $fichier = skip_accents(html_entity_decode($nomAlbum)) . "-arriere.jpg";
    $chemin = $dossier . $fichier;
    //suppression de la jaquette arriere
    if (file_exists($chemin)){unlink($chemin);}

    //suppression de l'album
    $manager->delete($album);
                                    
    echo "<strong>Album supprimé</strong>";
}
else
{
    echo ("probleme de suppression");
}
?>