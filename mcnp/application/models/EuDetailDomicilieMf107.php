<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuDetailDomicilieMf107 {

    protected $id_mf107;
    protected $id_dom;
    protected $mt_domi_apport;
    protected $nb_rep;
    protected $nb_reste;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
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

    function getId_dom() {
        return $this->id_dom;
    }

    function setId_dom($id_dom) {
        $this->id_dom = $id_dom;
        return $this;
    }

    function getId_mf107() {
        return $this->id_mf107;
    }

    function setId_mf107($id_mf107) {
        $this->id_mf107 = $id_mf107;
        return $this;
    }
 
    function getMt_domi_apport() {
        return $this->mt_domi_apport;
    }

    function setMt_domi_apport($mt_domi_apport) {
        $this->mt_domi_apport = $mt_domi_apport;
        return $this;
    }
    
    function getNb_rep() {
        return $this->nb_rep;
    }

    function setNb_rep($nb_rep) {
        $this->nb_rep = $nb_rep;
        return $this;
    }
    
    function getNb_reste() {
        return $this->nb_reste;
    }

    function setNb_reste($nb_reste) {
        $this->nb_reste = $nb_reste;
        return $this;
    }

}
?>
