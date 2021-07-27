<?php

class Application_Model_EuSmcipnp {

    protected $code_smcipnp;
    protected $lib_smcipnp;
    protected $code_membre;
    protected $desc_smcipnp;
    protected $date_smcipnp;
    protected $heure_smcipnp;
    protected $montant_smcipnp;
    protected $source_smcipnp;
    protected $code_acteur;
    protected $date_alloc;
    protected $etat_smcipnp;
    protected $transferer;
    protected $rembourser;
    protected $id_utilisateur;
    protected $domicilier;

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

    public function getCode_smcipnp() {
        return $this->code_smcipnp;
    }

    public function setCode_smcipnp($code_smcipnp) {
        $this->code_smcipnp = $code_smcipnp;
        return $this;
    }

    public function getLib_smcipnp() {
        return $this->lib_smcipnp;
    }

    public function setLib_smcipnp($lib_smcipnp) {
        $this->lib_smcipnp = $lib_smcipnp;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getDesc_smcipnp() {
        return $this->desc_smcipnp;
    }

    public function setDesc_smcipnp($desc_smcipnp) {
        $this->desc_smcipnp = $desc_smcipnp;
        return $this;
    }

    public function getDate_smcipnp() {
        return $this->date_smcipnp;
    }

    public function setDate_smcipnp($date_smcipnp) {
        $this->date_smcipnp = $date_smcipnp;
        return $this;
    }

    public function getHeure_smcipnp() {
        return $this->heure_smcipnp;
    }

    public function setHeure_smcipnp($heure_smcipnp) {
        $this->heure_smcipnp = $heure_smcipnp;
        return $this;
    }

    public function getMontant_smcipnp() {
        return $this->montant_smcipnp;
    }

    public function setMontant_smcipnp($montant_smcipnp) {
        $this->montant_smcipnp = $montant_smcipnp;
        return $this;
    }

    public function getSource_smcipnp() {
        return $this->source_smcipnp;
    }

    public function setSource_smcipnp($source_smcipnp) {
        $this->source_smcipnp = $source_smcipnp;
        return $this;
    }

    public function getCode_acteur() {
        return $this->code_acteur;
    }

    public function setCode_acteur($code_acteur) {
        $this->code_acteur = $code_acteur;
        return $this;
    }

    public function getDate_alloc() {
        return $this->date_alloc;
    }

    public function setDate_alloc($date_alloc) {
        $this->date_alloc = $date_alloc;
        return $this;
    }

    public function getEtat_smcipnp() {
        return $this->etat_smcipnp;
    }

    public function setEtat_smcipnp($etat_smcipnp) {
        $this->etat_smcipnp = $etat_smcipnp;
        return $this;
    }

    public function getTransferer() {
        return $this->transferer;
    }

    public function setTransferer($transferer) {
        $this->transferer = $transferer;
        return $this;
    }

    public function getRembourser() {
        return $this->rembourser;
    }

    public function setRembourser($rembourser) {
        $this->rembourser = $rembourser;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getDomicilier() {
        return $this->domicilier;
    }

    public function setDomicilier($domicilier) {
        $this->domicilier = $domicilier;
        return $this;
    }

}

