<?php
	session_start();
	
	$TITLE = "VVV Backend";
	
	define("SESSION_NAME_USERID", "userId");
	
	// MODELS
	include("models/User.php");
	
	// CONTROLLERS
	include("controllers/PageController.php");
	// TODO: ResponseController? Invalid permission response, session expired response, no session response
	
	global $page;
	$db = new DbController();
	$userController = new UserController($db);
	
	$db->connect();
	
	class MasterController {
		public $page, $db, $userController;
		
		public function __construct($page, $db, $userController) {
			$this->page = $page;
			
			$this->db = $db;
			$this->userController = $userController;
		}
		
		public function isSessionValid($sessionName) {
			if(isset($_SESSION[$sessionName])) {
				if(strcmp($sessionName, SESSION_NAME_USERID) == 0) {
					$user = $this->userController->getUserById($_SESSION[$sessionName]);
					
					if($user != null) {
						// TODO: Check if id is legit (???)
						if(true) {
							return true;
						} else {
							// No further user information validation
							// ... <useless else>
						}
					}
				} else {
					// No further validations.
					// NEW VALIDATION METHODS HERE!
				}
			}
			
			return false;
		}
	}

?>