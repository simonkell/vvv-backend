<?php
class UserController {
	private $ROLE_DEFAULT = 0;
	private $QUERY_REGISTER = "INSERT INTO Users (`Email`, `Password`) VALUES ('%s', '%s')";
	private $QUERY_UPDATE_PASSWORD = "UPDATE `Password` FROM Users WHERE `ID`='%d'";
	private $QUERY_USER_BY_EMAIL = "SELECT `ID`, `Password` FROM Users WHERE `Email`='%s' LIMIT 1";
	private $QUERY_USER_BY_ID = "SELECT `Email`, `Password` FROM Users WHERE `ID`='%s' LIMIT 1";
	
	private $db;
	
	public function __construct($db) {
		$this->db = $db;
	}
	
	private function hashPassword($password) {
		$options = [ 'cost' => 11] ;
		return password_hash($password, PASSWORD_BCRYPT, $options);
	}
	
	public function registerUser($db, $email, $password) {
		$con = $this->db->getConn();
		
		$password_hashed = $this->hashPassword($password);
		
		$escParamRole = $con->real_escape_string($this->ROLE_DEFAULT);
		$escParamEmail = $con->real_escape_string($email);
		$escParamPassword = $con->real_escape_string($password_hashed);
		
		return $con->query(sprintf($this->QUERY_REGISTER, $escParamRole, $escParamEmail, $escParamPassword));
	}
	
	public function changeUserPassword($db, User $user, $passwordNew) {
		$con = $this->db->getConn();
		
		$password_hashed = $this->hashPassword($password);
		
		$escParamPassword = $con->real_escape_string($password_hashed);
		
		return $con->query(sprintf($this->QUERY_UPDATE_PASSWORD, $user->id, $escParamPassword));
	}
	
	public function sendUserPasswordEmail(User $user) {
		
	}
	
	public function getUserByEmail($db, $email) {
		global $page, $mieterController;
		$con = $this->db->getConn();
		
		$escParamEmail = $con->real_escape_string($email);
		
		$result = $con->query(sprintf($this->QUERY_USER_BY_EMAIL, $escParamEmail));
		if($result && $result->num_rows > 0) {
			$result = $result->fetch_object();
			
			$user = new User;
			$user->id = $result->ID;
			$user->email = $escParamEmail;
			$user->passHash = $result->Password;
			
			return $user;
		} else {
			return null;
		}
		return null;
	}
	
	public function isExisting($email) {
		return ($this->getUserByEmail2($email) != null);
	}
	
	public function getUserByEmail2($email) {
		return $this->getUserByEmail($this->db, $email);
	}
	
	public function getUserById($id) {
		global $page, $mieterController;
		$con = $this->db->getConn();
		
		$escParamId = $con->real_escape_string($id);
		
		$result = $con->query(sprintf($this->QUERY_USER_BY_ID, $escParamId));
		
		if($result && $result->num_rows > 0) {
			$result = $result->fetch_object();
			
			$user = new User();
			$user->id = $escParamId;
			$user->email = $result->Email;
			$user->passHash = $result->Password;
			
			return $user;
		} else {
			return null;
		}
	}
	
	public function loginUserByEmail($db, User $user, $password) {
		if(password_verify($password, $user->passHash)) {
			$_SESSION[SESSION_NAME_USERID] = $user->id;
			return true;
		}
		
		// Log session login?
		
		return false;
	}
	
	public function logout() {
		session_destroy();
	}
}
?>