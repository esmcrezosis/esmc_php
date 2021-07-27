<?php

class Application_Model_EuFiliere {

    //put your code here
    protected $id_filiere;
    protected $nom_filiere;
    protected $descrip_filiere;
    protected $date_creation;
    protected $id_utilisateur;
	protected $code_division;
	protected $id_sous_division;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
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

    public function getId_filiere() {
        return $this->id_filiere;
    }

    public function setId_filiere($id_filiere) {
        $this->id_filiere = $id_filiere;
        return $this;
    }

    public function getNom_filiere() {
        return $this->nom_filiere;
    }

    public function setNom_filiere($nom_filiere) {
        $this->nom_filiere = $nom_filiere;
        return $this;
    }

    public function getDescrip_filiere() {
        return $this->descrip_filiere;
    }

    public function setDescrip_filiere($descrip_filiere) {
        $this->descrip_filiere = $descrip_filiere;
        return $this;
    }

    public function getDate_creation() {
        return $this->date_creation;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
	
	public function getCode_division() {
        return $this->code_division;
    }

    public function setCode_division($code_division) {
        $this->code_division = $code_division;
        return $this;
    }
	
	public function getId_sous_division() {
        return $this->id_sous_division;
    }

    public function setId_sous_division($id_sous_division) {
        $this->id_sous_division = $id_sous_division;
        return $this;
    }
	
	
	
	
}

?>
