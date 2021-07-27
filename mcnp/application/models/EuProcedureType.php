<?php

class Application_Model_EuProcedureType {

    //put your code here
    protected $procedure_type_id;
    protected $procedure_type_libelle;

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

    public function getProcedure_type_id() {
        return $this->procedure_type_id;
    }

    public function setProcedure_type_id($procedure_type_id) {
        $this->procedure_type_id = $procedure_type_id;
        return $this;
    }


    public function getProcedure_type_libelle() {
        return ($this->procedure_type_libelle);
    }

    public function setProcedure_type_libelle($procedure_type_libelle) {
        $this->procedure_type_libelle = ($procedure_type_libelle);
        return $this;
    }



}

?>
