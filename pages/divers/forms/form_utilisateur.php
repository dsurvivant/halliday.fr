<?php
	/**
	 * JMT
	 * FEVRIER 2021
	 */

?>
<form id="formutilisateur" method="post" action="index.php?gestionsite&noutilisateur=<?= $noutilisateur ?>" class="form">

	<div class="form-group">
		<div class="input-group">
			<span class="input-group-addon">No Utilisateur</span>
			<input type="text" id="noutilisateur" class="form-control" name="noutilisateur" value="<?= $noutilisateur ?>" readonly>
		</div>
		<span class="help-block" style="display: none;">Erreur</span>
		<br>

		<div class="input-group">
			<span class="input-group-addon">Pseudo</span>
			<input type="text" id="Pseudo" class="form-control" name="pseudo" value="<?= $pseudo ?>">
		</div>
		<span class="help-block" style="display: none;">Erreur</span>
		<br>

		<div class="input-group">
			<span class="input-group-addon">Nom</span>
			<input type="text" id="Nom" class="form-control" name="nom" value="<?= $nom ?>">
		</div>
		<span class="help-block" style="display: none;">Erreur</span>
		<br>

		<div class="input-group">
			<span class="input-group-addon">Prenom</span>
			<input type="text" id="Prenom" class="form-control" name="prenom" value="<?= $prenom ?>">
		</div>
		<span class="help-block" style="display: none;">Erreur</span>
		<br>

		<div class="input-group">
			<span class="input-group-addon">Email</span>
			<input type="text" id="Email" class="form-control" name="email" value="<?= $email ?>">
		</div>
		<span class="help-block" style="display: none;">Erreur</span>
		<br>

		<div class="input-group">
			<span class="input-group-addon">Mot de passe <span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" href="#" title="8 caractères mini, 1 lettre et 1 chiffre"></span></span>
			<input type="password" id="password" class="form-control" name="password" value="">
		</div>
		<span class="help-block" style="display: none;">Erreur</span>
		<br>

		<div class="input-group">
			<span class="input-group-addon">Confirmer Mot de passe</span>
			<input type="password" id="confirmpassword" class="form-control" name="confirmpassword" value="">
		</div>
		<span class="help-block" style="display: none;">Erreur</span>
	</div>

	<div class="form-group text-right">
		<button type="submit" class="btn btn-primary" name="btn_modifier" value="modifier">Modifier</button>
		<button type="submit" class="btn btn-danger" name="btn_supprimer" value="supprimer">Supprimer</button>

	</div>
</form>