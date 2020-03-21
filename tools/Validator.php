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
}