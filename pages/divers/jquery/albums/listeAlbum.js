//
//JOHNNY HALLYDAY
//  Créé par JMT
//
$(function()
{//début jQuery
//*************************************************************************************************************************
//**                                                                                                                       
//**                                          Programmeur: Michemuche62                                                             
//**
//**    Gère les différents affichage de la page membres
//**    
//**    0-INITIALISATION- 
//**        - Exécution de la fonction activer_selection (point 1)
//**
//**    1- FONCTIONS 
//**        * activer_selection(): Cette fonction est lancée au chargement
//**            Réponse aux évènements suivant:
//**                - Clic sur une ligne du tableau album ==> affiche la fiche de l'album sélectionné
//**                - Clic sur l'entête du tableau ==> Tri des éléments du tableau en fonction de l'intitulé
//**                                           ==> Sélection de la première ligne puis affichage de l'album correspondant
//**                - dblclic sur ligne ==> affichage de la fiche album
//**        * fiche_album(numero) ==> affiche la fiche de l'album passé en paramètre
//**    2- AFFICHAGE FICHE ALBUM PAR DEFAUT
//**    3- GESTION DES ELEMENTS RADIOS TYPE ALBUM
//**    4- BOUTON AJOUTER UN ALBUM (click sur + de l'entete du tableau de la liste d'albums)
//**    5- BOUTON MODIFIER UN ALBUM
//**    6- BOUTON ANNULER MODIF/AJOUT
//**    7- BOUTON SUPPRIMER UN ALBUM
//***   9- BOUTON CONFIRMER SUPPRESSION
//**
//****************************************************************************************************************************
var noAlbum;
var nombreAlbums=$('#tablelisteAlbums tr').length-1; //retrait de la ligne d'entête du tableau
var ordreAnnee = "croissant";
var ordreAlbum = "croissant";
var ordreNoALbum = "croissant";
var typeAlbum="Tous";


//*****
//*** 0- INITIALISATION
//*****

    activer_selection();
/*****                 **/
/***  1- FONCTIONS    **/
/*****               **/

    function activer_selection(numero)
    {
        //**** CLICK SUR UN LIGNE DU TABLEAU ***** (affichage de l'album)
        $('#section_gauche').on('click', '#tablelisteAlbums td', function()
        {
            //no d'album sélectionner et coloration de la ligne concernée
            noAlbum = $(this).closest('tr').find("td:first-child").text();
            console.log("noAlbum: " + noAlbum);
            $('#tablelisteAlbums tr').css('backgroundColor', 'aliceblue');
            $(this).closest('tr').css('backgroundColor', '#e4970c');
            //affichage de la fiche album 
            fiche_album(noAlbum);
        });

        //**** DOUBLE CLICK SUR UN LIGNE DU TABLEAU ***** (formulaire de modification)
        $('#section_gauche').on('dblclick', '#tablelisteAlbums td', function()
        {
            //no d'album sélectionner et coloration de la ligne concernée
            noAlbum = $(this).closest('tr').find("td:first-child").text();
            $('#tablelisteAlbums tr').css('backgroundColor', 'aliceblue');
            $(this).closest('tr').css('backgroundColor', '#e4970c');
            //affichage de la fiche album 
            fiche_album(noAlbum);
            
            //affichage du formulaire de modification
            $('#page_membre').css('display','none');
            $('#gestion_album').css('display','block');
            $('#gestion_album').load("pages/divers/albums/formmodifalbum_inc.php?noalbum="+noAlbum+"&noutilisateur="+$('#noutil').text());
        });

        //**** CLICK SUR L'ENTETE ****
        $('#section_gauche').on('click', '#tablelisteAlbums th', function()
        {
            var valeur = $(this).text();
            var noutil = $('footer #noutil').text();
            valeur = valeur.substring(0,6);
            switch(valeur)
            {
                //classement par année
                case "Année":
                    //determination de l'ordre de l'année
                    if (ordreAnnee=="croissant")
                        {ordreAnnee="decroissant"}
                    else
                        {ordreAnnee="croissant"}
                    //remis à jour de la liste d'album
                    $.ajax
                    ({
                        type: 'POST',
                        url : 'pages/divers/albums/listealbums_inc.php',
                        dataType: 'html',
                        data: {
                                ajax: "yes",
                                ordreAnnee: ordreAnnee,
                                choixtype: typeAlbum,
                                noutil: noutil,
                            },
                        success: function(data)
                        {
                            $('#section_gauche').html(data);
                        },
                        complete: function()
                        {
                            //surlignement du 1er album de la liste
                            $('#divlisteAlbums tbody tr:first').css('backgroundColor', '#e4970c');
                            //recupère le numéro d'album de la première ligne
                            noAlbum = $('#divlisteAlbums tbody tr:first').find("td:first-child").text();
                            //affichage de la fichealbum de la 1ere ligne du tableau d'album
                            $('#divlisteAlbums tbody tr:first').find("td:first-child").click();
                        }
                    });
                    break; 
                //classement par nom d'album
                case "Albums":
                    //determination de l'ordre de l'album
                    if (ordreAlbum=="croissant")
                        {ordreAlbum="decroissant"}
                    else
                        {ordreAlbum="croissant"}
                    //remis à jour de la liste d'album
                    $.ajax
                    ({
                        type: 'POST',
                        url : 'pages/divers/albums/listealbums_inc.php',
                        dataType: 'html',
                        data: {
                                ajax: "yes",
                                ordreAlbum: ordreAlbum,
                                choixtype: typeAlbum,
                                noutil: noutil,
                            },
                        success: function(data)
                        {    
                            //
                            $('#section_gauche').html(data);
                        },
                        complete: function()
                        {
                            //surlignement du 1er album de la liste
                            $('#divlisteAlbums tbody tr:first').css('backgroundColor', '#e4970c');
                            //recupère le numéro d'album de la première ligne
                            noAlbum = $('#divlisteAlbums tbody tr:first').find("td:first-child").text();
                            //affichage de la fichealbum de la 1ere ligne du tableau d'album
                            $('#divlisteAlbums tbody tr:first').find("td:first-child").click();
                        }
                    });
                    break;
                //classement par numéro d'album par défaut
                case "No":
                    if (ordreNoALbum=="croissant")
                        {ordreNoALbum="decroissant"}
                    else
                        {ordreNoALbum="croissant"}
                    //remis à jour de la liste d'album
                    $.ajax
                    ({
                        type: 'POST',
                        url : 'pages/divers/albums/listealbums_inc.php',
                        dataType: 'html',
                        data: {
                                ajax: "yes",
                                ordreNoALbum: ordreNoALbum,
                                choixtype: typeAlbum,
                                noutil: noutil,
                            },
                        success: function(data)
                        {    
                            //
                            $('#section_gauche').html(data);
                        },
                        complete: function()
                        {
                            //surlignement du 1er album de la liste
                            $('#divlisteAlbums tbody tr:first').css('backgroundColor', '#e4970c');
                            //recupère le numéro d'album de la première ligne
                            noAlbum = $('#divlisteAlbums tbody tr:first').find("td:first-child").text(); 
                            //affichage de la fichealbum de la 1ere ligne du tableau d'album
                            $('#divlisteAlbums tbody tr:first').find("td:first-child").click();
                        }
                    });
                    break;
            } 
        });
    }

    function fiche_album(numero)
    {
        $.ajax
            ({
                type: 'GET',
                url : 'pages/divers/albums/fichealbum_inc.php',
                dataType: 'html',
                data: 
                {
                    ajax: "yes",
                    noAlbum: numero,
                },
                success: function(data){
                    $('#section_centrale').html(data);
                        },
                error: function(){console.log("erreur ajax selection album dans la liste");}
            });
    }

//*****
//*** 2- AFFICHAGE FICHE ALBUM PAR DEFAUT
//*****
    //affichage de la fichealbum de la 1ere ligne du tableau d'album
    $('#divlisteAlbums tbody tr:first').find("td:first-child").click();


//*****
//*** 3- GESTION DES ELEMENTS RADIOS TYPE ALBUM
//****
    $('#section_gauche .radioType').click(function()
    {
        //nouvelle valeur du type
        typeAlbum = $(this).val();
        noutil = $('footer #noutil').text();
        console.log(noutil);
        //remis à jour de la liste d'album
        $.ajax
        ({
            type: 'POST',
            url : 'pages/divers/albums/listealbums_inc.php',
            dataType: 'html',
            data: 
                {
                    ajax: "yes",
                    choixtype: typeAlbum,
                    noutil: noutil,
                },
            success: function(data)
            {    
                //
                $('#section_gauche').html(data);
            }
        });
    });

//*****
//    4- BOUTON AJOUTER UN ALBUM (click sur + de l'entete du tableau de la liste d'albums)
//*****
    $('#section_gauche').on('click', '#bouton_ajout_album', function()
    {
        console.log("click plus");
        //affichage de la page de saisie du nouvel album
        $('#page_membre').css('display','none');
        $('#gestion_album').css('display','block');
        $('#gestion_album').load('pages/divers/albums/formajoutalbum_inc.php');
    });

//*****
//*** 5- BOUTON MODIFIER UN ALBUM
//*****

    $('#section_gauche').on('click', '#bouton_modifier_album',function()
        {
            //affichage de la page de modification du nouvel album
            $('#page_membre').css('display','none');
            $('#gestion_album').css('display','block');
            $('#gestion_album').load("pages/divers/albums/formmodifalbum_inc.php?noalbum="+noAlbum+"&noutilisateur="+$('#noutil').text());
        });

//*****
//*** 6- BOUTON ANNULER MODIF/AJOUT
//*****

    $('#gestion_album').on('click', '#bouton_annuler',function(e){
        e.preventDefault(); //neutralisation execution formulaire
        $('#gestion_album').html('');
        $('#gestion_album').css('display','none');
        $('#page_membre').css('display','block');
    });
    
//*****    
//*** 7- BOUTON SUPPRIMER UN ALBUM
//***

    $('#section_gauche').on('click', '#bouton_supprimer_album',function()
    {   
        alert("coucou");
        // passage au ROUGE
        $('.entete').css({
            backgroundColor : "#C33517",
            border : "#C33517 solid 2px"
        });
        $('#fichealbum').css('border','solid 2px #C33517');

        //
        $('#section_gauche').off('click', '#tablelisteAlbums td');
        $('#section_gauche').off('click', '#tablelisteAlbums th');
        $('#section_gauche #bouton_ajout_album').css('display','none');
        //
        $('#boutons_fiche_album').html('<button class="btn btn-danger" id="bouton_confirmer_suppression" title="Confirmer suppression">SUPPRIMER</button>');
        $('#boutons_fiche_album').append('&nbsp<button class="btn btn-danger" id="bouton_annuler_suppression" title="Annuler suppression">ANNULER</button>');
    });
     
//*****
//**  8- BOUTON ANNULER SUPPRESSION
//*****

     $('#section_centrale').on('click','#bouton_annuler_suppression',function()
     {
        //retour couleur normale
        $('.entete').css({
            backgroundColor : "#494646",
            border : "#494646 solid 1px"
        });
        $('#fichealbum').css('border','solid 1px #BBB6B6');
        //
        activer_selection();
        $('#section_gauche #bouton_ajout_album').css('display','block');
        //
        $('#boutons_fiche_album').html('<button class="btn btn-primary" id="bouton_modifier">Modifier</button>');
        $('#boutons_fiche_album').append('&nbsp<button class="btn btn-primary" id="bouton_supprimer">Supprimer</button>');
        
     });

//*****
//*** 9- BOUTON CONFIRMER SUPPRESSION
//*****

     $('#section_centrale').on('click','#bouton_confirmer_suppression',function()
     {
        
        //suppression de l'album
        $.ajax
        ({
            type: 'POST',
            url : 'pages/divers/albums/supprimeralbum_inc.php',
            dataType: 'html',
            data: 
                {
                    supprimeralbum: "yes",
                    noAlbum: noAlbum,
                },
            success: function(data)
                {    
                    console.log(data); //retour du n°supprimé
                }
        });

        //** Affichage
        $.ajax
        ({
            type: 'POST',
            url : 'pages/divers/albums/listealbums_inc.php',
            dataType: 'html',
            data: {
                    ajax: "yes",
                    ordreNoALbum: "decroissant"
                    },
                    success: function(data)
                    {    
                        $('#section_gauche').html(data);
                    },
                    complete: function()
                    {
                        //surlignement du 1er album de la liste
                        $('#divlisteAlbums tbody tr:first').css('backgroundColor', '#e4970c');
                        //recupère le numéro d'album de la première ligne
                        noAlbum = $('#divlisteAlbums tbody tr:first').find("td:first-child").text(); 
                        //affichage de la fichealbum de la 1ere ligne du tableau d'album
                        $('#divlisteAlbums tbody tr:first').find("td:first-child").click();

                        fiche_album(parseInt(noAlbum));
                        activer_selection();
                    },
        });

     })
//fin jQuery
});

