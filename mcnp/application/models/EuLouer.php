<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuLouer {

    protected $id_louer;
    protected $duree_location;
    protected $date_location;
    protected $mont_loyer;
    protected $id_proprietaire;
    protected $code_domiciliation;
    protected $code_membre_ag;
    protected $code_membre_loc;
    protected $id_maison;
    protected $id_appartement;
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

    function getId_louer() {
        return $this->id_louer;
    }

    function setId_louer($id_louer) {
        $this->id_louer = $id_louer;
        return $this;
    }

    function getDuree_location() {
        return $this->duree_location;
    }

    function setDuree_location($duree_location) {
        $this->duree_location = $duree_location;
        return $this;
    }

    function getDate_location() {
        return $this->date_location;
    }

    function setDate_location($date_location) {
        $this->date_location = $date_location;
        return $this;
    }

    function getMont_loyer() {
        return $this->mont_loyer;
    }

    function setMont_loyer($mont_loyer) {
        $this->mont_loyer = $mont_loyer;
        return $this;
    }

    function getId_proprietaire() {
        return $this->id_proprietaire;
    }

    function setId_proprietaire($id_proprietaire) {
        $this->id_proprietaire = $id_proprietaire;
        return $this;
    }
    
    function getCode_domiciliation() {
        return $this->code_domiciliation;
    }

    function setCode_domiciliation($code_domiciliation) {
        $this->code_domiciliation = $code_domiciliation;
        return $this;
    }

    function getCode_membre_ag() {
        return $this->code_membre_ag;
    }

    function setCode_membre_ag($code_membre_ag) {
        $this->code_membre_ag = $code_membre_ag;
        return $this;
    }

    function getCode_membre_loc() {
        return $this->code_membre_loc;
    }

    function setCode_membre_loc($code_membre_loc) {
        $this->code_membre_loc = $code_membre_loc;
        return $this;
    }

    function getId_maison() {
        return $this->id_maison;
    }

    function setId_maison($id_maison) {
        $this->id_maison = $id_maison;
        return $this;
    }

    function getId_appartement() {
        return $this->id_appartement;
    }

    function setId_appartement($id_appartement) {
        $this->id_appartement = $id_appartement;
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
