<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of EuCnpEntree
 *
 * @author user
 */
 
class Application_Model_EuTypeMf {


      //put your code here
      protected $code_type_mf;
      protected $lib_type_mf;
	  
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

    public function getCode_type_mf() {
        return $this->code_type_mf;
    }

    public function setCode_type_mf($code_type_mf) {
        $this->code_type_mf = $code_type_mf;
        return $this;
    }

    public function getLib_type_mf() {
        return $this->lib_type_mf;
    }

    public function setLib_type_mf($lib_type_mf) {
        $this->lib_type_mf = $lib_type_mf;
        return $this;
    }

}