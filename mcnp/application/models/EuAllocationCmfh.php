<?php
 
class Application_Model_EuAllocationCmfh {

    //put your code here
    protected $allocation_cmfh_id;
    protected $allocation_cmfh_code;
    protected $allocation_cmfh_montant_utilise;
    protected $allocation_cmfh_code_membre_cmfh;
    protected $allocation_cmfh_code_membre_integrageur;
    protected $allocation_cmfh_date;
    protected $allocation_cmfh_nombre;
    protected $allocation_cmfh_nombre_utilise;
    protected $allocation_cmfh_nombre_solde;
    protected $allocation_cmfh_actif;
    protected $allocation_cmfh_type;
    
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

    public function getAllocation_cmfh_id() {
        return $this->allocation_cmfh_id;
    }

    public function setAllocation_cmfh_id($allocation_cmfh_id) {
        $this->allocation_cmfh_id = $allocation_cmfh_id;
        return $this;
    }

    public function getAllocation_cmfh_code_membre_cmfh() {
        return $this->allocation_cmfh_code_membre_cmfh;
    }

    public function setAllocation_cmfh_code_membre_cmfh($allocation_cmfh_code_membre_cmfh) {
        $this->allocation_cmfh_code_membre_cmfh = $allocation_cmfh_code_membre_cmfh;
        return $this;
    }

    public function getAllocation_cmfh_montant_utilise() {
        return $this->allocation_cmfh_montant_utilise;
    }

    public function setAllocation_cmfh_montant_utilise($allocation_cmfh_montant_utilise) {
        $this->allocation_cmfh_montant_utilise = $allocation_cmfh_montant_utilise;
        return $this;
    }

    public function getAllocation_cmfh_code() {
        return ($this->allocation_cmfh_code);
    }

    public function setAllocation_cmfh_code($allocation_cmfh_code) {
        $this->allocation_cmfh_code = ($allocation_cmfh_code);
        return $this;
    }

    public function getAllocation_cmfh_code_membre_integrageur() {
        return $this->allocation_cmfh_code_membre_integrageur;
    }

    public function setAllocation_cmfh_code_membre_integrageur($allocation_cmfh_code_membre_integrageur) {
        $this->allocation_cmfh_code_membre_integrageur = $allocation_cmfh_code_membre_integrageur;
        return $this;
    }

    public function getAllocation_cmfh_date() {
        return $this->allocation_cmfh_date;
    }

    public function setAllocation_cmfh_date($allocation_cmfh_date) {
        $this->allocation_cmfh_date = $allocation_cmfh_date;
        return $this;
    }


    public function getAllocation_cmfh_nombre() {
        return $this->allocation_cmfh_nombre;
    }

    public function setAllocation_cmfh_nombre($allocation_cmfh_nombre) {
        $this->allocation_cmfh_nombre = $allocation_cmfh_nombre;
        return $this;
    }


    public function getAllocation_cmfh_nombre_utilise() {
        return $this->allocation_cmfh_nombre_utilise;
    }

    public function setAllocation_cmfh_nombre_utilise($allocation_cmfh_nombre_utilise) {
        $this->allocation_cmfh_nombre_utilise = $allocation_cmfh_nombre_utilise;
        return $this;
    }

    public function getAllocation_cmfh_nombre_solde() {
        return $this->allocation_cmfh_nombre_solde;
    }

    public function setAllocation_cmfh_nombre_solde($allocation_cmfh_nombre_solde) {
        $this->allocation_cmfh_nombre_solde = $allocation_cmfh_nombre_solde;
        return $this;
    }

    public function getAllocation_cmfh_actif() {
        return $this->allocation_cmfh_actif;
    }

    public function setAllocation_cmfh_actif($allocation_cmfh_actif) {
        $this->allocation_cmfh_actif = $allocation_cmfh_actif;
        return $this;
    }
    
    public function getAllocation_cmfh_type() {
        return $this->allocation_cmfh_type;
    }

    public function setAllocation_cmfh_type($allocation_cmfh_type) {
        $this->allocation_cmfh_type = $allocation_cmfh_type;
        return $this;
    }

}

?>
