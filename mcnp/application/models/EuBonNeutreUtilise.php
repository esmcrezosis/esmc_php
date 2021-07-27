<?php
 
class Application_Model_EuBonNeutreUtilise {

    //put your code here
    protected $bon_neutre_utilise_id;
    protected $bon_neutre_utilise_libelle;
    protected $bon_neutre_utilise_type;
    protected $bon_neutre_utilise_montant;
    protected $bon_neutre_id;
    protected $bon_neutre_utilise_date;
    protected $bon_neutre_detail_id;
    protected $usertable;
    protected $user_id;

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

    public function getBon_neutre_utilise_id() {
        return $this->bon_neutre_utilise_id;
    }

    public function setBon_neutre_utilise_id($bon_neutre_utilise_id) {
        $this->bon_neutre_utilise_id = $bon_neutre_utilise_id;
        return $this;
    }

    public function getBon_neutre_utilise_montant() {
        return $this->bon_neutre_utilise_montant;
    }

    public function setBon_neutre_utilise_montant($bon_neutre_utilise_montant) {
        $this->bon_neutre_utilise_montant = $bon_neutre_utilise_montant;
        return $this;
    }

    public function getBon_neutre_utilise_type() {
        return $this->bon_neutre_utilise_type;
    }

    public function setBon_neutre_utilise_type($bon_neutre_utilise_type) {
        $this->bon_neutre_utilise_type = $bon_neutre_utilise_type;
        return $this;
    }


    public function getBon_neutre_utilise_libelle() {
        return ($this->bon_neutre_utilise_libelle);
    }

    public function setBon_neutre_utilise_libelle($bon_neutre_utilise_libelle) {
        $this->bon_neutre_utilise_libelle = ($bon_neutre_utilise_libelle);
        return $this;
    }

    public function getBon_neutre_id() {
        return $this->bon_neutre_id;
    }

    public function setBon_neutre_id($bon_neutre_id) {
        $this->bon_neutre_id = $bon_neutre_id;
        return $this;
    }


    public function getBon_neutre_utilise_date() {
        return $this->bon_neutre_utilise_date;
    }

    public function setBon_neutre_utilise_date($bon_neutre_utilise_date) {
        $this->bon_neutre_utilise_date = $bon_neutre_utilise_date;
        return $this;
    }



    public function getBon_neutre_detail_id() {
        return $this->bon_neutre_detail_id;
    }

    public function setBon_neutre_detail_id($bon_neutre_detail_id) {
        $this->bon_neutre_detail_id = $bon_neutre_detail_id;
        return $this;
    }

    public function getUsertable() {
        return $this->usertable;
    }

    public function setUsertable($usertable) {
        $this->usertable = $usertable;
        return $this;
    } 


    public function getUser_id() {
        return $this->user_id;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
        return $this;
    }



}

?>
