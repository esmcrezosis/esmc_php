<?php

class Application_Model_EuDocument {

    //put your code here
    protected $id_document;
    protected $id_type_document;
    protected $nom_document;
    protected $descrip_document;
    protected $date_creation;
    protected $date_debut;
    protected $date_fin;
    protected $publier;
    protected $id_utilisateur;
    protected $accord;
    protected $num_appeloffres;

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

    public function getId_document() {
        return $this->id_document;
    }

    public function setId_document($id_document) {
        $this->id_document = $id_document;
        return $this;
    }

    public function getNom_document() {
        return ($this->nom_document);
    }

    public function setNom_document($nom_document) {
        $this->nom_document = ($nom_document);
        return $this;
    }

    public function getDescrip_document() {
        return $this->descrip_document;
    }

    public function setDescrip_document($descrip_document) {
        $this->descrip_document = $descrip_document;
        return $this;
    }

    public function getDate_creation() {
        return $this->date_creation;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }
	
    public function getDate_debut() {
        return $this->date_debut;
    }

    public function setDate_debut($date_debut) {
        $this->date_debut = $date_debut;
        return $this;
    }

    public function getDate_fin() {
        return $this->date_fin;
    }

    public function setDate_fin($date_fin) {
        $this->date_fin = $date_fin;
        return $this;
    }
	
    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getId_type_document() {
        return $this->id_type_document;
    }

    public function setId_type_document($id_type_document) {
        $this->id_type_document = $id_type_document;
        return $this;
    }

    public function getAccord() {
        return $this->accord;
    }

    public function setAccord($accord) {
        $this->accord = $accord;
        return $this;
    }
	
    public function getNum_appeloffres() {
        return $this->num_appeloffres;
    }

    public function setNum_appeloffres($num_appeloffres) {
        $this->num_appeloffres = $num_appeloffres;
        return $this;
    }

}

?>
