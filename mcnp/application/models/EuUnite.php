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
 
class Application_Model_EuUnite {


      //put your code here
      protected $code_unite;
      protected $lib_unite;
	  protected $des_unite;
	  
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

    public function getCode_unite() {
        return $this->code_unite;
    }

    public function setCode_unite($code_unite) {
        $this->code_unite = $code_unite;
        return $this;
    }

    public function getLib_unite() {
        return $this->lib_unite;
    }

    public function setLib_unite($lib_unite) {
        $this->lib_unite = $lib_unite;
        return $this;
    }
	
	 public function getDes_unite() {
        return $this->des_unite;
    }

    public function setDes_unite($des_unite) {
        $this->des_unite = $des_unite;
        return $this;
    }
	
	
	
	
	




	

}