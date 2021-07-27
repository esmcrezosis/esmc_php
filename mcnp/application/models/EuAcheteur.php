<?php
 
class Application_Model_EuAcheteur {

    //put your code here
    protected $acheteur_id;
    protected $acheteur_nom;
    protected $acheteur_prenom;
    protected $acheteur_numero;
    protected $acheteur_banque;
    protected $acheteur_date;
    protected $type_transfert;
    protected $mont_transfert;
    protected $acheteur_cel;
    protected $acheteur_code_membre;
    protected $acheteur_raison_sociale;
    protected $acheteur_type;
    protected $code_agence;
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

    public function getAcheteur_id() {
        return $this->acheteur_id;
    }

    public function setAcheteur_id($acheteur_id) {
        $this->acheteur_id = $acheteur_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }
	
    public function getAcheteur_nom() {
        return $this->acheteur_nom;
    }

    public function setAcheteur_nom($acheteur_nom) {
        $this->acheteur_nom = $acheteur_nom;
        return $this;
    }


    public function getAcheteur_prenom() {
        return $this->acheteur_prenom;
    }

    public function setAcheteur_prenom($acheteur_prenom) {
        $this->acheteur_prenom = $acheteur_prenom;
        return $this;
    }
	
    public function getAcheteur_numero() {
        return $this->acheteur_numero;
    }

    public function setAcheteur_numero($acheteur_numero) {
        $this->acheteur_numero = $acheteur_numero;
        return $this;
    }

    public function getAcheteur_banque() {
        return $this->acheteur_banque;
    }

    public function setAcheteur_banque($acheteur_banque) {
        $this->acheteur_banque = $acheteur_banque;
        return $this;
    }

    public function getAcheteur_date() {
        return $this->acheteur_date;
    }

    public function setAcheteur_date($acheteur_date) {
        $this->acheteur_date = $acheteur_date;
        return $this;
    }

    public function getType_transfert() {
        return $this->type_transfert;
    }

    public function setType_transfert($type_transfert) {
        $this->type_transfert = $type_transfert;
        return $this;
    }

    public function getMont_transfert() {
        return $this->mont_transfert;
    }

    public function setMont_transfert($mont_transfert) {
        $this->mont_transfert = $mont_transfert;
        return $this;
    }

    public function getAcheteur_cel() {
        return $this->acheteur_cel;
    }

    public function setAcheteur_cel($acheteur_cel) {
        $this->acheteur_cel = $acheteur_cel;
        return $this;
    }

    public function getAcheteur_code_membre() {
        return $this->acheteur_code_membre;
    }

    public function setAcheteur_code_membre($acheteur_code_membre) {
        $this->acheteur_code_membre = $acheteur_code_membre;
        return $this;
    }

    public function getAcheteur_raison_sociale() {
        return $this->acheteur_raison_sociale;
    }

    public function setAcheteur_raison_sociale($acheteur_raison_sociale) {
        $this->acheteur_raison_sociale = $acheteur_raison_sociale;
        return $this;
    }

    public function getAcheteur_type() {
        return $this->acheteur_type;
    }

    public function setAcheteur_type($acheteur_type) {
        $this->acheteur_type = $acheteur_type;
        return $this;
    }

    public function getCode_agence() {
        return $this->code_agence;
    }

    public function setCode_agence($code_agence) {
        $this->code_agence = $code_agence;
        return $this;
    }

}

?>
