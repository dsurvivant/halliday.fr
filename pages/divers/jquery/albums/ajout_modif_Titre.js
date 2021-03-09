//***************************************************
//**
//** CREE PAR JMT NOV 2020
//**
//** SCRIPT GESTION DE L'ONGLET TITRE
//**
//**    - Modification du texte de la chanson
//**    - Modification infos diverses du titre
//**
//***************************************************


$(function()
{//début jQuery
	//console.log("ajoutmodifTitre.js lancé");
	
	//*****
	//**	GESTION DE LA MODIFICATION DES PAROLES DE LA CHANSON
	//*****

	$('#section_centrale_titres').on('click', '.annulermodal',function(e)
    {
        e.preventDefault();
        $('.close').click();
    });

    $('#section_centrale_titres').on('click', '#validertexteTitre',function(e)
		{
            e.preventDefault();
            console.log('validation de la modif du texte des paroles');
			//Traitement de la modification des paroles
			console.log ("no titre: " + $('#notitre').text());
            
			 $.ajax
                ({
                    type: 'POST',
                    url : 'pages/divers/albums/modif_paroles_titres_inc.php',
                    dataType: 'html',
                    data: {
                            noTitre: $('#notitre').text(),
                            texteTitre: $('#textareaparoles').val()
                          },
                            success: function(data)
                            {    
                                console.log("ajax réussi");
                                //$("#reponseajax").html(data); test programmation
                                $('#contenutexteTitre').html(data)
                                
                            },
                            complete: function(data)
                            {
                            	$('#fermeturemodal').click();
                            },
                            
                            error: function() 
                            {
                            	$("#reponseajax").html("Erreur ajax dans ajout_modif_titre.js");
                            }
                });
		});

    $('#section_centrale_titres').on('click', '#validerinfostitre',function(e)
        {
            e.preventDefault();
            console.log('validation de la modif des infos du titre');
            //Traitement de la modification des paroles
            console.log($('#input_paroles').val());
            console.log($('#input_musique').val());
            console.log ("no titre: " + $('#notitre').text());
            
             $.ajax
                ({
                    type: 'POST',
                    url : 'pages/divers/albums/modif_infos_titres_inc.php',
                    dataType: 'html',
                    data: {
                            noTitre: $('#notitre').text(),
                            parolesTitre: $('#input_paroles').val(),
                            musiqueTitre: $('#input_musique').val()
                          },
                            success: function(data)
                            {    
                                console.log("ajax réussi");
                                //$("#reponseajax").html(data); test programmation
                                $('#parolesTitre').html($('#input_paroles').val());
                                $('#musiqueTitre').html($('#input_musique').val());
                            },
                            complete: function(data)
                            {
                                $('.close').click();
                            },
                            
                            error: function() 
                            {
                                $("#reponseajax").html("Erreur ajax dans ajout_modif_titre.js");
                            }
                });
        });
}); //fin jquery