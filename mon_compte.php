<?php
session_start();

require ('Inc/connect.php');

// PLACED THIS IF CONDITION BEFORE HEADER TO HAVE THE UPDATE EVEN IN THE HEADER AFTER MODIFYING THE USER ACCOUNT DETAILS>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

if (!empty($_POST["save"])) {
			extract($_POST);
			// session_destroy();
			$query3 = "REPLACE INTO membre (id_membre, pseudo, mdp, nom, prenom, email)
					  VALUES (?, ?, ?, ?, ?, ?)";
			$result = execRequette($query3, [$id_mem, $pseudo, $mdp, $nom, $prenom, $email]);
			$_SESSION['membre']['prenom']=$prenom;
			$_SESSION['membre']['nom']=$nom;
			$_SESSION['membre']['pseudo']=$pseudo;
			$_SESSION['membre']['mdp']=$mdp;
			$_SESSION['membre']['email']=$email;
			// header("location: ".RACINE_SITE."mon_compte.php");
}

require_once ('Inc/header.php');

if (!empty($_SESSION["membre"])) :
	if(isConnected()) : 
		
?>

	<?php

		if (isset($_GET["mod"]) && $_GET["mod"] == "modify") {
			$query1 = execRequette("SELECT * FROM membre WHERE id_membre = ?", [$_GET["id"]]);
			$member_session_act = $query1->fetch();
		}


		if (isset($_GET["del"]) && $_GET["del"] == "delete") {
			$query2 = execRequette("DELETE FROM membre WHERE id_membre = ?", [$_GET["id"]]);
			session_destroy();
			header("location: ".RACINE_SITE);
			exit();
			// echo "Votre compte a été supprimé";
			// echo "Au revoir et à bientôt";
		}
	
	?>


  <?php if (!isset($_GET["mod"]) || $_GET["mod"] != "modify") : ?>

		<div class="compte">
			<h4 class="text-center">Mon compte</h4>
			<div class="container ">
				<table class="table-borderless table-hover mb-3 col-6 offset-4">
					<tr class="">
						<td>Nom</td>
						<td>:</td>
						<td><?= $_SESSION["membre"]["nom"]; ?></td>
					</tr>
					<tr>
						<td>Prénom</td>
						<td>:</td>
						<td><?= $_SESSION["membre"]["prenom"]; ?></td>
					</tr>
					<tr>
						<td>Pseudo</td>
						<td>:</td>
						<td><?= $_SESSION["membre"]["pseudo"]; ?></td>
					</tr>
					<tr>
						<td>Mot de Passe</td>
						<td>:</td>
						<td><?= $_SESSION["membre"]["mdp"]; ?></td>
					</tr>
					<tr>
						<td>E-mail</td>
						<td>:</td>
						<td><?= $_SESSION["membre"]["email"]; ?></td>
					</tr>
				</table>
			</div>
			<div class=" d-flex justify-content-center mt-2 mb-5">
				<a href="?mod=modify&id=<?= $_SESSION["membre"]["id_membre"] ?>" class="btn btn-warning mr-5">Modifier le compte</a>

				<!-- <input class="btn btn-warning mr-5" type="submit" name="" value="Modifier le compte"> -->

				<input data-toggle="modal" data-target="#exampleModalCentered" class="btn btn-danger ml-5" type="submit" name="delete" value="Supprimer le compte">
			</div>
		</div>
		                        
<!-- BEGINING OF MODAL FOR THE DELETION OF ACCOUNT ----------------------------------------------------------------------------------------------------------------------------------------->

	    <div class="modal " id="exampleModalCentered" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered " role="document">
		    <div class="modal-content ">
		      <div class="modal-header ">
		        <h5 class="modal-title " id="exampleModalCenteredLabel">Suppression du compte</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">×</span>
		        </button>
		      </div>
		      <div class="modal-body ">
				
		<?php if ($_SESSION['membre']['statut'] <> "admin") : ?>

				<label class="col-sm-12 text-center">Êtes-vous sûr de vouloir supprimer votre compte?</label>

		<?php else : ?>

				<label class="col-sm-12 text-center">Vous êtes un "Administrateur". Vous ne pouvez pas supprimer votre compte</label>

		<?php endif; ?>


			  </div>
			  <div class="modal-footer d-flex justify-content-around">

			<!-- <input type="submit" name="delete" value="Delete" class="btn btn-danger "> -->

		<?php if ($_SESSION['membre']['statut'] <> "admin") : ?>

				<a href="?del=delete&id=<?= $_SESSION["membre"]["id_membre"] ?? 0?>" class="btn btn-danger " >Supprimer</a>

		<?php endif; ?>

		        <input type="button" name="cancel" value="Annuler" class="btn btn-secondary" data-dismiss="modal">
		      </div>
		  	</div>
		  </div>
		</div>

<!-- END  OF MODAL FOR THE DELETION OF ACCOUNT ----------------------------------------------------------------------------------------------------------------------------------------->
	
  <?php else : ?>
  		<div class="compte">
			<h4 class="text-center">Mon compte</h4>
			<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>" class="form-group">
				<div class="container ">
					<table class="table-borderless table-hover mb-3 col-6 offset-4">
						<input type="text" name="id_mem" value="<?= $member_session_act['id_membre']; ?>">
						<tr class="">
							<td>Nom</td>
							<td>:</td>
							<td><input type="text" name="nom" value="<?= $member_session_act['nom']; ?>"></td>
						</tr>
						<tr>
							<td>Prénom</td>
							<td>:</td>
							<td><input type="text" name="prenom" value="<?= $member_session_act['prenom']; ?>"></td>
						</tr>
						<tr>
							<td>Pseudo</td>
							<td>:</td>
							<td><input type="text" name="pseudo" value="<?= $member_session_act['pseudo']; ?>"></td>
						</tr>
						<tr>
							<td>Mot de Passe</td>
							<td>:</td>
							<td><input type="text" name="mdp" value="<?= $member_session_act['mdp']; ?>"></td>
						</tr>
						<tr>
							<td>E-mail</td>
							<td>:</td>
							<td><input type="text" name="email" value="<?= $member_session_act['email']; ?>"></td>
						</tr>
					</table>
				</div>
				<div class=" d-flex justify-content-center mt-2 mb-5">
					<input class="btn btn-success mr-5" type="submit" name="save" value="Enregistrer">
					<a href="<?= RACINE_SITE . 'mon_compte.php' ?>" class="btn btn-secondary ml-5" name="cancel">Annuler</a>
				</div>
			</form>
		</div>

  <?php endif; ?>


<?php 
	endif;  
endif;

require_once ('Inc/footer.php');

?>
