//*************************************************************************************************************************
//**                                                                                                                       
/**                                          Programmeur: Michemuche62        
    script de gestion de la barre de menu

        *  -CONNEXION UTILISATEUR: 
            ==> vérification des champs
            ==> si non valide, on reste sur la page et on affiche les messages d'erreurs
            ==> si valide soumission(submit) du formulaire
**/

$(function() 
{//début jquery

    //var decennie; //decennie déterminé par clic dans le menu
    //var memodecennie=$('#liste_decennie li:first()').attr('class'); //memorisation de la decennie avant changement suite à clic sur menu
    //var taille_ecran
    
    //***************** 
    //  menu de connexion
    //*****************

        // soumission du formulaire de connexion controle des champs de saisi
        $('#page_principale').on('click','#validerconnexion',function(e)
            {
                e.preventDefault();
                //effacement des messages d'erreur et des couleurs d'alerte
                $('#form_connexion .help-block').css('visibility','hidden');
                //$('#group-pseudo').removeClass('has-error');
                //$('#group-motdepasse').removeClass('has-error');

                //vérification des champs
                $email = $.trim($("#email").val());
                $motdepasse = $.trim($("#motdepasse").val());
                if (($email == '') || ($motdepasse == ''))
                {
                    if($email == '')
                    {
                        //$('#group-pseudo').addClass('has-error');
                        //$('#span-pseudo').css('visibility','visible');
                        $('#span-pseudo').css('visibility','visible');
                    }

                    if($motdepasse == '')
                    {
                        //$('#group-motdepasse').addClass('has-error');
                        $('#span-motdepasse').css('visibility','visible');
                    }
                }
                else
                {
                    $('#form_connexion').submit();
                }
            });

});//fin jquery