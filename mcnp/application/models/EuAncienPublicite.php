<?php

class Application_Model_EuAncienPublicite {

    protected  $id_ancien_publicite;
    protected  $libelle_ancien_publicite;
    
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

    function getId_ancien_publicite() {
        return $this->id_ancien_publicite;
    }

    function setId_ancien_publicite($id_ancien_publicite) {
        $this->id_ancien_publicite = $id_ancien_publicite;
        return $this;
    }

    function getLibelle_ancien_publicite() {
        return $this->libelle_ancien_publicite;
    }

    function setLibelle_ancien_publicite($libelle_ancien_publicite) {
        $this->libelle_ancien_publicite = $libelle_ancien_publicite;
        return $this;
    }

}

?>
