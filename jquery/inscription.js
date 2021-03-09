$(function()
{

    //** menu d'inscription
    //** Vérification des champs de saisis
    //** soummission du formulaire si pas d'erreur (#form_inscription)

    $('#page_principale').on('click','#validerinscription',function(e)
    {
        e.preventDefault();
        //effacement des messages d'erreur et des couleurs d'alerte
        $('#form_inscription .help-block').css('visibility','hidden');
        $('#form_inscription input').each(function()
        {
        	$(this).css('border', 'solid 1px #ccc');
        });

        //
        //vérification des champs
        //
        $erreur = false;

        //zones blanches
        $('#form_inscription input').each(function()
        {
            if ($(this).val().trim()=='') 
            {
                $(this).css('border', 'solid 1px red');
                $(this).next('span').css('visibility','visible');
                $erreur = true;
            }
        });

        var email = $('#email_inscription').val().trim();
        if(!ValidateEmail(email))
        {
        	$('#email_inscription').css('border', 'solid 1px red');
        	$('#email_inscription').next('span').css('visibility','visible');
        	$('#email_inscription').next('span').text('Adresse email invalide');
        	$erreur = true;
        }

        var password = $('#password_inscription').val().trim();
        //mots de passe différents
        if( $('#password_inscription').val().trim() != $('#confirmpassword_inscription').val().trim() )
        {
            $('#password_inscription').css('border', 'solid 1px red');
            $('#confirmpassword_inscription').css('border', 'solid 1px red');
            $('#confirmpassword_inscription').next('span').css('visibility', 'visible');
            $('#confirmpassword_inscription').next('span').text('Les mots de passe ne sont pas identiques');
            $erreur = true;
        }
        //criteres mot de passe
        else if (!validationmotdepasse(password))
        {
        	$('#password_inscription').css('border', 'solid 1px red');
            $('#confirmpassword_inscription').css('border', 'solid 1px red');
            $('#confirmpassword_inscription').next('span').css('visibility', 'visible');
            $('#confirmpassword_inscription').next('span').text('Les mots de passe ne respectent pas les critères');
            $erreur = true;
        }

        //soumission du formulaire
        if ($erreur==false) { $('#form_inscription').submit(); }
                
    });
});