$(function()
{
	//click sur une ligne du tableau utilisateurs
		$('#tableutilisateurs td').click(function() 
		{
			$("#tableutilisateurs tr").removeClass('selection');
			$(this).parent().addClass('selection');

			noutilisateur = $(this).parent().find('td:first').text();

			window.location.replace('index.php?gestionsite&noutilisateur=' + noutilisateur)
		});

	//curseurs coulissants droits des utilisateurs
	$('.choix1').click(function()
	{
		//COLORISATION
		$(this).addClass('bg-success text-white');
		$(this).removeClass('pointeur');
		$(this).next('.choix2').removeClass('bg-success text-white');
		$(this).next('.choix2').addClass('pointeur');

		choix = $(this).find('div').attr('Class'); //ajouter, supprimer etc..
		valeur = $(this).find('div').text(); //autorisé ou interdit
		noutilisateur = $('#formutilisateur #noutilisateur').val();

		//MIS A JOUR BDD
		$.ajax({
			url: 'pages/divers/ajax/updatedroits.php',
			type: 'POST',
			data: {choix: choix,
					valeur: valeur,
					noutilisateur: noutilisateur
					},
		})
	});

	$('.choix2').click(function()
	{
		//COLORISATION
		$(this).addClass('bg-success text-white');
		$(this).removeClass('pointeur');
		$(this).prev('.choix1').removeClass('bg-success text-white');
		$(this).prev('.choix1').addClass('pointeur');

		choix = $(this).find('div').attr('Class'); //ajouter, supprimer etc..
		valeur = $(this).find('div').text(); //autorisé ou interdit
		noutilisateur = $('#formutilisateur #noutilisateur').val();

		//MIS A JOUR BDD
		$.ajax({
			url: 'pages/divers/ajax/updatedroits.php',
			type: 'POST',
			data: {choix: choix,
					valeur: valeur,
					noutilisateur: noutilisateur
					},
		})
	});
});