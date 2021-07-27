<?php

class Application_Model_EuRepasMenuMembre {

    protected  $id_repas_menu_membre;
    protected  $id_repas;
    protected  $code_membre_client;
    protected  $jour_semaine;
    protected  $date_creation;
    protected  $code_membre_restaurant;
    
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

    function getId_repas_menu_membre() {
        return $this->id_repas_menu_membre;
    }

    function setId_repas_menu_membre($id_repas_menu_membre) {
        $this->id_repas_menu_membre = $id_repas_menu_membre;
        return $this;
    }

    function getId_repas() {
        return $this->id_repas;
    }

    function setId_repas($id_repas) {
        $this->id_repas = $id_repas;
        return $this;
    }

    function getCode_membre_client() {
        return $this->code_membre_client;
    }

    function setCode_membre_client($code_membre_client) {
        $this->code_membre_client = $code_membre_client;
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

    function getCode_membre_restaurant() {
        return $this->code_membre_restaurant;
    }

    function setCode_membre_restaurant($code_membre_restaurant) {
        $this->code_membre_restaurant = $code_membre_restaurant;
        return $this;
    }


}

?>
