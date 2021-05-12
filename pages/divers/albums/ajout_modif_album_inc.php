<?php
//
//michemuche62
//made in rock'n'roll
//**************************************************************************************************
//***** page de traitement php d'ajout et  de modification d'un album
//***** Traitement des jaquettes, des données album, des titres
//*****
//***** PARTIE 1: Récupération des éléments nécessaire au traitement de la page.
//***** Controle de la validité des éléments. Si erreur, message de retour
//***** 
//***** PARTIE 2: Traitement des jaquettes. En cas d'erreur le traitement s'arrête et un message d'erreur
//***** est généré.
//*****
//***** PARTIE 3: AJOUT/MODIFICATION DE L'ALBUM A LA BASE DE DONNEES
//***** RETOUR : 
//*****         1 - Si le nom de l'album ou l'annee est vide le code retour un message d'erreur (echo(message d'erreur)) -> FIN
//*****         2 - Si l'album existe déjà le code retourne un message d'erreur (echo(message d'erreur)) -> FIN
//*****         3 - ajout de l'album (sauf erreur de connexion bdd) =>Retourne un message de confirmation d'ajout : echo

//******
//**  PARTIE 1 - TRAITEMENT DES JAQUETTES AVANT ET ARRIERE SI AJOUT OU MODIF
//*****
require_once '../fonctions/fonctions.php'; //fonction de sécurité des saisies
require_once '../login/login.php'; //parametres de connexion et connexion à la bdd

require_once '../classes/Album.class.php';
require_once '../classes/AlbumsManager.class.php';
require_once '../classes/Titre.class.php';
require_once '../classes/TitresManager.class.php';
require_once '../classes/LiaisonAlbumsTitres.class.php';
require_once '../classes/LiaisonAlbumsTitresManager.class.php';

//variables
$erreurjaquette = false;
$erreuralbum = false;
$anciennomAlbum = "undefined";

//connexion à la base de donnees
$bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
//variable $erreur: false si tout les champs sont valides (par défaut)
$erreur = false;

//=== SECURISATION DES CHAMPS
if (isset($_POST['noAlbum']))
    {
        $noAlbum = $_POST['noAlbum'];
        //récupération de l'ancien libellé de l'album
        //instanciation de l'album
        $album = new Album(['noalbum' => $noAlbum]);
        $manager = new AlbumsManager($bdd);
        $manager-> findNoAlbum($album);
        $libelleancientypeAlbum = $manager->libelletypeAlbum($album);
        $anciennomAlbum = $album->getNomAlbum();
    }

$nomAlbum = trim(sanitizeString($_POST['nomAlbum']));
$datesortieAlbum = trim(sanitizeString($_POST['datesortieAlbum']));
$typeAlbum = $_POST['typeAlbum'];
$formatAlbum = $_POST['formatAlbum'];
$producteurAlbum = trim(sanitizeString($_POST['producteurAlbum']));
$referenceAlbum = trim(sanitizeString($_POST['referenceAlbum']));
$labelAlbum = trim(sanitizeString($_POST['labelAlbum']));
$descriptionAlbum =sanitizeString($_POST['descriptionAlbum']);
$pochetteAlbum=trim(sanitizeString($_POST['pochetteAlbum']));
$certificationsAlbum=trim(sanitizeString($_POST['certificationsAlbum']));
$musiciensAlbum=sanitizeString($_POST['musiciensAlbum']);
$enregistrementAlbum=sanitizeString($_POST['enregistrementAlbum']);

if ($_POST['noutil']!="")
    {$noutil = $_POST['noutil'];}
else{$noutil = "1";}
$titres = trim(sanitizeString($_POST['titres']));
$dureetitres = trim(sanitizeString($_POST['dureetitres']));

//=== RECUPERATION DU LIBELLE ALBUM
//instanciation de l'album
$album = new Album(['typeAlbum' => $typeAlbum]);
$manager = new AlbumsManager($bdd);
$libelletypeAlbum = $manager->libelletypeAlbum($album);

//=== VERIFICATION DES CHAMPS

if (empty($nomAlbum)) {$erreur=true;echo("vous n'avez pas saisi de nom d'album.<br/>"); }
if(testDate($datesortieAlbum)) //la date est correcte
    {
        // jj/mm/aaaa en yyyy/mm/dd
        $datesortieAlbum = dateconv($datesortieAlbum);
    }
