$(function()
{//début jQuery
	//*************************************************************************************************************************
	//**                                                                                                                       
	//**                                          Programmeur: Michemuche62                                                             
	//**
	//**    Gère la liste des titres de l'onglet Titres dans la partie membre
	//**    
	//****************************************************************************************************************************

	var noTitre;
	var ordreTitre = "croissant"; //ordre d'affichage des titres par nom sur clic entete
	var ordreNo = "croissant"; //ordre d'affichage des titres par no sur clic entete
	
	//INITIALISATION
	//surlignement du 1er titre de la liste
    $('#divlisteTitres .lignetitre:first').addClass('surligne');
 
	   
	//** CLICK SUR L'ENTETE TRI DE L'ORDRE D'AFFICHAGE DES TITRES
		$('#section_gauche_titres').on('click', '.entetetitre', function()
		{
		    /** TRI PAR NOM DE TITRE **/
			if ($(this).text()=="Titres")
		    {
			    //titre recherché
				titre = $('#inputrecherchetitre').val().trim();

			    //case à cocher modifierparolestitres, on récupére dans paroles
			    //la valeur with, without, ou all (avec paroles, sans paroles, tout)
			    $('.checkParolesTitres').each(function() 
			    {
			    	if($(this).attr('checked')=='checked')
			    	{
			    		paroles = ($(this).attr('value'));
			    	}
			    });

			    //determination de l'ordre de l'album
			    if (ordreTitre=="croissant") {ordreTitre="decroissant"}
			    else {ordreTitre="croissant"}

			    $.ajax
				({
				    type: 'POST',
				    url: 'pages/divers/albums/listetitres_inc.php',
				    dataType: 'html',
				    data: {
				        	ajax: "yes",
				        	ordreTitre: ordreTitre,
				        	checkparolestitres : paroles,
				        	recherchetitre: titre
				        	},
				    success: function(data)
				    {
				        //
				        $('#section_gauche_titres').html(data);
				    },
				    complete: function()
				    {
				        //surlignement du 1er titre de la liste
	    				//$('#divlisteTitres .lignetitre:first').css('backgroundColor', '#e4970c');
	    				$('#divlisteTitres .lignetitre:first').addClass('surligne');
	    				noTitre=$('#divlisteTitres .lignetitre:first').find('span:nth-child(1)').text();
	    				fiche_titre(noTitre);
				    },
				    error: function(){alert("erreur ajax titre");}
				});
			}
		
		});
		    
	/**
	 * CLICK SUR UNE LIGNE DU TABLEAU
	 */
		$('#section_gauche_titres').on('click', '.lignetitre',function()
	 	{
	 		notitre = $(this).find('span:nth-child(1)').text();
	 		$('.lignetitre').removeClass('surligne');
		    $(this).addClass('surligne');
		    //fiche de la ligne sélectionnée
		    noTitre = $(this).find('span:nth-child(1)').text();
		    fiche_titre(noTitre);
		});

	/**
	 * CHECKBOX SANS TEXTES
	 */
		$('.checkParolesTitres').change(function() 
		{
			action = "index.php?acces_membre&onglet=Titres&paroles=" + $(this).val();
			$('#formfiltres').attr('action', action)
			$('#formfiltres').submit();
		});


	/**
	 * RECHERCHE TITRE
	 */
		$('#inputrecherchetitre').keyup(function()
		{
			//titre recherché
			titre = $(this).val().trim();

			//case à cocher modifierparolestitres, on récupére dans paroles
			//la valeur with, without, ou all (avec paroles, sans paroles, tout)
			$('.checkParolesTitres').each(function() 
			{
			    if($(this).attr('checked')=='checked')
			    {
			    	paroles = ($(this).attr('value'));
			    }
			});

			//determination de l'ordre de l'album
			if (ordreTitre=="croissant") {ordreTitre="decroissant"}
			else {ordreTitre="croissant"}

			$.ajax
			({
				type: 'POST',
				url: 'pages/divers/albums/listetitres_inc.php',
				dataType: 'html',
				data: {
				        ajax: "yes",
				        ordreTitre: ordreTitre,
				        checkparolestitres : paroles,
				        recherchetitre: titre
				        },
			success: function(data)
				{
				    //
				    $('#section_gauche_titres').html(data);
				},
			complete: function()
				{
				    //surlignement du 1er titre de la liste
	    			//$('#divlisteTitres .lignetitre:first').css('backgroundColor', '#e4970c');
	    			$('#divlisteTitres .lignetitre:first').addClass('surligne');
	    			noTitre=$('#divlisteTitres .lignetitre:first').find('span:nth-child(1)').text();
	    			fiche_titre(noTitre);
				},
			error: function(){alert("erreur ajax titre");}
			});
			
		});

	/**
	 * FONCTIONS
	 */

	function fiche_titre(numero)
		{
		    noutil = $('footer #noutil').text();
		    $.ajax
		    ({
		        type: 'POST',
		        url : 'pages/divers/albums/fichetitre_inc.php',
		        dataType: 'html',
		        data: 
		        {
		            ajax: "yes",
		            notitre: numero,
		            noutil: noutil,
		        },
		        success: function(data)
		        {
		            $('#section_centrale_titres').html(data);
		        },
		        error: function(){console.log("erreur ajax selection album dans la liste");}
		    });
		}

}); //fin jQuery