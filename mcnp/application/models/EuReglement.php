<?php

class Application_Model_EuReglement
{

    protected $id_reglt;
    protected $date_reglt;
    protected $montant_reglt;
    protected $code_facture;
    
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

    function getId_reglt(){
        return $this->id_reglt;
    }
    function setId_reglt($id_reglt){
        $this->id_reglt = $id_reglt;
        return $this;
    }
	
    function getDate_reglt(){
        return $this->date_reglt;
    }
    function setDate_reglt($date_reglt){
        $this->date_reglt = $date_reglt;
        return $this;
    }
	
    function getMontant_reglt(){
        return $this->montant_reglt;
    }
    function setMontant_reglt($montant_reglt){
        $this->montant_reglt = $montant_reglt;
        return $this;
    }
	
    function getCode_facture(){
        return $this->code_facture;
    }
    function setCode_facture($code_facture){
        $this->code_facture = $code_facture;
        return $this;
    }
}
