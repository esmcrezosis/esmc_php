<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuBnp
 *
 * @author user
 */
class Application_Model_EuBnp {

    //put your code here
    protected $code_bnp;
    protected $id_operation;
    protected $code_type_bnp;
    protected $code_membre_app;
    protected $code_membre_benef;
    protected $montant_bnp;
    protected $mont_credit;
    protected $mont_conus;
    protected $mont_par;
    protected $mont_panu;
    protected $reconst_par;
    protected $reconst_panu;
    protected $rembourser;
    protected $periode;
    protected $conus;
    protected $panu;

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

    public function getCode_bnp() {
        return $this->code_bnp;
    }

    public function setCode_bnp($code_bnp) {
        $this->code_bnp = $code_bnp;
        return $this;
    }
    
    public function getId_operation() {
        return $this->id_operation;
    }

    public function setId_operation($id_operation) {
        $this->id_operation = $id_operation;
        return $this;
    }
    
    public function getCode_type_bnp() {
        return $this->code_type_bnp;
    }

    public function setCode_type_bnp($code_type_bnp) {
        $this->code_type_bnp = $code_type_bnp;
        return $this;
    }

    public function getCode_membre_app() {
        return $this->code_membre_app;
    }

    public function setCode_membre_app($code_membre_app) {
        $this->code_membre_app = $code_membre_app;
        return $this;
    }

    public function getCode_membre_benef() {
        return $this->code_membre_benef;
    }

    public function setCode_membre_benef($code_membre_benef) {
        $this->code_membre_benef = $code_membre_benef;
        return $this;
    }

    public function getMontant_bnp() {
        return $this->montant_bnp;
    }

    public function setMontant_bnp($montant_bnp) {
        $this->montant_bnp = $montant_bnp;
        return $this;
    }
    
       
    public function getMont_credit() {
        return $this->mont_credit;
    }

    public function setMont_credit($mont_credit) {
        $this->mont_credit = $mont_credit;
        return $this;
    }

    public function getMont_conus() {
        return $this->mont_conus;
    }

    public function setMont_conus($mont_conus) {
        $this->mont_conus = $mont_conus;
        return $this;
    }

    public function getMont_par() {
        return $this->mont_par;
    }

    public function setMont_par($mont_par) {
        $this->mont_par = $mont_par;
        return $this;
    }

    public function getMont_panu() {
        return $this->mont_panu;
    }

    public function setMont_panu($mont_panu) {
        $this->mont_panu = $mont_panu;
        return $this;
    }
    
    public function getReconst_par(){
        return $this->reconst_par;
    }
    
    public function setReconst_par($reconst_par){
        $this->reconst_par = $reconst_par;
        return $this;
    }
    
    public function getReconst_panu(){
        return $this->reconst_panu;
    }
    
    public function setReconst_panu($reconst_panu){
        $this->reconst_panu = $reconst_panu;
        return $this;
    }

    public function getRembourser() {
        return $this->rembourser;
    }

    public function setRembourser($rembourser) {
        $this->rembourser = $rembourser;
        return $this;
    }

    public function getPeriode() {
        return $this->periode;
    }

    public function setPeriode($periode) {
        $this->periode = $periode;
        return $this;
    }
    
    public function getConus() {
        return $this->conus;
    }

    public function setConus($conus) {
        $this->conus = $conus;
        return $this;
    }
    
    public function getPanu() {
        return $this->panu;
    }

    public function setPanu($panu) {
        $this->panu = $panu;
        return $this;
    }
    
    

}

?>
