<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuBnpSqmax
 *
 * @author user
 */
class Application_Model_EuBnpSqmax {
    //put your code here
    protected $id_sqmax;
    protected $code_membre;
    protected $code_cat;
    protected $montant;
	protected $id_credit;
    
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
    
    public function getId_sqmax(){
        return $this->id_sqmax;
    }
    
    public function setId_sqmax($id_sqmax){
        $this->id_sqmax = $id_sqmax;
        return $this;
    }
    
    public function getCode_membre(){
        return $this->code_membre;
    }
    
    public function setCode_membre($code_membre){
        $this->code_membre = $code_membre;
        return $this;
    }
    
    public function getCode_cat(){
        return $this->code_cat;
    }
    
    public function setCode_cat($code_cat){
        $this->code_cat = $code_cat;
        return $this;
    }
    
    public function getMontant(){
        return $this->montant;
    }
    
    public function setMontant($montant){
        $this->montant = $montant;
        return $this;
    }
	
	
	public function getId_credit(){
        return $this->id_credit;
    }
    
    public function setId_credit($id_credit){
        $this->id_credit = $id_credit;
        return $this;
    }
	
		
	
}

?>
