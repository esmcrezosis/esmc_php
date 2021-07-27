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
class Application_Model_EuRepartitionNn {

    //put your code here
    protected $id_rep_nn;
    protected $id_detail_appel_nn;
    protected $date_rep;
    protected $mont_rep;
	protected $mont_marge;
    protected $id_utilisateur;
	 protected $id_proposition;
   		

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
   
	
    public function getId_rep_nn() {
        return $this->id_rep_nn;
    }

    public function setId_rep_nn($id_rep_nn) {
        $this->id_rep_nn = $id_rep_nn;
        return $this;
    }

    public function getId_detail_appel_nn() {
           return $this->id_detail_appel_nn;
    }

    public function setId_detail_appel_nn($id_detail_appel_nn) {
        $this->id_detail_appel_nn = $id_detail_appel_nn;
        return $this;
    }

    public function getDate_rep() {
        return $this->date_rep;
    }

    public function setDate_rep($date_rep) {
        $this->date_rep = $date_rep;
        return $this;
    }

    public function getMont_rep() {
        return $this->mont_rep;
    }

    public function setMont_rep($mont_rep) {
        $this->mont_rep = $mont_rep;
        return $this;
    }
	
	public function getMont_marge() {
        return $this->mont_marge;
    }

    public function setMont_marge($mont_marge) {
        $this->mont_marge = $mont_marge;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
	
	public function getId_proposition() {
        return $this->id_proposition;
    }

    public function setId_proposition($id_proposition) {
        $this->id_proposition = $id_proposition;
        return $this;
    }
    
    

}

?>
