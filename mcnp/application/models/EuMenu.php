<?php
 
class Application_Model_EuMenu {

    //put your code here
    protected $menu_id;
    protected $menu_libelle;
    protected $menu_type;
    protected $ordre;
    protected $publier;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
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

    public function getMenu_id() {
        return $this->menu_id;
    }

    public function setMenu_id($menu_id) {
        $this->menu_id = $menu_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getMenu_libelle() {
        return ($this->menu_libelle);
    }

    public function setMenu_libelle($menu_libelle) {
        $this->menu_libelle = ($menu_libelle);
        return $this;
    }

    public function getMenu_type() {
        return $this->menu_type;
    }

    public function setMenu_type($menu_type) {
        $this->menu_type = $menu_type;
        return $this;
    }

    public function getOrdre() {
        return $this->ordre;
    }

    public function setOrdre($ordre) {
        $this->ordre = $ordre;
        return $this;
    }


}

?>
