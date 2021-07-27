<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eu_Division_gac
 *
 * @author user
 */
 
 
class Application_Model_EuLiaisonCompte  {

    //put your code here
    protected $id;
    protected $code_membre_admin;
    protected $code_membre_anim;
    protected $date_liaison;

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
	

    public function getId() {
        return $this->id;
    }
	

    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getCode_membre_admin() {
        return $this->code_membre_admin;
    }

    public function setCode_membre_admin($code_membre_admin) {
        $this->code_membre_admin = $code_membre_admin;
        return $this;
    }

    public function getCode_membre_anim() {
        return $this->code_membre_anim;
    }

    public function setCode_membre_anim($code_membre_anim) {
        $this->code_membre_anim = $code_membre_anim;
        return $this;
    }

    public function getDate_liaison() {
        return $this->date_liaison;
    }

    public function setDate_liaison($date_liaison) {
        $this->date_liaison = $date_liaison;
        return $this;
    }
	

}

?>
