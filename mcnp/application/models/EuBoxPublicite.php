<?php

class Application_Model_EuBoxPublicite {

    protected  $id_box_publicite;
    protected  $libelle_box_publicite;
    
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

    function getId_box_publicite() {
        return $this->id_box_publicite;
    }

    function setId_box_publicite($id_box_publicite) {
        $this->id_box_publicite = $id_box_publicite;
        return $this;
    }

    function getLibelle_box_publicite() {
        return $this->libelle_box_publicite;
    }

    function setLibelle_box_publicite($libelle_box_publicite) {
        $this->libelle_box_publicite = $libelle_box_publicite;
        return $this;
    }

}

?>
