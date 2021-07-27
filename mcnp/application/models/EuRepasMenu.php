<?php

class Application_Model_EuRepasMenu {

    protected  $id_repas_menu;
    protected  $id_repas;
    protected  $code_membre;
    protected  $jour_semaine;
    protected  $date_creation;
    
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

    function getId_repas_menu() {
        return $this->id_repas_menu;
    }

    function setId_repas_menu($id_repas_menu) {
        $this->id_repas_menu = $id_repas_menu;
        return $this;
    }

    function getId_repas() {
        return $this->id_repas;
    }

    function setId_repas($id_repas) {
        $this->id_repas = $id_repas;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    function getJour_semaine() {
        return $this->jour_semaine;
    }

    function setJour_semaine($jour_semaine) {
        $this->jour_semaine = $jour_semaine;
        return $this;
    }

    function getDate_creation() {
        return $this->date_creation;
    }

    function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }


}

?>
