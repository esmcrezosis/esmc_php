<?php

 
class Application_Model_EuMobilisateur  {

    //put your code here
	protected $id_mobilisateur;
    protected $code_membre;
    protected $id_utilisateur;
    protected $datecreat;
    protected $etat;

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
	
	
	public function getId_mobilisateur() {
        return $this->id_mobilisateur;
    }

    public function setId_mobilisateur($id_mobilisateur) {
        $this->id_mobilisateur = $id_mobilisateur;
        return $this;
    }
    
    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getDatecreat() {
        return $this->datecreat;
    }

    public function setDatecreat($datecreat) {
        $this->datecreat = $datecreat;
        return $this;
    }

    public function getEtat() {
        return $this->etat;
    }

    public function setEtat($etat) {
        $this->etat = $etat;
        return $this;
    }
	

}

?>
