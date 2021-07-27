<?php
 
class Application_Model_EuValidationOpi {

    //put your code here
    protected $validation_opi_id;
    protected $validation_opi_banque_user;
    protected $validation_opi_traite;
    protected $validation_opi_date;
    protected $publier;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getValidation_opi_id() {
        return $this->validation_opi_id;
    }

    public function setValidation_opi_id($validation_opi_id) {
        $this->validation_opi_id = $validation_opi_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getValidation_opi_banque_user() {
        return ($this->validation_opi_banque_user);
    }

    public function setValidation_opi_banque_user($validation_opi_banque_user) {
        $this->validation_opi_banque_user = ($validation_opi_banque_user);
        return $this;
    }

    public function getValidation_opi_date() {
        return $this->validation_opi_date;
    }

    public function setValidation_opi_date($validation_opi_date) {
        $this->validation_opi_date = $validation_opi_date;
        return $this;
    }

    public function getValidation_opi_traite() {
        return ($this->validation_opi_traite);
    }

    public function setValidation_opi_traite($validation_opi_traite) {
        $this->validation_opi_traite = ($validation_opi_traite);
        return $this;
    }



}

?>
