
<?php

if(isset($_SESSION['noutil'])) //déjà connecté
{
	?><br><p class="jumbotron">Mais.. Dites moi.. Vous êtes déjà connecté !</p><?php
}
else
{
		$erreur=false;
		if($pseudo!='') {$erreur=true;}
	?>

	<div class="container">
	
		<div class="row">
			<?php if($erreur){$visible="visible";}else{$visible="hidden";}?>
			<h1 id="erreur_saisis" class="col-lg-12" style="visibility: <?php echo $visible; ?> ">Pseudo ou Mot de passe invalide</h1>
		</div>

		<br>

		<div class="row">
			<div class="col-lg-6 col-xs-12">
				<!-- FORMULAIRE DE CONNEXION DEJA MEMBRE -->
				<?php require ('pages/site/views/forms/form_connexion.php')?>
				<a href="index.php?inscription" style="float: right;">Inscription</a>
			</div>
		</div>

	</div>
<?php
}
?>



	