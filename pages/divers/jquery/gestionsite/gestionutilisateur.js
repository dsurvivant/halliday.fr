$(function()
{
	$('#tableutilisateurs td').click(function() 
	{
		$("#tableutilisateurs tr").removeClass('selection');
		$(this).parent().addClass('selection');

		noutilisateur = $(this).parent().find('td:first').text();

		window.location.replace('index.php?gestionsite&noutilisateur=' + noutilisateur)
	});
});