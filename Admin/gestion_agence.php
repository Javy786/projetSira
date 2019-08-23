<?php

require("../Inc/connect.php");
session_start();
require_once('../Inc/header.php');

if (!empty($_SESSION["membre"])) :
	if(isAdmin()) :
		if (isset($_POST["submit"])) {
			
			if (isset($_POST['new_photo'])) {
				$nom_photo = $_POST['new_photo'];
			}

			if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
				if ($_FILES["photo"]["size"] <= 1000000) {
					$nom_photo = "";
					$extension_aut = ["jpg", "jpeg", "png", "gif", "bmp"];
					$info = pathinfo($_FILES["photo"]["name"]);
					$extension_upl = $info["extension"];
					if (in_array($extension_upl, $extension_aut)) {
						$nom_photo = $_POST["titre"] ."_". basename($_FILES["photo"]["name"]);
						$root = $_SERVER["DOCUMENT_ROOT"].RACINE_SITE."utilities/img";
						move_uploaded_file($_FILES["photo"]["tmp_name"], $root .'/'. $nom_photo);
					}else {
						echo "Cette extension n'est pas autorisée";
					}
				}else {
					echo "Cette fichier est trop volumuneux";
				}
			}

			extract($_POST);
			$query = "REPLACE INTO agences (id_agence, titre, adresse, ville, cp, description, photo)
					  VALUES(?, ?, ?, ?, ?, ?, ?)"; 
			$res = execRequette($query, [$id_age, $titre, $address, $ville, $cp, $description, $nom_photo]);
			header("location: " . RACINE_SITE . "Admin/gestion_agence.php" );
		}

?>

	<?php

// CONDITION TO MODIFY INCASE OF MODIFICATION>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

		if (isset($_GET["mod"]) && $_GET["mod"] == "modify") {
			$query1 = execRequette("SELECT * FROM agences WHERE id_agence = ?", [$_GET["id"]]);
			$agence_act = $query1->fetch();
		}

// CONDITION TO DELETE INCASE OF DELETING>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

		if (isset($_GET["del"]) && $_GET["del"] == "delete") {
			$query2 = execRequette("DELETE FROM agences WHERE id_agence = ?", [$_GET["id"]]);
			header("location: ".RACINE_SITE."Admin/gestion_agence.php");
		}

	?>


<br>
<br>
	<div class="container">
		<table class="table table-bordered table-hover table-responsive">
			<thead class="thead-light">
				<tr>
					<th>Id Agence</th>
					<th>Titre</th>
					<th>Adresse</th>
					<th>Ville</th>
					<th>Code Postale</th>
					<th>Description</th>
					<th>Photo</th>
					<th>Actions</th>
				</tr>
			</thead>
		
	<?php 
		$query1 = execRequette("SELECT * FROM agences", []);
		$list_agence = $query1->fetchAll();
		foreach ($list_agence as $key => $value) : 
	?>

		<tr>
			<td><?= $value["id_agence"]; ?></td>
			<td><?= $value["titre"]; ?></td>
			<td><?= $value["adresse"]; ?></td>
			<td><?= $value["ville"]; ?></td>
			<td><?= $value["cp"]; ?></td>
			<td><?= $value["description"]; ?></td>
			<td><img src="<?= RACINE_SITE . 'utilities/img/'. $value['photo']; ?>" width="150" height="150" class="rounded width" alt=""></td>
			<td><a href="?mod=modify&id=<?= $value["id_agence"] ?>" class=""><i class="far fa-edit mr-2"></i></a><a href="?del=delete&id=<?= $value["id_agence"] ?>" ><i class="fas fa-trash-alt ml-2"></i></a></td>
		</tr>
		
	<?php endforeach; ?>

	</table>
	<br>
	<br>

	<!-- <div class="container"> -->
		<form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>" enctype="multipart/form-data" class="form-group">
			<input type="hidden" name="id_age" value="<?= $agence_act["id_agence"] ?? 0 ?>">
			<div class="form-group row">
			    <label for="inputTitre" class="col-sm-2 col-form-label">Titre:</label>
			    <div class="col-sm-10">
			      <input type="text" name="titre" value="<?= isset($agence_act['titre']) ? $agence_act['titre'] : '' ?>" class="form-control" required id="inputTitre" placeholder="Titre de l'agence">
			    </div>
			</div>

			<div class="form-group row">
			    <label for="inputAdr" class="col-sm-2 col-form-label">Adresse:</label>
			    <div class="col-sm-10">
			      <input type="text" name="address" value="<?= isset($agence_act['adresse']) ? $agence_act['adresse'] : '' ?>" class="form-control" required id="inputAdr" placeholder="Adresse">
			    </div>
			</div>

	        <div class="form-group row">
			    <label for="inputCity" class="col-sm-2 col-form-label">Ville:</label>
			    <div class="col-sm-10">
			      <input type="text" name="ville" value="<?= isset($agence_act['ville']) ? $agence_act['ville'] : '' ?>" class="form-control" required id="inputCity" placeholder="Ville">
			    </div>
			</div>

	        <div class="form-group row">
			    <label for="inputCp" class="col-sm-2 col-form-label">Code Postale:</label>
			    <div class="col-sm-10">
			      <input type="text" name="cp" value="<?= isset($agence_act['cp']) ? $agence_act['cp'] : '' ?>" class="form-control" required id="inputCp" placeholder="Code Postale">
			    </div>
			</div>

			<div class="form-group row">
			    <label for="inputDesc" class="col-sm-2 col-form-label">Description:</label>
			    <div class="col-sm-10">
			      <textarea name="description" required value="" class="form-control" id="inputDesc" placeholder="Description de votre agence"><?= isset($agence_act['description']) ? $agence_act['description'] : '' ?></textarea>
			    </div>
			</div>
			<div class="form-group row">
			    <label for="inputPic" class="col-sm-2 col-form-label">Photo:</label>
			    <div class="col-sm-4">
					<input type="file" name="photo" value="" class="form-control" id="inputPic">
					
				<?php if(isset($agence_act['photo'])) : ?>
					
					<br>
					<img src="<?= RACINE_SITE . 'utilities/img/'. $agence_act['photo']??''?>" width="150" height="150" class="rounded width " alt="">
					<input type="hidden" name="new_photo" class="" value="<?= $agence_act['photo']; ?>" size="55">
					
				<?php endif; ?>

				</div>
			</div>
		  	<div class=" d-flex justify-content-center mt-2">
	        	<input type="submit" name="submit" value="Enregistrer" class="btn btn-success mr-5">
	        	<input type="reset" name="clear" value="Réintialiser" class="btn btn-success ml-5">
	      	</div>
	    </form>
	</div>

<?php
	endif;
endif;

require_once ('../Inc/footer.php');

?>