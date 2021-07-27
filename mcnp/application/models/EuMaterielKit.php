<?php

class Application_Model_EuMaterielKit {

    protected  $id_materiel_kit;
    protected  $libelle_materiel_kit;
    
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

    function getId_materiel_kit() {
        return $this->id_materiel_kit;
    }

    function setId_materiel_kit($id_materiel_kit) {
        $this->id_materiel_kit = $id_materiel_kit;
        return $this;
    }

    function getLibelle_materiel_kit() {
        return $this->libelle_materiel_kit;
    }

    function setLibelle_materiel_kit($libelle_materiel_kit) {
        $this->libelle_materiel_kit = $libelle_materiel_kit;
        return $this;
    }

}

?>
