<?php
	if (isset($_GET['log'])) { $email=$_GET['log']; }
	else { $email=''; }
?>

<div class="container-fluid">
	<div class="row">
		<span id="spanerror" class="text-danger mx-auto mt-3"></span>
	</div>

	<div class="row">
		<form id="formforgetpassword" class="mx-auto mt-3 p-2 border border-info" method="post" action="index.php?forgetpassword&email=<?= $email; ?>">
			<legend class="text-center text-info">Nouveau Mot de passe</legend>

			<div class="input-group mb-4 mt-4">
				<div class="input-group-prepend"><span class="input-group-text">Mot de passe</span></div>
				<input id="password" type="password" class="form-control" name="password" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" required>
			</div>

			<div class="input-group mb-1">
				<div class="input-group-prepend"><span class="input-group-text">Confirmer</span></div>
				<input id="confirmpassword" type="password" class="form-control" name="confirmpassword" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" required>
			</div>
			<span id="forgetpassword" class="font-weight-light float-right" data-toggle="modal" data-target="#modalforgetpassword">8 caractères mini, 1 lettre et 1 chiffre</span>
			<br>

			<input type="submit" id="validernewpassword" class="mt-4 btn btn-outline-info btn-sm float-right" value="Valider">
		</form>
	</div>

</div>