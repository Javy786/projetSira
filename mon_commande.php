<?php

require("Inc/connect.php");
session_start();
require_once("Inc/header.php");

if (isConnected()) :
	if (!empty($_SESSION["membre"])) :
		
		if (isset($_POST["confirm"])) {
			if (!empty($_POST["confirm"])) {
				extract($_POST);
			 	$query1 = "REPLACE INTO commande (id_membre, id_vehicule, id_agence, date_heure_depart, date_heure_fin, prix_total, Date_enregistrement)
			 				VALUES (?, ?, ?, ?, ?, ?, Now())";
			 	$commande = execRequette($query1, [$id_mem, $id_veh, $id_age, $fromDate, $toDate, $prix_total]);
			 	header("Location: ".RACINE_SITE.'mon_commande.php');
		 	}
		}


		$query2 = "SELECT com.*, veh.titre AS vehicule, age.titre AS agence FROM `commande` AS com INNER JOIN agences AS age ON age.id_agence = com.id_agence INNER JOIN vehicule as veh ON veh.id_vehicule = com.id_vehicule WHERE id_membre = ?";
		$commande_client = execRequette($query2, [$_SESSION["membre"]["id_membre"]]);

		if (isset($_GET["val"]) && $_GET["val"] == "validate") {
			$query = execRequette("SELECT veh.*, age.titre AS agence FROM `agences` AS age INNER JOIN vehicule AS veh ON age.id_agence = veh.id_agence WHERE veh.id_vehicule = ?", [$_GET["id"]]);
			$commande_act = $query->fetchAll();
		}
?>


<?php if (isset($_GET["val"]) && $_GET["val"] == "validate") : ?>
	

		<div class="container-fluid d-flex justify-content-center">
			<div class="row">
				<div class="col-sm-9">
					<table class="table table-bordered table-hover">
						<thead class="thead-light">
							<tr>
								<th>Marque</th>
								<th>Modele</th>
								<th>Description</th>
								<th>Prix</th>
								<th>Agence</th>
								<th>Date debut</th>
								<th>Date fin</th>
								<th>Jour/s</th>
								<th>Prix Totale</th>
							</tr>
						</thead>
							
						<?php foreach ($commande_act as $key => $value) : ?>
							<tr>
								<td><?= $value["marque"] ?></td>
								<td><?= $value["modele"] ?></td>
								<td><?= $value["description"] ?></td>
								
								<td><?= $value["prix_journalier"] ?></td>
								<td><?= $value["agence"] ?></td>

<?php $dateNow = date("Y-m-d"); ?>

<script type="text/javascript">

	function secondDate(){
	    var date1 = document.getElementById('fromDate').value;
	    document.getElementById('toDate').min = date1;
	}

	function calculer(prix){ 
		var date1 = document.getElementById('fromDate').value;
		var date2 = document.getElementById('toDate').value;
		var fromDate = date1.replace(/-/gi, '/');
		var toDate = date2.replace(/-/gi, '/');
		
		var start = temps(fromDate.split("/"));
		var end = temps(toDate.split("/"));
		var nb = (end - start) / (1000 * 60 * 60 * 24); // + " jours";
		nb++;

		document.getElementsByClassName('res')[0].innerHTML= nb;
		document.getElementsByClassName('res')[1].innerHTML= nb;
		var tot_price = nb*prix;
		// // document.getElementById('res').innerHTML+= '<input type="submit" name="envoi" value="Confirmer">';
		document.getElementsByClassName('pr_to')[0].innerHTML = tot_price;
		document.getElementsByClassName('pr_to')[1].innerHTML = tot_price;
		document.getElementById('pt').value = tot_price;
	}


	function temps(date){
		var d = new Date(date[0], date[1] - 1, date[2]);
		return d.getTime();
	}


</script>

						<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
							<div class="form-group">
								<td><input type="date" min="<?= $dateNow ?>" value="<?= $dateNow ?>" name="fromDate" id="fromDate" class="form-control"></td>
								<td class="text-center"><input type="date" onclick="secondDate()" oninput="calculer(<?= $value["prix_journalier"] ?>), active()" min="<?= $dateNow ?>" name="toDate" id="toDate" class="form-control" required>
								<span id="appear_button1">
									<!-- <input class="btn-sm btn-secondary " type="reset" name="reset" onclick="inactive()" value="Réintialiser"> -->
								</span>
								</td>
								<td ><span class="res"></span></td>
								<td><span class="pr_to"></span></td>
							</div>
							</tr>


							<input type="hidden" name="id_mem" value="<?= $_SESSION['membre']['id_membre'] ?>">
							<input type="hidden" name="id_age" value="<?= $value["id_agence"] ?>">
							<input type="hidden" name="id_veh" value="<?= $_GET["id"] ?>">
							<input type="hidden" name="prix" value="<?= $value["prix_journalier"] ?>">
							<input type="hidden" id="pt" name="prix_total" value="">

						<?php endforeach; ?>
										
						</table>
