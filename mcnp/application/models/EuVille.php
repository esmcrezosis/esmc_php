<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Model_EuVille {

      
      protected $id_ville;
      protected $lib_ville;
      protected $date_create;
      protected $id_pays;
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
    
    
    function getId_ville() {
        return $this->id_ville;
    }

    function setId_ville($id_ville) {
        $this->id_ville = $id_ville;
        return $this;
    }
    
    
    function getLib_ville() {
        return $this->lib_ville;
    }

    function setLib_ville($lib_ville) {
        $this->lib_ville = $lib_ville;
        return $this;
    }

    function getDate_create() {
        return $this->date_create;
    }

    function setDate_create($date_create) {
        $this->date_create = $date_create;
        return $this;
    }
    
     function getId_pays() {
        return $this->id_pays;
    }

    function setId_pays($id_pays) {
        $this->id_pays = $id_pays;
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
