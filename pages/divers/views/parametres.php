
<div id="parametres" class="container">

	<div class="row">
		<h3 class="col-lg-12 text-center jumbotron">PARAMETRES</h3>
		<h4 class="col-lg-12 text-danger text-center" ><?= $_SESSION['message']; ?></h4>
	</div>

	<div class="row">
		<form id="form_parametres" class="col-lg-6" action="index.php?parametres&modifierprofil" method="post">

			<div id="group-pseudo" class="form-group">
				<div class="input-group">
					<span class="input-group-addon">Pseudo</span>
					<input id="pseudo" type="text" class="form-control" name="pseudo" maxlength="32" value="<?= $_SESSION['pseudo']; ?>" required >
				</div>
				<span class="help-block">Corrigez l'erreur s'il vous plait</span>
			
				<div class="input-group">
					<span class="input-group-addon">Nom</span>
					<input type="text" id="nom" class="form-control" name="nom" maxlength="32" value="<?= $_SESSION['nomutil']; ?>" required >
				</div>
				<span class="help-block">Corrigez l'erreur s'il vous plait</span>
			
				<div class="input-group">
					<span class="input-group-addon">Prénom</span>
					<input type="text" id="prenom" class="form-control" name="prenom" maxlength="32" value="<?= $_SESSION['prenomutil']; ?>" required>
				</div>
				<span class="help-block">Corrigez l'erreur s'il vous plait</span>
				
				<div class="input-group">
					<span class="input-group-addon">Email</span>
					<input type="email" id="email" class="form-control" name="email" maxlength="255" value="<?= $_SESSION['email']; ?>" required>
				</div>
				<span class="help-block">Corrigez l'erreur s'il vous plait</span>
			</div>

		</form>	

		<div class="col-lg-6">

			<div class="input-group">
				<span class="input-group-addon">Ancien mot de passe</span>
				<input form="form_parametres" id="old_password" type="password" class="form-control" name="old_password" maxlength="255">
			</div>
			<span class="help-block">Corrigez l'erreur s'il vous plait</span>
			
			<div class="input-group">
				<span class="input-group-addon">Nouveau mot de passe <span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" href="#" title="8 caractères mini, 1 lettre et 1 chiffre"></span></span>
				<input form="form_parametres" id="password" type="password" class="form-control" name="password" maxlength="255">
			</div>
			<span class="help-block">Corrigez l'erreur s'il vous plait</span>
			
			<div class="input-group">
				<span class="input-group-addon">Confirmation mot de passe</span>
				<input form="form_parametres" id="confirm_password" type="password" class="form-control" name="confirm_password" maxlength="255">
			</div>
			<span class="help-block">Corrigez l'erreur s'il vous plait</span>

		</div>
	</div>

	<div class="row text-center"><input form="form_parametres" type="submit" id="modifierprofil" class="btn btn-primary btn-sm" name="modifierprofil" value="Modifier"></div>
	

</div>