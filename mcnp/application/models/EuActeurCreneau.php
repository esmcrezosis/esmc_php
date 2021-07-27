<?php

class Application_Model_EuActeurCreneau {

    protected $code_acteur;
    protected $nom_acteur;
    protected $code_membre;
    protected $id_type_acteur;
    protected $code_membre_gestionnaire;
    protected $date_creation;
    protected $id_utilisateur;
    protected $groupe;
    protected $code_creneau;
    protected $code_gac_filiere;
    protected $code_gac;
    protected $id_filiere;
    protected $focus;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
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

    function getCode_acteur() {
        return $this->code_acteur;
    }

    function setCode_acteur($code_acteur) {
        $this->code_acteur = $code_acteur;
        return $this;
    }

    function getNom_acteur() {
        return $this->nom_acteur;
    }

    function setNom_acteur($nom_acteur) {
        $this->nom_acteur = $nom_acteur;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    function getId_type_acteur() {
        return $this->id_type_acteur;
    }

    function setId_type_acteur($id_type_acteur) {
        $this->id_type_acteur = $id_type_acteur;
        return $this;
    }

    public function getCode_membre_gestionnaire() {
        return $this->code_membre_gestionnaire;
    }

    public function setCode_membre_gestionnaire($code_membre_gestionnaire) {
        $this->code_membre_gestionnaire = $code_membre_gestionnaire;
        return $this;
    }

    function getDate_creation() {
        return $this->date_creation;
    }

    function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }

    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
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

    function getCode_creneau() {
        return $this->code_creneau;
    }

    function setCode_creneau($code_creneau) {
        $this->code_creneau = $code_creneau;
        return $this;
    }
    
    public function getCode_gac_filiere() {
        return $this->code_gac_filiere;
    }

    public function setCode_gac_filiere($code_gac_filiere) {
        $this->code_gac_filiere = $code_gac_filiere;
        return $this;
    }
    
    public function getCode_gac() {
        return $this->code_gac;
    }

    public function setCode_gac($code_gac) {
        $this->code_gac = $code_gac;
        return $this;
    }
    
    public function getId_filiere() {
        return $this->id_filiere;
    }

    public function setId_filiere($id_filiere) {
        $this->id_filiere = $id_filiere;
        return $this;
    }
    
    public function getFocus() {
        return $this->focus;
    }

    public function setFocus($focus) {
        $this->focus = $focus;
        return $this;
    }

}

?>
