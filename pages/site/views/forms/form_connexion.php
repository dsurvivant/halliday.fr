
<?php 
ob_start();
?>
<div class="container-fluid">
	<div class="row">
		<form class="mx-auto mt-4 p-2 border border-info"  id="form_connexion" action="index.php?demandeconnexion" method="post">
			<legend class="text-center border border-info text-info">Connexion</legend>

			<div class="input-group mb-1">
				<div class="input-group-prepend"><span class="input-group-text">Pseudo</span></div>
				<input id="pseudo" type="text" class="form-control" name="pseudo" value='<?php echo $pseudo;?>' required>
			</div>
			<span id="span-pseudo" class="help-block">Corrigez l'erreur s'il vous plait</span>

			<div class="input-group mb-1">
				<div class="input-group-prepend"><span class="input-group-text">Mot de passe</span></div>
				<input id="motdepasse" type="password" class="form-control" name="motdepasse" value='<?php echo $password;?>' required>
			</div>
			<span id="span-motdepasse" class="help-block">Corrigez l'erreur s'il vous plait</span>

			<input type="submit" id="validerconnexion"class="mt-2 btn btn-outline-info btn-sm float-right" name="validerconnexion" value="Connexion">
		</form>
	</div>

	<div class="row">
		<div class="mx-auto"><a class="text-info" href="index.php?inscription">Inscription</a></div>
	</div>
</div>

<?php
$corpspage = ob_get_clean();

$titre="Connexion"; 
include ("pages/site/views/template.php");


?>
