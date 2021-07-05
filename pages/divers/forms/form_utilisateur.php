<?php
	/**
	 * JMT
	 * FEVRIER 2021
	 */

?>
<form id="formutilisateur" method="post" action="index.php?gestionsite&noutilisateur=<?= $noutilisateur ?>">

	<div class="input-group mb-3">
        <div class="input-group-prepend"><span class="input-group-text" id="url-base">https://pierre-giraud.com/cours/</span></div>
        <input type="text" class="form-control" id="url" aria-describedby="url-base">
    </div>
    <span class="help-block" style="display: none;">Erreur</span>

	<div class="input-group mb-3">
		<div class="input-group-prepend"><span class="input-group-text">No</span></div>
		<input type="text" id="noutilisateur" class="form-control" name="noutilisateur" value="<?= $noutilisateur ?>" readonly>
	</div>

	<div class="input-group mb-3">
		<div class="input-group-prepend"><span class="input-group-text">Pseudo</span></div>
		<input type="text" id="Pseudo" class="form-control" name="pseudo" value="<?= $pseudo ?>">
	</div>
	<span class="help-block" style="display: none;">Erreur</span>
		
	<div class="input-group mb-3">
		<div class="input-group-prepend"><span class="input-group-text">Nom</span></div>
		<input type="text" id="Nom" class="form-control" name="nom" value="<?= $nom ?>">
	</div>
	<span class="help-block" style="display: none;">Erreur</span>

	<div class="input-group mb-3">
		<div class="input-group-prepend"><span class="input-group-text">Prénom</span></div>
		<input type="text" id="Prenom" class="form-control" name="prenom" value="<?= $prenom ?>">
	</div>
	<span class="help-block" style="display: none;">Erreur</span>
		
	<div class="input-group mb-3">
		<div class="input-group-prepend"><span class="input-group-text">Email</span></div>
		<input type="text" id="Email" class="form-control" name="email" value="<?= $email ?>">
	</div>
	<span class="help-block" style="display: none;">Erreur</span>
		
	<div class="input-group mb-3">
		<div class="input-group-prepend"><span class="input-group-text">Mot de passe</span></div>
		<input type="password" id="password" class="form-control" name="password" value="" placeholder="8 caractères mini, 1 lettre et 1 chiffre">
	</div>
	<span class="help-block" style="display: none;">Erreur</span>

	<div class="input-group mb-3">
		<div class="input-group-prepend"><span class="input-group-text">Confirmer mdp</span></div>
		<input type="password" id="confirmpassword" class="form-control" name="confirmpassword" value="" placeholder="8 caractères mini, 1 lettre et 1 chiffre">
	</div>
	<span class="help-block" style="display: none;">Erreur</span>

	<div class="form-group text-right">
		<button type="submit" class="btn btn-primary" name="btn_modifier" value="modifier">Modifier</button>
		<button type="submit" class="btn btn-danger" name="btn_supprimer" value="supprimer">Supprimer</button>
	</div>
</form>