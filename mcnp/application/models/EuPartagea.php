<?php
 
class Application_Model_EuPartagea {

    //put your code here
    protected $partagea_id;
    protected $partagea_association;
    protected $partagea_souscription;
    protected $partagea_montant;
    protected $partagea_integrateur;
    protected $partagea_offreur_projet;
    protected $partagea_montant_utilise;
    protected $partagea_montant_solde;
    protected $partagea_montant_impot;
    protected $partagea_date;
    protected $partagea_activation;
    protected $partagea_code_activation;
    
    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        return $this->$method();
    }
    
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getPartagea_id() {
        return $this->partagea_id;
    }

    public function setPartagea_id($partagea_id) {
        $this->partagea_id = $partagea_id;
        return $this;
    }

    public function getPartagea_association() {
        return htmlentities($this->partagea_association);
    }

    public function setPartagea_association($partagea_association) {
        $this->partagea_association = html_entity_decode($partagea_association);
        return $this;
    }

    public function getPartagea_souscription() {
        return htmlentities($this->partagea_souscription);
    }

    public function setPartagea_souscription($partagea_souscription) {
        $this->partagea_souscription = html_entity_decode($partagea_souscription);
        return $this;
    }

    public function getPartagea_integrateur() {
        return htmlentities($this->partagea_integrateur);
    }

    public function setPartagea_integrateur($partagea_integrateur) {
        $this->partagea_integrateur = html_entity_decode($partagea_integrateur);
        return $this;
    }

    public function getPartagea_offreur_projet() {
        return htmlentities($this->partagea_offreur_projet);
    }

    public function setPartagea_offreur_projet($partagea_offreur_projet) {
        $this->partagea_offreur_projet = html_entity_decode($partagea_offreur_projet);
        return $this;
    }
	
    public function getPartagea_montant() {
        return $this->partagea_montant;
    }

    public function setPartagea_montant($partagea_montant) {
        $this->partagea_montant = $partagea_montant;
        return $this;
    }
	
    public function getPartagea_montant_utilise() {
        return $this->partagea_montant_utilise;
    }

    public function setPartagea_montant_utilise($partagea_montant_utilise) {
        $this->partagea_montant_utilise = $partagea_montant_utilise;
        return $this;
    }

	
    public function getPartagea_montant_solde() {
        return $this->partagea_montant_solde;
    }

    public function setPartagea_montant_solde($partagea_montant_solde) {
        $this->partagea_montant_solde = $partagea_montant_solde;
        return $this;
    }

    public function getPartagea_montant_impot() {
        return $this->partagea_montant_impot;
    }

    public function setPartagea_montant_impot($partagea_montant_impot) {
        $this->partagea_montant_impot = $partagea_montant_impot;
        return $this;
    }

    public function getPartagea_date() {
        return $this->partagea_date;
    }

    public function setPartagea_date($partagea_date) {
        $this->partagea_date = $partagea_date;
        return $this;
    }

    public function getPartagea_activation() {
        return ($this->partagea_activation);
    }

    public function setPartagea_activation($partagea_activation) {
        $this->partagea_activation = ($partagea_activation);
        return $this;
    }

    public function getPartagea_code_activation() {
        return ($this->partagea_code_activation);
    }

    public function setPartagea_code_activation($partagea_code_activation) {
        $this->partagea_code_activation = ($partagea_code_activation);
        return $this;
    }


}

?>
