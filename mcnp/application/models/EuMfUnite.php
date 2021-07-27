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
 
class Application_Model_EuMfUnite {

      //put your code here
      protected $id_mf;
      protected $code_unite;
	  protected $date_mf_unite;
	  
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
	  
	
    public function getId_mf() {
        return $this->id_mf;
    }

    public function setId_mf($id_mf) {
        $this->id_mf = $id_mf;
        return $this;
    }

    public function getCode_unite() {
        return $this->code_unite;
    }

    public function setCode_unite($code_unite) {
        $this->code_unite = $code_unite;
        return $this;
    }
	
	public function getDate_mf_unite() {
        return $this->date_mf_unite;
    }

    public function setDate_mf_unite($date_mf_unite) {
        $this->date_mf_unite = $date_mf_unite;
        return $this;
    }
		

}