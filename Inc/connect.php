<?php
	
// FUNCTION FOR THE CONNECTION TO THE DATABASE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

	// function connect(){
	// 	$dsn = "mysql:host=localhost;dbname=projet_sira;charset=utf8";
	// 	$user = "root";
	// 	$password = "";

	// 	try { 
	// 		$pdo = new PDO($dsn, $user, $password,
	// 		    [PDO:: ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
	// 			[PDO:: ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]); 
	// 	}catch (PDOException $e){
	// 		echo "Connection Failed " . $e->getMessage();
	// 	}
	// 	return $pdo;
	// }


	// ANOTHER METHOD TO CONNECT TO THE DATABASE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

		$dsn = "mysql:host=localhost;dbname=projet_sira;charset=utf8";
		$user = "root";
		$password = "";

		try { 
			$pdo = new PDO($dsn, $user, $password,
			    [PDO:: ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				 PDO:: ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]); 

		}catch (PDOException $e){
			echo "Connection Failed " . $e->getMessage();
		}


	//		$pdo->execute("SET NAMES utf8");

		define("RACINE_SITE", "/PHP/Projet_Sira/");
		require_once("function.php");


?>