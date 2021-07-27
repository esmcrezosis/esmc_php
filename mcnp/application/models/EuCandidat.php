<?php
 
class Application_Model_EuCandidat {

    //put your code here
    protected $candidat_id;
    protected $id_type_candidat;
    protected $candidat_nom;
    protected $candidat_poste;
    protected $candidat_document;
    protected $candidat_datenaiss;
    protected $candidat_nationalite;
    protected $candidat_education;
    protected $candidat_affiliation;
    protected $candidat_formation;
    protected $candidat_pays;
    protected $candidat_langue;
    protected $candidat_experience;
    protected $candidat_tache;
    protected $candidat_competence;
    protected $candidat_attestation;
    protected $candidat_date;
    protected $publier;

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

    public function getCandidat_id() {
        return $this->candidat_id;
    }

    public function setCandidat_id($candidat_id) {
        $this->candidat_id = $candidat_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getCandidat_nom() {
        return ($this->candidat_nom);
    }

    public function setCandidat_nom($candidat_nom) {
        $this->candidat_nom = ($candidat_nom);
        return $this;
    }

    public function getCandidat_poste() {
        return ($this->candidat_poste);
    }

    public function setCandidat_poste($candidat_poste) {
        $this->candidat_poste = ($candidat_poste);
        return $this;
    }

    public function getCandidat_document() {
        return $this->candidat_document;
    }

    public function setCandidat_document($candidat_document) {
        $this->candidat_document = $candidat_document;
        return $this;
    }

    public function getCandidat_datenaiss() {
        return $this->candidat_datenaiss;
    }

    public function setCandidat_datenaiss($candidat_datenaiss) {
        $this->candidat_datenaiss = $candidat_datenaiss;
        return $this;
    }

    public function getCandidat_nationalite() {
        return ($this->candidat_nationalite);
    }

    public function setCandidat_nationalite($candidat_nationalite) {
        $this->candidat_nationalite = ($candidat_nationalite);
        return $this;
    }

    public function getCandidat_education() {
        return ($this->candidat_education);
    }

    public function setCandidat_education($candidat_education) {
        $this->candidat_education = ($candidat_education);
        return $this;
    }

    public function getCandidat_affiliation() {
        return ($this->candidat_affiliation);
    }

    public function setCandidat_affiliation($candidat_affiliation) {
        $this->candidat_affiliation = ($candidat_affiliation);
        return $this;
    }

    public function getCandidat_formation() {
        return ($this->candidat_formation);
    }

    public function setCandidat_formation($candidat_formation) {
        $this->candidat_formation = ($candidat_formation);
        return $this;
    }

    public function getCandidat_pays() {
        return ($this->candidat_pays);
    }

    public function setCandidat_pays($candidat_pays) {
        $this->candidat_pays = ($candidat_pays);
        return $this;
    }

    public function getCandidat_langue() {
        return ($this->candidat_langue);
    }

    public function setCandidat_langue($candidat_langue) {
        $this->candidat_langue = ($candidat_langue);
        return $this;
    }

    public function getCandidat_experience() {
        return ($this->candidat_experience);
    }

    public function setCandidat_experience($candidat_experience) {
        $this->candidat_experience = ($candidat_experience);
        return $this;
    }

    public function getCandidat_tache() {
        return ($this->candidat_tache);
    }

    public function setCandidat_tache($candidat_tache) {
        $this->candidat_tache = ($candidat_tache);
        return $this;
    }

    public function getCandidat_competence() {
        return ($this->candidat_competence);
    }

    public function setCandidat_competence($candidat_competence) {
        $this->candidat_competence = ($candidat_competence);
        return $this;
    }

    public function getCandidat_attestation() {
        return ($this->candidat_attestation);
    }

    public function setCandidat_attestation($candidat_attestation) {
        $this->candidat_attestation = ($candidat_attestation);
        return $this;
    }

    public function getCandidat_date() {
        return $this->candidat_date;
    }

    public function setCandidat_date($candidat_date) {
        $this->candidat_date = $candidat_date;
        return $this;
    }

    public function getId_type_candidat() {
        return ($this->id_type_candidat);
    }

    public function setId_type_candidat($id_type_candidat) {
        $this->id_type_candidat = ($id_type_candidat);
        return $this;
    }

}

?>
