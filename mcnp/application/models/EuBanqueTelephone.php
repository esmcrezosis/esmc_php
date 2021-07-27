<?php

class Application_Model_EuBanqueTelephone {

    protected  $id_telephone;
    protected  $telephone;
    protected  $status;
    protected  $code_banque;
    protected  $id_banque_user;
    
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

    function getId_telephone() {
        return $this->id_telephone;
    }

    function setId_telephone($id_telephone) {
        $this->id_telephone = $id_telephone;
        return $this;
    }

    function getTelephone() {
        return $this->telephone;
    }

    function setTelephone($telephone) {
        $this->telephone = $telephone;
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
    public function getId_banque_user() {
        return $this->id_banque_user;
    }
    public function setId_banque_user($id_banque_user) {
        $this->id_banque_user = $id_banque_user;
        return $this;
    }
}

?>
