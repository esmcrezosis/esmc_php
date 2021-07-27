<?php
 
class Application_Model_EuBonDetail {

    //put your code here
    protected $bon_detail_id;
    protected $bon_detail_libelle;
    protected $bon_detail_reference;
    protected $bon_detail_quantite;
    protected $bon_id;
    protected $bon_detail_prix_unitaire;

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

    public function getBon_detail_id() {
        return $this->bon_detail_id;
    }

    public function setBon_detail_id($bon_detail_id) {
        $this->bon_detail_id = $bon_detail_id;
        return $this;
    }

    public function getBon_detail_quantite() {
        return $this->bon_detail_quantite;
    }

    public function setBon_detail_quantite($bon_detail_quantite) {
        $this->bon_detail_quantite = $bon_detail_quantite;
        return $this;
    }

    public function getBon_detail_reference() {
        return $this->bon_detail_reference;
    }

    public function setBon_detail_reference($bon_detail_reference) {
        $this->bon_detail_reference = $bon_detail_reference;
        return $this;
    }


    public function getBon_detail_libelle() {
        return ($this->bon_detail_libelle);
    }

    public function setBon_detail_libelle($bon_detail_libelle) {
        $this->bon_detail_libelle = ($bon_detail_libelle);
        return $this;
    }

    public function getBon_id() {
        return $this->bon_id;
    }

    public function setBon_id($bon_id) {
        $this->bon_id = $bon_id;
        return $this;
    }

    public function getBon_detail_prix_unitaire() {
        return $this->bon_detail_prix_unitaire;
    }

    public function setBon_detail_prix_unitaire($bon_detail_prix_unitaire) {
        $this->bon_detail_prix_unitaire = $bon_detail_prix_unitaire;
        return $this;
    }



}

?>
