<?php

class Application_Model_EuCmUtilisateur {

    protected  $id_cm_utilisateur;
    protected  $libelle_cm_utilisateur;
    
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

    function getId_cm_utilisateur() {
        return $this->id_cm_utilisateur;
    }

    function setId_cm_utilisateur($id_cm_utilisateur) {
        $this->id_cm_utilisateur = $id_cm_utilisateur;
        return $this;
    }

    function getLibelle_cm_utilisateur() {
        return $this->libelle_cm_utilisateur;
    }

    function setLibelle_cm_utilisateur($libelle_cm_utilisateur) {
        $this->libelle_cm_utilisateur = $libelle_cm_utilisateur;
        return $this;
    }

}

?>
