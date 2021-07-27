<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDetailFgFn
 *
 * @author user
 */
class Application_Model_EuDetailFgfn {

    //put your code here
    protected $id_fgfn;
    protected $code_membre_pbf;
    protected $code_fgfn;
    protected $date_fgfn;
    protected $mont_fgfn;
    protected $mont_preleve;
    protected $solde_fgfn;
    protected $creditcode;
    protected $origine_fgfn;
	protected $type_fgfn;

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

    public function getId_fgfn() {
        return $this->id_fgfn;
    }

    public function setId_fgfn($id_fgfn) {
        $this->id_fgfn = $id_fgfn;
        return $this;
    }


    public function getCode_membre_pbf() {
        return $this->code_membre_pbf;
    }

    public function setCode_membre_pbf($code_membre_pbf) {
        $this->code_membre_pbf = $code_membre_pbf;
        return $this;
    }

    public function getMont_fgfn() {
        return $this->mont_fgfn;
    }

    public function setMont_fgfn($mont_fgfn) {
        $this->mont_fgfn = $mont_fgfn;
        return $this;
    }

    public function getMont_preleve() {
        return $this->mont_preleve;
    }

    public function setMont_preleve($mont_preleve) {
        $this->mont_preleve = $mont_preleve;
        return $this;
    }

    public function getSolde_fgfn() {
        return $this->solde_fgfn;
    }

    public function setSolde_fgfn($solde_fgfn) {
        $this->solde_fgfn = $solde_fgfn;
        return $this;
    }

    public function getDate_fgfn() {
        return $this->date_fgfn;
    }

    public function setDate_fgfn($date_fgfn) {
        $this->date_fgfn = $date_fgfn;
        return $this;
    }
    
    public function getCode_fgfn(){
        return $this->code_fgfn;
    }
    
    public function setCode_fgfn($code_fgfn){
        $this->code_fgfn = $code_fgfn;
        return $this;
    }
    
    public function getCreditcode(){
        return $this->creditcode;
    }
    
    public function setCreditcode($creditcode){
        $this->creditcode = $creditcode;
        return $this;
    }
    
    
    public function getOrigine_fgfn(){
        return $this->origine_fgfn;
    }
    
    public function setOrigine_fgfn($origine_fgfn){
        $this->origine_fgfn = $origine_fgfn;
        return $this;
    }
	
	public function getType_fgfn(){
        return $this->type_fgfn;
    }
    
    public function setType_fgfn($type_fgfn){
        $this->type_fgfn = $type_fgfn;
        return $this;
    }
	
	
	

}

?>
