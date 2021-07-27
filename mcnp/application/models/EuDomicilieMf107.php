<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuDomicilieMf107 {
    protected $id_dom;
    protected $mt_domiciliation;
    protected $mt_domicilie;
    protected $etat_domiciliation;
    protected $code_membre;
    protected $date_dom;
    protected $heure_dom;
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

    
    function getId_dom() {
        return $this->id_dom;
    }

    function setId_dom($id_dom) {
        $this->id_dom = $id_dom;
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

    function getEtat_domiciliation() {
        return $this->etat_domiciliation;
    }

    function setEtat_domiciliation($etat_domiciliation) {
        $this->etat_domiciliation = $etat_domiciliation;
        return $this;
    }

    
    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    
    function getDate_dom() {
        return $this->date_dom;
    }

    function setDate_dom($date_dom) {
        $this->date_dom = $date_dom;
        return $this;
    }

    
    function getHeure_dom() {
        return $this->heure_dom;
    }

    
    function setHeure_dom($heure_dom) {
        $this->heure_dom = $heure_dom;
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
