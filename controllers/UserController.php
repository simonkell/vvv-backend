<?php
class UserController {
	private $ROLE_DEFAULT = 1;
	private $QUERY_REGISTER = "INSERT INTO users (`email`, `forename`, `surname`, `pass`, `role`, `active`) VALUES ('%s', '%s', '%s', '%s', '%d', '%b')";
	private $QUERY_UPDATE_PASSWORD = "UPDATE users SET `email`='%s', `forename`='%s', `surname`='%s', `pass`='%s', `role`='%d', `active`='%b' WHERE `ID`='%d'";
	private $QUERY_USER_BY_EMAIL = "SELECT `id`, `forename`, `surname`, `pass`, `role`, `active` FROM users WHERE `email`='%s' LIMIT 1";
	private $QUERY_USER_BY_ID = "SELECT `email`, `forename`, `surname`, `pass`, `role`, `active` FROM users WHERE `id`='%d' LIMIT 1";
	
	private $db;
	
	public function __construct($db) {
		$this->db = $db;
	}
	
	private function hashPassword($password) {
		$options = [ 'cost' => 11] ;
		return password_hash($password, PASSWORD_BCRYPT, $options);
	}
	
	public function registerUser($email, $forename, $surname, $pass, $role, $active = 0) {
		$con = $this->db->getConn();
		
		$password_hashed = $this->hashPassword($password);
		
		$escParamEmail = $con->real_escape_string($email);
		$escParamForname = $con->real_escape_string($forename);
		$escParamSurname = $con->real_escape_string($surname);
		// pass
		$escParamRole = $con->real_escape_string($role);
		
		return $con->query(sprintf($this->QUERY_REGISTER, $escParamEmail, $escParamForname, $escParamSurname, $password_hashed, $escParamRole));
	}
	
	public function changeUserPassword($db, User $user, $passwordNew) {
		$con = $this->db->getConn();
		
		$password_hashed = $this->hashPassword($password);
		
		return $con->query(sprintf($this->QUERY_UPDATE_PASSWORD, $user->id, $password_hashed));
	}
	
	public function sendUserPasswordEmail(User $user) {
		// Ciao
	}
	
	public function getUserByEmail($email) {
		$con = $this->db->getConn();
		
		$escParamEmail = $con->real_escape_string($email);
		
		$result = $con->query(sprintf($this->QUERY_USER_BY_EMAIL, $escParamEmail));
		if($result && $result->num_rows > 0) {
			$result = $result->fetch_object();
			
			$user = new User;
			$user->id = $result->id;
			$user->email = $result->email;
			$user->forename = $result->forename;
			$user->surname = $result->surname;
			$user->pass = $result->pass;
			$user->role = $result->role;
			$user->active = $result->active;
			
			return $user;
		} else {
			return null;
		}
		return null;
	}
	
	public function isExisting($email) {
		return ($this->getUserByEmail($this->db, $email) != null);
	}
	
	public function getUserById($id) {
		$con = $this->db->getConn();
		
		$escParamId = $con->real_escape_string($id);
		
		$result = $con->query(sprintf($this->QUERY_USER_BY_ID, $escParamId));
		
		if($result && $result->num_rows > 0) {
			$result = $result->fetch_object();
			
			$user = new User;
			$user->id = $result->id;
			$user->email = $result->email;
			$user->forename = $result->forename;
			$user->surname = $result->surname;
			$user->pass = $result->pass;
			$user->role = $result->role;
			$user->active = $result->active;
			
			return $user;
		} else {
			return null;
		}
	}
	
	public function loginUserWithPassCheck(User $user, $password) {
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