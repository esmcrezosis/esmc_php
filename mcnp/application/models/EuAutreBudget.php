<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Model_EuAutreBudget {
    
    protected $id_budget;
    protected $libbesoin;
    protected $montant;
    protected $id_investissement;

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
   
    
    function getId_budget() {
        return $this->id_budget;
    }

    function setId_budget($id_budget) {
        $this->id_budget = $id_budget;
        return $this;
    }


    function getLibbesoin() {
        return $this->libbesoin;
    }

    function setLibbesoin($libbesoin) {
        $this->libbesoin = $libbesoin;
        return $this;
    }


    function getMontant() {
        return $this->montant;
    }

    function setMontant($montant) {
        $this->montant = $montant;
        return $this;
    }
    
    
	
    function getId_investissement() {
        return $this->id_investissement;
    }


    function setId_investissement($id_investissement) {
        $this->id_investissement = $id_investissement;
        return $this;
    }
     
    
}  









?>
