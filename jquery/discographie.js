/**
	script de gestion de l'affichage des albums
**/

$(function() 
{//début jquery
	$('#page_principale').on('click','.liste_titres li',function(){
		//coloration des onglets
		$(this).closest('.liste_titres').find('li').each(function(){$(this).css('backgroundColor','#494646')});
		$(this).css('backgroundColor','steelblue');
		//
		var numerodisque = $(this).index()+1;
		//effacement de tous les titres
		$(this).closest('.liste_titres').find('.detail_disque').each(function(){
			$(this).css('display','none');
		});
		//affichage des titres de l'onglet sélectionné
		$(this).closest('.liste_titres').find('#detail_disque' + numerodisque).css({
																					display: 'block'
																					});

																					});
});