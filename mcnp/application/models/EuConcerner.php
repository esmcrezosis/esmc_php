<?php

 class Application_Model_EuConcerner
{
    protected $id_besoin;
    protected $id_objet;
    protected $qte_objet;
    protected $type;
    
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
    function getId_besoin(){
        return $this->id_besoin;
    }
    
    function setId_besoin($id_besoin){
        $this->id_besoin = $id_besoin;
        return $this;
    }
    
    function getId_objet(){
        return $this->id_objet;
    }
    
    function setId_objet($id_objet) {
        $this->id_objet = $id_objet;
         return $this;
    }
    
    function getQte_objet(){
        return $this->qte_objet;
    }
    
    function setQte_objet($qte_objet){
        $this->qte_objet = (int) $qte_objet;
        return $this;
    }
    
    function getType(){
        return $this->type;
    }
    
    function setType($type){
        $this->type =$type;
        return $this;
    }
}
