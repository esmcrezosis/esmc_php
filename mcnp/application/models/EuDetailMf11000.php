<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuDetailMf11000 {

    protected $id_mf11000;
    protected $num_bon;
    protected $code_membre;
    protected $date_mf11000;
    protected $mont_apport;
    protected $cel;
    protected $pourcentage;
    protected $id_utilisateur;
    protected $proprietaire;

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

    function getId_mf11000() {
        return $this->id_mf11000;
    }

    function setId_mf11000($id_mf11000) {
        $this->id_mf11000 = $id_mf11000;
        return $this;
    }

    function getNum_bon() {
        return $this->num_bon;
    }

    function setNum_bon($num_bon) {
        $this->num_bon = $num_bon;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    function getDate_mf11000() {
        return $this->date_mf11000;
    }

    function setDate_mf11000($date_mf11000) {
        $this->date_mf11000 = $date_mf11000;
        return $this;
    }

    function getMont_apport() {
        return $this->mont_apport;
    }

    function setMont_apport($mont_apport) {
        $this->mont_apport = $mont_apport;
        return $this;
    }
    
    function getCel() {
        return $this->cel;
    }

    function setCel($cel) {
        $this->cel = $cel;
        return $this;
    }

    function getPourcentage() {
        return $this->pourcentage;
    }

    function setPourcentage($pourcentage) {
        $this->pourcentage = $pourcentage;
        return $this;
    }

    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    function getProprietaire() {
        return $this->proprietaire;
    }

    function setProprietaire($proprietaire) {
        $this->proprietaire = $proprietaire;
        return $this;
    }

}
?>

