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
			if ($(this).text()=="Titre")
		    {
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
				        	},
				    success: function(data)
				    {
				        //
				        $('#section_gauche_titres').html(data);
				    },
				    complete: function()
				    {
				        //surlignement du 1er titre de la liste
	    				$('#divlisteTitres .lignetitre:first').css('backgroundColor', '#e4970c');
	    				noTitre=$('#divlisteTitres .lignetitre:first').find('span:nth-child(1)').text();
	    				fiche_titre(noTitre);
				    },
				    error: function(){alert("erreur ajax titre");}
				});
			}

		    /** TRI PAR NO DE TITRE **/
		        	

		    if ($(this).text()=="No")
		    {
			    //determination de l'ordre de l'album
			    if (ordreNo=="croissant"){ordreNo="decroissant"}
			    else{ordreNo="croissant"}

			    $.ajax
				({
				    type: 'POST',
				    url: 'pages/divers/albums/listetitres_inc.php',
				    dataType: 'html',
				    data: {
				        	ajax: "yes",
				        	ordreNo: ordreNof,
				        	},
				    success: function(data){$('#section_gauche_titres').html(data);},
				    complete: function()
				    {
				        //surlignement du 1er titre de la liste
	    				$('#divlisteTitres .lignetitre:first').css('backgroundColor', '#e4970c');
	    				noTitre=$('#divlisteTitres .lignetitre:first').find('span:nth-child(1)').text();
	    				fiche_titre(noTitre);
				    },
				    error: function(){alert("erreur ajax titre");}

				});
			}
		});
		    
	/**
	 * 
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