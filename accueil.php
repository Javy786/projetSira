<?php

// require("index.php");
// session_start();
// require_once("Inc/header.php");


	
	$query = execRequette("SELECT age.titre AS agence, veh.* FROM `vehicule` AS veh INNER JOIN agences as age ON age.id_agence = veh.id_agence", []);
		$vehicule_list = $query->fetchAll();


// if (isConnected()) {
	// if (!empty($_SESSION["membre"])) {

// CONDITION TO SORT IN ASCENDING ORDER>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

		if (isset($_GET["asc"]) && $_GET["asc"] == "ascending") {
			$query1 = execRequette("SELECT age.titre AS agence, veh.* FROM `vehicule` AS veh INNER JOIN agences as age ON age.id_agence = veh.id_agence ORDER BY prix_journalier ASC", []);
			$vehicule_asc = $query1->fetchAll();
		}

// CONDITION TO SORT IN DESCENDING ORDER>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

		if (isset($_GET["desc"]) && $_GET["desc"] == "descending") {
			$query2 = execRequette("SELECT age.titre AS agence, veh.* FROM `vehicule` AS veh INNER JOIN agences as age ON age.id_agence = veh.id_agence ORDER BY prix_journalier DESC", []);
			$vehicule_desc = $query2->fetchAll();
		}
	// }
// }


?>


	<div class="container col-sm-12 ml-n5 mb-5 d-flex justify-content-between">
		<!-- <div class="d-flex justify-content-between"> -->

  <?php foreach ($vehicule_list as $key => $value) : ?>

			<div class="row d-flex justify-content-center">
				<div class="col-4">
					<img src="<?= RACINE_SITE . 'utilities/img/' . $value['photo']; ?>" alt="" width="150" height="150">
				</div>
			</div>

  <?php endforeach; ?>

  		<!-- </div> -->
	</div>

	<div class="container-fluid d-flex">
		<div class="offset-1 col-6">
			<div id="demo" class="carousel slide carousel-fade sticky-top" data-ride="carousel">

		  <!-- Indicators -->
			    <!-- <ul class="carousel-indicators">
				    <li data-target="#demo" data-slide-to="0" class="active"></li>
				    <li data-target="#demo" data-slide-to="1"></li>
				    <li data-target="#demo" data-slide-to="2"></li>
			  	</ul> -->
			  
			  <!-- The slideshow -->
			  	<div class="carousel-inner">

		<?php 
			$count = 0;
			foreach ($vehicule_list as $key => $value) : 
				if ($count == 0) :
		?>

				 	<div class="carousel-item active">
			     		<img src="<?= RACINE_SITE . 'utilities/img/' . $value['photo']; $count; ?>" alt="<?= $value['photo']; ?>" width="750" height="850">
			    	</div>

		  <?php else : ?>

			    	<div class="carousel-item">
			     		<img src="<?= RACINE_SITE . 'utilities/img/' . $value['photo']; $count; ?>" alt="<?= $value['photo']; ?>" width="750" height="850">
			    	</div>

		<?php 
				endif;
				$count++;
			endforeach; 
		?>

				  <!-- Left and right controls -->
				  	<a class="carousel-control-prev" href="#demo" data-slide="prev"><span class="carousel-control-prev-icon"></span></a>
				  	<a class="carousel-control-next" href="#demo" data-slide="next"><span class="carousel-control-next-icon"></span></a>
				</div>
			</div>
		</div>

			<div class="col-sm-2 d-flex-column">
				<div class="d-flex justify-content-center">
				<p ><span id="sort" style='font-size:25px;'>Prix <a href="<?= RACINE_SITE?>?asc=ascending#sort" >&#9650;</a><a href="?desc=descending#sort" >&#9660;</a></span></p>
			</div>

			<?php if (!empty($_GET["asc"])) : ?>

				<?php foreach ($vehicule_asc as $key => $value) : ?>

			<div class="mb-5">
				<div class="card text-center shadow-lg bg-light rounded">
				  <img src="<?= RACINE_SITE . 'utilities/img/' . $value['photo']; ?>" class="card-img-top" alt="Card image cap" width="150" height="250">
				  <div class="card-body bg-primary text-white">
				    <h4 class="card-title"><?= $value['titre']; ?></h4>
				    <p class="card-text">

			      	<?= $value['description']; ?><br>
					<?= $value['prix_journalier']; ?><br>
					<?= $value['agence']; ?>

				    </p>
		<?php 
			if (isConnected()) :
				if (!empty($_SESSION["membre"])) : ?>

					<a href="<?= RACINE_SITE. 'mon_commande.php' ?>?val=validate&id=<?= $value["id_vehicule"] ?>" class="text-white btn btn-success">Réserver</a>

		  <?php 
				endif; 
		    else : 
		  ?>
		  			<a href="" data-toggle="modal" data-target="#connectionModalCentered" class="text-white btn btn-success">Réserver</a>

	  <?php endif; ?>

				  </div>
				</div>
			</div>

			<?php endforeach; ?>
		<?php elseif (isset($_GET["desc"])) : ?>

			<?php foreach ($vehicule_desc as $key => $value) : ?>

			<div class="mb-5">
				<div class="card text-center shadow-lg bg-light rounded">
				  <img src="<?= RACINE_SITE . 'utilities/img/' . $value['photo']; ?>" class="card-img-top" alt="Card image cap" width="150" height="250">
				  <div class="card-body bg-primary text-white">
				    <h4 class="card-title"><?= $value['titre']; ?></h4>
				    <p class="card-text">

			      	<?= $value['description']; ?><br>
					<?= $value['prix_journalier']; ?><br>
					<?= $value['agence']; ?>

				    </p>
		<?php 
			if (isConnected()) :
				if (!empty($_SESSION["membre"])) : ?>

					<a href="<?= RACINE_SITE. 'mon_commande.php' ?>?val=validate&id=<?= $value["id_vehicule"] ?>" class="text-white btn btn-success">Réserver</a>

		  <?php 
				endif; 
		    else : 
		  ?>
		  			<a href="" data-toggle="modal" data-target="#connectionModalCentered" class="text-white btn btn-success">Réserver</a>

	  <?php endif; ?>
	  
				  </div>
				</div>
			</div>

			<?php endforeach; ?>
		<?php else : ?>

		<?php foreach ($vehicule_list as $key => $value) : ?>

			<div class="mb-5">
				<div class="card text-center shadow-lg bg-light rounded">
				  <img src="<?= RACINE_SITE . 'utilities/img/' . $value['photo']; ?>" class="card-img-top" alt="Card image cap" width="150" height="250">
				  <div class="card-body bg-primary text-white">
				    <h4 class="card-title"><?= $value['titre']; ?></h4>
				    <p class="card-text">

			      	<?= $value['description']; ?><br>
					<?= $value['prix_journalier']; ?><br>
					<?= $value['agence']; ?>

				    </p>
		<?php 
			if (isConnected()) :
				if (!empty($_SESSION["membre"])) : ?>

					<a href="<?= RACINE_SITE. 'mon_commande.php' ?>?val=validate&id=<?= $value["id_vehicule"] ?>" class="text-white btn btn-success">Réserver</a>

		  <?php 
				endif; 
		    else : 
		  ?>
		  			<a href="" data-toggle="modal" data-target="#connectionModalCentered" class="text-white btn btn-success">Réserver</a>

	  <?php endif; ?>
				  </div>
				</div>
			</div>

		<?php endforeach; ?>
			<?php endif; ?>

		</div>
	</div>


<?php
// 	endif;
// endif;

require_once("Inc/footer.php");
?>