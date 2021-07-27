<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuKrr {

      protected $id_credit;
      protected $date_demande;
      protected $code_membre;
      protected $code_produit;
      protected $date_echue;
      protected $date_renouveller;
      protected $payer;
      protected $mont_capa;
      protected $mont_krr;
      protected $mont_reconst;
      protected $reconstituer;
	  protected $code_membre_morale;
	  protected $type_krr;
	

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

    public function getId_credit() {
        return $this->id_credit;
    }

    public function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getCode_produit() {
        return $this->code_produit;
    }

    public function setCode_produit($code_produit) {
        $this->code_produit = $code_produit;
        return $this;
    }

    public function getDate_echue() {
        return $this->date_echue;
    }

    public function setDate_echue($date_echue) {
        $this->date_echue = $date_echue;
        return $this;
    }

    public function getDate_renouveller() {
        return $this->date_renouveller;
    }

    public function setDate_renouveller($date_renouveller) {
        $this->date_renouveller = $date_renouveller;
        return $this;
    }

    public function getPayer() {
        return $this->payer;
    }

    public function setPayer($payer) {
        $this->payer = $payer;
        return $this;
    }

    public function getMont_capa() {
        return $this->mont_capa;
    }

    public function setMont_capa($mont_capa) {
        $this->mont_capa = $mont_capa;
        return $this;
    }
    
    public function getDate_demande(){
        return $this->date_demande;
    }

    public function setDate_demande($date_demande){
        $this->date_demande = $date_demande;
        return $this;
    }
    
    public function getReconstituer(){
        return $this->reconstituer;
    }

    public function setReconstituer($reconstituer){
        $this->reconstituer = $reconstituer;
        return $this;
    }
    
    public function getMont_krr() {
        return $this->mont_krr;
    }

    public function setMont_krr($mont_krr) {
        $this->mont_krr = $mont_krr;
        return $this;
    }
    
    public function getMont_reconst() {
        return $this->mont_reconst;
    }

    public function setMont_reconst($mont_reconst) {
        $this->mont_reconst = $mont_reconst;
        return $this;
    }
	
	
	public function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    public function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }
	
	public function getType_krr() {
        return $this->type_krr;
    }

    public function setType_krr($type_krr) {
        $this->type_krr = $type_krr;
        return $this;
    }
	
	
	
}
