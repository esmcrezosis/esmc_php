<?php

class Application_Model_EuContact {

    //put your code here
    protected $contact_id;
    protected $contact_nom;
    protected $contact_email;
    protected $contact_sujet;
    protected $contact_message;
    protected $contact_type;
    protected $contact_date;
    protected $traiter;

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

    public function getContact_id() {
        return $this->contact_id;
    }

    public function setContact_id($contact_id) {
        $this->contact_id = $contact_id;
        return $this;
    }

    public function getContact_email() {
        return $this->contact_email;
    }

    public function setContact_email($contact_email) {
        $this->contact_email = $contact_email;
        return $this;
    }

    public function getContact_message() {
        return ($this->contact_message);
    }

    public function setContact_message($contact_message) {
        $this->contact_message = ($contact_message);
        return $this;
    }

    public function getContact_sujet() {
        return ($this->contact_sujet);
    }

    public function setContact_sujet($contact_sujet) {
        $this->contact_sujet = ($contact_sujet);
        return $this;
    }

    public function getContact_type() {
        return $this->contact_type;
    }

    public function setContact_type($contact_type) {
        $this->contact_type = $contact_type;
        return $this;
    }

    public function getContact_nom() {
        return ($this->contact_nom);
    }

    public function setContact_nom($contact_nom) {
        $this->contact_nom = ($contact_nom);
        return $this;
    }

    public function getContact_date() {
        return $this->contact_date;
    }

    public function setContact_date($contact_date) {
        $this->contact_date = $contact_date;
        return $this;
    }

    public function getTraiter() {
        return $this->traiter;
    }

    public function setTraiter($traiter) {
        $this->traiter = $traiter;
        return $this;
    }
	
}

?>
