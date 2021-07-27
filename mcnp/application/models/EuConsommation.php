<?php

class Application_Model_EuConsommation
{
    protected $num_consom;
    protected $membre;
    protected $vendeur;
    protected $produit;
    protected $consommation;
    protected $date_consom;
    
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
    
    function getNum_Conso(){
        return $this->num_consom;
    }
    
    function setNum_Conso($num_conso){
        $this->num_consom = $num_conso;
        return $this;
    }    

    function getMembre(){
        return $this->membre;
    }
    
    function setMembre($membre){
        $this->membre = $membre;
        return $this;
    }
 
    function getVendeur(){
        return $this->vendeur;
    }
    
    function setVendeur($vendeur){
        $this->vendeur = $vendeur;
        return $this;
    }
  
    function getProduit(){
        return $this->produit;
    }
    
    function setProduit($produit){
        $this->produit = $produit;
        return $this;
    }
      
    function getConsommation(){
        return $this->consommation;
    }
    
    function setConsommation($consommation){
        $this->consommation = $consommation;
        return $this;
    }
      
    function getDate_consom(){
        return $this->date_consom;
    }
    
    function setDate_consom($date_consom){
        $this->date_consom = $date_consom;
        return $this;
    }    
}

