<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 
class Application_Model_EuDetailKrr {
	
	protected $id_detail_krr;
    protected $id_krr;
    protected $id_credit;
    protected $source_credit;
	protected $mont_credit;
    protected $annuler;
	

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
		
	
	public function getId_detail_krr() {
        return $this->id_detail_krr;
    }

    public function setId_detail_krr($id_detail_krr) {
        $this->id_detail_krr = $id_detail_krr;
        return $this;
    }
	

    public function getId_krr() {
        return $this->id_krr;
    }

    public function setId_krr($id_krr) {
        $this->id_krr = $id_krr;
        return $this;
    }

    public function getId_credit() {
        return $this->id_credit;
    }

    public function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }
	
	
    public function getSource_credit() {
        return $this->source_credit;
    }

    public function setSource_credit($source_credit) {
        $this->source_credit = $source_credit;
        return $this;
    }

    public function getMont_credit() {
        return $this->mont_credit;
    }

    public function setMont_credit($mont_credit) {
        $this->mont_credit = $mont_credit;
        return $this;
    }

    public function getAnnuler() {
        return $this->annuler;
    }

    public function setAnnuler($annuler) {
        $this->annuler = $annuler;
        return $this;
    }

}