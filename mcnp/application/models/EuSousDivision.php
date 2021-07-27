<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eu_Sous_Division
 *
 * @author user
 */
 
 
class Application_Model_EuSousDivision {

    //put your code here
    protected $id_sous_division;
    protected $id_division;
    protected $nom_sous_division;
    protected $desc_sous_division;
	protected $date_creation;

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
	
    public function getId_sous_division() {
        return $this->id_sous_division;
    }

    public function setId_sous_division($id_sous_division) {
        $this->id_sous_division = $id_sous_division;
        return $this;
    }
    
    public function getId_division() {
        return $this->id_division;
    }

    public function setId_division($id_division) {
        $this->id_division = $id_division;
        return $this;
    }
	
    public function getNom_sous_division() {
        return $this->nom_sous_division;
    }

    public function setNom_sous_division($nom_sous_division) {
        $this->nom_sous_division = $nom_sous_division;
        return $this;
    }

    public function getDesc_sous_division() {
        return $this->desc_sous_division;
    }

    public function setDesc_sous_division($desc_sous_division) {
        $this->desc_sous_division = $desc_sous_division;
        return $this;
    }
	
	
	public function getDate_creation() {
        return $this->date_creation;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }

    

    public function exchangeArray($data) {
        $this->id_sous_division = (isset($data['id_sous_division'])) ? $data['id_sous_division'] : NULL;
        $this->id_division = (isset($data['id_division'])) ? $data['id_division'] : NULL;
        $this->nom_sous_division = (isset($data['nom_sous_division'])) ? $data['nom_sous_division'] : NULL;
        $this->desc_sous_division = (isset($data['desc_sous_division'])) ? $data['desc_sous_division'] : NULL;
		$this->date_creation = (isset($data['date_creation'])) ? $data['date_creation'] : NULL;
    }

    public function toArray() {
       $data = array(
            'id_sous_division' => $this->id_sous_division,
            'id_division' => $this->id_division,
            'nom_sous_division' => $this->nom_sous_division,
            'desc_sous_division' => $this->desc_sous_division,
			'date_creation' => $this->date_creation,
       );
       return $data;
    }
    
    

}

?>
