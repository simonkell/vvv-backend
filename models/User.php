<?php
class User {
	public $id, $email, $passHash;
	
	public function hasPermission($level) {
		return false;
		//return $this->mieter->rolle->befugnis >= $level;
	}
}
?>