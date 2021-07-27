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
class Application_Model_EuTypeGac {

    //put your code here
    protected $code_type_gac;
    protected $nom_type_gac;
    protected $ordre_type_gac;

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

    public function getCode_type_gac() {
        return $this->code_type_gac;
    }

    public function setCode_type_gac($code_type_gac) {
        $this->code_type_gac = $code_type_gac;
        return $this;
    }

    public function getNom_type_gac() {
        return $this->nom_type_gac;
    }

    public function setNom_type_gac($nom_type_gac) {
        $this->nom_type_gac = $nom_type_gac;
        return $this;
    }

    public function getOrdre_type_gac() {
        return $this->ordre_type_gac;
    }

    public function setOrdre_type_gac($ordre_type_gac) {
        $this->ordre_type_gac = $ordre_type_gac;
        return $this;
    }

    public function exchangeArray($data) {
        $this->code_type_gac = (isset($data['code_type_gac'])) ? $data['code_type_gac'] : NULL;
        $this->nom_type_gac = (isset($data['nom_type_gac'])) ? $data['nom_type_gac'] : NULL;
        $this->ordre_type_gac = (isset($data['ordre_type_gac'])) ? $data['ordre_type_gac'] : NULL;
    }

    public function toArray() {
        $data = array(
            'code_type_gac' => $this->code_type_gac,
            'nom_type_gac' => $this->nom_type_gac,
            'ordre_type_gac' => $this->ordre_type_gac
        );
        return $data;
    }

}

?>
