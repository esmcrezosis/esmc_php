<?php

class Application_Model_EuTacheType {

    //put your code here
    protected $tache_type_id;
    protected $tache_type_libelle;

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

    public function getTache_type_id() {
        return $this->tache_type_id;
    }

    public function setTache_type_id($tache_type_id) {
        $this->tache_type_id = $tache_type_id;
        return $this;
    }


    public function getTache_type_libelle() {
        return ($this->tache_type_libelle);
    }

    public function setTache_type_libelle($tache_type_libelle) {
        $this->tache_type_libelle = ($tache_type_libelle);
        return $this;
    }



}

?>
