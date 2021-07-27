<?php

class Application_Model_EuBudgetFacture {

    protected $id_objet;
    protected $code_proforma;
    protected $pu_objet;
    protected $qte_objet;
    protected $remise_objet;
    protected $categorie_objet;
    protected $id_besoin;
    protected $id_investissement;
   

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

    function getId_objet() {
        return $this->id_objet;
    }

    function setId_objet($id_objet) {
        $this->id_objet = $id_objet;
        return $this;
    }

    function getCode_proforma() {
        return $this->code_proforma;
    }

    function setCode_proforma($code_proforma) {
        $this->code_proforma = $code_proforma;
        return $this;
    }

    function getPu_objet() {
        return $this->pu_objet;
    }

    function setPu_objet($pu_objet) {
        $this->pu_objet = $pu_objet;
        return $this;
    }

    function getQte_objet() {
        return $this->qte_objet;
    }

    function setQte_objet($qte_objet) {
        $this->qte_objet = $qte_objet;
        return $this;
    }

    function getRemise_objet() {
        return $this->remise_objet;
    }

    function setRemise_objet($remise_objet) {
        $this->remise_objet = $remise_objet;
        return $this;
    }

    function getCategorie_objet() {
        return $this->categorie_objet;
    }

    function setCategorie_objet($categorie_objet) {
        $this->categorie_objet = $categorie_objet;
        return $this;
    }
    
    function getId_investissement() {
        return $this->id_investissement;
    }

    function setId_investissement($id_investissement) {
        $this->id_investissement = $id_investissement;
        return $this;
    }
    
    function getId_besoin() {
        return $this->id_besoin;
    }

    function setId_besoin($id_besoin) {
        $this->id_besoin = $id_besoin;
        return $this;
    }

}

