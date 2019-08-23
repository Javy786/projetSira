<?php

require("../Inc/connect.php");
session_start();
require_once("../Inc/header.php");

if (isConnected()) :
	if (!empty($_SESSION["membre"])) :
		
		$query2 = "SELECT com.*, veh.titre AS vehicule, age.titre AS agence, mem.nom AS nom, mem.prenom AS prenom FROM `commande` AS com INNER JOIN agences AS age ON age.id_agence = com.id_agence INNER JOIN vehicule as veh ON veh.id_vehicule = com.id_vehicule INNER JOIN membre AS mem ON mem.id_membre = com.id_membre";
		$commande_client = execRequette($query2, []);
?>

	<?php

// CONDITION TO MODIFY INCASE OF MODIFICATION>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

		if (isset($_GET["mod"]) && $_GET["mod"] == "modify") {
			$query1 = execRequette("SELECT * FROM commande WHERE id_commande = ?", [$_GET["id"]]);
			$vehicule_act = $query1->fetch();
		}

// CONDITION TO DELETE INCASE OF DELETING>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

		if (isset($_GET["del"]) && $_GET["del"] == "delete") {
			$query2 = execRequette("DELETE FROM commande WHERE id_commande = ?", [$_GET["id"]]);
			header("location: ".RACINE_SITE."Admin/gestion_commande.php");
		}

	?>

			<?php if (isset($_GET["mod"]) && $_GET["mod"] == "modify") : ?>
				
				<div class="container-fluid">
					<h4>Gestion de commandes de membres</h4>
					<table class=" table table-bordered table-hover">
						<thead class="thead-light">
							<tr>
								<!-- <th>S.No</th> -->
								<th>N° Commande</th>
								<th>Nom et Prénom</th>
								<th>Vehicule</th>
								<th>Agence</th>
								<th>Date Debut</th>
								<th>Date Fin</th>
								<!-- <th>Jour/s</th> -->
								<th>Prix Totale</th>
								<th>Date de Réservation</th>
								<th>Action</th>
							</tr>
						</thead>

				<?php foreach ($commande_client as $key => $value) : ?>
						
						<tr>
							<!-- <td></td> -->
							<td><?= $value["id_commande"] ?></td>
							<td><?= strtoupper($value["nom"]) . " " . $value["prenom"];  ?></td>
							<td><?= $value["vehicule"] ?></td>
							<td><?= $value["agence"] ?></td>
							<td><?= $value["date_heure_depart"] ?></td>
							<td><?= $value["date_heure_fin"] ?></td>
							<!-- <td></span></td> -->
							<td><?= $value["prix_total"] ?></td>
							<td><?= $value["date_enregistrement"] ?></td>
							<td><a href="?mod=modify&id=<?= $value["id_commande"] ?>" class=""><i class="far fa-edit mr-2"></i></a><a href="?del=delete&id=<?= $value["id_commande"] ?>" ><i class="fas fa-trash-alt ml-2"></i></a></td>
						</tr>


				<?php endforeach;?>
					</table>
				</div>

			<?php else : ?>	

				<div class="container-fluid">
					<h4>Gestion de commandes de membres</h4>
					<table class=" table table-bordered table-hover">
						<thead class="thead-light">
							<tr>
								<th>S.No</th>
								<th>N° Commande</th>
								<th>Nom et Prénom</th>
								<th>Vehicule</th>
								<th>Agence</th>
								<th>Date Debut</th>
								<th>Date Fin</th>
								<!-- <th>Jour/s</th> -->
								<th>Prix Totale</th>
								<th>Date de Réservation</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
				<?php $i=1; ?>
				<?php foreach ($commande_client as $key => $value) : ?>
						
						<tr>
							<td><?= $i."." ?></td>
							<td><?= $value["id_commande"] ?></td>
							<td><?= strtoupper($value["nom"]) . " " . $value["prenom"];  ?></td>
							<td><?= $value["vehicule"] ?></td>
							<td><?= $value["agence"] ?></td>
							<td><?= $value["date_heure_depart"] ?></td>
							<td><?= $value["date_heure_fin"] ?></td>
							<!-- <td></span></td> -->
							<td><?= $value["prix_total"] ?></td>
							<td><?= $value["date_enregistrement"] ?></td>
							<td><input class="btn-sm btn-primary" type="submit" name="valid" value="Valider"></td>
							<td><a href="?mod=modify&id=<?= $value["id_commande"] ?>" class=""><i class="far fa-edit mr-2"></i></a><a href="?del=delete&id=<?= $value["id_commande"] ?>" ><i class="fas fa-trash-alt ml-2"></i></a></td>
						</tr>
						
						<?php $i++; ?>


				<?php endforeach;?>
					</table>
				</div>

			<?php endif; ?>

<?php
	endif;
endif;

require_once("../Inc/footer.php");
?>

