<?php
ob_start();
?>

<div class="container-fluid">

	<div class="row">
		<form id="form_inscription" class="mx-auto border border-info mt-2 p-2" action="index.php?inscription" method="post">
			<legend class="text-center border border-info text-info">Inscription</legend>

				<div class="input-group">
					<div class="input-group-prepend"><span class="input-group-text">Pseudo</span></div>
					<input id="pseudo_inscription" type="text" class="form-control input-lg" name="pseudo" maxlength="32" required>
				</div>
				<span class="help-block">Corrigez l'erreur s'il vous plait</span>
				
				<div class="input-group">
					<div class="input-group-prepend"><span class="input-group-text">Nom</span></div>
					<input type="text" id="nom_inscription" class="form-control input-lg" name="nom" maxlength="32" required>
				</div>
				<span class="help-block">Corrigez l'erreur s'il vous plait</span>

				<div class="input-group">
					<div class="input-group-prepend"><span class="input-group-text">Prenom</span></div>
					<input type="text" id="prenom_inscription" class="form-control input-lg" name="prenom" maxlength="32" required>
				</div>
				<span class="help-block">Corrigez l'erreur s'il vous plait</span>

			
				<div class="input-group">
					<div class="input-group-prepend"><span class="input-group-text">Email</span></div>
					<input type="text" id="email_inscription" class="form-control input-lg" name="email" maxlength="255" required>
				</div>
				<span id="span_email" class="help-block">Corrigez l'erreur s'il vous plait</span>

				<div class="input-group">
					<div class="input-group-prepend"><span class="input-group-text">Mot de passe*</span></div>
					<input id="password_inscription" type="password" class="form-control input-lg" name="motdepasse" maxlength="255" required>
				</div>
				<span class="help-block">Corrigez l'erreur s'il vous plait</span>
				
				<div class="input-group">
					<div class="input-group-prepend"><span class="input-group-text">Confirmation MDP</span></div>
					<input id="confirmpassword_inscription" type="password" class="form-control input-lg" name="confirm_motdepasse" maxlength="255" required>
				</div>
				<span id="span_confirm_password" class="help-block">Corrigez l'erreur s'il vous plait</span><br>
			

			<input  type="submit" id="validerinscription" class="mt-2 btn btn-outline-info btn-sm" name="validerinscription" value="Valider Inscription">
		</form>	
	</div>

	<div class="row">
		<p class="mx-auto">* 8 caractères mini, 1 lettre et 1 chiffre</p>
	</div>
</div>

<?php
$corpspage = ob_get_clean();

$titre="Inscription"; 
include ("pages/site/views/template.php");


?>