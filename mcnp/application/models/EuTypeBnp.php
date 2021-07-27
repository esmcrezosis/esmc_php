<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Application_Model_EuTypeBnp
 *
 * @author user
 */
class Application_Model_EuTypeBnp {
    //put your code here
    protected $code_type_bnp;
    protected $libelle_bnp;
    protected $tx_conus;
    protected $tx_par;
    protected $tx_panu;
    protected $tx_fs;
    protected $tx_panu_fs;


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

    public function getCode_type_bnp(){
        return $this->code_type_bnp;
    }
    
    public function setCode_type_bnp($code_type_bnp){
        $this->code_type_bnp = $code_type_bnp;
        return $this;
    }
    
    public function getLibelle_bnp(){
        return $this->libelle_bnp;
    }
    
    public function setLibelle_bnp($libelle_bnp){
        $this->libelle_bnp = $libelle_bnp;
        return $this;
    }
    
    public function getTx_conus(){
        return $this->tx_conus;
    }
    
    public function setTx_conus($tx_conus){
        $this->tx_conus = $tx_conus;
        return $this;
    }
    
    public function getTx_par(){
        return $this->tx_par;
    }
    
    public function setTx_par($tx_par){
        $this->tx_par = $tx_par;
        return $this;
    }
    
    public function getTx_panu(){
        return $this->tx_panu;
    }
    
    public function setTx_panu($tx_panu){
        $this->tx_panu = $tx_panu;
        return $this;
    }
    
    public function getTx_fs(){
        return $this->tx_fs;
    }
    
    public function setTx_fs($tx_fs){
        $this->tx_fs = $tx_fs;
        return $this;
    }
    
    public function getTx_panu_fs(){
        return $this->tx_panu_fs;
    }
    
    public function setTx_panu_fs($tx_panu_fs){
        $this->tx_panu_fs = $tx_panu_fs;
        return $this;
    }
}

?>
