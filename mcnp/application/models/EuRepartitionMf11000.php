<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuRepartitionMf11000 {

    protected $id_rep;
    protected $id_mf11000;
    protected $code_mf11000;
    protected $code_membre;
    protected $mont_rep;
    protected $mont_reglt;
    protected $solde_rep;
    protected $date_rep;
    protected $payer;
    protected $id_utilisateur;
	protected $etat;


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

    function getId_rep() {
        return $this->id_rep;
    }

    function setId_rep($id_rep) {
        $this->id_rep = $id_rep;
        return $this;
    }

    function getId_mf11000() {
        return $this->id_mf11000;
    }

    function setId_mf11000($id_mf11000) {
        $this->id_mf11000 = $id_mf11000;
        return $this;
    }
    
    function getCode_mf11000() {
        return $this->code_mf11000;
    }

    function setCode_mf11000($code_mf11000) {
        $this->code_mf11000 = $code_mf11000;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    function getMont_rep() {
        return $this->mont_rep;
    }

    function setMont_rep($mont_rep) {
        $this->mont_rep = $mont_rep;
        return $this;
    }

    function getDate_rep() {
        return $this->date_rep;
    }

    function setDate_rep($date_rep) {
        $this->date_rep = $date_rep;
        return $this;
    }

    function getPayer() {
        return $this->payer;
    }

    function setPayer($payer) {
        $this->payer = $payer;
        return $this;
    }

    function getMont_reglt() {
        return $this->mont_reglt;
    }

    function setMont_reglt($mont_reglt) {
        $this->mont_reglt = $mont_reglt;
        return $this;
    }
    
    function getSolde_rep() {
        return $this->solde_rep;
    }

    function setSolde_rep($solde_rep) {
        $this->solde_rep = $solde_rep;
        return $this;
    }

    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
	
	
	function getEtat() {
        return $this->etat;
    }

    function setEtat($etat) {
        $this->etat = $etat;
        return $this;
    }
	
	

}

?>
