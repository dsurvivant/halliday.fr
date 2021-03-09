<div class="container">
<hr>
<form id="form_inscription" class="row" action="index.php?inscription" method="post">
	<legend>Inscription</legend>

	<div id="group-pseudo" class="form-group col-lg-6">
		<label class="control-label" for="pseudo">Pseudo</label>
		<input id="pseudo_inscription" type="text" class="form-control input-lg" name="pseudo" maxlength="32" required>
		<span class="help-block">Corrigez l'erreur s'il vous plait</span>

		<label for="nom_inscription" class="control-label">Nom</label>
		<input type="text" id="nom_inscription" class="form-control input-lg" name="nom" maxlength="32" required>
		<span class="help-block">Corrigez l'erreur s'il vous plait</span>

		<label for="prenom_inscription" class="control-label">Prénom</label>
		<input type="text" id="prenom_inscription" class="form-control input-lg" name="prenom" maxlength="32" required>
		<span class="help-block">Corrigez l'erreur s'il vous plait</span>
	</div>

	<div id="group-motdepasse" class="form-group col-lg-6">
		<label for="email_inscription" class="control-label">Adresse mail</label>
		<input type="text" id="email_inscription" class="form-control input-lg" name="email" maxlength="255" required>
		<span class="help-block">Corrigez l'erreur s'il vous plait</span>

		<label class="control-label" for="password_inscription">Mot de passe <span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" href="#" title="8 caractères mini, 1 lettre et 1 chiffre"></span></label>
		<input id="password_inscription" type="password" class="form-control input-lg" name="motdepasse" maxlength="255" required>
		<span class="help-block">Corrigez l'erreur s'il vous plait</span>

		<label class="control-label" for="confirmpassword_inscription">Confirmation Mot de passe</label>
		<input id="confirmpassword_inscription" type="password" class="form-control input-lg" name="confirm_motdepasse" maxlength="255" required>
		<span class="help-block">Corrigez l'erreur s'il vous plait</span>
	</div>

	<input type="submit" id="validerinscription" class="btn btn-primary btn-sm" name="validerinscription" value="Valider Inscription">
</form>	
<br>
</div>