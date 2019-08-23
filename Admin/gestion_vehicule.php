<?php /*$date = date("d_m_Y_G"); echo $date; */?>
<?php

require("../Inc/connect.php");
session_start();
require_once ('../Inc/header.php');

if (!empty($_SESSION["membre"])) :
	if(isAdmin()) :
		if (isset($_POST["submit"])) {

			if (isset($_POST['new_photo'])) {
				$nom_photo = $_POST['new_photo'];
			}
			
			if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
				if ($_FILES["photo"]["size"] <= 1000000) {
					// $nom_photo = "";
					$extension_aut = ["jpg", "jpeg", "png", "gif", "bmp"];
					$info = pathinfo($_FILES["photo"]["name"]);
					$extension_upl = $info["extension"];
					if (in_array($extension_upl, $extension_aut)) {
						$date = Date("d-m-Y");
						$nom_photo = basename($_FILES["photo"]["name"]) ."_". $_POST["titre"] ."_". $date;
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
			$query = "REPLACE INTO vehicule (id_vehicule, id_agence, titre, marque, modele, description, photo, prix_journalier)
					VALUES(?, ?, ?, ?, ?, ?, ?, ?)"; 
			$res = execRequette($query, [$id_veh, $agence_list_id, $titre, $brand, $model, $description, $nom_photo, $price]);
			header("location: " . RACINE_SITE . "Admin/gestion_vehicule.php" );
		}

?>


<?php
// CONDITION TO GET THE ID OF THE AGENCE TO LIST AS SELECT OPTION SO THAT IT CAN BE SELECTED TO DISPLAY IN THE TABLE OF VEHICULE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		// if (isset($_POST["submit"])) {
			// extract($_POST);
			$query3 = execRequette("SELECT * FROM agences", []);
			$agence_list = $query3->fetchAll();
			// header("location: " . RACINE_SITE . "Admin/gestion_vehicule.php" );
		// }


// CONDITION TO MODIFY INCASE OF MODIFICATION>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

		if (isset($_GET["mod"]) && $_GET["mod"] == "modify") {
			$query1 = execRequette("SELECT * FROM vehicule WHERE id_vehicule = ?", [$_GET["id"]]);
			$vehicule_act = $query1->fetch();
		}

// CONDITION TO DELETE INCASE OF DELETING>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

		if (isset($_GET["del"]) && $_GET["del"] == "delete") {
			$query2 = execRequette("DELETE FROM vehicule WHERE id_vehicule = ?", [$_GET["id"]]);
			// header("location: ".RACINE_SITE."Admin/gestion_vehicule.php");
		}

	?>

<br>
<br>
	<div class="container">
		<table class="table table-bordered table-hover table-responsive">
			<thead class="thead-light">
				<tr>
					<th>Vehicule</th>
					<th>Agence</th>
					<th>Titre</th>
					<th>Marque</th>
					<th>Modele</th>
					<th>Description</th>
					<th>Photo</th>
					<th>Prix</th>
					<th>Actions</th>
				</tr>
			</thead>
		
	<?php 
		$query1 = execRequette("SELECT veh.id_vehicule AS id_vehicule, age.titre AS agence, veh.titre AS titre, veh.marque AS marque, veh.modele AS modele, veh.description AS description, veh.photo AS photo, veh.prix_journalier AS prix FROM `vehicule` AS veh INNER JOIN agences as age ON age.id_agence = veh.id_agence", []);

//ANOTHER METHOD TO DEFINE A REQUEST USING * >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

		// $query1 = execRequette("SELECT age.titre AS agence, veh.* FROM `vehicule` AS veh INNER JOIN agences as age ON age.id_agence = veh.id_agence", []);

		$list_vehicule = $query1->fetchAll();
		foreach ($list_vehicule as $key => $value) : 
	?>

			<tr>
				<td><?= $value["id_vehicule"]; ?></td>
				<td><?= $value["agence"]; ?></td>
				<td><?= $value["titre"]; ?></td>
				<td><?= $value["marque"]; ?></td>
				<td><?= $value["modele"]; ?></td>
				<td><?= $value["description"]; ?></td>
				<td><img src="<?= RACINE_SITE . 'utilities/img/'. $value['photo']; ?>"  width="150" height="150" class="rounded width" alt=""></td>
				<td><?= $value["prix"]; ?></td>
				<td><a href="?mod=modify&id=<?= $value["id_vehicule"] ?>" ><i class="far fa-edit mr-2"></i></a><a href="?del=delete&id=<?= $value["id_vehicule"] ?>" ><i class="fas fa-trash-alt ml-2"></i></a></td>

			</tr>
		
	<?php endforeach; ?>

		</table>
		<br>
		<br>

	<!-- <div class="container-fluid"> -->
		<form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>" enctype="multipart/form-data" class="form-group">
			<div class="row d-flex justify-content-center">
				
				<div class="col-5 mr-5">
					<div class="form-group row">
						<select name="agence_list_id" required class="custom-select">
							<option hidden disabled selected value>...</option>
							
							<?php foreach ($agence_list as $key => $value): ?>

							<option name="id_age" value="<?= $value["id_agence"] ?>" <?= isset($vehicule_act['id_agence']) && $vehicule_act['id_agence'] ==  $value["id_agence"] ? 'selected' : ''?>><?= $value["titre"] ?></option>

							<?php endforeach; ?>

						</select>
					</div>

					<input type="hidden" name="id_veh" value="<?= isset($vehicule_act['id_vehicule']) ? $vehicule_act['id_vehicule'] : 0 ?>">

<!-- ANOTHER METHOD -->

					<!-- <input type="hidden" name="id_veh" value="<? /*= $vehicule_act['id_vehicule'] ?? 0 */?>"> -->

					<div class="form-group row">
					    <label for="inputTitre" class="col-sm-2 col-form-label">Titre:</label>
					    <input type="text" name="titre" required class="form-control"  id="inputTitre" value="<?= isset($vehicule_act['titre']) ? $vehicule_act['titre'] : '' ?>" placeholder="Titre de l'annonce">
					</div>

					<div class="form-group row">
					    <label for="inputMrq" class="col-sm-2 col-form-label">Marque:</label>
					    <input type="text" name="brand" required class="form-control"  value="<?= isset($vehicule_act['marque']) ? $vehicule_act['marque'] : '' ?>" id="inputMrq" placeholder="Marque">
					</div>

			        <div class="form-group row">
					    <label for="inputMod" class="col-sm-2 col-form-label">Modele:</label>
					    <input type="text" name="model" required class="form-control" value="<?= isset($vehicule_act['modele']) ? $vehicule_act['modele'] : '' ?>" id="inputMod" placeholder="Modele">
					</div>

			        <div class="form-group row">
					    <label for="inputPr" class="col-sm-2 col-form-label">Prix:</label>
					    <input type="text" name="price" class="form-control" value="<?= isset($vehicule_act['prix_journalier']) ? $vehicule_act['prix_journalier'] : '' ?>" id="inputPr" placeholder="Prix Journalier">
					</div>
				</div>
				<div class="col-5 ml-5">
					<div class="form-group row">
					    <label for="inputDesc" class="col-sm-2 col-form-label">Description:</label>
					    <textarea name="description" required class="form-control" id="inputDesc" placeholder="Description de votre vehicule"><?= isset($vehicule_act['description']) ? $vehicule_act['description'] : '' ?></textarea>
					</div>
					<div class="form-group row">
					    <label for="inputPic" class="col-sm-2 col-form-label">Photo:</label>
						<input type="file" name="photo" class="form-control" id="inputPic">
						
				<?php if (isset($vehicule_act["photo"])) : ?>
						
						<br><br>
						<div class="container">
						<input type="hidden" name="new_photo" class="" value="<?= isset($vehicule_act['photo']) ? $vehicule_act['photo'] : '' ?>" >
						<img src="<?= RACINE_SITE. 'utilities/img/' . $vehicule_act['photo'] ?>" alt="" width="150" height="150" class="rounded width mr-3">
						<input type="text" disabled name="" class="" value="<?= isset($vehicule_act['photo']) ? $vehicule_act['photo'] : '' ?>" size="50">

				<?php endif; ?>

						</div>
	      			</div>
			      	<div class=" d-flex justify-content-center mt-2">
			        	<input type="submit" name="submit" value="Enregistrer" class="btn btn-success mr-5">
			        	<input type="reset" name="clear" value="Réintialiser" class="btn btn-success ml-5">
			      	</div>
				</form>
			</div>
		</div>
	</div>

<?php
	endif;
endif;

require_once ('../Inc/footer.php');

?>