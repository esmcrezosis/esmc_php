<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Model_EuQuartier {

      
      protected $id_quartier;
      protected $lib_quartier;
      protected $date_create;
      protected $id_ville;
      protected $id_utilisateur;

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
    
    function getId_quartier() {
        return $this->id_quartier;
    }

    function setId_quartier($id_quartier) {
        $this->id_quartier = $id_quartier;
        return $this;
    }
    
    
    function getLib_quartier() {
        return $this->lib_quartier;
    }

    function setLib_quartier($lib_quartier) {
        $this->lib_quartier = $lib_quartier;
        return $this;
    }

    function getDate_create() {
        return $this->date_create;
    }

    function setDate_create($date_create) {
        $this->date_create = $date_create;
        return $this;
    }
    
     function getId_ville() {
        return $this->id_ville;
    }

    function setId_ville($id_ville) {
        $this->id_ville = $id_ville;
        return $this;
    }
    
    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
    
    

}
?>
