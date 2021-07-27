<?php

class Application_Model_EuCreneau {

    protected $code_creneau;
    protected $nom_creneau;
    protected $code_membre;
    protected $id_type_creneau;
    protected $code_membre_gestionnaire;
    protected $date_creation;
    protected $id_utilisateur;
    protected $groupe;
    protected $code_gac_filiere;

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

    function getCode_creneau() {
        return $this->code_creneau;
    }

    function setCode_creneau($code_creneau) {
        $this->code_creneau = $code_creneau;
        return $this;
    }

    function getNom_creneau() {
        return $this->nom_creneau;
    }

    function setNom_creneau($nom_creneau) {
        $this->nom_creneau = $nom_creneau;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    function getId_type_creneau() {
        return $this->id_type_creneau;
    }

    function setId_type_creneau($id_type_creneau) {
        $this->id_type_creneau = $id_type_creneau;
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

    public function getCode_gac_filiere() {
        return $this->code_gac_filiere;
    }

    public function setCode_gac_filiere($code_gac_filiere) {
        $this->code_gac_filiere = $code_gac_filiere;
        return $this;
    }

}

?>
