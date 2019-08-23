<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	    <title>Projet Sira</title>
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	    <link href="<?= RACINE_SITE . 'Utilities/css/style.css' ?>" rel="stylesheet" type="text/css">
	    

	    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="https://kit.fontawesome.com/11f16c82d4.js"></script>
		

		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>  
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">  
   

	</head>
	<body>
		<header class="">
			<div class="mb-5 paddingTitle">
				<h1 class="text-center text-white ">Bienvenue à Bord</h1>
				<h3 class="text-center text-white ">Location de véhicule 24h/24 7j/7</h3>
				
				<?php if(isConnected()) : ?>
					
					<div class=" text-center text-white ">Bonjour <?= $_SESSION["membre"]["nom"] ." ". $_SESSION["membre"]["prenom"]; ?></div>

					<div class="container ">
					<nav class="col-12">
						<ul class="nav nav-pills d-flex justify-content-between">
	                    	<li class=""><a class="nav-link btn btn-info" href="<?= RACINE_SITE ?>">Accueil</a></li>
                            <li><a class="nav-link btn btn-info" href="<?= RACINE_SITE.'mon_compte.php' ?>">Mon Compte</a></li>
                            <li><a class="nav-link btn btn-info " href="<?= RACINE_SITE.'mon_commande.php' ?>">Mes Locations</a></li>

                    <?php if(isConnected() && $_SESSION["membre"]["statut"] == "admin") : ?>
                            
                            <li><a class="nav-link btn btn-primary " href="<?= RACINE_SITE.'Admin/gestion_membre.php' ?>">Membre</a></li>
                            <li><a class="nav-link btn btn-primary " href="<?= RACINE_SITE.'Admin/gestion_agence.php' ?>">Agence</a></li>
                            <li><a class="nav-link btn btn-primary " href="<?= RACINE_SITE.'Admin/gestion_vehicule.php' ?>">Véhicule</a></li>
                            <li><a class="nav-link btn btn-primary " href="<?= RACINE_SITE.'Admin/gestion_commande.php' ?>">Commandes</a></li>
                    <?php endif; ?>
                            <li class=""><a class="nav-link btn btn-danger" href="<?= RACINE_SITE . 'connection.php?deconnect=logout' ?>">se déconnecter</a></li>
                    	</ul>
                    </nav>
                </div>
                
				<?php else : ?>

				<div class="container">
					<nav class="mt-5  mb-5 col-6 offset-3">
						<ul class="nav nav-pills d-flex justify-content-around">
		                    <li class="nav-item ml-5">
		                        <a class="nav-link btn btn-success" data-toggle="modal" data-target="#inscriptionModalCentered" href="">Inscription</a>
	                        
	<!-- BEGINING OF MODAL FOR THE INSCRIPTION ----------------------------------------------------------------------------------------------------------------------------------------->

		                        <div class="modal " id="inscriptionModalCentered" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredLabel" aria-hidden="true">
								  <div class="modal-dialog modal-dialog-centered " role="document">
								    <div class="modal-content ">
								      <div class="modal-header ">
								        <h5 class="modal-title " id="exampleModalCenteredLabel">Inscription</h5>
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <span aria-hidden="true">×</span>
								        </button>
								      </div>
								      <div class="modal-body ">

	<!-- BEGINING OF FORM FOR THE INSCRIPTION ------------------------------------------------------------------------------------------------------------------------------------------------>								      									
										<form method="POST" action="<?= RACINE_SITE .'inscription.php'?>" class="form-group">
							                <div class="container">
								                <div class="form-group row">
												    <!-- <label for="inputNom" class="col-sm-2 col-form-label">Nom:</label> -->
												    <div class="input-group mb-1">
													    <div class="input-group-prepend">
													      <span class="input-group-text"><i class="fas fa-user"></i></span>
													    </div>
												      	<input type="text" name="nom" required class="form-control" required autofocus id="inputNom" placeholder="Nom">
												    </div>
												</div>

								                <div class="form-group row">
												    <!-- <label for="inputPrenom" class="col-sm-2 col-form-label">Prenom:</label> -->
												    <div class="input-group mb-1">
													    <div class="input-group-prepend">
													      <span class="input-group-text"><i class="fas fa-user"></i></span>
													    </div>  
												      	<input type="text" name="prenom" class="form-control" required id="inputPrenom" placeholder="Prénom">
												    </div>
												</div>

												<div class="form-group row">
												    <!-- <label for="inputMail" class="col-sm-2 col-form-label">E-mail:</label> -->
												    <div class="input-group mb-1">
													    <div class="input-group-prepend">
													      <span class="input-group-text"><i class="fas fa-envelope"></i></span>
													    </div>
												      	<input type="email" name="email" required class="form-control" required id="inputMail" placeholder="E-mail">
												    </div>
												</div>


												<div class="form-group row">
												    <!-- <label for="inputLogin" class="col-sm-2 col-form-label">Pseudo:</label> -->
												    <div class="input-group mb-1">
													    <div class="input-group-prepend">
													      <span class="input-group-text"><i class="fas fa-user"></i></span>
													    </div>
												      	<input type="text" name="pseudo" required class="form-control" required id="inputLogin" placeholder="Pseudo">
												    </div>
												</div>

												<div class="form-group row">
												    <!-- <label for="inputPass" class="col-sm-2 col-form-label">Mot de Passe:</label> -->
												    <div class="input-group mb-1">
													    <div class="input-group-prepend">
													      <span class="input-group-text"><i class="fas fa-lock"></i></span>
													    </div>
												      	<input type="password" name="mdp" required class="form-control" required id="inputPass" placeholder="Mot de Passe">
												    </div>
												</div>

												<div class="form-group row">
												    <label class="col-sm-2 col-form-label">Civilité:</label>
												    <div class="col-sm-10">
													    <div class=" custom-control custom-radio">  
												            <input type="radio" name="gender" value="m" id="male" class="custom-control-input " required>
													      	<label for="male" class="custom-control-label">Homme</label>
												        </div>
												        <div class="custom-control custom-radio">
												            <input type="radio" name="gender" value="f" id="female" class="custom-control-input" required>
												        	<label for="female" class="custom-control-label">Femme</label>
													    </div>
													</div>
													<div class="d-flex justify-content-end">
														<a href="" class="" data-toggle="modal" data-target="#connectionModalCentered" class="close" data-dismiss="modal">Êtes-vous déjà inscrit?</a>
													</div>
												</div>
												<hr>
											  	<div class=" d-flex justify-content-around mt-2">
										        	<input type="submit" name="inscrire" value="Inscrire" class="btn btn-success ">
										        	<input type="reset" name="clear" value="Réintialiser" class="btn btn-success ">
										      	</div>
										    </div>
									    </form>  

	<!-- END OF FORM FOR THE INSCRIPTION ------------------------------------------------------------------------------------------------------------------------------------------------>					
								      </div>
								    </div>
								  </div>
								</div>

	<!-- END  OF MODAL FOR THE INSCRIPTION ----------------------------------------------------------------------------------------------------------------------------------------->

		                    </li>
		                    <li class="nav-item mr-5 mb-5">
		                        <a class="nav-link btn btn-success" data-toggle="modal" data-target="#connectionModalCentered" href="#">Connection</a>

	<!-- BEGINING OF MODAL FOR THE INSCRIPTION ----------------------------------------------------------------------------------------------------------------------------------------->

		                        <div class="modal " id="connectionModalCentered" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredLabel" aria-hidden="true">
								  <div class="modal-dialog modal-dialog-centered " role="document">
								    <div class="modal-content ">
								      <div class="modal-header ">
								        <h5 class="modal-title " id="exampleModalCenteredLabel">Connection</h5>
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <span aria-hidden="true">×</span>
								        </button>
								      </div>
								      <div class="modal-body text-center">

	<!-- BEGINING OF FORM FOR THE INSCRIPTION ------------------------------------------------------------------------------------------------------------------------------------------------>								      	
								      	<form method="post" action="<?= RACINE_SITE .'connection.php'?>">
								        	<div class="container">
									        	<div class="form-group row">
											    <!-- <label for="inputLogin" class="col-sm-2 col-form-label">Login :</label> -->
											    	<div class="input-group mb-1">
													    <div class="input-group-prepend">
													      <span class="input-group-text"><i class="fas fa-user"></i></span>
													    </div>
													    <input type="text" name="login" class="form-control" id="inputLogin" placeholder="Login" required autofocus>
													 </div>
												</div>
												<div class="form-group row">
												<!-- <label for="inputPass" class="col-sm-2 col-form-label">Mot de Passe :</label> -->
												    <div class="input-group mb-1">
													    <div class="input-group-prepend">
													      <span class="input-group-text"><i class="fas fa-lock"></i></span>
													    </div>
													    <input type="password" name="mdp" class="form-control" id="inputPass" placeholder="Mot de Passe" required>
													</div>
												    <a href="" class="" data-toggle="modal" data-target="#inscriptionModalCentered" class="close" data-dismiss="modal">Pas un membre? S'inscrire</a>
												</div>
												<hr>
											  	<div class=" d-flex justify-content-around mt-2">
										        	<input type="submit" name="connect" value="Connecter" class="btn btn-success ">
										        	<input type="reset" name="clear" value="Réintialiser" class="btn btn-success ">
										      	</div>
										    </div>
								        </form>
									        
	<!-- END OF FORM FOR THE INSCRIPTION ------------------------------------------------------------------------------------------------------------------------------------------------>
	
									  </div>
								    </div>
								  </div>
								</div>
		                    </li>
		                </ul>
					</nav>
				</div>

			<?php endif; ?>
			
			</div>
		</header>
		<main>

			<?php

			if (isset($_SESSION["erreur"])) {
				echo $_SESSION["erreur"];
				unset($_SESSION["erreur"]);
			}
			if (isset($_SESSION["inscription"])) {
				echo $_SESSION["inscription"];
				unset($_SESSION["inscription"]);
			}

			?>
			


