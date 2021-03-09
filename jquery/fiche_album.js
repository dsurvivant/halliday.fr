$(function()
{
//jquery ready

/** Gestion des éléments dynamique de la fiche d'un album **/

    //ici le conteneur est dé
    $('#page_principale').on('click','.chevron_bas',function()
    {
        /*$(this).closest('h3').next('section').css('display','none');*/
        $(this).closest('h3').next('.contenu').toggle('hide', '', 'slow');
        $(this).css('display','none');
        $(this).next('.chevron_droite').css('display','inline-block');
    });

    $('#page_principale').on('click','.chevron_droite',function()
    {
        $(this).closest('h3').next('.contenu').css('display','block');
        $(this).css('display','none');
        $(this).prev('.chevron_bas').css('display','inline-block');
    });


/** popover (grosse info-bulle) **/
$('.pop').popover({placement: 'bottom', trigger:'hover'});

//fin jquery
});