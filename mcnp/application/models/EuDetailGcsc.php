<?php

class Application_Model_EuDetailGcsc {

    protected $id_detail_gcsc;
    protected $code_membre;
    protected $date_conso;
    protected $mont_gcsc;
    protected $source;
    protected $id_credit;
    protected $id_gcsc;
    protected $bon_id;
	

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid compte_gcp property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid compte_gcsc property');
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
	


    function getId_detail_gcsc() {
        return $this->id_detail_gcsc;
    }

    function setId_detail_gcsc($id_detail_gcsc) {
        $this->id_detail_gcsc = $id_detail_gcsc;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

	
    function getDate_conso() {
        return $this->date_conso;
    }

    function setDate_conso($date_conso) {
        $this->date_conso = $date_conso;
        return $this;
    }

    function getMont_gcsc() {
        return $this->mont_gcsc;
    }

    function setMont_gcsc($mont_gcsc) {
        $this->mont_gcsc = $mont_gcsc;
        return $this;
    }

    function getSource() {
        return $this->source;
    }

    function setSource($source) {
        $this->source = $source;
        return $this;
    }
	
    function getId_credit() {
        return $this->id_credit;
    }

    function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }

    function getId_gcsc() {
        return $this->id_gcsc;
    }

    function setId_gcsc($id_gcsc) {
        $this->id_gcsc = $id_gcsc;
        return $this;
    }

    function getBon_id() {
       return $this->bon_id;
    }

    function setBon_id($bon_id) {
      $this->bon_id = $bon_id;
      return $this;
    }

}

