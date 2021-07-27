<?php

class Application_Model_EuPlacement
{

    protected $num_placement;
    protected $membre;
    protected $produit;
    protected $montant_placement;
    protected $date_placement;
    protected $heure_placement;
    protected $agence;
    protected $caisse;
    
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

    function getNum_placement(){
        return $this->num_placement;
    }
    
    function setNum_placement($num_placement){
        $this->num_placement = $num_placement;
        return $this;
    }
    
    function getMembre(){
        return $this->membre;
    }
    function setMembre($membre){
        $this->membre = $membre;
        return $this;
    }
    
    function getProduit(){
        return $this->produit;
    }
    function setProduit($produit){
        $this->produit = $produit;
        return $this;
    }
    
    function getMontant_placement(){
        return $this->montant_placement;
    }
    function setMontant_placement($montant_placement){
        $this->montant_placement = $montant_placement;
        return $this;
    }
    
    function  getDate_placement(){
        return $this->date_placement;
    }
    function setDate_placement($date_placement){
        $this->date_placement = $date_placement;
        return $this;
    }
    
    function getHeure_placement(){
        return $this->heure_placement;
    }

    function setHeure_placement($heure_placement){
        $this->heure_placement = $heure_placement;
        return $this;
    }
    
    function getAgence(){
        return $this->agence;
    }
    
    function setAgence($agence){
        $this->agence = $agence;
        return $this;
    }
    
    function getCaisse(){
        return $this->caisse;
    }
    
    function setCaisse($caisse){
        $this->caisse = $caisse;
        return $this;
    }
}

