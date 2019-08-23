<?php
session_start();
require("../Inc/connect.php");
require_once ('../Inc/header.php');

if (!empty($_SESSION["membre"])) :
	if(isAdmin()) :
		if (isset($_POST["submit"])) {
			extract($_POST);
			$query = "REPLACE INTO membre (id_membre, pseudo, mdp, nom, prenom, email, civilite, statut, date_enregistrement)
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, Now())";
			$res = execRequette($query, [$id_mem, $pseudo, $mdp, $nom, $prenom, $email, $gender, $status]);
			header("location: " . RACINE_SITE . "Admin/gestion_membre.php");
		}
?>
	<?php

// CONDITION TO MODIFY INCASE OF MODIFICATION>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

		if (isset($_GET["mod"]) && $_GET["mod"] == "modify") {
			$query1 = execRequette("SELECT * FROM membre WHERE id_membre = ?", [$_GET["id"]]);
			$membre_act = $query1->fetch();
		}

// CONDITION TO DELETE INCASE OF DELETING>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

		if (isset($_GET["del"]) && $_GET["del"] == "delete") {
			$query2 = execRequette("DELETE FROM membre WHERE id_membre = ?", [$_GET["id"]]);
			header("location: ".RACINE_SITE."Admin/gestion_membre.php");
		}

	?>

	<div class="container">
		<table class="table table-bordered table-hover table-responsive">
			<thead class="thead-light">
				<tr>
					<th>Id Membre</th>
					<th>Pseudo</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>E-mail</th>
					<th>Civilité</th>
					<th>Statut</th>
					<th>Date_Enregistrement</th>
					<th>Actions</th>
				</tr>
			</thead>
			
	<?php 
			$query2 = execRequette("SELECT * FROM membre WHERE id_membre <> ?", [$_SESSION["membre"]["id_membre"]]);
			$list_membre = $query2->fetchAll();
			foreach ($list_membre as $key => $value) : 
	?>

				<tr>
					<td><?= $value["id_membre"]; ?></td>
					<td><?= $value["pseudo"]; ?></td>
					<td><?= $value["nom"]; ?></td>
					<td><?= $value["prenom"]; ?></td>
					<td><?= $value["email"]; ?></td>
					<td><?= $value["civilite"]; ?></td>
					<td><?= $value["statut"]; ?></td>
					<td><?= $value["date_enregistrement"]; ?></td>
					<td><a href="?mod=modify&id=<?= $value["id_membre"] ?>" ><i class="far fa-edit mr-2"></i></a><a href="?del=delete&id=<?= $value["id_membre"] ?>" ><i class="fas fa-trash-alt ml-2"></i></a></td>
				</tr>
			
			<?php endforeach; ?>

		</table>
		<br>
		<br>
		<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="form-group">

	<!-- USED THE ANOTHER METHOD (?) TO DISPLAY THE VALUES IN THE INPUT WHEN MODIFY BUTTON IS CLICKED -->

			<input type="hidden" name="id_mem" value="<?= $membre_act['id_membre'] ?? 0 ?>" class="form-control" >

			<div class="form-group row">
			    <label for="inputLogin" class="col-sm-2 col-form-label">Pseudo:</label>
			    <div class="col-sm-10">

	<!-- USED THE TERNARY OPERATORS (?) TO DISPLAY THE VALUES IN THE INPUT WHEN MODIFY BUTTON IS CLICKED -->

			      <input type="text" name="pseudo" value="<?= isset($membre_act['pseudo']) ? $membre_act['pseudo'] : '' ?>" class="form-control" required id="inputLogin" placeholder="Pseudo">
			    </div>
			</div>

			<div class="form-group row">
			    <label for="inputPass" class="col-sm-2 col-form-label">Mot de Passe:</label>
			    <div class="col-sm-10">
			      <input type="text" name="mdp" value="<?= $membre_act['mdp'] ?? '' ?>" class="form-control" required id="inputPass" placeholder="Mot de Passe">
			    </div>
			</div>

	        <div class="form-group row">
			    <label for="inputNom" class="col-sm-2 col-form-label">Nom:</label>
			    <div class="col-sm-10">
			      <input type="text" name="nom" value="<?= $membre_act['nom'] ?? '' ?>" class="form-control" required id="inputNom" placeholder="Votre Nom">
			    </div>
			</div>

	        <div class="form-group row">
			    <label for="inputPrenom" class="col-sm-2 col-form-label">Prenom:</label>
			    <div class="col-sm-10">
			      <input type="text" name="prenom" value="<?= $membre_act['prenom'] ?? '' ?>" class="form-control" required id="inputPrenom" placeholder="Votre Prénom">
			    </div>
			</div>

			<div class="form-group row">
			    <label for="inputMail" class="col-sm-2 col-form-label">E-mail:</label>
			    <div class="col-sm-10">
			      <input type="email" name="email" value="<?= $membre_act['email'] ?? '' ?>" class="form-control" required id="inputMail" placeholder="Votre E-mail">
			    </div>
			</div>
			<div class="form-group row">
			    <label for="inputSex" class="col-sm-2 col-form-label">Civilité:</label>
			    <div class="col-sm-10">
			    	<select name="gender" class="custom-select custom-control" id="inputSex" required>
			    		<option value="">...</option>

	<!-- WE HAVE GIVEN THE VALUE AS M/F IN THE OPTION BECAUSE WE HAVE CREATED ENUM('M', 'F') IN THE DATABASE. IF WE GIVE ANY OTHER VALUE HERE FOR HOMME AND FEMME, YOU WILL GET A ERROR AS DATA TRUNCATED-->

	<!-- USED THE TERNARY OPERATORS (?) TO DISPLAY THE VALUES FOR HOMME & FEMME IN THE INPUT & GET SELECTED WHEN MODIFY BUTTON IS CLICKED -->
			    		
			    		<option value="m" <?= isset($membre_act['civilite']) && $membre_act['civilite'] == 'm' ? 'selected' : '' ?>>Homme</option> 
			    		<option value="f" <?= isset($membre_act['civilite']) && $membre_act['civilite'] == 'f' ? 'selected' : '' ?>>Femme</option>
			    	</select>
				</div>
			</div>
			<div class="form-group row">
			    <label for="inputStatus" class="col-sm-2 col-form-label">Statut:</label>
			    <div class="col-sm-10">
			    	<select name="status" class="custom-select custom-control" id="inputStatus" required>
			    		<option value="">...</option>
			    		<option value="admin" <?= isset($membre_act['statut']) && $membre_act['statut'] == 'admin' ? 'selected' : '' ?>>Admin</option>
			    		<option value="client" <?= isset($membre_act['statut']) && $membre_act['statut'] == 'client' ? 'selected' : '' ?>>Client</option>
			    	</select>
				</div>
			</div>
		  	<div class=" d-flex justify-content-around mt-2">
	        	<input type="submit" name="submit" value="Enregistrer" class="btn btn-success ">
	        	<input type="reset" name="clear" value="Réintialiser" class="btn btn-success ">
	      	</div>
	    </form>
	</div>

<?php
		endif; 
	endif;

require_once ('../Inc/footer.php');

?>