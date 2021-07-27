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
class Application_Model_EuPostePointage {

    //put your code here
    protected $id_poste_pointage;
    protected $libelle_poste_pointage;
    protected $code_membre_employeur;
    protected $salaire_base;
    

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

    public function getId_poste_pointage() {
        return $this->id_poste_pointage;
    }

    public function setId_poste_pointage($id_poste_pointage) {
        $this->id_poste_pointage = $id_poste_pointage;
        return $this;
    }

    public function getCode_membre_employeur() {
        return $this->code_membre_employeur;
    }

    public function setCode_membre_employeur($code_membre_employeur) {
        $this->code_membre_employeur = $code_membre_employeur;
        return $this;
    }

    public function getLibelle_poste_pointage() {
        return $this->libelle_poste_pointage;
    }

    public function setLibelle_poste_pointage($libelle_poste_pointage) {
        $this->libelle_poste_pointage = $libelle_poste_pointage;
        return $this;
    }

    public function getSalaire_base() {
        return $this->salaire_base;
    }

    public function setSalaire_base($salaire_base) {
        $this->salaire_base = $salaire_base;
        return $this;
    }
    
	
	
	
}



?>
