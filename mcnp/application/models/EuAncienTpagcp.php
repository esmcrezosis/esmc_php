<?php

class Application_Model_EuAncienTpagcp {

    protected $id_tpagcp;
    protected $code_tegc;
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

    function getCode_tegc() {
        return $this->code_tegc;
    }

    function setCode_tegc($code_tegc) {
        $this->code_tegc = $code_tegc;
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
	

}

