<?php

class Application_Model_EuBesoin
{
    
    protected $id_besoin;
    protected $objet_besoin;
    protected $date_valide;
    protected $date_besoin;
    protected $code_membre;
    protected $disponible;
    
    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        return $this->$method();
    }
    
     public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    function getId_besoin() {
        return $this->id_besoin;
    }

    function setId_besoin($id_besoin) {
        $this->id_besoin = $id_besoin;
        return $this;
    }


    function getObjet_besoin() {
        return $this->objet_besoin;
    }

    function setObjet_besoin($objet_besoin) {
        $this->objet_besoin = (string)$objet_besoin;
        return $this;
    }
	
    function getDate_valide() {
        return $this->date_valide;
    }
    function setDate_valide($date_valide) {
        $this->date_valide = $date_valide;
        return $this;
    }
    function getDate_besoin() {
        return $this->date_besoin;
    }

    function setDate_besoin($date_besoin) {
        $this->date_besoin = $date_besoin;
        return $this;
    }
    function getCode_membre() {
        return $this->code_membre;
    }
    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
    
    
    function getDisponible() {
        return $this->disponible;
    }
    
    function setDisponible($disponible) {
        $this->disponible = $disponible;
        return $this;
    }
    
}