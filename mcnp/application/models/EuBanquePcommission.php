<?php

class Application_Model_EuBanquePcommission {

    protected  $id_pcommission;
    protected  $pcommission;
    protected  $status;
    protected  $code_banque;
    protected  $id_type_acteur;
    
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

    function getId_pcommission() {
        return $this->id_pcommission;
    }

    function setId_pcommission($id_pcommission) {
        $this->id_pcommission = $id_pcommission;
        return $this;
    }

    function getPcommission() {
        return $this->pcommission;
    }

    function setPcommission($pcommission) {
        $this->pcommission = $pcommission;
        return $this;
    }
	
    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    function getCode_banque() {
        return $this->code_banque;
    }

    function setCode_banque($code_banque) {
        $this->code_banque = $code_banque;
        return $this;
    }

    function getId_type_acteur() {
        return $this->id_type_acteur;
    }

    function setId_type_acteur($id_type_acteur) {
        $this->id_type_acteur = $id_type_acteur;
        return $this;
    }
}

?>
