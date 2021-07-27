<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDevise
 *
 * @author user
 */
 
class Application_Model_EuCodeActivation {

    //put your code here
    protected $id_code_activation;
    protected $souscription_id;
    protected $date_generer;
    protected $code_fs;
    protected $code_fl;
    protected $code_fkps;
    protected $code_membre;
    protected $origine_code;
    protected $membreasso_id;
	protected $montant_souscrit;
    
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
    
    public function getId_code_activation() {
        return $this->id_code_activation;
    }
    
    public function setId_code_activation($id_code_activation){
        $this->id_code_activation = $id_code_activation;
        return $this;
    }

    public function getSouscription_id() {
        return $this->souscription_id;
    }
    public function setSouscription_id($souscription_id) {
        $this->souscription_id = $souscription_id;
        return $this;
    }
    
    
    public function getCode_fs() {
      return $this->code_fs;
    } 
    
    public function setCode_fs($code_fs) {
        $this->code_fs = $code_fs;
        return $this;
    }
    
    public function getCode_fl() {
      return $this->code_fl;
    }
    public function setCode_fl($code_fl){
        $this->code_fl = $code_fl;
        return $this;
    }
    
    public function getCode_fkps() {
      return $this->code_fkps;
    }
    
    public function setCode_fkps($code_fkps) {
      $this->code_fkps = $code_fkps;
      return $this;
    }
    
    
    public function getCode_membre() {
      return $this->code_membre;
    }
    
    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
    
    public function getDate_generer(){
        return $this->date_generer;
    }
    public function setDate_generer($date_generer) {
        $this->date_generer = $date_generer;
        return $this;
    }
    
    public function getOrigine_code(){
        return $this->origine_code;
    }
    public function setOrigine_code($origine_code) {
        $this->origine_code = $origine_code;
        return $this;
    }
    
    
    public function getMembreasso_id(){
        return $this->membreasso_id;
    }
    public function setMembreasso_id($membreasso_id) {
        $this->membreasso_id = $membreasso_id;
        return $this;
    }
	
	
	public function getMontant_souscrit() {
        return $this->montant_souscrit;
    }
	
    public function setMontant_souscrit($montant_souscrit) {
        $this->montant_souscrit = $montant_souscrit;
        return $this;
    }
	
	
	
	
    
}

?>
