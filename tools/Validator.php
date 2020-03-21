<?php
namespace tools;

class Validator
{
    private $requiredAttributes;
    private $obj;

    public function __construct($obj, $requiredAttributes)
    {
        $this->obj = $obj;
        $this->requiredAttributes = $requiredAttributes;
        return $this;
    }

    /**
     * @return HttpError[]
     */
    public function validate()
    {
        $found = [];
        foreach ($this->requiredAttributes as $requiredAttribute) {
            $found[$requiredAttribute] = false;
        }

        foreach ($this->obj as $attr => $value) {
            if (isset($found[$attr])) {
                $found[$attr] = true;
            }
        }

        $errors = [];
        foreach ($found as $attributeName => $item) {
            if (!$item) {
                $errors[] = new HttpError(400, $attributeName . ' is a required field');
            }
        }

        return $errors;
    }
	
	public function isValidEmail($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	
	public function validatePassword($password) {
		$errors = array();
		
		// Check if the password is satisfying
		if (strlen($password) < 8) {
			array_push($errors, new HttpError(400, 'Dein Passwort sollte über 8 Zeichen lang sein.'));
		}

		if (!preg_match("#[0-9]+#", $password)) {
			array_push($errors, new HttpError(400, 'Dein Passwort sollte mindestens eine Zahl enthalten.'));
		}

		if (!preg_match("#[a-zA-Z]+#", $password)) {
			array_push($errors, new HttpError(400, 'Dein Passwort sollte mindestens einen Buchstaben enthalten.'));
		}
		return $errors;
	}
}