<?php

require("Inc/connect.php");


if (isset($_POST["inscrire"])) {
	 if (!empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["email"]) && !empty($_POST["pseudo"]) && !empty($_POST["mdp"]) && !empty($_POST["gender"])) {

//EXTRACT PERMITS TO ACCESS TO $Pseudo, $nom, ... >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

		extract($_POST); 
		$logExist = execRequette("SELECT * FROM membre WHERE pseudo = :login", ["login" => $pseudo]);
		if ($logExist->rowCount() != 0) {
			echo "<div class='text-centre'> Ce login existe déjà</div>";

		}else{
			$query = "REPLACE INTO membre (pseudo, mdp, nom, prenom, email, civilite, statut, date_enregistrement)
					  VALUES (:login, :pass, :nome, :prenome, :mail, :sex, 'client', Now())";
			$res = execRequette($query, 
							array("login" => $pseudo,
								  "pass" => $mdp,
								  "nome" => $nom,
								  "prenome" => $prenom,
								  "mail" => $email,
								  "sex" => $gender));
		header("location: ".RACINE_SITE);				
		}
	 }
}

?>