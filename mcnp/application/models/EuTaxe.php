<?php

class Application_Model_EuTaxe
{
    protected $id_taxe;
    protected $libelle_taxe;
    protected $taux_taxe;
    protected $id_pays;
    
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

    function getId_taxe() {
        return $this->id_taxe;
    }

    function setId_taxe($id_taxe) {
        $this->id_taxe = $id_taxe;
        return $this;
    }

    
    function getLibelle_taxe() {
        return $this->libelle_taxe;
    }

    function setLibelle_taxe($libelle_taxe) {
        $this->libelle_taxe = (string)$libelle_taxe;
        return $this;
    }
    
    function getTaux_taxe() {
        return $this->taux_taxe;
    }

    function setTaux_taxe($taux_taxe) {
        $this->taux_taxe = (string)$taux_taxe;
        return $this;
    }
    
    function getId_pays() {
        return $this->id_pays;
    }

    function setId_pays($id_pays) {
        $this->id_pays = (string)$id_pays;
        return $this;
    }
}


