<?php

class ValidateField {
    protected $sanitizedData;
    protected bool $isValid = false;
    protected string $fieldName;
    protected bool $required;

    public function __construct(string $fieldName){
        $this->fieldName = $fieldName;
    }

    public function getValue(){
        return $this->sanitizedData;
    }

    public function getFieldName(){
        return $this->fieldName;
    }
    
    public function getIsValid(){
        return $this->isValid;
    }
}

/**
 * Class that validates the given HTML field.
 */
class ValidateQuantityField extends ValidateField {
    public function __construct($fieldName){
        parent::__construct($fieldName);
        $this->required = false;
        $this->sanitizedData = filter_var($_POST[$this->fieldName], FILTER_SANITIZE_NUMBER_INT);
        $this->setIsValid();
    }

    /**
     * Returns true if the given field is empty or numeric.
     */
    private function setIsValid(){
        if(trim($_POST[$this->fieldName]) === ""){
            $this->isValid = true;
        }
        if(is_numeric($this->sanitizedData)){
            $this->isValid = true;
        }
    }
}

/**
 * Class that validates the given HTML field.
 */
class ValidateEmptyField extends ValidateField {
    public function __construct($fieldName){
        parent::__construct($fieldName);
        $this->required = true;
        $this->sanitizedData = filter_input(INPUT_POST, $this->fieldName, FILTER_SANITIZE_STRING);
        $this->setIsValid();
    }

    /**
     * Returns true if the given field is empty.
     */
    private function setIsValid(){
        if(trim($_POST[$this->fieldName]) !== ""){
            $this->isValid = true;
        }
    }
}

/**
 * Class that validates the given HTML field.
 */
class ValidateProvinceField extends ValidateField {

    // Valid province codes
    private array $provinceCodes = [
        'AB', // Alberta
        'BC', // British Columbia
        'MB', // Manitoba
        'NB', // New Brunswick
        'NL', // Newfoundland and Labrador
        'NS', // Nova Scotia
        'ON', // Ontario
        'PE', // Prince Edward Island
        'QC', // Quebec
        'SK', // Saskatchewan
        'NT', // Northwest Territories
        'NU', // Nunavut
        'YT'  // Yukon
    ];

    public function __construct($fieldName){
        parent::__construct($fieldName);
        $this->sanitizedData = filter_input(INPUT_POST, $this->fieldName, FILTER_SANITIZE_STRING);
        $this->setIsValid();
    }

    /**
     * Returns true if the given field a valid province code.
     */
    private function setIsValid(){
        if(in_array($_POST[$this->fieldName], $this->provinceCodes)){
            $this->isValid = true;
        }
    }
}

/**
 * Class that validates the given HTML field.
 */
class ValidatePostalField extends ValidateField {
    public function __construct($fieldName){
        parent::__construct($fieldName);
        $this->required = true;
        $this->sanitizedData = filter_input(INPUT_POST, $this->fieldName, FILTER_SANITIZE_STRING);
        $this->setIsValid();
    }

    /**
     * Returns true if the given field is a valid Canadian postal code.
     */
    private function setIsValid(){
        if(filter_var($this->sanitizedData, FILTER_VALIDATE_REGEXP, array(
            "options" => array("regexp"=>"/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/")))){
                $this->isValid = true;
            }
    }
}

/**
 * Class that validates the given HTML field.
 */
class ValidateEmailField extends ValidateField {
    public function __construct($fieldName){
        parent::__construct($fieldName);
        $this->required = true;
        $this->sanitizedData = filter_input(INPUT_POST, $this->fieldName, FILTER_SANITIZE_STRING);
        $this->setIsValid();
    }

    /**
     * Returns true if the given field is a valid email.
     */
    private function setIsValid(){
        if(filter_var($this->sanitizedData, FILTER_VALIDATE_EMAIL)){
            $this->isValid = true;
        }
    }
}

/**
 * Class that validates the given HTML field.
 */
class ValidateCardTypeField extends ValidateField {
    public function __construct($fieldName){
        parent::__construct($fieldName);
        $this->required = true;
        $this->sanitizedData = filter_input(INPUT_POST, $this->fieldName, FILTER_SANITIZE_STRING);
        $this->setIsValid();
    }

    /**
     * Returns true if a card type has been chosen.
     */
    private function setIsValid(){
        if($this->sanitizedData && $this->sanitizedData == 'on'){
            $this->isValid = true;
        }
    }
}

/**
 * Class that validates the given HTML field.
 */
class ValidateMonthField extends ValidateField {
    public function __construct($fieldName){
        parent::__construct($fieldName);
        $this->required = true;
        $this->sanitizedData = filter_var($_POST[$this->fieldName], FILTER_SANITIZE_NUMBER_INT);
        $this->setIsValid();
    }

    /**
     * Returns true if a valid month has been chosen.
     */
    private function setIsValid(){
        if(filter_var($this->sanitizedData, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1, "max_range" => 12)))){
            $this->isValid = true;
        }
    }
}

/**
 * Class that validates the given HTML field.
 */
class ValidateYearField extends ValidateField {
    public function __construct($fieldName){
        parent::__construct($fieldName);
        $this->required = true;
        $this->sanitizedData = filter_var($_POST[$this->fieldName], FILTER_SANITIZE_STRING);
        $this->setIsValid();
    }

    /**
     * Returns true if the card expiry year chosen is a valid year.
     */
    private function setIsValid(){
        if($this->sanitizedData >= date("Y") && $this->sanitizedData < (date("Y") + 5)){
            $this->isValid = true;
        }
    }
}

/**
 * Class that validates the given HTML field.
 */
class ValidateCardNumberField extends ValidateField {
    public function __construct($fieldName){
        parent::__construct($fieldName);
        $this->required = true;
        $this->sanitizedData = filter_var($_POST[$this->fieldName], FILTER_SANITIZE_NUMBER_INT);
        $this->setIsValid();
    }

    /**
     * Returns true if the given field is a 10 digit number.
     */
    private function setIsValid(){
        if(filter_var($this->sanitizedData, FILTER_VALIDATE_INT) && 
            (strlen((string)$this->sanitizedData) == 10) && 
            is_numeric($this->sanitizedData)){
            $this->isValid = true;
        }
    }
}

?>
