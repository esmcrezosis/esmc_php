<?php

class Application_Model_EuPorter {

    protected $id_porter;
    protected $code_proforma;
    protected $id_objet;
    protected $qte_objet;
    protected $pu_objet;
    protected $remise;
    protected $mdv;
    protected $disponible;

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

    function getId_porter() {
        return $this->id_porter;
    }

    function setId_porter($id_porter) {
        $this->id_porter = $id_porter;
        return $this;
    }

    function getCode_proforma() {
        return $this->code_proforma;
    }

    function setCode_proforma($code_proforma) {
        $this->code_proforma = $code_proforma;
        return $this;
    }

    function getId_objet() {
        return $this->id_objet;
    }

    function setId_objet($id_objet) {
        $this->id_objet = $id_objet;
        return $this;
    }

    function getQte_objet() {
        return $this->qte_objet;
    }

    function setQte_objet($qte_objet) {
        $this->qte_objet = $qte_objet;
        return $this;
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

    function getMdv() {
        return $this->mdv;
    }

    function setMdv($mdv) {
        $this->mdv = $mdv;
        return $this;
    }

    function getDisponible() {
        return $this->disponible;
    }

    function setDisponible($disponible) {
        $this->disponible = $disponible;
        return $this;
    }

}

