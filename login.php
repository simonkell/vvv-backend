<?php
	include("controllers/MasterController.php"); // init, settings, etc
	$master = new MasterController($db, $userController);
	
	/* LOGOUT */
	if(isset($_GET["logout"])) { // Alternatively: rest request over json? => requestController!
		$userController->logout();
		http_response_code(200);
		return;
	}
	
	/* LOGIN REQUEST */
	$dataContent = file_get_contents("php://input");
	if(!$dataContent) {
		http_response_code(400);
		return;
	}
	
	$data = json_decode($dataContent);
	$jsonEmail =  $data->email;
	$jsonPassword =  $data->password;
	
	if(empty($jsonEmail) || empty($jsonPassword)) {
		http_response_code(400);
		echo json_encode(array("message" => "Die Daten des Logins wurden nicht korrekt übermittelt. (email, password)"));
		return;
	}
	
	if(!$userController->isExisting($jsonEmail)) {
		http_response_code(401);
		echo json_encode(array("message" => "Es konnte kein Benutzer zu dieser Email-Adresse gefunden werden."));
		return;
	}
	
	$user = $userController->getUserByEmail($jsonEmail);
	if(!$user) { // Should not happen if isExisting returns true
		http_response_code(500);
		echo json_encode(array("message" => "Fehler beim Laden des Benutzers. Das hätte nicht passieren dürfen, versuchen Sie es erneut :-("));
		return;
	}
	
	if($userController->loginUserWithPassCheck($user, $jsonPassword)) {
		http_response_code(200);
		echo json_encode(array("message" => "Anmeldung erfolgreich."));
		return;
	} else {
		http_response_code(401);
		echo json_encode(array("message" => "Die Anmeldedaten stimmen nicht überein."));
		return;
	}
?>