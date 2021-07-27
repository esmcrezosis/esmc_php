<?php
 
class Application_Model_EuValidationQuittance {

    //put your code here
    protected $validation_quittance_id;
    protected $validation_quittance_utilisateur;
    protected $validation_quittance_souscription;
    protected $validation_quittance_date;
	protected $validation_bc;
    protected $publier;
    protected $validation_quittance_acheteur;
    protected $validation_quittance_livraison;
    protected $validation_quittance_preinscription;
    protected $validation_quittance_preinscription_morale;

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

    public function getValidation_quittance_id() {
        return $this->validation_quittance_id;
    }

    public function setValidation_quittance_id($validation_quittance_id) {
        $this->validation_quittance_id = $validation_quittance_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getValidation_quittance_utilisateur() {
        return ($this->validation_quittance_utilisateur);
    }

    public function setValidation_quittance_utilisateur($validation_quittance_utilisateur) {
        $this->validation_quittance_utilisateur = ($validation_quittance_utilisateur);
        return $this;
    }

    public function getValidation_quittance_date() {
        return $this->validation_quittance_date;
    }

    public function setValidation_quittance_date($validation_quittance_date) {
        $this->validation_quittance_date = $validation_quittance_date;
        return $this;
    }

    public function getValidation_quittance_souscription() {
        return ($this->validation_quittance_souscription);
    }

    public function setValidation_quittance_souscription($validation_quittance_souscription) {
        $this->validation_quittance_souscription = ($validation_quittance_souscription);
        return $this;
    }

    public function getValidation_quittance_acheteur() {
        return $this->validation_quittance_acheteur;
    }

    public function setValidation_quittance_acheteur($validation_quittance_acheteur) {
        $this->validation_quittance_acheteur = $validation_quittance_acheteur;
        return $this;
    }

    public function getValidation_quittance_livraison() {
        return $this->validation_quittance_livraison;
    }

    public function setValidation_quittance_livraison($validation_quittance_livraison) {
        $this->validation_quittance_livraison = $validation_quittance_livraison;
        return $this;
    }

    public function getValidation_quittance_preinscription() {
        return $this->validation_quittance_preinscription;
    }

    public function setValidation_quittance_preinscription($validation_quittance_preinscription) {
        $this->validation_quittance_preinscription = $validation_quittance_preinscription;
        return $this;
    }

    public function getValidation_quittance_preinscription_morale() {
        return $this->validation_quittance_preinscription_morale;
    }

    public function setValidation_quittance_preinscription_morale($validation_quittance_preinscription_morale) {
        $this->validation_quittance_preinscription_morale = $validation_quittance_preinscription_morale;
        return $this;
    }
	
	public function getValidation_bc() {
        return $this->validation_bc;
    }

    public function setValidation_bc($validation_bc) {
        $this->validation_bc = $validation_bc;
        return $this;
    }
	


}

?>
