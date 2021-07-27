<?php

class Application_Model_EuInvestissement {

    protected $id_investissement;
    protected $montant_budget;
    protected $cat_objet;
    protected $date_investissement;
    protected $code_smcipn;
    protected $id_utilisateur;
    protected $id_besoin;

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

    public function getId_investissement() {
        return $this->id_investissement;
    }

    public function setId_investissement($id_investissement) {
        $this->id_investissement = $id_investissement;
        return $this;
    }

    public function getMontant_budget() {
        return $this->montant_budget;
    }

    public function setMontant_budget($montant_budget) {
        $this->montant_budget = $montant_budget;
        return $this;
    }

    public function getCat_objet() {
        return $this->cat_objet;
    }

    public function setCat_objet($cat_objet) {
        $this->cat_objet = $cat_objet;
        return $this;
    }

    public function getDate_investissement() {
        return $this->date_investissement;
    }

    public function setDate_investissement($date_investissement) {
        $this->date_investissement = $date_investissement;
        return $this;
    }

    public function getCode_smcipn() {
        return $this->code_smcipn;
    }

    public function setCode_smcipn($code_smcipn) {
        $this->code_smcipn = $code_smcipn;
        return $this;
    }
    
    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
    
    public function getId_besoin() {
        return $this->id_besoin;
    }

    public function setId_besoin($id_besoin) {
        $this->id_besoin = $id_besoin;
        return $this;
    }

}

?>
