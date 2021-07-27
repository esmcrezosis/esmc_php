<?php

class Application_Model_EuGacFiliere {

//put your code here
    protected $code_gac_filiere;
    protected $nom_gac_filiere;
    protected $code_membre;
    protected $code_membre_gestionnaire;
    protected $date_creation;
    protected $id_utilisateur;
    protected $groupe;
    protected $code_gac;

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

    public function getCode_gac_filiere() {
        return $this->code_gac_filiere;
    }

    public function setCode_gac_filiere($code_gac_filiere) {
        $this->code_gac_filiere = $code_gac_filiere;
        return $this;
    }

    public function getNom_gac_filiere() {
        return $this->nom_gac_filiere;
    }

    public function setNom_gac_filiere($nom_gac_filiere) {
        $this->nom_gac_filiere = $nom_gac_filiere;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getCode_membre_gestionnaire() {
        return $this->code_membre_gestionnaire;
    }

    public function setCode_membre_gestionnaire($code_membre_gestionnaire) {
        $this->code_membre_gestionnaire = $code_membre_gestionnaire;
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

    public function getGroupe() {
        return $this->groupe;
    }

    public function setGroupe($groupe) {
        $this->groupe = $groupe;
        return $this;
    }

    public function getCode_gac() {
        return $this->code_gac;
    }

    public function setCode_gac($code_gac) {
        $this->code_gac = $code_gac;
        return $this;
    }

}

?>
