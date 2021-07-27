<?php

class Application_Model_EuDomiciliation {

    protected $code_domicilier;
    protected $code_membre_beneficiaire;
    protected $code_membre_assureur;
    protected $cat_ressource;
    protected $montant_subvent;
    protected $montant_domicilier;
    protected $domicilier;
    protected $accorder;
    protected $date_domiciliation;
    protected $date_echue;
    protected $type_domiciliation;
    protected $code_smcipn;
    protected $code_smcipnp;
    protected $id_utilisateur;
    protected $id_proposition;
    protected $duree_renouvellement;
    protected $reste_duree;

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

    public function getCode_domicilier() {
        return $this->code_domicilier;
    }

    public function setCode_domicilier($code_domicilier) {
        $this->code_domicilier = $code_domicilier;
        return $this;
    }

    public function getCode_membre_beneficiaire() {
        return $this->code_membre_beneficiaire;
    }

    public function setCode_membre_beneficiaire($code_membre_beneficiaire) {
        $this->code_membre_beneficiaire = $code_membre_beneficiaire;
        return $this;
    }

    public function getCode_membre_assureur() {
        return $this->code_membre_assureur;
    }

    public function setCode_membre_assureur($code_membre_assureur) {
        $this->code_membre_assureur = $code_membre_assureur;
        return $this;
    }

    public function getCat_ressource() {
        return $this->cat_ressource;
    }

    public function setCat_ressource($cat_ressource) {
        $this->cat_ressource = $cat_ressource;
        return $this;
    }

    public function getMontant_subvent() {
        return $this->montant_subvent;
    }

    public function setMontant_subvent($montant_subvent) {
        $this->montant_subvent = $montant_subvent;
        return $this;
    }

    public function getMontant_domicilier() {
        return $this->montant_domicilier;
    }

    public function setMontant_domicilier($montant_domicilier) {
        $this->montant_domicilier = $montant_domicilier;
        return $this;
    }

    public function getDomicilier() {
        return $this->domicilier;
    }

    public function setDomicilier($domicilier) {
        $this->domicilier = $domicilier;
        return $this;
    }

    public function getAccorder() {
        return $this->accorder;
    }

    public function setAccorder($accorder) {
        $this->accorder = $accorder;
        return $this;
    }

    public function getDate_domiciliation() {
        return $this->date_domiciliation;
    }

    public function setDate_domiciliation($date_domiciliation) {
        $this->date_domiciliation = $date_domiciliation;
        return $this;
    }

    public function getDate_echue() {
        return $this->date_echue;
    }

    public function setDate_echue($date_echue) {
        $this->date_echue = $date_echue;
        return $this;
    }

    public function getType_domiciliation() {
        return $this->type_domiciliation;
    }

    public function setType_domiciliation($type_domiciliation) {
        $this->type_domiciliation = $type_domiciliation;
        return $this;
    }

    public function getCode_smcipn() {
        return $this->code_smcipn;
    }

    public function setCode_smcipn($code_smcipn) {
        $this->code_smcipn = $code_smcipn;
        return $this;
    }

    public function getCode_smcipnp() {
        return $this->code_smcipnp;
    }

    public function setCode_smcipnp($code_smcipnp) {
        $this->code_smcipnp = $code_smcipnp;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
    
    function getId_proposition() {
        return $this->id_proposition;
    }

    function setId_proposition($id_proposition) {
        $this->id_proposition = $id_proposition;
        return $this;
    }

    function getDuree_renouvellement() {
        return $this->duree_renouvellement;
    }

    function setDuree_renouvellement($duree_renouvellement) {
        $this->duree_renouvellement = $duree_renouvellement;
        return $this;
    }

    function getReste_duree() {
        return $this->reste_duree;
    }

    function setReste_duree($reste_duree) {
        $this->reste_duree = $reste_duree;
        return $this;
    }
}

?>
