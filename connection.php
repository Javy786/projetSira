<?php

require("Inc/connect.php");
session_start();


// if (isset($_POST["login"]) && isset($_POST["mdp"])) {

// //EXTRACT PERMITS TO ACCESS TO $Pseudo, $nom, ... >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

// 		// extract($_POST); 
// 		$connect = execRequette("SELECT * FROM membre WHERE pseudo = ? AND mdp = ?",  [$_POST["login"], $_POST["mdp"]]);
// 		if ($connect->rowCount() != 0) {
// 			$res = $connect->fetch();
// 			$_SESSION["membre"] = $res;
// 		}else{
// 			$_SESSION["erreur"] = "<h3>Indentifiant incorrect ou Utilisateur inexistatnt</h3>";			
// 		}
// 	header("location: ".RACINE_SITE);				
	
// }


// CONDITION TO CREATE THE SESSION OF CLIENT INTO THE WEBSITE IF THE LOGIN & PWD ENTERED BY CLIENT MATCHES THE LOGIN AND PWD IN DB>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

if (isset($_POST["login"]) && isset($_POST["mdp"])) {
	extract($_POST);  //Extract permits to access to $Pseudo, $nom, ... -------------------- 
	$connect = execRequette("SELECT * FROM membre WHERE pseudo = ? AND mdp = ?",  [$login, $mdp]);
	if ($connect->rowCount() != 0) {
		$res = $connect->fetch();
		$_SESSION["membre"] = $res;
		// var_dump($res);
	}else{
		$_SESSION["erreur"] = 
							"<div class=' container text-center alert alert-danger mt-n5' role='alert' >
								<h4 class='alert-heading'>Oops!!! Erreur!</h4>
								Indentifiant incorrect ou Utilisateur inexistant
							</div>";
	}
	header("location: ".RACINE_SITE);
	// echo $_SESSION["erreur"];			
}


// CONDITION TO DECONNECT THE SESSION FROM THE WEBSITE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

if (isset($_GET["deconnect"])) {
	session_destroy();
	header("location: " .RACINE_SITE);
	exit();
}

?>
