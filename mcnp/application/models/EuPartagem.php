<?php
 
class Application_Model_EuPartagem {

    //put your code here
    protected $partagem_id;
    protected $partagem_membreasso;
    protected $partagem_souscription;
    protected $partagem_montant;
    protected $partagem_integrateur;
    protected $partagem_offreur_projet;
    protected $partagem_montant_utilise;
    protected $partagem_montant_solde;
    protected $partagem_montant_impot;
    protected $partagem_date;
    protected $partagem_activation;
    protected $partagem_code_activation;

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

    public function getPartagem_id() {
        return $this->partagem_id;
    }

    public function setPartagem_id($partagem_id) {
        $this->partagem_id = $partagem_id;
        return $this;
    }

    public function getPartagem_membreasso() {
        return htmlentities($this->partagem_membreasso);
    }

    public function setPartagem_membreasso($partagem_membreasso) {
        $this->partagem_membreasso = html_entity_decode($partagem_membreasso);
        return $this;
    }

    public function getPartagem_souscription() {
        return htmlentities($this->partagem_souscription);
    }

    public function setPartagem_souscription($partagem_souscription) {
        $this->partagem_souscription = html_entity_decode($partagem_souscription);
        return $this;
    }


    public function getPartagem_integrateur() {
        return htmlentities($this->partagem_integrateur);
    }

    public function setPartagem_integrateur($partagem_integrateur) {
        $this->partagem_integrateur = html_entity_decode($partagem_integrateur);
        return $this;
    }

    public function getPartagem_offreur_projet() {
        return htmlentities($this->partagem_offreur_projet);
    }

    public function setPartagem_offreur_projet($partagem_offreur_projet) {
        $this->partagem_offreur_projet = html_entity_decode($partagem_offreur_projet);
        return $this;
    }

    public function getPartagem_montant() {
        return $this->partagem_montant;
    }

    public function setPartagem_montant($partagem_montant) {
        $this->partagem_montant = $partagem_montant;
        return $this;
    }


    public function getPartagem_montant_utilise() {
        return $this->partagem_montant_utilise;
    }

    public function setPartagem_montant_utilise($partagem_montant_utilise) {
        $this->partagem_montant_utilise = $partagem_montant_utilise;
        return $this;
    }

    public function getPartagem_montant_solde() {
        return $this->partagem_montant_solde;
    }

    public function setPartagem_montant_solde($partagem_montant_solde) {
        $this->partagem_montant_solde = $partagem_montant_solde;
        return $this;
    }


    public function getPartagem_montant_impot() {
        return $this->partagem_montant_impot;
    }

    public function setPartagem_montant_impot($partagem_montant_impot) {
        $this->partagem_montant_impot = $partagem_montant_impot;
        return $this;
    }

    public function getPartagem_date() {
        return $this->partagem_date;
    }

    public function setPartagem_date($partagem_date) {
        $this->partagem_date = $partagem_date;
        return $this;
    }


    public function getPartagem_activation() {
        return ($this->partagem_activation);
    }

    public function setPartagem_activation($partagem_activation) {
        $this->partagem_activation = ($partagem_activation);
        return $this;
    }

    public function getPartagem_code_activation() {
        return ($this->partagem_code_activation);
    }

    public function setPartagem_code_activation($partagem_code_activation) {
        $this->partagem_code_activation = ($partagem_code_activation);
        return $this;
    }


}

?>
