<?php

class Application_Model_EuFactureSmcipnDetail {

    protected $id_facture_detail;
    protected $code_facture;
    protected $code_membre_fournisseur;
    protected $mont_investis;
    protected $investis_alloue;
    protected $solde_investis;
    protected $code_membre_salarier;
    protected $mont_salaire;
    protected $salaire_alloue;
    protected $solde_salaire;

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
    
    function getId_facture_detail() {
        return $this->id_facture_detail;
    }

    function setId_facture_detail($id_facture_detail) {
        $this->id_facture_detail = $id_facture_detail;
        return $this;
    }
    

    function getCode_facture() {
        return $this->code_facture;
    }

    function setCode_facture($code_facture) {
        $this->code_facture = $code_facture;
        return $this;
    }

    
    function getCode_membre_fournisseur() {
        return $this->code_membre_fournisseur;
    }

    function setCode_membre_fournisseur($code_membre_fournisseur) {
        $this->code_membre_fournisseur = $code_membre_fournisseur;
        return $this;
    }
    
    function getMont_investis() {
        return $this->mont_investis;
    }

    function setMont_investis($mont_investis) {
        $this->mont_investis = $mont_investis;
        return $this;
    }
    
    function getInvestis_alloue() {
        return $this->investis_alloue;
    }

    function setInvestis_alloue($investis_alloue) {
        $this->investis_alloue = $investis_alloue;
        return $this;
    }
    
    function getSolde_investis() {
        return $this->solde_investis;
    }

    function setSolde_investis($solde_investis) {
        $this->solde_investis = $solde_investis;
        return $this;
    }
    
    function getCode_membre_salarier() {
        return $this->code_membre_salarier;
    }

    function setCode_membre_salarier($code_membre_salarier) {
        $this->code_membre_salarier = $code_membre_salarier;
        return $this;
    }

    function getMont_salaire() {
        return $this->mont_salaire;
    }

    function setMont_salaire($mont_salaire) {
        $this->mont_salaire = $mont_salaire;
        return $this;
    }

    function getSalaire_alloue() {
        return $this->salaire_alloue;
    }

    function setSalaire_alloue($salaire_alloue) {
        $this->salaire_alloue = $salaire_alloue;
        return $this;
    }

    function getSolde_salaire() {
        return $this->solde_salaire;
    }

    function setSolde_salaire($solde_salaire) {
        $this->solde_salaire = $solde_salaire;
        return $this;
    }

}
