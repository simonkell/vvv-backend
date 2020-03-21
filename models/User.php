<?php
class User {
	public $id, $email, $forename, $surname, $pass, $role, $active;
	
	public function hasPermission($level) {
		return false;
		//return $this->mieter->rolle->befugnis >= $level;
	}
}
?>