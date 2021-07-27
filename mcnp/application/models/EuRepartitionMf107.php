<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuRepartitionMf107 {
	
    protected $id_rep;
    protected $id_mf107;
    protected $code_membre;
    protected $date_rep;
    protected $mont_rep;
    protected $mont_reglt;
	protected $solde_rep;
    protected $payer;
    protected $id_utilisateur;

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

    
    function getId_mf107() {
        return $this->id_mf107;
    }

    
    function setId_mf107($id_mf107) {
        $this->id_mf107 = $id_mf107;
        return $this;
    }

    
    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
    
    function getDate_rep() {
        return $this->date_rep;
    }

    function setDate_rep($date_rep) {
        $this->date_rep = $date_rep;
        return $this;
    }
    
    function getMont_rep() {
        return $this->mont_rep;
    }

    function setMont_rep($mont_rep) {
        $this->mont_rep = $mont_rep;
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
	
	
    
    function getPayer() {
        return $this->payer;
    }

    function setPayer($payer) {
        $this->payer = $payer;
        return $this;
    }
    
    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

}
?>
