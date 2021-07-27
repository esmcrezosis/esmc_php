<?php

class Application_Model_EuAncienEscompte {

    protected $id_escompte;
    protected $code_compte;
    protected $code_membre;
    protected $code_membre_benef;
    protected $date_escompte;
    protected $id_echange;
    protected $montant;
    protected $ntf;
    protected $mont_tranche;
    protected $date_deb;
    protected $periode;
    protected $date_fin;
    protected $mont_echu;
    protected $mont_echu_transferer;
    protected $date_deb_tranche;
    protected $date_fin_tranche;
    protected $reste_ntf;
    protected $solde;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid compte_gcp property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid compte_gcp property');
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

    function getId_escompte() {
        return $this->id_escompte;
    }

    function setId_escompte($id_escompte) {
        $this->id_escompte = $id_escompte;
        return $this;
    }

    function getCode_compte() {
        return $this->code_compte;
    }

    function setCode_compte($code_compte) {
        $this->code_compte = $code_compte;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getCode_membre_benef() {
        return $this->code_membre_benef;
    }

    public function setCode_membre_benef($code_membre_benef) {
        $this->code_membre_benef = $code_membre_benef;
        return $this;
    }

    function getMontant() {
        return $this->montant;
    }

    function setMontant($montant) {
        $this->montant = $montant;
        return $this;
    }

    function getNtf() {
        return $this->ntf;
    }

    function setNtf($ntf) {
        $this->ntf = $ntf;
        return $this;
    }

    function getReste_ntf() {
        return $this->reste_ntf;
    }

    function setReste_ntf($reste_ntf) {
        $this->reste_ntf = $reste_ntf;
        return $this;
    }

    function getMont_tranche() {
        return $this->mont_tranche;
    }

    function setMont_tranche($mont_tranche) {
        $this->mont_tranche = $mont_tranche;
        return $this;
    }

    function getDate_deb() {
        return $this->date_deb;
    }

    function setDate_deb($date_deb) {
        $this->date_deb = $date_deb;
        return $this;
    }

    function getDate_escompte() {
        return $this->date_escompte;
    }

    function setDate_escompte($date_escompte) {
        $this->date_escompte = $date_escompte;
        return $this;
    }

    function getPeriode() {
        return $this->periode;
    }

    function setPeriode($periode) {
        $this->periode = $periode;
        return $this;
    }

    function getDate_fin() {
        return $this->date_fin;
    }

    function setDate_fin($date_fin) {
        $this->date_fin = $date_fin;
        return $this;
    }

    function getMont_echu() {
        return $this->mont_echu;
    }

    function setMont_echu($mont_echu) {
        $this->mont_echu = $mont_echu;
        return $this;
    }
    
    function getMont_echu_transferer() {
        return $this->mont_echu_transferer;
    }

    function setMont_echu_transferer($mont_echu_transferer) {
        $this->mont_echu_transferer = $mont_echu_transferer;
        return $this;
    }

    function getDate_deb_tranche() {
        return $this->date_deb_tranche;
    }

    function setDate_deb_tranche($date_deb_tranche) {
        $this->date_deb_tranche = $date_deb_tranche;
        return $this;
    }

    function getDate_fin_tranche() {
        return $this->date_fin_tranche;
    }

    function setDate_fin_tranche($date_fin_tranche) {
        $this->date_fin_tranche = $date_fin_tranche;
        return $this;
    }

    function getSolde() {
        return $this->solde;
    }

    function setSolde($solde) {
        $this->solde = $solde;
        return $this;
    }

    public function getId_echange() {
        return $this->id_echange;
    }

    public function setId_echange($id_echange) {
        $this->id_echange = $id_echange;
        return $this;
    }

}

