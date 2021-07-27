<?php

class Application_Model_EuTpagcp {

    protected $id_tpagcp; 
    protected $code_membre;
    protected $code_compte;
    protected $mont_gcp;
    protected $date_deb;
    protected $ntf;
    protected $mont_tranche;
    protected $date_fin;
    protected $periode;
    protected $date_fin_tranche;
    protected $mont_echu;
    protected $mont_echange;
    protected $mont_escompte;
    protected $solde;
    protected $reste_ntf;
    protected $date_deb_tranche;
    protected $escomptable;
    protected $mode_reglement;
    protected $type_ressource;
    protected $mont_gcp_maj;
    protected $numero_bl;
    protected $type_bl;
    protected $reinjecter;
    protected $nbre_injection;
    

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

    function getId_tpagcp() {
        return $this->id_tpagcp;
    }

    function setId_tpagcp($id_tpagcp) {
        $this->id_tpagcp = $id_tpagcp;
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

    function getMont_gcp() {
        return $this->mont_gcp;
    }

    function setMont_gcp($mont_gcp) {
        $this->mont_gcp = $mont_gcp;
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

    function getDate_deb_tranche() {
        return $this->date_deb_tranche;
    }

    function setDate_deb_tranche($date_deb_tranche) {
        $this->date_deb_tranche = $date_deb_tranche;
        return $this;
    }

    function getPeriode(){
        return $this->periode;
    }

    function setPeriode($periode){
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

    function getDate_fin_tranche() {
        return $this->date_fin_tranche;
    }

    function setDate_fin_tranche($date_fin_tranche) {
        $this->date_fin_tranche = $date_fin_tranche;
        return $this;
    }

    function getMont_echu(){
        return $this->mont_echu;
    }

    function setMont_echu($mont_echu){
        $this->mont_echu = $mont_echu;
        return $this;
    }

    function getMont_echange(){
        return $this->mont_echange;
    }

    function setMont_echange($mont_echange){
        $this->mont_echange = $mont_echange;
        return $this;
    }

    function getMont_escompte(){
        return $this->mont_escompte;
    }

    function setMont_escompte($mont_escompte){
        $this->mont_escompte = $mont_escompte;
        return $this;
    }

    function getSolde(){
        return $this->solde;
    }

    function setSolde($solde){
        $this->solde = $solde;
        return $this;
    }


    function getEscomptable(){
        return $this->escomptable;
    }

    function setEscomptable($escomptable) {
        $this->escomptable = $escomptable;
        return $this;
    }


    function getMode_reglement() {
        return $this->mode_reglement;
    }

    function setMode_reglement($mode_reglement) {
        $this->mode_reglement = $mode_reglement;
        return $this;
    }

    function getType_ressource() {
        return $this->type_ressource;
    }

    function setType_ressource($type_ressource) {
        $this->type_ressource = $type_ressource;
        return $this;
    }


    function getMont_gcp_maj() {
        return $this->mont_gcp_maj;
    }

    function setMont_gcp_maj($mont_gcp_maj) {
        $this->mont_gcp_maj = $mont_gcp_maj;
        return $this;
    }

    function getNumero_bl() {
        return $this->numero_bl;
    }

    function setNumero_bl($numero_bl) {
        $this->numero_bl = $numero_bl;
        return $this;
    }

    function getType_bl() {
        return $this->type_bl;
    }

    function setType_bl($type_bl) {
        $this->type_bl = $type_bl;
        return $this;
    }


    function getReinjecter() {
        return $this->reinjecter;
    }

    function setReinjecter($reinjecter) {
        $this->reinjecter = $reinjecter;
        return $this;
    }


    function getNbre_injection() {
        return $this->nbre_injection;
    }

    function setNbre_injection($nbre_injection) {
        $this->nbre_injection = $nbre_injection;
        return $this;
    }




}
