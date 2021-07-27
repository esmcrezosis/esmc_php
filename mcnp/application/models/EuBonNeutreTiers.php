<?php
 
class Application_Model_EuBonNeutreTiers {

    //put your code here
    protected $bon_neutre_tiers_id;
    protected $bon_neutre_tiers_apporteur;
    protected $bon_neutre_tiers_beneficiaire;
    protected $bon_neutre_tiers_montant;
    protected $bon_neutre_tiers_date;

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

    public function getBon_neutre_tiers_id() {
        return $this->bon_neutre_tiers_id;
    }

    public function setBon_neutre_tiers_id($bon_neutre_tiers_id) {
        $this->bon_neutre_tiers_id = $bon_neutre_tiers_id;
        return $this;
    }

    public function getBon_neutre_tiers_montant() {
        return $this->bon_neutre_tiers_montant;
    }

    public function setBon_neutre_tiers_montant($bon_neutre_tiers_montant) {
        $this->bon_neutre_tiers_montant = $bon_neutre_tiers_montant;
        return $this;
    }

    public function getBon_neutre_tiers_beneficiaire() {
        return $this->bon_neutre_tiers_beneficiaire;
    }

    public function setBon_neutre_tiers_beneficiaire($bon_neutre_tiers_beneficiaire) {
        $this->bon_neutre_tiers_beneficiaire = $bon_neutre_tiers_beneficiaire;
        return $this;
    }


    public function getBon_neutre_tiers_apporteur() {
        return ($this->bon_neutre_tiers_apporteur);
    }

    public function setBon_neutre_tiers_apporteur($bon_neutre_tiers_apporteur) {
        $this->bon_neutre_tiers_apporteur = ($bon_neutre_tiers_apporteur);
        return $this;
    }


    public function getBon_neutre_tiers_date() {
        return $this->bon_neutre_tiers_date;
    }

    public function setBon_neutre_tiers_date($bon_neutre_tiers_date) {
        $this->bon_neutre_tiers_date = $bon_neutre_tiers_date;
        return $this;
    }




}

?>
