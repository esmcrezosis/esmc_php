<?php

class Application_Model_EuTypePublicite {

    protected  $id_type_publicite;
    protected  $libelle_type_publicite;
    
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

    function getId_type_publicite() {
        return $this->id_type_publicite;
    }

    function setId_type_publicite($id_type_publicite) {
        $this->id_type_publicite = $id_type_publicite;
        return $this;
    }

    function getLibelle_type_publicite() {
        return $this->libelle_type_publicite;
    }

    function setLibelle_type_publicite($libelle_type_publicite) {
        $this->libelle_type_publicite = $libelle_type_publicite;
        return $this;
    }

}

?>
