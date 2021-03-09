<div class="container">
	<div class="row">
		<br>
		<form class="col-md-6 col-md-push-3" id="form_connexion" action="index.php?demandeconnexion" method="post">
			<legend>Déjà Membre, je m'identifie</legend>

			<div id="group-pseudo" class="form-group">
				<label class="control-label" for="pseudo">Pseudo</label>
				<input id="pseudo" type="text" class="form-control" name="pseudo" value='<?php echo $pseudo;?>' required>
				<span id="span-pseudo" class="help-block">Corrigez l'erreur s'il vous plait</span>
			</div>

			<div id="group-motdepasse" class="form-group">
				<label class="control-label" for="motdepasse">Mot de passe</label>
				<input id="motdepasse" type="password" class="form-control" name="motdepasse" value='<?php echo $password;?>' required>
				<span id="span-motdepasse" class="help-block">Corrigez l'erreur s'il vous plait</span>
			</div>

			<input type="submit" id="validerconnexion" class="btn btn-primary btn-sm" name="validerconnexion" value="Connexion">
		</form>
	</div>

	<div class="row">
		<a class="col-md-6 col-md-push-3" href="index.php?inscription" style="float: right;">Inscription</a>
	</div>
</div>