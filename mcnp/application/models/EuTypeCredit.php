<?php

class Application_Model_EuTypeCredit  {

    protected $code_type_credit;
    protected $lib_type_credit;
    protected $code_cat_produit;
	protected $quotar;
	protected $quotanr;
	protected $prk;
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

    
	function getCode_type_credit() {
        return $this->code_type_credit;
    }

    function setCode_type_credit($code_type_credit) {
        $this->code_type_credit = $code_type_credit;
        return $this;
    }

    function getLib_type_credit() {
        return $this->lib_type_credit;
    }

    function setLib_type_credit($lib_type_credit) {
        $this->lib_type_credit =  $lib_type_credit;
        return $this;
    }

    function getCode_cat_produit() {
        return $this->code_cat_produit;
    }

    function setCode_cat_produit($code_cat_produit) {
        $this->code_cat_produit = $code_cat_produit;
        return $this;
    }
	
	function getQuotar() {
      return $this->quotar;
    }

    function setQuotar($quotar) {
      $this->quotar = $quotar;
      return $this;
    }
	
	function getQuotanr() {
      return $this->quotanr;
    }

    function setQuotanr($quotanr) {
      $this->quotanr = $quotanr;
      return $this;
    }
	
	function getPrk() {
      return $this->prk;
    }

    function setPrk($prk) {
      $this->prk = $prk;
      return $this;
    }
	
	function getType_produit() {
      return $this->type_produit;
    }

    function setType_produit($type_produit) {
      $this->type_produit = $type_produit;
      return $this;
    }
	
    public function exchangeArray($data) {
        $this->code_cat_produit = (isset($data['code_cat_produit'])) ? $data['code_cat_produit'] : NULL;
        $this->code_type_credit = (isset($data['code_type_credit'])) ? $data['code_type_credit'] : NULL;
        $this->lib_type_credit = (isset($data['lib_type_credit'])) ? $data['lib_type_credit'] : NULL;
		$this->quotar = (isset($data['quotar'])) ? $data['quotar'] : NULL;
		$this->quotanr = (isset($data['quotanr'])) ? $data['quotanr'] : NULL;
		$this->prk = (isset($data['prk'])) ? $data['prk'] : NULL;
		$this->type_produit = (isset($data['type_produit'])) ? $data['type_produit'] : NULL;
    }
    
    public function toArray() {
        $data = array(
          'code_cat_produit' => $this->code_cat_produit,
          'code_type_credit' => $this->code_type_credit,
          'lib_type_credit' => $this->lib_type_credit,
		  'quotar' => $this->quotar,
		  'quotanr' => $this->quotanr,
		  'prk' => $this->prk,
		  'type_produit' => $this->type_produit
        );
        return $data;
    }
	
	
	
	
	
	

}

