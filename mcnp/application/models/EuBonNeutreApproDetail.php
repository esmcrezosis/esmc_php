<?php
 
class Application_Model_EuBonNeutreApproDetail {

    //put your code here
    protected $bon_neutre_detail_id;
    protected $bon_neutre_appro_id;
    protected $bon_neutre_appro_detail_banque;
    protected $bon_neutre_appro_detail_montant;
    protected $bon_neutre_appro_detail_date;
    protected $bon_neutre_appro_detail_mont_utilise;
    protected $bon_neutre_appro_detail_solde;

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

    public function getBon_neutre_detail_id() {
        return $this->bon_neutre_detail_id;
    }

    public function setBon_neutre_detail_id($bon_neutre_detail_id) {
        $this->bon_neutre_detail_id = $bon_neutre_detail_id;
        return $this;
    }

    public function getBon_neutre_appro_detail_montant() {
        return $this->bon_neutre_appro_detail_montant;
    }

    public function setBon_neutre_appro_detail_montant($bon_neutre_appro_detail_montant) {
        $this->bon_neutre_appro_detail_montant = $bon_neutre_appro_detail_montant;
        return $this;
    }

    public function getBon_neutre_appro_detail_banque() {
        return $this->bon_neutre_appro_detail_banque;
    }

    public function setBon_neutre_appro_detail_banque($bon_neutre_appro_detail_banque) {
        $this->bon_neutre_appro_detail_banque = $bon_neutre_appro_detail_banque;
        return $this;
    }


    public function getBon_neutre_appro_id() {
        return ($this->bon_neutre_appro_id);
    }

    public function setBon_neutre_appro_id($bon_neutre_appro_id) {
        $this->bon_neutre_appro_id = ($bon_neutre_appro_id);
        return $this;
    }


    public function getBon_neutre_appro_detail_date() {
        return $this->bon_neutre_appro_detail_date;
    }

    public function setBon_neutre_appro_detail_date($bon_neutre_appro_detail_date) {
        $this->bon_neutre_appro_detail_date = $bon_neutre_appro_detail_date;
        return $this;
    }

    public function getBon_neutre_appro_detail_mont_utilise() {
        return $this->bon_neutre_appro_detail_mont_utilise;
    }

    public function setBon_neutre_appro_detail_mont_utilise($bon_neutre_appro_detail_mont_utilise) {
        $this->bon_neutre_appro_detail_mont_utilise = $bon_neutre_appro_detail_mont_utilise;
        return $this;
    }


    public function getBon_neutre_appro_detail_solde() {
        return $this->bon_neutre_appro_detail_solde;
    }

    public function setBon_neutre_appro_detail_solde($bon_neutre_appro_detail_solde) {
        $this->bon_neutre_appro_detail_solde = $bon_neutre_appro_detail_solde;
        return $this;
    }


}

?>
