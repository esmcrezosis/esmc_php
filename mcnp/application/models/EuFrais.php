<?php

class Application_Model_EuFrais {

    protected $if_frais;
    protected $code_gac;
    protected $pourcent_frais;
    protected $mont_projet;
    protected $date_frais;
    protected $id_proposition;
    protected $id_utilisateur;
    protected $disponible;
    protected $montant_proposition;
    protected $montant_salaire;
    protected $montant_frais;
    protected $valider;

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

    function getId_frais() {
        return $this->id_frais;
    }

    function setId_frais($id_frais) {
        $this->id_frais = $id_frais;
        return $this;
    }

    function getCode_gac() {
        return $this->code_gac;
    }

    function setCode_gac($code_gac) {
        $this->code_gac = $code_gac;
        return $this;
    }

    function getPourcent_frais() {
        return $this->pourcent_frais;
    }

    function setPourcent_frais($pourcent_frais) {
        $this->pourcent_frais = $pourcent_frais;
        return $this;
    }

    function getMont_projet() {
        return $this->mont_projet;
    }

    function setMont_projet($mont_projet) {
        $this->mont_projet = $mont_projet;
        return $this;
    }

    function getDate_frais() {
        return $this->date_frais;
    }

    function setDate_frais($date_frais) {
        $this->date_frais = $date_frais;
        return $this;
    }

    function getId_proposition() {
        return $this->id_proposition;
    }

    function setId_proposition($id_proposition) {
        $this->id_proposition = $id_proposition;
        return $this;
    }

    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
    public function getDisponible() {
        return $this->disponible;
    }

    public function setDisponible($disponible) {
        $this->disponible = $disponible;
        return $this;
    }

    public function getMontant_proposition() {
        return $this->montant_proposition;
    }

    public function setMontant_proposition($montant_proposition) {
        $this->montant_proposition = $montant_proposition;
        return $this;
    }

    public function getMontant_salaire() {
        return $this->montant_salaire;
    }

    public function setMontant_salaire($montant_salaire) {
        $this->montant_salaire = $montant_salaire;
        return $this;
    }

    public function getMontant_frais() {
        return $this->montant_frais;
    }

    public function setMontant_frais($montant_frais) {
        $this->montant_frais = $montant_frais;
        return $this;
    }

    public function getValider() {
        return $this->valider;
    }

    public function setValider($valider) {
        $this->valider = $valider;
        return $this;
    }
	
}
