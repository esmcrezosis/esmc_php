<?php

class Application_Model_EuObjetHors
{

    protected $id_objet_hors;
    protected $id_besoin;
    protected $design_objet_hors;
    protected $qte_objet_hors;
    
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

    function getId_objet_hors(){
        return $this->id_objet_hors;
    }
    
    function setId_objet_hors($id_objet_hors){
        $this->id_objet_hors = $id_objet_hors;
        return $this;
    }
    
    function getId_besoin(){
        return $this->id_besoin;
    }
    
    function setId_besoin($id_besoin){
        $this->id_besoin = $id_besoin;
        return $this;
    }
    
    function getDesign_objet_hors(){
        return $this->design_objet_hors;
    }
    
    function setDesign_objet_hors($design_objet_hors){
        $this->design_objet_hors = $design_objet_hors;
        return $this;
    }
    
    function getQte_objet_hors(){
        return $this->qte_objet_hors;
    }
    
    function setQte_objet_hors($qte_objet_hors){
        $this->qte_objet_hors = (int) $qte_objet_hors;
        return $this;
    }
}