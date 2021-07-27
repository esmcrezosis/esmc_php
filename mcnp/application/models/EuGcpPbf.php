<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuGcpPbf
 *
 * @author user
 */
class Application_Model_EuGcpPbf {

    //put your code here
    protected $code_gcp_pbf;
    protected $code_membre;
    protected $code_compte;
    protected $mont_gcp;
    protected $mont_gcp_reel;
    protected $mont_agio;
    protected $gcp_compense;
    protected $solde_gcp_reel;
    protected $solde_gcp;
    protected $agio_consomme;
    protected $solde_agio;
    protected $type_capa;

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
            throw new Exception('Invalid compte_gcsc property');
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

    public function getCode_gcp_pbf() {
        return $this->code_gcp_pbf;
    }

    public function setCode_gcp_pbf($code_gcp_pbf) {
        $this->code_gcp_pbf = $code_gcp_pbf;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getCode_compte() {
        return $this->code_compte;
    }

    public function setCode_compte($code_compte) {
        $this->code_compte = $code_compte;
        return $this;
    }

    public function getMont_gcp() {
        return $this->mont_gcp;
    }

    public function setMont_gcp($mont_gcp) {
        $this->mont_gcp = $mont_gcp;
        return $this;
    }

    public function getMont_gcp_reel() {
        return $this->mont_gcp_reel;
    }

    public function setMont_gcp_reel($mont_gcp_reel) {
        $this->mont_gcp_reel = $mont_gcp_reel;
        return $this;
    }

    public function setMont_agio($mont_agio) {
        $this->mont_agio = $mont_agio;
        return $this;
    }

    public function getMont_agio() {
        return $this->mont_agio;
    }

    public function getSolde_gcp_reel() {
        return $this->solde_gcp_reel;
    }

    public function setSolde_gcp_reel($solde_gcp_reel) {
        $this->solde_gcp_reel = $solde_gcp_reel;
        return $this;
    }

    public function getSolde_gcp() {
        return $this->solde_gcp;
    }

    public function setSolde_gcp($solde_gcp) {
        $this->solde_gcp = $solde_gcp;
        return $this;
    }

    public function getGcp_compense() {
        return $this->gcp_compense;
    }

    public function setGcp_compense($gcp_compense) {
        $this->gcp_compense = $gcp_compense;
        return $this;
    }

    public function getAgio_comsomme() {
        return $this->agio_consomme;
    }

    public function setAgio_consomme($agio_consomme) {
        $this->agio_consomme = $agio_consomme;
        return $this;
    }

    public function getSolde_agio() {
        return $this->solde_agio;
    }

    public function setSolde_agio($solde_agio) {
        $this->solde_agio = $solde_agio;
        return $this;
    }
    
    public function getType_capa() {
        return $this->type_capa;
    }

    public function setType_capa($type_capa) {
        $this->type_capa = $type_capa;
        return $this;
    }

}

?>
