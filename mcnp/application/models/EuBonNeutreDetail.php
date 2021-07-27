<?php
 
class Application_Model_EuBonNeutreDetail {

    //put your code here
    protected $bon_neutre_detail_id;
    protected $bon_neutre_detail_code;
    protected $bon_neutre_detail_montant;
    protected $bon_neutre_detail_montant_utilise;
    protected $bon_neutre_id;
    protected $bon_neutre_detail_montant_solde;
    protected $bon_neutre_detail_date;
    protected $bon_neutre_detail_numero;
    protected $bon_neutre_detail_date_numero;
    protected $bon_neutre_detail_banque;
    protected $bon_neutre_detail_vignette;
    protected $id_canton;
    protected $bon_neutre_tiers_id;
    protected $bon_neutre_appro_id;
    protected $bon_neutre_detail_type; 
    protected $bon_neutre_detail_commission; 
   
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

    public function getBon_neutre_id() {
        return $this->bon_neutre_id;
    }

    public function setBon_neutre_id($bon_neutre_id) {
        $this->bon_neutre_id = $bon_neutre_id;
        return $this;
    }

    public function getBon_neutre_detail_montant() {
        return $this->bon_neutre_detail_montant;
    }

    public function setBon_neutre_detail_montant($bon_neutre_detail_montant) {
        $this->bon_neutre_detail_montant = $bon_neutre_detail_montant;
        return $this;
    }

    public function getBon_neutre_detail_code() {
        return ($this->bon_neutre_detail_code);
    }

    public function setBon_neutre_detail_code($bon_neutre_detail_code) {
        $this->bon_neutre_detail_code = ($bon_neutre_detail_code);
        return $this;
    }

    public function getBon_neutre_detail_montant_solde() {
        return $this->bon_neutre_detail_montant_solde;
    }

    public function setBon_neutre_detail_montant_solde($bon_neutre_detail_montant_solde) {
        $this->bon_neutre_detail_montant_solde = $bon_neutre_detail_montant_solde;
        return $this;
    }

    public function getBon_neutre_detail_date() {
        return $this->bon_neutre_detail_date;
    }

    public function setBon_neutre_detail_date($bon_neutre_detail_date) {
        $this->bon_neutre_detail_date = $bon_neutre_detail_date;
        return $this;
    }


    public function getBon_neutre_detail_montant_utilise() {
        return $this->bon_neutre_detail_montant_utilise;
    }

    public function setBon_neutre_detail_montant_utilise($bon_neutre_detail_montant_utilise) {
        $this->bon_neutre_detail_montant_utilise = $bon_neutre_detail_montant_utilise;
        return $this;
    }


    public function getBon_neutre_detail_numero() {
        return $this->bon_neutre_detail_numero;
    }

    public function setBon_neutre_detail_numero($bon_neutre_detail_numero) {
        $this->bon_neutre_detail_numero = $bon_neutre_detail_numero;
        return $this;
    }

    public function getBon_neutre_detail_date_numero() {
        return $this->bon_neutre_detail_date_numero;
    }

    public function setBon_neutre_detail_date_numero($bon_neutre_detail_date_numero) {
        $this->bon_neutre_detail_date_numero = $bon_neutre_detail_date_numero;
        return $this;
    }

    public function getBon_neutre_detail_vignette() {
        return $this->bon_neutre_detail_vignette;
    }

    public function setBon_neutre_detail_vignette($bon_neutre_detail_vignette) {
        $this->bon_neutre_detail_vignette = $bon_neutre_detail_vignette;
        return $this;
    }

    public function getBon_neutre_detail_banque() {
        return $this->bon_neutre_detail_banque;
    }

    public function setBon_neutre_detail_banque($bon_neutre_detail_banque) {
        $this->bon_neutre_detail_banque = $bon_neutre_detail_banque;
        return $this;
    }

    public function getId_canton() {
        return $this->id_canton;
    }

    public function setId_canton($id_canton) {
        $this->id_canton = $id_canton;
        return $this;
    }

    public function getBon_neutre_tiers_id() {
        return $this->bon_neutre_tiers_id;
    }

    public function setBon_neutre_tiers_id($bon_neutre_tiers_id) {
        $this->bon_neutre_tiers_id = $bon_neutre_tiers_id;
        return $this;
    }


    public function getBon_neutre_appro_id() {
        return $this->bon_neutre_appro_id;
    }

    public function setBon_neutre_appro_id($bon_neutre_appro_id) {
        $this->bon_neutre_appro_id = $bon_neutre_appro_id;
        return $this;
    }

    public function getBon_neutre_detail_type() {
        return $this->bon_neutre_detail_type;
    }

    public function setBon_neutre_detail_type($bon_neutre_detail_type) {
        $this->bon_neutre_detail_type = $bon_neutre_detail_type;
        return $this;
    }

    public function getBon_neutre_detail_commission() {
        return $this->bon_neutre_detail_commission;
    }

    public function setBon_neutre_detail_commission($bon_neutre_detail_commission) {
        $this->bon_neutre_detail_commission = $bon_neutre_detail_commission;
        return $this;
    }

}

?>
