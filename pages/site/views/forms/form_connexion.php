
<?php 
if (!isset($email)) { $email='';}
if (!isset($password)) { $password=''; }
if (isset($_SESSION['message'])){ $message=$_SESSION['message'];}
else { $message=''; }

ob_start();
?>
<div class="container-fluid">
	<div class="row">
		<h5 class="col text-center text-danger"><?= $message ?></h5>
	</div>
	<div class="row">
		<form class="mx-auto mt-4 p-2 border border-info"  id="form_connexion" action="index.php?demandeconnexion" method="post">
			<legend class="text-center text-info">Connexion</legend>

			<div class="input-group mb-1">
				<div class="input-group-prepend"><span class="input-group-text">Email</span></div>
				<input id="email" type="text" class="form-control" name="email" value='<?php echo $email;?>' required>
			</div>
			<span id="span-pseudo" class="help-block text-danger">Corrigez l'erreur s'il vous plait</span>

			<div class="input-group mb-1">
				<div class="input-group-prepend"><span class="input-group-text">Mot de passe</span></div>
				<input id="motdepasse" type="password" class="form-control" name="motdepasse" value='<?php echo $password;?>' required>
			</div>
			<span id="forgetpassword" class="font-weight-light float-right" data-toggle="modal" data-target="#modalforgetpassword">Mot de passe oublié</span>
			<br>
			<span id="span-motdepasse" class="help-block text-danger">Corrigez l'erreur s'il vous plait</span>

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


<div class="modal fade" id="modalforgetpassword" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Titre</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
            </div>
            <div class="modal-body">
              <p>Texte du modal + choix et actions...</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
              <button type="button" class="btn btn-primary">Enregistrer</button>
            </div>
          </div>
        </div>
</div> 
