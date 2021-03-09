//*************************************************************************************************************************
//**                                                                                                                       
/**                                          Programmeur: Michemuche62        
    script de gestion de la barre de menu

    - PROCEDURES:
        * 1 - Changement de résolution d'écran : 
            ==> en résolution mobile le menu disparait (menu  en position verticale)
            ==> hors résolution mobile le menu s'affiche s'il est effacé (menu en position horizontale)

        * 2 - Bouton menu glissant :
            ==> effectue le glissement du menu glissant à chaque appui sur le bouton

        * 3 -CONNEXION UTILISATEUR: 
            ==> vérification des champs
            ==> si non valide, on reste sur la page et on affiche les messages d'erreurs
            ==> si valide soumission(submit) du formulaire
**/

$(function() 
{//début jquery

    var decennie; //decennie déterminé par clic dans le menu
    var memodecennie=$('#liste_decennie li:first()').attr('class'); //memorisation de la decennie avant changement suite à clic sur menu
    var taille_ecran

    //on cache le menu en résolution mobile
    taille_ecran = $(window).width();
    if (taille_ecran  < 768)
        {
            $('#barre_navigation').hide();
            $('#barre_navigation').css('visibility','visible');
        }

    //******************
    // 1 - changement de résolution de l'écran
    //******************
        $(window).resize(function()
        {
            taille_ecran = $(window).width();
            if (taille_ecran  >768) { $('#barre_navigation').show(); }  
        });
    //******************
    // 2 - bouton menu glissant
    //******************

        //menu glissant pour la résolution mobile
            $('#image_menu').click(function()
            {
                $('#barre_navigation').toggle('slide', { direction: 'right' }, 500);        
            });
    
    //***************** 
    //  3 - menu de connexion
    //*****************

        // soumission du formulaire de connexion controle des champs de saisi
        $('#page_principale').on('click','#validerconnexion',function(e)
            {
                e.preventDefault();
                //effacement des messages d'erreur et des couleurs d'alerte
                $('#form_connexion .help-block').css('visibility','hidden');
                $('#group-pseudo').removeClass('has-error');
                $('#group-motdepasse').removeClass('has-error');

                //vérification des champs
                $pseudo = $.trim($("#pseudo").val());
                $motdepasse = $.trim($("#motdepasse").val());
                if (($pseudo == '') || ($motdepasse == ''))
                {
                    if($pseudo == '')
                    {
                        $('#group-pseudo').addClass('has-error');
                        //$('#span-pseudo').css('visibility','visible');
                        $('#span-pseudo').css('visibility','visible');
                    }

                    if($motdepasse == '')
                    {
                        $('#group-motdepasse').addClass('has-error');
                        $('#span-motdepasse').css('visibility','visible');
                    }
                }
                else
                {
                    $('#form_connexion').submit();
                }
            });

});//fin jquery