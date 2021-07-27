<?php

class Application_Model_EuAgrement {

    //put your code here
    protected $id_agrement;
    protected $id_type_agrement;
    protected $num_agrement;
    protected $libelle_agrement;
    protected $desc_agrement;
    protected $date_agrement;
    protected $code_membre_morale;
    protected $id_utilisateur;
    protected $code_membre_morale_agrement;
    protected $id_type_acteur;
    protected $cel_agrement;
    protected $id_type_creneau;
    protected $id_filiere;

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

    public function getId_agrement() {
        return $this->id_agrement;
    }

    public function setId_agrement($id_agrement) {
        $this->id_agrement = $id_agrement;
        return $this;
    }

    public function getNum_agrement() {
        return $this->num_agrement;
    }

    public function setNum_agrement($num_agrement) {
        $this->num_agrement = $num_agrement;
        return $this;
    }

    public function getDesc_agrement() {
        return $this->desc_agrement;
    }

    public function setDesc_agrement($desc_agrement) {
        $this->desc_agrement = $desc_agrement;
        return $this;
    }

    public function getDate_agrement() {
        return $this->date_agrement;
    }

    public function setDate_agrement($date_agrement) {
        $this->date_agrement = $date_agrement;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    public function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }

    public function getId_type_agrement() {
        return $this->id_type_agrement;
    }

    public function setId_type_agrement($id_type_agrement) {
        $this->id_type_agrement = $id_type_agrement;
        return $this;
    }

    public function getLibelle_agrement() {
        return ($this->libelle_agrement);
    }

    public function setLibelle_agrement($libelle_agrement) {
        $this->libelle_agrement = ($libelle_agrement);
        return $this;
    }

    public function getCode_membre_morale_agrement() {
        return $this->code_membre_morale_agrement;
    }

    public function setCode_membre_morale_agrement($code_membre_morale_agrement) {
        $this->code_membre_morale_agrement = $code_membre_morale_agrement;
        return $this;
    }
	
    public function getId_type_acteur() {
        return $this->id_type_acteur;
    }

    public function setId_type_acteur($id_type_acteur) {
        $this->id_type_acteur = $id_type_acteur;
        return $this;
    }

    public function getCel_agrement() {
        return $this->cel_agrement;
    }

    public function setCel_agrement($cel_agrement) {
        $this->cel_agrement = $cel_agrement;
        return $this;
    }
	
    public function getId_type_creneau() {
        return $this->id_type_creneau;
    }

    public function setId_type_creneau($id_type_creneau) {
        $this->id_type_creneau = $id_type_creneau;
        return $this;
    }

    public function getId_filiere() {
        return $this->id_filiere;
    }

    public function setId_filiere($id_filiere) {
        $this->id_filiere = $id_filiere;
        return $this;
    }

}

?>
