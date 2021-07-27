<?php
 
class Application_Model_EuFacturesDetail {

    //put your code here
    protected $facture_detail_id;
    protected $facture_detail_libelle;
    protected $facture_detail_reference;
    protected $facture_detail_quantite;
    protected $facture_id;
    protected $facture_detail_prix_unitaire;

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

    public function getFacture_detail_id() {
        return $this->facture_detail_id;
    }

    public function setFacture_detail_id($facture_detail_id) {
        $this->facture_detail_id = $facture_detail_id;
        return $this;
    }

    public function getFacture_detail_quantite() {
        return $this->facture_detail_quantite;
    }

    public function setFacture_detail_quantite($facture_detail_quantite) {
        $this->facture_detail_quantite = $facture_detail_quantite;
        return $this;
    }

    public function getFacture_detail_reference() {
        return $this->facture_detail_reference;
    }

    public function setFacture_detail_reference($facture_detail_reference) {
        $this->facture_detail_reference = $facture_detail_reference;
        return $this;
    }


    public function getFacture_detail_libelle() {
        return ($this->facture_detail_libelle);
    }

    public function setFacture_detail_libelle($facture_detail_libelle) {
        $this->facture_detail_libelle = ($facture_detail_libelle);
        return $this;
    }

    public function getFacture_id() {
        return $this->facture_id;
    }

    public function setFacture_id($facture_id) {
        $this->facture_id = $facture_id;
        return $this;
    }

    public function getFacture_detail_prix_unitaire() {
        return $this->facture_detail_prix_unitaire;
    }

    public function setFacture_detail_prix_unitaire($facture_detail_prix_unitaire) {
        $this->facture_detail_prix_unitaire = $facture_detail_prix_unitaire;
        return $this;
    }



}

?>
