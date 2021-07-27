<?php

class Application_Model_EuSmcipnpwi {

    protected $code_smcipn;
    protected $code_membre;
    protected $date_smcipn;
    protected $mont_salaire;
    protected $mont_investis;
    protected $salaire_alloue;
    protected $investis_alloue;
    protected $type_smcipn;
    protected $rembourser;
    protected $etat_alloc_salaire;
    protected $etat_alloc_investis;
    protected $id_utilisateur;

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

    public function getCode_smcipn() {
        return $this->code_smcipn;
    }

    public function setCode_smcipn($code_smcipn) {
        $this->code_smcipn = $code_smcipn;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
    
    public function getDate_smcipn() {
        return $this->date_smcipn;
    }

    public function setDate_smcipn($date_smcipn) {
        $this->date_smcipn = $date_smcipn;
        return $this;
    }

    public function getMont_salaire() {
        return $this->mont_salaire;
    }

    public function setMont_salaire($mont_salaire) {
        $this->mont_salaire = $mont_salaire;
        return $this;
    }

    public function getMont_investis() {
        return $this->mont_investis;
    }

    public function setMont_investis($mont_investis) {
        $this->mont_investis = $mont_investis;
        return $this;
    }

    public function getSalaire_alloue() {
        return $this->salaire_alloue;
    }

    public function setSalaire_alloue($salaire_alloue) {
        $this->salaire_alloue = $salaire_alloue;
        return $this;
    }

    public function getInvestis_alloue() {
        return $this->investis_alloue;
    }

    public function setInvestis_alloue($investis_alloue) {
        $this->investis_alloue = $investis_alloue;
        return $this;
    }

    public function getType_smcipn() {
        return $this->type_smcipn;
    }

    public function setType_smcipn($type_smcipn) {
        $this->type_smcipn = $type_smcipn;
        return $this;
    }   

    public function getRembourser() {
        return $this->rembourser;
    }

    public function setRembourser($rembourser) {
        $this->rembourser = $rembourser;
        return $this;
    }

    public function getEtat_alloc_investis() {
        return $this->etat_alloc_investis;
    }

    public function setEtat_alloc_investis($etat_alloc_investis) {
        $this->etat_alloc_investis = $etat_alloc_investis;
        return $this;
    }

    public function getEtat_alloc_salaire() {
        return $this->etat_alloc_salaire;
    }

    public function setEtat_alloc_salaire($etat_alloc_salaire) {
        $this->etat_alloc_salaire = $etat_alloc_salaire;
        return $this;
    }
    
    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

}

?>