else //la date n'est pas au bon format
    {
        $erreur=true;echo("Le format de la date de sortie n'est pas valable");
    }           
if ($erreur==false) //les critères sur les champs sont respectés (pas d'erreur)
{

    if ($erreurjaquette==false) //pas d'erreur sur la jaquette on passe à la suite
    {
        //******
        //**  PARTIE 3 - AJOUT/MODIFICATION DE L'ALBUM A LA BASE DE DONNEES
        //*****
        //instanciation de l'album
        $album = new Album(['nomAlbum' => $nomAlbum]);
        $manager = new AlbumsManager($bdd);
        $reponse = $manager->existAlbum($album);

        //***** MODIFICATION D'UN ALBUM *****
        if (isset($_POST['noAlbum'])) //noalbum envoyé par Ajax lors de la soumission d'une modification
        {
            //si le nom est modifié et que l'album n'existe pas on modifie celui ci, sinon message erreur
            if ((($anciennomAlbum!=$nomAlbum) and ($reponse==false)) or ($anciennomAlbum==$nomAlbum))
            {    
                //recuperation d'ancien élément de l'album
                $album = new Album(['noalbum' => $_POST['noAlbum']]);
                $manager = new AlbumsManager($bdd);
                $manager-> findNoAlbum($album); //hydratation de la classe album
                $datesaisie = $album->getDatesaisieAlbum();
                $noutil = $album->getNoutil();
                $noAlbum = $_POST['noAlbum'];

                //instanciation de l'album
                $album = new Album(
                [
                    'noAlbum' => $noAlbum,
                    'nomAlbum' => $nomAlbum,
                    'datesortieAlbum' => dateconv($datesortieAlbum),
                    'typeAlbum' => $typeAlbum,
                    'datesaisieAlbum' => $datesaisie,
                    'noutil' => $noutil,
                    'formatAlbum' => $formatAlbum,
                    'producteurAlbum' => $producteurAlbum,
                    'referenceAlbum' => $referenceAlbum,
                    'labelAlbum' => $labelAlbum,
                    'descriptionAlbum' => $descriptionAlbum,
                    'pochetteAlbum' => $pochetteAlbum,
                    'certificationsAlbum' => $certificationsAlbum,
                    'musiciensAlbum' => $musiciensAlbum,
                    'enregistrementAlbum' => $enregistrementAlbum
                ]);
                $manager->update($album);
                
                //effacement de l'album et des titres associés dans la table de liaison
                $manager = new LiaisonAlbumsTitresManager($bdd);
                $album = new Album(['noalbum' => $noAlbum]);
                $manager->delete($album);
            }
            else //erreur: modification d'un album qui existe déjà
            {
                $erreuralbum=true;
                $messageErreur ="<strong>Album non ajouté :</strong> L'album <span id='retourNomAlbum'>'" . $nomAlbum . "(" . $noAlbum . ")
                '</span> existe déjà<br/>";
            }
        } 
        //***** AJOUT D'UN ALBUM *****
        else 
        {      
            //est ce que cet album existe déjà ?
            if($reponse==false) // l'album n'existe pas
            {
                $datedujour=date("Y-m-d");
                //instanciation de l'album
                $album = new Album(
                [
                'nomAlbum' => $nomAlbum,
                'datesortieAlbum' => $datesortieAlbum,
                'typeAlbum' => $typeAlbum,
                'noutil' => $noutil,
                'datesaisieAlbum' => $datedujour,
                'formatAlbum' => $formatAlbum,
                'producteurAlbum' => $producteurAlbum,
                'referenceAlbum' => $referenceAlbum,
                'labelAlbum' => $labelAlbum,
                'descriptionAlbum' => $descriptionAlbum,
                'pochetteAlbum' => $pochetteAlbum,
                'certificationsAlbum' => $certificationsAlbum,
                'musiciensAlbum' => $musiciensAlbum,
                'enregistrementAlbum' => $enregistrementAlbum
                ]);

                $manager = new AlbumsManager($bdd);
                $noAlbum = $manager->add($album); //ajout de l'album et récupération du no créé par sql
                $libelletypeAlbum = $manager->libelletypeAlbum($album);

            }
            else // l'album existe dèjà
            {
                $erreuralbum=true;
                $messageErreur ="<strong>Album non ajouté :</strong> L'album <span id='retourNomAlbum'>'" . $nomAlbum . "'</span> existe déjà";
            }
        }


            //******
            //**  PARTIE 4 - ENREGISTREMENT DES TITRES DANS LA BDD
            //*****
            //doit-on enregistrer les titres mon ami ?
            if($erreuralbum == false)
            {
                if ($titres!="" AND $dureetitres!="")
                {
                    $i=0;
                    $tabtitres = explode ('/', $titres); //titres="tab1/titre1/titre2/tab2/titre1/titre2/titre3/tab3/etc...
                    $tabdureetitres = explode  ('/', $dureetitres); //durees="tab1/duree1/duree2/tab2/duree1/duree2/duree3/tab3/etc...
                        
                    foreach($tabtitres as $titre)
                    {
                        if (substr($titre,0,3)!="tab") //permet la séparation des disques: 
                        {
                            //*******
                            //**** AJOUT DANS LA TABLE titres
                            //*******
                                $compteurpiste++;

                                //instanciation du titre
                                $titre_saisi = new Titre(['nomTitre' => $titre ]);
                                $manager = new TitresManager($bdd);
                                $reponse = $manager->existTitre($titre_saisi);

                                if ($reponse==false) //l'album n'existe pas on peut ajouter l'album à la bdd
                                { //le titre n'existe pas on peut ajouter l'album à la bdd
                                
                                    $manager = new TitresManager($bdd);
                                    $noTitre = $manager->add($titre_saisi);
                                }
                                else //le titre existe déjà
                                {
                                    $manager = new TitresManager($bdd);
                                    $noTitre = $manager->findNotitre($titre_saisi);
                                }

                            //*******
                            //**** AJOUT DANS LA TABLE liaisonalbumstitres
                            //*******
                                $liaisonalbumstitres = new LiaisonAlbumsTitres([
                                    'noAlbum'=> $noAlbum,
                                    'noTitre'=> $noTitre,
                                    'dureeTitre'=> $tabdureetitres[$i],
                                    'noPiste'=> $compteurpiste,
                                    'noDisque'=> $noDisque,
                                ]);
                                //ajout à la base de données
                                $manager = new LiaisonAlbumsTitresManager($bdd);
                                $manager->add($liaisonalbumstitres);
                                    
                                $i++;
                        }
                        else 
                        {
                            $noDisque = substr($titre,3);
                            $compteurpiste = 0;
                            $i++;
                        }
                    }
                }

                //******
                //**  PARTIE 2 - TRAITEMENT DES JAQUETTES AVANT ET ARRIERE SI AJOUT OU MODIF
                //*****
                //***** TRAITEMENT DE LA JAQUETTE AVANT SI AJOUT OU MODIFICATION D'UN ALBUM
                if (isset($_FILES['fileJaquetteAvant']['error'])) 
                {
                    switch($_FILES['fileJaquetteAvant']['error'])
                    {
                        case 0: //aucune erreur
                                //
                                //chemin de la jaquette
                                //$dossier = getcwd(); //chemin de l'application
                                $dossier = "../images/" . $libelletypeAlbum . "/";
                                $fichier = skip_accents(html_entity_decode($nomAlbum)) . "-avant.jpg";
                                $fichier = nettoyerChaine($fichier);
                                $chemin = $dossier . $fichier;

                                // effacement de la jaquette si elle existe déjà
                                if (file_exists($chemin)) {unlink($chemin);}

                                //taille du fichier <1Mo
                                $taille = filesize($_FILES['fileJaquetteAvant']['tmp_name']);
                                $taille_maxi = 1024000; //1Mo

                                //***** MODIFICATION *****
                                if($anciennomAlbum !="undefined") //s'il s'agit d'une modification
                                {
                                    if($anciennomAlbum==$nomAlbum) //le nom de l'album n'est pas modifié
                                    {
                                        if ($libelleancientypeAlbum!=$libelletypeAlbum)
                                        {
                                            //en cas de modification du type de l'album, il faut supprimer la jaquette contenue
                                            //dans le dossier de l'ancien type
                                            //chemin de la jaquette à supprimer:
                                            $anciendossier = '../images/' . $libelleancientypeAlbum . "/";
                                            $ancienfichier = skip_accents(html_entity_decode($nomAlbum)) . "-avant.jpg";
                                            $ancienfichier = nettoyerChaine($ancienfichier);
                                            $ancienchemin = $anciendossier . $ancienfichier;

                                            if(file_exists($ancienchemin))
                                            {unlink($ancienchemin);}
                                            
                                        }
                                    }
                                    else //le nom de l'album a été modifié
                                    {
                                        if ($libelleancientypeAlbum!=$libelletypeAlbum)
                                        {
                                            //ici le nom de l'album a été modifié ainsi que le type d'album
                                            //on supprime les jaquettes avec l'ancien nom
                                            //chemin de la jaquette à supprimer:
                                            $anciendossier = '../images/' . $libelleancientypeAlbum . "/";
                                            $ancienfichier = skip_accents(html_entity_decode($anciennomAlbum)) . "-avant.jpg";
                                            $ancienfichier = nettoyerChaine($ancienfichier);
                                            $ancienchemin = $anciendossier . $ancienfichier;
                                            if(file_exists($ancienchemin))
                                            {unlink($ancienchemin);} //suppression de la jaquette
                                        }
                                        else
                                        {
                                            //ici le nom de l'album a été modifié mais pas le type d'album
                                            //on supprime les jaquettes avec l'ancien nom
                                            //chemin de la jaquette à supprimer:
                                            $anciendossier = '../images/' . $typeAlbum . "/";
                                            $ancienfichier = skip_accents(html_entity_decode($anciennomAlbum)) . "-avant.jpg";
                                            $ancienfichier = nettoyerChaine($ancienfichier);
                                            $ancienchemin = $anciendossier . $ancienfichier;

                                            if(file_exists($ancienchemin))
                                            {unlink($ancienchemin);} //suppression de la jaquette
                                        }
                                    }
                                }

                                //***** ENREGISTREMENT DE LA JAQUETTE *****
                                //seuls les fichiers de type jpg,jpeg,png sont acceptés et une taille de 1Mo maxi
                                if( ($_FILES['fileJaquetteAvant']['type']=="image/jpeg") and ($taille <= $taille_maxi) ) 
                                {
                                    //upload du fichier
                                    if(move_uploaded_file($_FILES['fileJaquetteAvant']['tmp_name'], $chemin))
                                    {
                                        /*** SUCCES UPLOAD JAQUETTE AVANT **/
                                    }
                                    else 
                                    { 
                                        $erreurjaquette = true;
                                        $messageErreur = "problème lors du téléchargement de la jaquette avant.<br/>";
                                    }
                                }
                                else
                                {
                                    $erreurjaquette = true;
                                    $messageErreur = "Problème sur le type du fichier de la jaquette avant";
                                    $messageErreur.= " (uniquement jpg, jpeg)<br/> ou problème sur la taille du fichier (doit être <1Mo)<br/>";
                                }
                        break;

                        case 1: //taille du fichier trop grande
                        $erreurjaquette = true;
                        $messageErreur = "Taille de la jaquette avant trop importante (<1Mo)<br/>";    
                        break;

                        case 3: //fichier partiellement téléchargé
                        $erreurjaquette = true;
                        $messageErreur="Erreur de téléchargement de la Jaquette Avant.<br/>";
                        break;

                        case 4: //aucun fichier téléchargé

                        //***** AJOUT *****
                        // pas de message d'erreur, jaquette par défaut dans cette situation

                        //***** MODIFICATION *****
                        //CAS DE LA MODIFICATION SANS CHANGEMENT JAQUETTE
                        if (isset($_POST['noAlbum'])) //si s'agit d'une modification album
                        {
                            if($anciennomAlbum==$nomAlbum) //le nom de l'album n'est pas modifié
                            {
                                if ($libelleancientypeAlbum!=$libelletypeAlbum)
                                {
                                        //ici le nom de l'album n'est pas modifié, le type de l'album est modifié
                                        //déplacement du fichier de la jaquette, du dossier de l'ancien type vers le nouveau type
                                        //chemin origine de la jaquette à supprimer:
                                        $anciendossier = '../images/' . $libelleancientypeAlbum . "/";
                                        $ancienfichier = skip_accents(html_entity_decode($nomAlbum)) . "-avant.jpg";
                                        $ancienfichier = nettoyerChaine($ancienfichier);
                                        $ancienchemin = $anciendossier . $ancienfichier;
                                        //chemin de destination
                                        $destdossier = '../images/' . $libelletypeAlbum . "/";
                                        $nouveaufichier = skip_accents(html_entity_decode($nomAlbum)) . "-avant.jpg";
                                        $nouveaufichier = nettoyerChaine($nouveaufichier);
                                        $destchemin = $destdossier . $nouveaufichier;
                                        
                                        //si le dossier de destination n'existe pas, on le crée biensur :-)
                                        if(!file_exists($destdossier))
                                        {
                                            mkdir($destdossier);
                                        }

                                        if(file_exists($ancienchemin))
                                        {
                                            //déplacement du fichier
                                            copy ($ancienchemin, $destchemin);
                                            //suppression du fichier origine
                                            unlink($ancienchemin);
                                        }
                                        
                                }
                            }
                            else //le nom d'album a été modifié
                            {
                                if ($libelleancientypeAlbum!=$libelletypeAlbum)
                                {
                                        //ici le nom de l'album est modifié ainsi que le type de l'album
                                        //on renomme le fichier puis on déplace le fichier dans le dossier du nouveau type
                                //*** RENOMMAGE ***
                                    //** chemin de la jaquette avec le nouveau nom d'album
                                    $dossier = '../images/' . $libelleancientypeAlbum . "/";
                                    $fichier = skip_accents(html_entity_decode($nomAlbum)) . "-avant.jpg";
                                    $fichier = nettoyerChaine($fichier);
                                    $chemin = $dossier . $fichier;
                                    //chemin de la jaquette avec l'ancien nom
                                    $ancienfichier = skip_accents(html_entity_decode($anciennomAlbum)) . "-avant.jpg";
                                    $ancienfichier = nettoyerChaine($ancienfichier);
                                    $ancienchemin = $dossier . $ancienfichier;
                                    //renommage du fichier jaquette par le nouveau nom
                                    rename ($ancienchemin, $chemin);
                                //*** DEPLACEMENT ***
                                    //chemin de destination
                                    $destdossier = '../images/' . $libelletypeAlbum . "/";
                                    $nouveaufichier = skip_accents(html_entity_decode($nomAlbum)) . "-avant.jpg";
                                    $nouveaufichier = nettoyerChaine($nouveaufichier);
                                    $destchemin = $destdossier . $nouveaufichier;

                                    //si le dossier de destination n'existe pas, on le crée biensur :-)
                                        if(!file_exists($destdossier))
                                        {
                                            mkdir($destdossier);
                                        }

                                    if(file_exists($chemin))
                                    {
                                        //déplacement du fichier
                                        copy ($chemin, $destchemin);
                                        //suppression du fichier origine
                                        unlink($chemin);
                                    }
                                }
                                else
                                {
                                    //ici le nom de l'album est modifié mais pas le type
                                    //on renomme simplement le nom du fichier de la jaquette

                                    //chemin du nouveau fichier
                                    $dossier = '../images/' . $libelletypeAlbum . "/";
                                    $fichier = skip_accents(html_entity_decode($nomAlbum)) . "-avant.jpg";
                                    $fichier = nettoyerChaine($fichier);
                                    $chemin = $dossier . $fichier;
                                    //chemin de l'ancien fichier
                                    $ancienfichier = skip_accents(html_entity_decode($anciennomAlbum)) . "-avant.jpg";
                                    $ancienfichier = nettoyerChaine($ancienfichier);
                                    $ancienchemin = $dossier . $ancienfichier;
                                    //remplacement de l'ancien par le nouveau
                                    rename ($ancienchemin, $chemin);
                                }
                            }
                        }
                        break;
                    }
                }
                //***** TRAITEMENT DE LA JAQUETTE ARRIERE SI AJOUT OU MODIFICATION D'UN ALBUM
                if (isset($_FILES['fileJaquetteArriere']['error'])) 
                {
                    switch($_FILES['fileJaquetteArriere']['error'])
                    {
                        case 0: //aucune erreur
                                //
                                //chemin de la jaquette
                                //$dossier = getcwd(); //chemin de l'application
                                $dossier = "../images/" . $libelletypeAlbum . "/";
                                $fichier = skip_accents(html_entity_decode($nomAlbum)) . "-arriere.jpg";
                                $fichier = nettoyerChaine($fichier);
                                $chemin = $dossier . $fichier;

                                // effacement de la jaquette si elle existe déjà
                                if (file_exists($chemin)) {unlink($chemin);}

                                //taille du fichier <1Mo
                                $taille = filesize($_FILES['fileJaquetteArriere']['tmp_name']);
                                $taille_maxi = 1024000; //1Mo

                                //***** MODIFICATION *****
                                if($anciennomAlbum !="undefined") //s'il s'agit d'une modification
                                {
                                    if($anciennomAlbum==$nomAlbum) //le nom de l'album n'est pas modifié
                                    {
                                        if ($libelleancientypeAlbum!=$libelletypeAlbum)
                                        {
                                            //en cas de modification du type de l'album, il faut supprimer la jaquette contenue
                                            //dans le dossier de l'ancien type
                                            //chemin de la jaquette à supprimer:
                                            $anciendossier = '../images/' . $libelleancientypeAlbum . "/";
                                            $ancienfichier = skip_accents(html_entity_decode($nomAlbum)) . "-arriere.jpg";
                                            $ancienfichier = nettoyerChaine($ancienfichier);
                                            $ancienchemin = $anciendossier . $ancienfichier;

                                            if(file_exists($ancienchemin))
                                            {unlink($ancienchemin);}
                                        }
                                    }
                                    else //le nom de l'album a été modifié
                                    {
                                        if ($libelleancientypeAlbum!=$libelletypeAlbum)
                                        {
                                            //ici le nom de l'album a été modifié ainsi que le type d'album
                                            //on supprime les jaquettes avec l'ancien nom
                                            //chemin de la jaquette à supprimer:
                                            $anciendossier = '../images/' . $libelleancientypeAlbum . "/";
                                            $ancienfichier = skip_accents(html_entity_decode($anciennomAlbum)) . "-arriere.jpg";
                                            $ancienfichier = nettoyerChaine($ancienfichier);
                                            $ancienchemin = $anciendossier . $ancienfichier;

                                            if(file_exists($ancienchemin))
                                            {unlink($ancienchemin);} //suppression de la jaquette
                                        }
                                        else
                                        {
                                            //ici le nom de l'album a été modifié mais pas le type d'album
                                            //on supprime les jaquettes avec l'ancien nom
                                            //chemin de la jaquette à supprimer:
                                            $anciendossier = '../images/' . $typeAlbum . "/";
                                            $ancienfichier = skip_accents(html_entity_decode($anciennomAlbum)) . "-arriere.jpg";
                                            $ancienfichier = nettoyerChaine($ancienfichier);
                                            $ancienchemin = $anciendossier . $ancienfichier;

                                            if(file_exists($ancienchemin))
                                            {unlink($ancienchemin);} //suppression de la jaquette
                                        }
                                    }
                                }

                                //***** ENREGISTREMENT DE LA JAQUETTE *****
                                //seuls les fichiers de type jpg,jpeg,png sont acceptés et une taille de 1Mo maxi
                                if( ($_FILES['fileJaquetteArriere']['type']=="image/jpeg") and ($taille <= $taille_maxi) ) 
                                {
                                    //upload du fichier
                                    if(move_uploaded_file($_FILES['fileJaquetteArriere']['tmp_name'], $chemin))
                                    {
                                        /*** SUCCES UPLOAD JAQUETTE AVANT **/
                                    }
                                    else 
                                    { 
                                        $erreurjaquette = true;
                                        $messageErreur = "problème lors du téléchargement de la jaquette arriere.<br/>";
                                    }
                                }
                                else
                                {
                                    $erreurjaquette = true;
                                    $messageErreur = "Problème sur le type du fichier arriere";
                                    $messageErreur.= " (uniquement jpg, jpeg)<br/> ou problème sur la taille du fichier (doit être <1Mo)<br/>";
                                }
                        break;

                        case 1: //taille du fichier trop grande
                        $erreurjaquette = true;
                        $messageErreur = "Taille de la jaquette arriere trop importante (<1Mo)<br/>";    
                        break;

                        case 3: //fichier partiellement téléchargé
                        $erreurjaquette = true;
                        $messageErreur="Erreur de téléchargement de la Jaquette arriere.<br/>";
                        break;

                        case 4: //aucun fichier téléchargé

                        //***** AJOUT *****
                        // pas de message d'erreur, jaquette par défaut dans cette situation

                        //***** MODIFICATION *****
                        //CAS DE LA MODIFICATION SANS CHANGEMENT JAQUETTE
                        if (isset($_POST['noAlbum'])) //si s'agit d'une modification album
                        {
                            if($anciennomAlbum==$nomAlbum) //le nom de l'album n'est pas modifié
                            {
                                if ($libelleancientypeAlbum!=$libelletypeAlbum)
                                {
                                        //ici le nom de l'album n'est pas modifié, le type de l'album est modifié
                                        //déplacement du fichier de la jaquette, du dossier de l'ancien type vers le nouveau type
                                        //chemin origine de la jaquette à supprimer:
                                        $anciendossier = '../images/' . $libelleancientypeAlbum . "/";
                                        $ancienfichier = skip_accents(html_entity_decode($nomAlbum)) . "-arriere.jpg";
                                        $ancienfichier = nettoyerChaine($ancienfichier);
                                        $ancienchemin = $anciendossier . $ancienfichier;
                                        //chemin de destination
                                        $destdossier = '../images/' . $libelletypeAlbum . "/";
                                        $nouveaufichier = skip_accents(html_entity_decode($nomAlbum)) . "-arriere.jpg";
                                        $nouveaufichier = nettoyerChaine($nouveaufichier);
                                        $destchemin = $destdossier . $nouveaufichier;

                                        //si le dossier de destination n'existe pas, on le crée biensur :-)
                                        if(!file_exists($destdossier))
                                        {
                                            mkdir($destdossier);
                                        }

                                        if(file_exists($ancienchemin))
                                        {
                                            //déplacement du fichier
                                            copy ($ancienchemin, $destchemin);
                                            //suppression du fichier origine
                                            unlink($ancienchemin);
                                        }
                                }
                            }
                            else //le nom d'album a été modifié
                            {
                                if ($libelleancientypeAlbum!=$libelletypeAlbum)
                                {
                                        //ici le nom de l'album est modifié ainsi que le type de l'album
                                        //on renomme le fichier puis on déplace le fichier dans le dossier du nouveau type
                                //*** RENOMMAGE ***
                                    //** chemin de la jaquette avec le nouveau nom d'album
                                    $dossier = '../images/' . $libelleancientypeAlbum . "/";
                                    $fichier = skip_accents(html_entity_decode($nomAlbum)) . "-arriere.jpg";
                                    $fichier = nettoyerChaine($fichier);
                                    $chemin = $dossier . $fichier;
                                    //chemin de la jaquette avec l'ancien nom
                                    $ancienfichier = skip_accents(html_entity_decode($anciennomAlbum)) . "-arriere.jpg";
                                    $ancienfichier = nettoyerChaine($ancienfichier);
                                    $ancienchemin = $dossier . $ancienfichier;
                                    //renommage du fichier jaquette par le nouveau nom
                                    rename ($ancienchemin, $chemin);
                                //*** DEPLACEMENT ***
                                    //chemin de destination
                                    $destdossier = '../images/' . $libelletypeAlbum . "/";
                                    $nouveaufichier = skip_accents(html_entity_decode($nomAlbum)) . "-arriere.jpg";
                                    $nouveaufichier = nettoyerChaine($nouveaufichier);
                                    $destchemin = $destdossier . $nouveaufichier;

                                    //si le dossier de destination n'existe pas, on le crée biensur :-)
                                        if(!file_exists($destdossier))
                                        {
                                            mkdir($destdossier);
                                        }

                                    if(file_exists($chemin))
                                    {
                                        //déplacement du fichier
                                        copy ($chemin, $destchemin);
                                        //suppression du fichier origine
                                        unlink($chemin);
                                    }
                                }
                                else
                                {
                                    //ici le nom de l'album est modifié mais pas le type
                                    //on renomme simplement le nom du fichier de la jaquette

                                    //chemin du nouveau fichier
                                    $dossier = '../images/' . $libelletypeAlbum . "/";
                                    $fichier = skip_accents(html_entity_decode($nomAlbum)) . "-arriere.jpg";
                                    $fichier = nettoyerChaine($fichier);
                                    $chemin = $dossier . $fichier;
                                    //chemin de l'ancien fichier
                                    $ancienfichier = skip_accents(html_entity_decode($anciennomAlbum)) . "-arriere.jpg";
                                    $ancienfichier = nettoyerChaine($ancienfichier);
                                    $ancienchemin = $dossier . $ancienfichier;
                                    //remplacement de l'ancien par le nouveau
                                    rename ($ancienchemin, $chemin);
                                }
                            }
                        }
                        break;
                    }
                }
                echo ("success: " . $noAlbum); //retour vers ajax
            }
            else
            {
                echo $messageErreur;
            }
    }
    else
    {
        echo $messageErreur;
    }

}
else
{
    echo ("<strong>L'album n'a pas été ajouté.</strong><br/>");
}
?>