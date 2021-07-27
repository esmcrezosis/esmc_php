<?php
class Application_Model_EuTypeMaison {

      protected $id_type_maison;
      protected $lib_type_maison;
      protected $id_utilisateur;
	  protected $date_create;

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

    function getId_type_maison() {
        return $this->id_type_maison;
    }

    function setId_type_maison($id_type_maison) {
        $this->id_type_maison = $id_type_maison;
        return $this;
    }
    
    function getLib_type_maison() {
        return $this->lib_type_maison;
    }

    function setLib_type_maison($lib_type_maison) {
        $this->lib_type_maison = $lib_type_maison;
        return $this;
    }
    
    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
    
    function getDate_create() {
        return $this->date_create;
    }

    function setDate_create($date_create) {
        $this->date_create = $date_create;
        return $this;
    }
    
    
}   
?>



























