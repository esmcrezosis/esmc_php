<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuDomicilieMf11000 {

    protected $id_domi;
    protected $code_membre;
    protected $mt_domiciliation;
    protected $mt_domicilie;
    protected $etat_domi;
    protected $date_domi;
    protected $heure_domi;
    protected $cel;
    protected $id_utilisateur;

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

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    function getMt_domiciliation() {
        return $this->mt_domiciliation;
    }

    function setMt_domiciliation($mt_domiciliation) {
        $this->mt_domiciliation = $mt_domiciliation;
        return $this;
    }

    function getMt_domicilie() {
        return $this->mt_domicilie;
    }

    function setMt_domicilie($mt_domicilie) {
        $this->mt_domicilie = $mt_domicilie;
        return $this;
    }

    function getEtat_domi() {
        return $this->etat_domi;
    }

    function setEtat_domi($etat_domi) {
        $this->etat_domi = $etat_domi;
        return $this;
    }

    function getDate_domi() {
        return $this->date_domi;
    }

    function setDate_domi($date_domi) {
        $this->date_domi = $date_domi;
        return $this;
    }

    function getHeure_domi() {
        return $this->heure_domi;
    }

    function setHeure_domi($heure_domi) {
        $this->heure_domi = $heure_domi;
        return $this;
    }
    
    function getCel() {
        return $this->cel;
    }

    function setCel($cel) {
        $this->cel = $cel;
        return $this;
    }

    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

}

?>
