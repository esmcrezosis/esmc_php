<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuStandProduit {
         
    protected $id_produit;
    protected $design_produit;
    protected $id_stand;
    protected $id_filiere;

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

    function getId_produit() {
        return $this->id_produit;
    }

    function setId_produit($id_produit) {
        $this->id_produit = $id_produit;
        return $this;
    }

    function getDesign_produit() {
        return $this->design_produit;
    }

    function setDesign_produit($design_produit) {
        $this->design_produit = $design_produit;
        return $this;
    }

    function getId_stand() {
        return $this->id_stand;
    }

    function setId_stand($id_stand) {
        $this->id_stand = $id_stand;
        return $this;
    }
    
    
    function getId_filiere() {
        return $this->id_filiere;
    }

    function setId_filiere($id_filiere) {
        $this->id_filiere = $id_filiere;
        return $this;
    }
                  
}

?>

