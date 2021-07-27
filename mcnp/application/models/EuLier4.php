<?php

class Application_Model_EuLier4 {

    protected $num_pforma;
    protected $id_objet_hors;
    protected $qte_objet;
    protected $pu_objet;
    protected $remise;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        $this->$method($value);
    }
    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
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
    function getNum_pforma() {
        return $this->num_pforma;
    }
    function setNum_pforma($num_pforma) {
        $this->num_pforma = $num_pforma;
        return $this;
    }
    function getId_objet_hors() {
        return $this->id_objet_hors;
    }
    function setId_objet_hors($id_objet_hors) {
        $this->id_objet_hors = $id_objet_hors;
        return $this;
    }

    function getQte_objet() {
        return $this->qte_objet;
    }
    function setQte_objet($qte_objet) {
        $this->qte_objet = $qte_objet;
        return $this;;
    }

    function getPu_objet() {
        return $this->pu_objet;
    }
    function setPu_objet($pu_objet) {
        $this->pu_objet = $pu_objet;
        return $this;
    }
    function getRemise() {
        return $this->remise;
    }
    function setRemise($remise) {
        $this->remise = $remise;
        return $this;
    }
}
