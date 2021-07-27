<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eu_Division
 *
 * @author user
 */
class Application_Model_EuDivision {

    //put your code here
    protected $id_division;
    protected $code_division;
    protected $nom_division;
    protected $desc_division;
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

    public function getId_division() {
        return $this->id_division;
    }

    public function setId_division($id_division) {
        $this->id_division = $id_division;
        return $this;
    }
    
    public function getCode_division() {
        return $this->code_division;
    }

    public function setCode_division($code_division) {
        $this->code_division = $code_division;
        return $this;
    }

    public function getNom_division() {
        return $this->nom_division;
    }

    public function setNom_division($nom_division) {
        $this->nom_division = $nom_division;
        return $this;
    }

    public function getDesc_division() {
        return $this->desc_division;
    }

    public function setDesc_division($desc_division) {
        $this->desc_division = $desc_division;
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
        $this->id_division = (isset($data['id_division'])) ? $data['id_division'] : NULL;
        $this->code_division = (isset($data['code_division'])) ? $data['code_division'] : NULL;
        $this->nom_division = (isset($data['nom_division'])) ? $data['nom_division'] : NULL;
        $this->desc_division = (isset($data['desc_division'])) ? $data['desc_division'] : NULL;
		$this->date_creation = (isset($data['date_creation'])) ? $data['date_creation'] : NULL;
    }

    public function toArray() {
       $data = array(
         'id_division' => $this->id_division,
         'code_division' => $this->code_division,
         'nom_division' => $this->nom_division,
         'desc_division' => $this->desc_division,
	     'date_creation' => $this->date_creation,
       );
       return $data;
    }
    
    

}

?>
