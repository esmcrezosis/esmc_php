<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuPrk
 *
 * @author Mawuli
 */
class Application_Model_EuPrk {

    //put your code here
    protected $id_prk;
    protected $code_tegc;
    protected $valeur;
	protected $code_type_credit;
	protected $type_produit;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
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

    public function getId_prk() {
        return $this->id_prk;
    }

    public function setId_prk($id_prk) {
        $this->id_prk = $id_prk;
        return $this;
    }

    function getCode_tegc() {
        return $this->code_tegc;
    }

    function setCode_tegc($code_tegc) {
        $this->code_tegc = $code_tegc;
        return $this;
    }

    public function getValeur() {
        return $this->valeur;
    }

    public function setValeur($valeur) {
        $this->valeur = $valeur;
        return $this;
    }
	
	public function getCode_type_credit() {
        return $this->code_type_credit;
    }

    public function setCode_type_credit($code_type_credit) {
        $this->code_type_credit = $code_type_credit;
        return $this;
    }
	
	public function getType_produit() {
        return $this->type_produit;
    }

    public function setType_produit($type_produit) {
        $this->type_produit = $type_produit;
        return $this;
    }
	
	
	
    
    /*
	public function exchangeArray($data) {
        $this->id_prk = (isset($data['id_prk'])) ? $data['id_prk'] : NULL;
        $this->code_type_credit = (isset($data['code_type_credit'])) ? $data['code_type_credit'] : NULL;
        $this->valeur = (isset($data['valeur'])) ? $data['valeur'] : NULL;
    }
    
    public function toArray() {
        $data = array(
            'id_prk' => $this->id_prk,
            'code_type_credit' => $this->code_type_credit,
        
            'valeur' => $this->valeur
        );
        return $data;
    }
	*/

}

?>
