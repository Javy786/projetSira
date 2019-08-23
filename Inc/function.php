<?php

//FUNCTION FOR THE PREPARE AND EXECUTE>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

function execRequette($req, $params = array()){

//GLOBALISATION OF THE VARIABLE PDO>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

	global $pdo;
	$stmt = $pdo->prepare($req);

	if (!empty($params)) {
		foreach ($params as $key => $value) {
			$params[$key] = htmlspecialchars($value);
		}
	}
	$stmt->execute($params);
	return $stmt;
}



//FUNCTION TO CHECK WHETHER CLIENT/ADMIN CONNECTED TO WEBSITE OR NOT>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

function isConnected() {
    if(isset($_SESSION['membre']))
        return true;
    return false;
}

function isAdmin(){
    if(isConnected() && $_SESSION['membre']['statut'] == "admin")
        return true;
    return false;
}


?>