<script >

	function active(){
		document.getElementById('appear_button1').innerHTML='<input class="btn-sm btn-secondary appear_button" type="reset" name="reset" onclick="inactive()" value="Réintialiser">';
		document.getElementById('appear_button2').innerHTML='<input data-toggle="modal" data-target="#exampleModalCentered" class="btn-lg btn-success" type="button" name="valider" value="Valider">';
		}

	function inactive(){
		document.getElementsByClassName('res')[0].innerHTML='';
		document.getElementsByClassName('pr_to')[0].innerHTML='';
		document.getElementById('appear_button2').innerHTML='';
		document.getElementById('toDate').value='';
		}

</script>
						<div class="col text-center" id="appear_button2">
							<!-- <input data-toggle="modal" data-target="#exampleModalCentered" class="btn-lg btn-success" type="button" name="valider" value="Valider"> -->
						</div>

<!-- BEGINING OF MODAL FOR THE CONFIRMATION OF THE COMMANDE ----------------------------------------------------------------------------------------------------------------------------------------->

						    <div class="modal " id="exampleModalCentered" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredLabel" aria-hidden="true">
							  <div class="modal-dialog modal-dialog-centered " role="document">
							    <div class="modal-content ">
							      <div class="modal-header ">
							        <h5 class="modal-title " id="exampleModalCenteredLabel">Confirmation du commande</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">×</span>
							        </button>
							      </div>
							      <div class="modal-body ">
									<!-- <label class="col-sm-12 text-center">Jour/s: </label> -->
									<div class="col-sm-8 offset-2 text-center">
										<table class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>Jour/s</th>
													<th>Prix</th>
												</tr>
												<tr>
													<td><span class="res"></span></td>
													<td><span class="pr_to"></span></td>
												</tr>
											</thead>
										</table>
									</div>
									<!-- <label class="col-sm-12 text-center">Prix: </span></label> -->
								  </div>
								  <div class="modal-footer d-flex justify-content-around">
							        <input type="submit" class="btn btn-success"  name="confirm" value="Confirmer">
							        <input type="reset" class="btn btn-secondary" name="cancel" value="Annuler" data-dismiss="modal">
		      					  </div>
							  	</div>
							  </div>
							</div>

<!-- END  OF MODAL FOR THE CONFIRMATION OF THE COMMANDE ----------------------------------------------------------------------------------------------------------------------------------------->

						</form>
					</div>
				<div class="col-sm-2 offset-1">
					<img src="<?= RACINE_SITE . 'utilities/img/'. $value['photo']; ?>" width="300" height="300" class="rounded width" alt="">
				</div>
			</div>
		</div>

	  <?php else : ?>
		
	  	

				<div class="container">
					<h4>Historique de Location</h4>
					<table class=" table table-bordered table-hover">
						<thead class="thead-light">
							<tr>
								<th>S.No</th>
								<th>N° Commande</th>
								<th>Vehicule</th>
								<th>Agence</th>
								<th>Date Debut</th>
								<th>Date Fin</th>
								<!-- <th>Jour/s</th> -->
								<th>Prix Totale</th>
								<th>Date_Enregistrement</th>
								<th>Status</th>
							</tr>
						</thead>

				<?php $i=1; ?>
				<?php foreach ($commande_client as $key => $value) : ?>
						
						<tr>
							<td><?= $i. "." ?></td>
							<td><?= $value["id_commande"] ?></td>
							<td><?= $value["vehicule"] ?></td>
							<td><?= $value["agence"] ?></td>
							<td><?= $value["date_heure_depart"] ?></td>
							<td><?= $value["date_heure_fin"] ?></td>
							<!-- <td></span></td> -->
							<td><?= $value["prix_total"] ?></td>
							<td><?= $value["date_enregistrement"] ?></td>
							<td>En cours</td>
						</tr>

					<?php $i++; ?>

				<?php endforeach;?>
					</table>
				</div>
	
       	 <?php
  		      endif; 
        ?>

<?php
	endif;
endif;

require_once("Inc/footer.php");
?>

