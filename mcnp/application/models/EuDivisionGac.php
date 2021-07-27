<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eu_Division_gac
 *
 * @author user
 */
 
 
class Application_Model_EuDivisionGac  {

    //put your code here
    protected $id_division_gac;
    protected $code_gac;
    protected $code_membre;
    protected $type_division;
	protected $nom_division;
    protected $libelle_division;

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
	

    public function getId_division_gac() {
        return $this->id_division_gac;
    }
	

    public function setId_division_gac($id_division_gac) {
        $this->id_division_gac = $id_division_gac;
        return $this;
    }
    
    public function getCode_gac() {
        return $this->code_gac;
    }

    public function setCode_gac($code_gac) {
        $this->code_gac = $code_gac;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getType_division() {
        return $this->type_division;
    }

    public function setType_division($type_division) {
        $this->type_division = $type_division;
        return $this;
    }
	
	
	public function getNom_division() {
        return $this->nom_division;
    }

    public function setNom_division($nom_division) {
        $this->nom_division = $nom_division;
        return $this;
    }
	
	
	
	 public function getLibelle_division() {
        return $this->libelle_division;
    }

    public function setLibelle_division($libelle_division) {
        $this->libelle_division = $libelle_division;
        return $this;
    }
	

}

?>
