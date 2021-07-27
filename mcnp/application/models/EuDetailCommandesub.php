<?php

class Application_Model_EuDetailCommandesub
{
    protected $num_com;
    protected $code_objet;
    protected $design_objet;
    protected $qte_objet;
    protected $pu_objet;
    protected $remise;
    
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

    function getNum_com() {
        return $this->num_com;
    }

    function setNum_com($num_com) {
        $this->num_com = $num_com;
        return $this;
    }
    function getCode_objet() {
        return $this->code_objet;
    }
    function setCode_objet($code_objet) {
        $this->code_objet = $code_objet;
        return $this;
    } 
    function getDesign_objet() {
        return $this->design_objet;
    }
    function setDesign_objet($design_objet) {
        $this->design_objet =$design_objet;
        return $this;
    }
    function getQte_objet() {
        return $this->qte_objet;
    }
    function setQte_objet($qte_objet) {
        $this->qte_objet = $qte_objet;
        return $this;
    }
    function getPu_objet() {
        return $this->pu_objet;
    }
    function setPu_objet($pu_objet) {
        $this->pu_objet = $pu_objet;
        return $this;
    }
    function getRemise() {
        return $this->remise;
    }
    function setRemise($remise) {
        $this->remise = $remise;
        return $this;
    }
}


