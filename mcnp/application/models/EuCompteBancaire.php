<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuCompteBancaire
 *
 * @author user
 */
class Application_Model_EuCompteBancaire {

    //put your code here
    protected $code_banque;
    protected $code_membre;
	protected $code_membre_morale;
    protected $num_compte_bancaire;
    protected $id_compte;
    protected $principal;

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

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
	
	function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }

    function getCode_banque() {
        return $this->code_banque;
    }

    function setCode_banque($code_banque) {
        $this->code_banque = $code_banque;
        return $this;
    }

    public function getId_compte() {
        return $this->id_compte;
    }

    public function setId_compte($id_compte) {
        $this->id_compte = $id_compte;
        return $this;
    }

    public function getNum_compte_bancaire() {
        return $this->num_compte_bancaire;
    }

    public function setNum_compte_bancaire($num_compte_bancaire) {
        $this->num_compte_bancaire = $num_compte_bancaire;
        return $this;
    }
		
    public function getPrincipal() {
        return $this->principal;
    }

    public function setPrincipal($principal) {
        $this->principal = $principal;
        return $this;
    }

	
	
	
	
	
	

}
?>
