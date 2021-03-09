$(function()
{
	//effacement des messages d'erreur et des couleurs d'alerte
    $('#parametres .help-block').css('visibility','hidden');
    $('#parametres input').each(function()
    {
       	$(this).css('border', 'solid 1px #ccc');
    });

	$('#modifierprofil').click(function(event) {
		event.preventDefault();

		//effacement des messages d'erreur et des couleurs d'alerte
        $('#parametres .help-block').css('visibility','hidden');
        $('#parametres input').each(function()
        {
        	$(this).css('border', 'solid 1px #ccc');
        });

        //
        //vérification des champs
        //
        var $erreur = false;

        //zones blanches
        $('#form_parametres input').each(function()
        {
            if ($(this).val().trim()=='') 
            {
                $(this).css('border', 'solid 1px red');
                $(this).next('span').css('visibility','visible');
                $erreur = true;
            }
        });

        var email = $('#form_parametres #email').val().trim();
        if(!ValidateEmail(email))
        {
        	$('#form_parametres #email').css('border', 'solid 1px red');
        	$('#form_parametres #email').closest('div').next('span').css('visibility','visible');
        	$('#form_parametres #email').closest('div').next('span').css('color','red');
        	$('#form_parametres #email').closest('div').next('span').text('Adresse email invalide');
        	$erreur = true;
        }

         var password = $('#parametres #password').val().trim();
        //mots de passe différents
        if( $('#parametres #password').val().trim() != $('#parametres #confirm_password').val().trim() )
        {
            $('#parametres #password').css('border', 'solid 1px red');
            $('#parametres #confirm_password').css('border', 'solid 1px red');
            $('#parametres #confirm_password').closest('div').next('span').css('visibility', 'visible');
            $('#parametres #confirm_password').closest('div').next('span').css('color', 'red');
            $('#parametres #confirm_password').closest('div').next('span').text('Les mots de passe ne sont pas identiques');
            $erreur = true;
        }
        //criteres mot de passe
        else if (!validationmotdepasse(password) && password!='')
        {
        	$('#parametres #password').css('border', 'solid 1px red');
            $('#parametres #confirm_password').css('border', 'solid 1px red');
            $('#parametres #confirm_password').closest('div').next('span').css('visibility', 'visible');
            $('#parametres #confirm_password').closest('div').next('span').css('color', 'red');
            $('#parametres #confirm_password').closest('div').next('span').text('Les mots de passe ne respectent pas les critères');
            $erreur = true;
        }

        $.ajax({
        	url: 'index.php',
        	type: 'POST',
        	dataType: 'html',
        	data: {oldpassword: $('#parametres #old_password').val().trim()},
        })
        .done(function() {
        	
        })
        .fail(function() {
        	console.log("error");
        })
        .always(function(data) {
        	if(data!="valide" && password!='')
        	{
        		$('#parametres #old_password').css('border', 'solid 1px red');
        		$('#parametres #old_password').closest('div').next('span').css('visibility', 'visible');
            	$('#parametres #old_password').closest('div').next('span').css('color', 'red');
            	$('#parametres #old_password').closest('div').next('span').text('Ancien mot de passe non valide');
        		$erreur = true;
        	}
        	
			if($erreur==false) { $('#form_parametres').submit(); }
        });
        
       
	});
});