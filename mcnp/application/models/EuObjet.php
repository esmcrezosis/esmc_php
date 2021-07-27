<?php

class Application_Model_EuObjet
{
    protected $id_objet;
    protected $design_objet;
	protected $unite_mesure;
    
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
    function getId_objet(){
        return $this->id_objet;
    }
    function setId_objet($id_objet){
        $this->id_objet = $id_objet;
        return $this;
    }    
    function getDesign_objet(){
        return $this->design_objet;
    }
    function setDesign_objet($design_objet){
        $this->design_objet = (string) $design_objet;
        return $this;
    }
	
	function getUnite_mesure(){
        return $this->unite_mesure;
    }
	
    function setUnite_mesure($unite_mesure){
        $this->unite_mesure = $unite_mesure;
        return $this;
    }
	
}

?>