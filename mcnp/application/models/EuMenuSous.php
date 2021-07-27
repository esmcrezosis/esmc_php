<?php
 
class Application_Model_EuMenuSous {

    //put your code here
    protected $menusous_id;
    protected $menusous_libelle;
    protected $menusous_menu;
    protected $menusous_url;
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

    public function getMenusous_id() {
        return $this->menusous_id;
    }

    public function setMenusous_id($menusous_id) {
        $this->menusous_id = $menusous_id;
        return $this;
    }

    public function getMenusous_menu() {
        return $this->menusous_menu;
    }

    public function setMenusous_menu($menusous_menu) {
        $this->menusous_menu = $menusous_menu;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getMenusous_libelle() {
        return ($this->menusous_libelle);
    }

    public function setMenusous_libelle($menusous_libelle) {
        $this->menusous_libelle = ($menusous_libelle);
        return $this;
    }


    public function getMenusous_url() {
        return ($this->menusous_url);
    }

    public function setMenusous_url($menusous_url) {
        $this->menusous_url = ($menusous_url);
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
