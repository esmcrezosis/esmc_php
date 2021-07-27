<?php

class Application_Model_EuOffreDemandeMessage {

    //put your code here
    protected $id_message;
    protected $id_offre;
    protected $id_demande;
    protected $message;
    protected $date_message;
    protected $type_message;
    protected $code_membre;
    protected $code_compte;
    protected $id_credit;

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

    public function getId_message() {
        return $this->id_message;
    }

    public function setId_message($id_message) {
        $this->id_message = $id_message;
        return $this;
    }

    public function getId_offre() {
        return $this->id_offre;
    }

    public function setId_offre($id_offre) {
        $this->id_offre = $id_offre;
        return $this;
    }

    public function getId_demande() {
        return $this->id_demande;
    }

    public function setId_demande($id_demande) {
        $this->id_demande = $id_demande;
        return $this;
    }
    public function getId_credit() {
        return $this->id_credit;
    }

    public function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }
	
    public function getDate_message() {
        return $this->date_message;
    }

    public function setDate_message($date_message) {
        $this->date_message = $date_message;
        return $this;
    }

    public function getType_message() {
        return $this->type_message;
    }

    public function setType_message($type_message) {
        $this->type_message = $type_message;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getCode_compte() {
        return $this->code_compte;
    }

    public function setCode_compte($code_compte) {
        $this->code_compte = $code_compte;
        return $this;
    }
	
}

?>
