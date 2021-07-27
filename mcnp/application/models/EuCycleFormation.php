<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuCycleFormation
 *
 */
 
class Application_Model_EuCycleFormation {
    //put your code here
    protected $id;
    protected $code_cycle_formation;
    protected $nom_cycle_formation;
    protected $duree_annee_formation;
    protected $duree_cycle_formation;
	protected $taux_cycle_formation;
    
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
	
    
    
    public function getId(){
        return $this->id;
    }
    
    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getCode_cycle_formation(){
        return $this->code_cycle_formation;
    }
    
    public function setCode_cycle_formation($code_cycle_formation){
        $this->code_cycle_formation = $code_cycle_formation;
        return $this;
    }
    
    public function getNom_cycle_formation(){
        return $this->nom_cycle_formation;
    }
    
    public function setNom_cycle_formation($nom_cycle_formation) {
        $this->nom_cycle_formation = $nom_cycle_formation;
        return $this;
    }
	
    
    public function getDuree_annee_formation(){
        return $this->duree_annee_formation;
    }
    
    public function setDuree_annee_formation($duree_annee_formation){
        $this->duree_annee_formation = $duree_annee_formation;
        return $this;
    }
	
    public function getDuree_cycle_formation(){
        return $this->duree_cycle_formation;
    }
    
    public function setDuree_cycle_formation($duree_cycle_formation){
        $this->duree_cycle_formation = $duree_cycle_formation;
        return $this;
    }
	
	public function getTaux_cycle_formation(){
        return $this->taux_cycle_formation;
    }
    
    public function setTaux_cycle_formation($taux_cycle_formation){
        $this->taux_cycle_formation = $taux_cycle_formation;
        return $this;
    }
	
	
	
	
}

?>
