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
class Application_Model_EuPointage {

    //put your code here
    protected $id_pointage;
    protected $date_heure_debut;
    protected $date_heure_fin;
    protected $code_membre_employe;
    protected $id_poste_pointage;
	protected $traiter;
	protected $date_pointage;
    

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

    public function getId_pointage() {
        return $this->id_pointage;
    }

    public function setId_pointage($id_pointage) {
        $this->id_pointage = $id_pointage;
        return $this;
    }

    public function getCode_membre_employe() {
        return $this->code_membre_employe;
    }

    public function setCode_membre_employe($code_membre_employe) {
        $this->code_membre_employe = $code_membre_employe;
        return $this;
    }

    public function getDate_heure_debut() {
        return $this->date_heure_debut;
    }

    public function setDate_heure_debut($date_heure_debut) {
        $this->date_heure_debut = $date_heure_debut;
        return $this;
    }

    public function getDate_heure_fin() {
        return $this->date_heure_fin;
    }

    public function setDate_heure_fin($date_heure_fin) {
        $this->date_heure_fin = $date_heure_fin;
        return $this;
    }

    public function getId_poste_pointage() {
        return $this->id_poste_pointage;
    }

    public function setId_poste_pointage($id_poste_pointage) {
        $this->id_poste_pointage = $id_poste_pointage;
        return $this;
    }
	
	public function getTraiter() {
        return $this->traiter;
    }

    public function setTraiter($traiter) {
        $this->traiter = $traiter;
        return $this;
    }
	
	public function getDate_pointage() {
        return $this->date_pointage;
    }

    public function setDate_pointage($date_pointage) {
        $this->date_pointage = $date_pointage;
        return $this;
    }
    
	
	
	
}



?>
