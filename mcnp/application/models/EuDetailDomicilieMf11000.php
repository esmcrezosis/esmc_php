<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuDetailDomicilieMf11000 {

    protected $id_domi;
    protected $id_mf11000;
    protected $mt_domi_apport;
    protected $nb_repartition;
    protected $reste_repartition;

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

    function getId_domi() {
        return $this->id_domi;
    }

    function setId_domi($id_domi) {
        $this->id_domi = $id_domi;
        return $this;
    }

    function getId_mf11000() {
        return $this->id_mf11000;
    }

    function setId_mf11000($id_mf11000) {
        $this->id_mf11000 = $id_mf11000;
        return $this;
    }

    function getMt_domi_apport() {
        return $this->mt_domi_apport;
    }

    function setMt_domi_apport($mt_domi_apport) {
        $this->mt_domi_apport = $mt_domi_apport;
        return $this;
    }

    function getNb_repartition() {
        return $this->nb_repartition;
    }

    function setNb_repartition($nb_repartition) {
        $this->nb_repartition = $nb_repartition;
        return $this;
    }
    
    function getReste_repartition() {
        return $this->reste_repartition;
    }

    function setReste_repartition($reste_repartition) {
        $this->reste_repartition = $reste_repartition;
        return $this;
    }

}
?>

