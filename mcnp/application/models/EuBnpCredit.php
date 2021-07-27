<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuBnpCredit
 *
 * @author user
 */
class Application_Model_EuBnpCredit {

    //put your code here
    protected $code_bnp;
    protected $id_credit;
    protected $mont_credit;
    protected $mont_conus;
    protected $mont_par;
    protected $mont_panu;
    protected $mont_fs;
    protected $mont_panu_fs;
    protected $periode_remb;

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

    public function getId_credit() {
        return $this->id_credit;
    }

    public function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
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

    public function getPeriode_remb() {
        return $this->periode_remb;
    }

    public function setPeriode_remb($periode_remb) {
        $this->periode_remb = $periode_remb;
        return $this;
    }

}

?>
