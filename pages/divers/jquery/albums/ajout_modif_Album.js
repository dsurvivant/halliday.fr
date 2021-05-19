$(function()
{//début jquery
    //console.log("ajout_modif_album.js chargé");
    //*****
    //**    VARIABLES
    //*****
    var $nomAlbum;
    //var $anneeAlbum;09nov2019
    var $datesortieAlbum;
    var $titre;
    var $dureetitre;
    var titres = new Array(); //contient les titres en tableau
    var listetitres = new Array(); //tableau des titres de la bdd - utilisé pour l'autocompletion
    var dureetitres = new Array(); //contient les durees des titres en tableau
    var $titres; //contient les titres en linéaire (implode php)
    var $dureetitres; //contient les durees en linéaire (implode php)
    var $i=1;
    var $nbonglettitre = -1; //-1 car retrait de l'onglet +
    var $ongletactiftitre = 0; //entier
    var $i; //compteur général du script
    var $tableauactif=1; //tableau actuellement sélectionné pour la saisi : chiffre entier
    var $compteurtitre; //permet la numérotation des numéro de titres
    var $nbsupport; //nombre de cd ou de disques pour un album
    var $erreur=true; //variable de vérification des saisis
    var $messageerreur; //variable contenant le message d'erreur
    var $ancienTypeAlbum = $('#typeAlbum').val();
    var noalbum_traite=1; // numéro de l'album ajouté ou modifié
    var ordreAnnee = "croissant";
    var ordreAlbum = "croissant";
    var ordreNoALbum = "croissant";

    //*****
    //** FONCTIONS
    //**    selectionTableauTitre($tab) ==> mis en valeur du tableau passé en paramètre
    //**    selectonOngletTitre() ==> mis en valeur de l'onglet du tableau actif
    //**    validationDuree($dureetitre) ==> si 1111 ou 11:11 retourne true sinon false
    //*****
        function selectionTableauTitre($tab) //mis en valeur du tableau ; $tab est le numéro du tableau
        {
            //Grisement de tous les tableaux
            $("#bloctableaux .tableTitres th").css('background-color', '#beb7b4');
            $("#bloctableaux .tableTitres th").css('border', '1px solid #beb7b4');
            $("#bloctableaux .tableTitres td").css('border', '1px solid #beb7b4');
            $("#bloctableaux .tableTitres").css('border', '1px solid #beb7b4');

            //coloration du tableau actif
            $('#tableTitres' + $tab + ' th').css('background-color', '#D0E3FA');
            $('#tableTitres' + $tab + ' th').css('border', '1px solid #6495ed');
            $('#tableTitres' + $tab + ' td').css('border', '1px solid #6495ed');

        }

        function selectonOngletTitre() //mis en valeur de l'onglet
        {
            //déselection de tous les onglets
            $('.onglettitre').each(function()
            {
                $(this).css(
                {
                    color: 'black',
                    backgroundColor: 'white',
                    border: 'none'
                });
            });

            //surbrillance  de l'onglet
            $i = $tableauactif-1;
            $('#onglettitres li').eq($i).css(
            {
                color: 'black',
                backgroundColor: '#D0E3FA',
                border: '1px solid #6495ed'
            });
        }

        function validationDuree($dureetitre) //si 1111 ou 11:11 retourne true sinon false
        {
            if ((/^[0-9]{4}$/.test($dureetitre)) || (/^[0-9]{2}:[0-9]{2}$/.test($dureetitre)))
                {return true}
            else
                {return false}
        }

    //*****
    //** INITIALISATION
    //**    effacement du tableau de titres de la bdd
    //**    calcul nombre onglet disques
    //*****
        //effacement du tableau de titres de la bdd et
        //récupération des titres dans le tableau listetitres (autocompletion)
        listetitres.splice(0);
        $('#selecttitre option').each(function()
            {
                listetitres.push(($(this).text().trim()));
            });

        $('#onglettitres li:first').css('background-color', '#D0E3FA'); //coloration premier onglet
        selectionTableauTitre(1); //selection du premier tableau

        //calcul nombre onglet disques
        $('#onglettitres .onglettitre').each(function(){$nbonglettitre++;});

    //*****
    //** AUTOCOMPLETION
    //*****

        //autocomplete du titre dans le tableau
        $('#gestion_album').on('keyup', '.modifier_titre', function()
        {
            valeur = $(this).val();
           $.ajax(
            {
                type: 'GET',
                url : 'pages/divers/albums/liste_titres_autocomplete.php',
                data: {term: valeur},
                success : function(donnee)
                {
                    //console.log("titres: " + donnee);

                    var listetitres = donnee.split('-');

                    $('.modifier_titre').autocomplete(
                        {
                            source : listetitres
                        });
                },
                error : function(donnee)
                {
                    console.log("erreur autocomplete: " + donnee);
                }
            });
        });

    //*****
    //** EVENEMENTS CLICK
    //**    - ajout d'un onglet et donc d'un tableau
    //**    - sélection d'un onglet (disque1, disque2, disque3, etc...)
    //**    - BOUTON MOINS DES TITRES: suppression d'un titre du tableau de titres
    //**    - BOUTON PLUS DES TITRES - AJOUTER TITRE 
    //**    - SELECTION DU TABLEAU ET DE L'ONGLET CORRESPONDANT SI CLICK DESSUS
    //**    - SELECTION DU TABLEAU ET DE L'ONGLET CORRESPONDANT SI FOCUS DESSUS
    //**    - Suppression d'un tableau
    //**
    //*****

        //ajout d'un onglet et donc d'un tableau
        $('#bouton_plus_onglet').click(function()
        {
            $i=0;
            //affichage du bloc tableaux
            //$('#bloctableaux').css('visibility', 'visible');
            //déselection des autres onglets
            $('.onglettitre').each(function()
            {
                $i++; //comptage du nombre d'onglet avant ajout
                $(this).css(
                {
                    color: 'black',
                    backgroundColor: 'white'
                });
                console.log("nb onglets: " + $i);
            });
            //mis à jour des compteurs
            $nbonglettitre++;
            $ongletactiftitre = $i-1; //moins onglet bouton plus
            $tableauactif = $ongletactiftitre + 1;

            //ajout de l'onglet dans le html
            $('#ongletplus').before('<li class="onglettitre">Disque ' + $nbonglettitre + '</li>');

            //création du tableau html à la suite du dernier tableau
            $('#bloctableaux').append('<table id="tableTitres'
                + $nbonglettitre
                +'" class="table tableTitres"><caption id="disque'
                + $nbonglettitre
                +'">Disque '
                + $nbonglettitre
                + '<img  id="suppressionTableau" src="pages/divers/images/boutons/poubelle.png" alt="supprimer tableau" title="supprimer tableau" width="15px">'
                +'</caption><thead><tr>\
                <th>No</th>\
                <th>Titre</th>\
                <th>Durée</th>\
                <th></th>\
                <th><img class="bouton_plus_titre_thead" src="pages/divers/images/boutons/bouton-plus.png" alt="ajouter titre" title="ajouter titre" width="15px"></th>\
                </tr>\
                </thead><tbody>\
                <tr class="ligne">\
                <td class="notitre">1</td>\
                <td><input class="modifier_titre form-control" type="text" name="nomtitre"/></td>\
                <td><input class="modifier_duree form-control" type="text" name="dureetitre"  maxlength="5" /></td>\
                <td><img class=" bouton_moins_titre" src="pages/divers/images/boutons/bouton-moins.png" alt="supprimer titre" title="supprimer titre" width="15px"></td>\
                <td><img class=" bouton_plus_titre" src="pages/divers/images/boutons/bouton-plus.png" alt="ajouter titre" title="ajouter titre" width="15px"></td>\
                </tr></tbody></table>');

            //focus sur l'onglet et sur le tableau
            $('.onglettitre:eq(' + $ongletactiftitre + ')').click();
        });

        //sélection d'un onglet (disque1, disque2, disque3, etc...)
        $("#onglettitres").on ('click', '.onglettitre', function()
        {
            // sauf si bouton +
            if ($(this).index()!=$nbonglettitre)
            {
                //déselection de tous les onglets
                $('.onglettitre').each(function()
                {
                    $(this).css(
                    {
                        color: 'black',
                        backgroundColor: 'white',
                        border: 'none'
                    });
                });

                //sélection de l'onglet cliqué
                $(this).css(
                {color: 'black',
                    backgroundColor: '#D0E3FA',
                    border: '1px solid #6495ed'
                });

                //mis à jour des compteurs
                $ongletactiftitre = $(this).index();
                $tableauactif = $ongletactiftitre + 1;

                //Mis en valeur du tableau de travail
                selectionTableauTitre($tableauactif);
            }
        });

        //BOUTON MOINS DES TITRES: suppression d'un titre du tableau de titres
        $('#bloctableaux').on('click','.bouton_moins_titre',function()
        {
            //coloration de la ligne concernée
            $(this).closest('tr').css('backgroundColor', 'red');

            //détermination du tableau contenant le titre à supprimer
            $tableauactif = $(this).closest('table').attr('id');
            $tableauactif = $tableauactif.substr(-1);

            //mis en valeur du tableau concerné
            selectionTableauTitre($tableauactif);
            //surbrillance de l'onglet correspondant au tableau
            selectonOngletTitre($tableauactif);

            if (confirm("Etes vous sûr de supprimer ce titre ?"))
            {
                //suppression de la ligne concernée après confirmation
                $(this).closest('tr').remove();
                //renumérotation des titres
                $i=0;
                $('#tableTitres' + $tableauactif + ' .ligne').each(function()
                {
                    $i++;
                    $(this).find('td:first').text($i);
                });
                
                //console.log("nombre de lignes: " + $i);
            }
            else
            {
                $(this).closest('tr').css('backgroundColor', 'white');
            }
        });

        //BOUTON PLUS DE L'ENTETE DU TABLEAU DES TITRES - AJOUTER TITRE
        $('#bloctableaux').on('click','.bouton_plus_titre',function()
        {
            txt = ''
            $(this).closest('tr').after('<tr class="ligne">\
                <td class="notitre"></td>\
                <td><input class="modifier_titre form-control" type="text" name="nomtitre"/></td>\
                <td><input class="modifier_duree form-control" type="text" name="dureetitre"  maxlength="5" /></td>\
                <td><img class=" bouton_moins_titre" src="pages/divers/images/boutons/bouton-moins.png" alt="supprimer titre" title="supprimer titre" width="15px"></td>\
                <td><img class=" bouton_plus_titre" src="pages/divers/images/boutons/bouton-plus.png" alt="ajouter titre" title="ajouter titre" width="15px"></td>\
                </tr>');
            
            //numérotation des titres
            $i=0;
            var tableau = $(this).closest('.tableTitres');
            $(this).closest('.tableTitres').find('.ligne').each(function()
            {
                $i++;
                $(this).find('td:first').text($i);
            });

            //
            $(this).closest('.tableTitres').find('.modifier_titre').last().focus();
            //$('.modifier_titre').last().focus();
        });

        //BOUTON PLUS DES TITRES - AJOUTER TITRE
        $('#bloctableaux').on('click','.bouton_plus_titre_thead',function()
        {
            $(this).closest('table').find('tbody').prepend('<tr class="ligne">\
                <td class="notitre"></td>\
                <td><input class="modifier_titre form-control" type="text" name="nomtitre"/></td>\
                <td><input class="modifier_duree form-control" type="text" name="dureetitre"  maxlength="5" /></td>\
                <td><img class=" bouton_moins_titre" src="pages/divers/images/boutons/bouton-moins.png" alt="supprimer titre" title="supprimer titre" width="15px"></td>\
                <td><img class=" bouton_plus_titre" src="pages/divers/images/boutons/bouton-plus.png" alt="ajouter titre" title="ajouter titre" width="15px"></td>\
                </tr>');
            
            //numérotation des titres
            $i=0;
            var tableau = $(this).closest('.tableTitres');
            $(this).closest('.tableTitres').find('.ligne').each(function()
            {
                $i++;
                $(this).find('td:first').text($i);
            });

            //
            $(this).closest('.tableTitres').find('.modifier_titre').last().focus();
            //$('.modifier_titre').last().focus();
        });

        //SELECTION DU TABLEAU ET DE L'ONGLET CORRESPONDANT SI CLICK DESSUS
        $('#bloctitres').on('click', '.tableTitres', function()
        {
            $tableauactif = ($(this).attr('id')).substr(11,1);
            selectionTableauTitre($tableauactif);
            selectonOngletTitre();
        });

        //suppression d'un tableau
        $('#bloctitres').on('click','#suppressionTableau',function()
        {
            $(this).closest('tr').find('th').css("backgroundColor", "red");

            if (confirm("Etes vous sûr de supprimer ce tableau ?"))
            { 
                //suppression du dernier onglet disque
                $('#onglettitres li:nth-child(' + $nbonglettitre + ')').remove();
                $nbonglettitre = $nbonglettitre -1;
                    
                $(this).closest('table').remove();

                //renumérotation des tableaux
                
                $i=0;
                $('#bloctableaux .tableTitres').each(function(){
                    $i++;
                    $(this).attr('id',"tableTitres" + $i);
                    $(this).find('caption').text('Disque ' + $i);
                    $(this).find('caption').append('<img  id="suppressionTableau" src="pages/divers/images/boutons/poubelle.png" alt="supprimer tableau" title="supprimer tableau" width="15px">');
                });
            }
        });
    //*****
    //** FOCUS
    //*****

        //SELECTION DU TABLEAU ET DE L'ONGLET CORRESPONDANT SI FOCUS DESSUS
        $('#bloctitres').on('focus', '.tableTitres', function()
        {
            $tableauactif = ($(this).attr('id')).substr(11,1);
            selectionTableauTitre($tableauactif);
            selectonOngletTitre();
        });

        //vérification de la duree en quittant la zone de saisie
        $('#bloctitres').on('focusout','.modifier_duree',function()
        {
            $dureetitre = $(this).val();
            $dureetitre = $.trim($dureetitre);

             if (validationDuree($dureetitre)) //controle du format duree titre 1223 ou 12:12
            {
                $(this).css('backgroundColor','white');

                //transformation de la duree mmss en mm:ss
                if ((/^[0-9]{4}$/.test($dureetitre)))
                {
                    $tampon = $dureetitre.substr(0,2);
                    $dureetitre = $tampon + ":" + $dureetitre.substr(2);
                    $(this).val($dureetitre);
                }
            }
            else
            {
                if ($dureetitre=='')
                    {$(this).val("00:00");}
                else
                    {$(this).css('backgroundColor','red');}
            }
        });

        //vérification du titre en quittant la zone de saisie, si vide on remet le titre par défaut s'il existe (en mode modification)
        $('#bloctitres').on('focusout','.modifier_titre',function()
        {
            $nomtitre = $(this).val();
            $nomtitre = $.trim($nomtitre);

            if ($nomtitre == '') { $(this).val($(this).attr("placeholder")); }
        });

        $(".modifier_duree").focus(function(){ $(this).css('backgroundColor','white');});
        $(".modifier_titre").focus(function(){ $(this).css('backgroundColor','white');});

    //*****
    //**    JAQUETTES
    //*****
        //affectation de l'image à la balise img
        $('.input-file').change(function()
        {
            $image = $(this).closest('.jaquette').find('img');
            if (this.files && this.files[0])
            {
                var reader = new FileReader();
                reader.onload = function (e)
                {
                    $image.attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        //ouverture de l'explorateur
        $('img').click(function()
        {
            //ouverture de l'explorateur de fichiers
            $(this).closest('.jaquette').children('input').click();
        });
    //*****
    //**    CLAVIER
    //*****

        //touche ENTREE dans le champ de saisi durée du titre ==> ajout d'une ligne supplémentaire
        $('#bloctitres').on("keyup", ".modifier_duree",function(touche)
        {
            var appui = touche.which || touche.keyCode; //le code est compatible sur tous les navigateurs grâce à ces deux propriétés

            if(appui == 13)
            {
                $(this).closest('tr').after('<tr class="ligne">\
                    <td class="notitre"></td>\
                    <td><input class="modifier_titre form-control" type="text" name="nomtitre"/></td>\
                    <td><input class="modifier_duree form-control" type="text" name="dureetitre"  maxlength="5" /></td>\
                    <td><img class=" bouton_moins_titre" src="pages/divers/images/boutons/bouton-moins.png" alt="supprimer titre" title="supprimer titre" width="15px"></td>\
                    <td><img class=" bouton_plus_titre" src="pages/divers/images/boutons/bouton-plus.png" alt="ajouter titre" title="ajouter titre" width="15px"></td>\
                    </tr>');
                //numérotation des titres
                $i=0;
                var tableau = $(this).closest('.tableTitres');
                $(this).closest('.tableTitres').find('.ligne').each(function()
                {
                    $i++;
                    $(this).find('td:first').text($i);
                });

                //
                $(this).closest('.tableTitres').find('.modifier_titre').last().focus();
                
                return false;
            }
        });

        $('#bloctitres').on("keyup", ".modifier_titre",function(touche)
        {
            var appui = touche.which || touche.keyCode; //le code est compatible sur tous les navigateurs grâce à ces deux propriétés

            if(appui == 13)
            {
                $(this).closest('tr').find('.modifier_duree').focus();
            }
        });

        

    //*****
    //**    CONTROLE DES SAISIS
    //*****

        // annee doit etre sous forme jj/ll/aaaa
        $('#datesortieAlbum').keyup(function()
        {
            if (/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/.test($(this).val()))
            { $(this).css({color:'black', backgroundColor: 'white'}); } //ok
            else
            { $(this).css({color:'black', backgroundColor: 'red'}); }   //erreur
        });

    //*****
    //** SOUMISSION DU FORMULAIRE : formAjoutAlbum
    //*****

        $('#bouton_valider').click(function(e)
        {
            e.preventDefault();
            $erreur=false;
            $messageerreur='';

            //*********** CONTROLE DES ELEMENTS SAISIS  **********
            $nomAlbum = $('#nomAlbum').val();
            $nomAlbum = $.trim($nomAlbum);
            //$anneeAlbum = $('#anneeAlbum').val(); 09nov2019
            //$anneeAlbum = $.trim($anneeAlbum) 09nov2019
            $datesortieAlbum=$('#datesortieAlbum').val();
            $datesortieAlbum = $.trim($datesortieAlbum)

            //***** NOM DE L'ALBUM OBLIGATOIRE  *****

                if ($nomAlbum=='')
                {
                    $('#nomAlbum').css({color: 'black', 'background-color': 'red'});
                    $messageerreur ="Nom de l'album ne peut être vide.<br/>";
                    $erreur=true;
                }
                else {$('#nomAlbum').css({color: 'black', 'background-color': 'white'}) ;}


            //***** date de sortie sous forme jj/mm/aaaa  *****

                if ((/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/.test($datesortieAlbum)))
                {
                    $('#datesortieAlbum').css({color: 'black', 'background-color': 'white'});
                }
                else
                {
                    $('#datesortieAlbum').css({color: 'black', 'background-color': 'red'});
                    $messageerreur +=" La date de sortie doit être sous la forme jj/mm/aaaa ou j/m/aaaa<br/>";
                    $erreur=true;
                }

             /***** SUPPRESSION DE LA DERNIERE LIGNE SI LE TITRE EST VIDE **/
             $('.tableTitres').each(function(){
                if($(this).find('.modifier_titre').last().val()=='')
                {
                    $(this).find('.modifier_titre').last().closest('tr').remove();
                }
             });

            //***** VERIFICATION DU BON FORMAT DES DUREES *****

                $('.modifier_duree').each(function()
                {
                    if (!validationDuree($(this).val())) //controle du format duree titre 1223 ou 12:12
                    {
                        $(this).css('background-color', 'red');
                        $erreur=true;
                        $messageerreur = "Problème de format sur les durées<br/>";
                    }

                });

                //***** VERIFICATION QU'IL N'Y A PAS UN TITRE VIDE  *****
                $('.modifier_titre').each(function()
                {
                    if ($(this).val()=='')
                    {
                        $erreur = true;
                        $(this).css('backgroundColor', 'red');
                        $messageerreur = "Un ou plusieurs titres sont vides.";
                    }
                });
//*******************************************************
//*********** TRAITEMENT DES DONNEES SAISIS   ***********
//*******************************************************

            if ($erreur==false) //pas d'erreur sur les données saisies
            {
                $i=0;
                //effacement des eventuelles champs d'erreur
                $('#erreurformulaire').html('');

                //*****
                //***** SOUMISSION
                //*****

                // RECUPERATION DES TITRES SAISIS AVANT SOUMISSIONS A LA BDD
                titres.splice(0); //effacement tableaux contenant les titres
                dureetitres.splice(0); //effacement tableaux contenant les durees

                //récupérations des valeurs titre/duree
                    //$titres contient tous les titres en linéaire ss forme tab1/titre1/titre2/tab2/titre1/etc...
                    //$durees contient toutes les durees en linéaire ss forme tab1/duree1/duree2/tab2/duree1/etc...
                    for (var i=1; i<=$('.tableTitres').length; i++) //exécution à chaque tableau titres
                    {
                        $i++;
                        titres.push("tab" + $i);
                        dureetitres.push("tab" + $i);

                        $('#tableTitres' + $i + ' tbody tr').each(function()
                        {
                            // LES TITRES
                            $(this).find('td:eq(1) input').each(function(){
                                                titres.push($(this).val());
                                            });

                            // LES DUREES
                            $(this).find('td:eq(2) input').each(function(){
                                                dureetitres.push($(this).val());
                                            });
                         });

                        $titres = titres.join('/');
                        $dureetitres = dureetitres.join('/');

                    }

                    var form = $('#formAlbum')[0];
                    var data = new FormData(form);
                    //ajout de champ supplementaire

                    data.append("ancien_nomAlbum", $('#nomAlbum').attr("placeholder"));
                    data.append("noutil", $('#inputnoutil').val());
                    data.append("titres", $titres);
                    data.append("dureetitres", $dureetitres);
                //AJOUT MODIF DE L'ALBUM DANS LA BDD
                $.ajax
                ({
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    url : 'pages/divers/albums/ajout_modif_album_inc.php',
                    data:data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    success: function(data)
                    {
                        reponseajax = data.substr(0,7);
                        //alert("reponse 1: " + reponseajax);
                        if (reponseajax=="success")
                        {
                            noalbum_traite = data.substr(9);
                        }
                        else
                        {
                            $('#erreurformulaire').css('color', 'red');
                            $('#erreurformulaire').html(data)
                        }
                    },
                    error: function(){console.log("erreur ajax min tio")},
                    complete: function(data)
                    {
                        //reponseajax = data.substr(0,7);
                        if (reponseajax=="success")
                        {
                        /**                      **/
                        /** LA SAISIE EST VALIDEE **/
                        /**                      **/
                            mode = $('#bouton_valider').text();
                            //reaffichage de la page membre avec fiche de l'album ajouté ou modifié
                            $('#gestion_album').html('').css('display','none');
                            $('#page_membre').css('display','block');

                            //dans le cas d'un ajout, on remet la liste d'album à jour, triée par
                            //no album décroissant
                            if (mode!="Modifier")
                            {
                                noutil = $('footer #noutil').text();
                                $.ajax
                                ({
                                    type: 'POST',
                                    url : 'pages/divers/albums/listealbums_inc.php',
                                    dataType: 'html',
                                    data: {
                                            ajax: "yes",
                                            ordreNoALbum: "decroissant",
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
                                    },
                                    error: function() {alert("erreur");}
                                });
                            }
                            //fiche album
                            $.ajax
                            ({
                                type: 'GET',
                                url : 'pages/divers/albums/fichealbum_inc.php',
                                dataType: 'html',
                                data: 
                                {
                                    ajax: "yes",
                                    noAlbum: noalbum_traite,
                                },
                                success: function(data){
                                    $('#section_centrale').html(data);
                                        },
                                error: function(){console.log("erreur ajax selection album dans la liste");}
                            });
                        } /** if **/
                        else
                        {
                        /**                              **/
                        /** LA SAISIE N'EST PAS VALIDEE **/
                        /**                            **/
                            alert ("Apparamment, il y a une bourde !!!")
                        } /**else**/
                    }

                });

            }
            else
            {
                $('#erreurformulaire').css({color: 'red'});
                $('#erreurformulaire').html('Erreur : ' + $messageerreur);
            }
        });

//fin jquery
});
