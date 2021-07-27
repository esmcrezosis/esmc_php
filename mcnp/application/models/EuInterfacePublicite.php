<?php

class Application_Model_EuInterfacePublicite {

    protected  $id_interface_publicite;
    protected  $libelle_interface_publicite;
    
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

    function getId_interface_publicite() {
        return $this->id_interface_publicite;
    }

    function setId_interface_publicite($id_interface_publicite) {
        $this->id_interface_publicite = $id_interface_publicite;
        return $this;
    }

    function getLibelle_interface_publicite() {
        return $this->libelle_interface_publicite;
    }

    function setLibelle_interface_publicite($libelle_interface_publicite) {
        $this->libelle_interface_publicite = $libelle_interface_publicite;
        return $this;
    }

}

?>
