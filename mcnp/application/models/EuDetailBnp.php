<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDetailBnp
 *
 * @author user
 */
class Application_Model_EuDetailBnp {
    //put your code here
    protected $id_detail;
    protected $code_bnp;
    protected $id_credit;
    protected $mont_capa;
    protected $montant_credit;
    protected $mont_conus;
    protected $mont_par;
    protected $mont_panu;
    protected $mont_fs;
    protected $mont_panu_fs;
    protected $periode;
    protected $renouv_effectue;


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
    
     public function getId_detail() {
        return $this->id_detail;
    }

    public function setId_detail($id_detail) {
        $this->id_detail = $id_detail;
        return $this;
    }
    
    public function getCode_bnp() {
        return $this->code_bnp;
    }

    public function setCode_bnp($code_bnp) {
        $this->code_bnp = $code_bnp;
        return $this;
    }

    public function getId_credit() {
        return $this->id_credit;
    }

    public function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }
    
    public function getMont_capa() {
        return $this->mont_capa;
    }

    public function setMont_capa($mont_capa) {
        $this->mont_capa = $mont_capa;
        return $this;
    }
    
    public function getMontant_credit() {
        return $this->montant_credit;
    }

    public function setMontant_credit($montant_credit) {
        $this->montant_credit = $montant_credit;
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

    public function getMont_fs() {
        return $this->mont_fs;
    }

    public function setMont_fs($mont_fs) {
        $this->mont_fs = $mont_fs;
        return $this;
    }
    
    public function getMont_panu_fs() {
        return $this->mont_panu_fs;
    }

    public function setMont_panu_fs($mont_panu_fs) {
        $this->mont_panu_fs = $mont_panu_fs;
        return $this;
    }
    
    public function getPeriode() {
        return $this->periode;
    }

    public function setPeriode($periode) {
        $this->periode = $periode;
        return $this;
    }
    
    public function getRenouv_effectue() {
        return $this->renouv_effectue;
    }

    public function setRenouv_effectue($renouv_effectue) {
        $this->renouv_effectue = $renouv_effectue;
        return $this;
    }
    
}

?>
