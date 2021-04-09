//*************************************************************************************************************************
//**                                                                                                                       
/**                                          Programmeur: Michemuche62        
        -formulaire de connexion
        -formulaire nouveau mot de passe (suite oubli)
**/

$(function() 
{//début jquery

function validationmotdepasse($motdepasse)
    {
        if (/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test($motdepasse))
        { return (true); }
        return (false);
    }

 // soumission du formulaire de connexion controle des champs de saisi
    $('#page_principale').on('click','#validerconnexion',function(e)
    {
        e.preventDefault();
        //effacement des messages d'erreur et des couleurs d'alerte
        $('#form_connexion .help-block').css('visibility','hidden');

        //vérification des champs
        $email = $.trim($("#email").val());
        $motdepasse = $.trim($("#motdepasse").val());
        if (($email == '') || ($motdepasse == ''))
        {
            if($email == ''){$('#span-pseudo').css('visibility','visible'); }

            if($motdepasse == ''){ $('#span-motdepasse').css('visibility','visible');}
        }
         else{$('#form_connexion').submit();}
    });

//soummission du formaulaire nouveau mot de passe
    $('#page_principale').on('click','#validernewpassword',function(e)
    {
        e.preventDefault();
        erreur = false;
        message = '';
        $('#spanerror').html();

        password = $('#password').val();
        confirmpassword = $('#confirmpassword').val();

        //critères mot de passe
        if (!validationmotdepasse(password))
        {
            $('#formforgetpassword #password').css('border', 'solid 1px red');
            erreur = true;
            message = "Critères mot de passe non respectés";
        }

        //mot de passe différents
        if (password!=confirmpassword)
        {
            $('#formforgetpassword input').css('border', 'solid 1px red');
            erreur = true;
            message = "Les mots de passe ne sont pas identiques";
        }

         //champ vide
        $('#formforgetpassword input').each(function()
        {
            if ($(this).val().trim()=='') 
            {
                $(this).css('border', 'solid 1px red');
                erreur = true;
                message = "Un des champs est vide";
            }
        });

         if(erreur==false) { $('#formforgetpassword').submit(); }
        else { $('#spanerror').html(message); }    
    });

});//fin jquery