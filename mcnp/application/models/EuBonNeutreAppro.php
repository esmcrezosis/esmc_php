<?php
 
class Application_Model_EuBonNeutreAppro {

    //put your code here
    protected $bon_neutre_appro_id;
    protected $bon_neutre_appro_apporteur;
    protected $bon_neutre_appro_beneficiaire;
    protected $bon_neutre_appro_montant;
    protected $bon_neutre_appro_date;
    protected $bon_neutre_appro_banque_user;
    protected $bon_neutre_appro_commission;

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

    public function getBon_neutre_appro_id() {
        return $this->bon_neutre_appro_id;
    }

    public function setBon_neutre_appro_id($bon_neutre_appro_id) {
        $this->bon_neutre_appro_id = $bon_neutre_appro_id;
        return $this;
    }

    public function getBon_neutre_appro_montant() {
        return $this->bon_neutre_appro_montant;
    }

    public function setBon_neutre_appro_montant($bon_neutre_appro_montant) {
        $this->bon_neutre_appro_montant = $bon_neutre_appro_montant;
        return $this;
    }

    public function getBon_neutre_appro_beneficiaire() {
        return $this->bon_neutre_appro_beneficiaire;
    }

    public function setBon_neutre_appro_beneficiaire($bon_neutre_appro_beneficiaire) {
        $this->bon_neutre_appro_beneficiaire = $bon_neutre_appro_beneficiaire;
        return $this;
    }


    public function getBon_neutre_appro_apporteur() {
        return ($this->bon_neutre_appro_apporteur);
    }

    public function setBon_neutre_appro_apporteur($bon_neutre_appro_apporteur) {
        $this->bon_neutre_appro_apporteur = ($bon_neutre_appro_apporteur);
        return $this;
    }


    public function getBon_neutre_appro_date() {
        return $this->bon_neutre_appro_date;
    }

    public function setBon_neutre_appro_date($bon_neutre_appro_date) {
        $this->bon_neutre_appro_date = $bon_neutre_appro_date;
        return $this;
    }


    public function getBon_neutre_appro_banque_user() {
        return $this->bon_neutre_appro_banque_user;
    }

    public function setBon_neutre_appro_banque_user($bon_neutre_appro_banque_user) {
        $this->bon_neutre_appro_banque_user = $bon_neutre_appro_banque_user;
        return $this;
    }


    public function getBon_neutre_appro_commission() {
        return $this->bon_neutre_appro_commission;
    }

    public function setBon_neutre_appro_commission($bon_neutre_appro_commission) {
        $this->bon_neutre_appro_commission = $bon_neutre_appro_commission;
        return $this;
    }


}

?>
