<?php

class Application_Model_EuBanque {

    protected  $code_banque;
    protected  $libelle_banque;
    protected  $compte_banque;
    protected  $iban_banque;
    protected  $type_banque;
    protected  $id_pays;
	protected  $code_membre_morale;
    
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

    function getCode_banque() {
        return $this->code_banque;
    }

    function setCode_banque($code_banque) {
        $this->code_banque = $code_banque;
        return $this;
    }

    function getLibelle_banque() {
        return $this->libelle_banque;
    }

    function setLibelle_banque($libelle_banque) {
        $this->libelle_banque = $libelle_banque;
        return $this;
    }

    function getCompte_banque() {
        return $this->compte_banque;
    }

    function setCompte_banque($compte_banque) {
        $this->compte_banque = $compte_banque;
        return $this;
    }

    function getIban_banque() {
        return $this->iban_banque;
    }

    function setIban_banque($iban_banque) {
        $this->iban_banque = $iban_banque;
        return $this;
    }

    function getType_banque() {
        return $this->type_banque;
    }

    function setType_banque($type_banque) {
        $this->type_banque = $type_banque;
        return $this;
    }

    function getId_pays() {
        return $this->id_pays;
    }

    function setId_pays($id_pays) {
        $this->id_pays = $id_pays;
        return $this;
    }
	
	function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }
	
	
	
	
	

}

?>
