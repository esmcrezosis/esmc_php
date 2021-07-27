<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eu_Liaison_user
 *
 * @author user
 */
 
 
class Application_Model_EuLiaisonUser  {

    //put your code here
	protected $id_liaison_user;
    protected $id_utilisateur;
    protected $id_division_gac;
    protected $date_liaison;

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
	
	
	public function getId_liaison_user() {
        return $this->id_liaison_user;
    }

    public function setId_liaison_user($id_liaison_user) {
        $this->id_liaison_user = $id_liaison_user;
        return $this;
    }
    
    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getId_division_gac() {
        return $this->id_division_gac;
    }

    public function setId_division_gac($id_division_gac) {
        $this->id_division_gac = $id_division_gac;
        return $this;
    }

    public function getDate_liaison() {
        return $this->date_liaison;
    }

    public function setDate_liaison($date_liaison) {
        $this->date_liaison = $date_liaison;
        return $this;
    }
	

}

?>
