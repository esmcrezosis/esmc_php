<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuCnpEntree
 *
 * @author user
 */
class Application_Model_EuActivite {

    //put your code here
    protected $code_activite;
    protected $nom_activite;
    protected $id_filiere;
    protected $id_utilisateur;
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

    public function getCode_activite() {
        return $this->code_activite;
    }

    public function setCode_activite($code_activite) {
        $this->code_activite = $code_activite;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getDate_creation() {
        return $this->date_creation;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }

    public function getId_filiere() {
        return $this->id_filiere;
    }

    public function setId_filiere($id_filiere) {
        $this->id_filiere = $id_filiere;
        return $this;
    }

    public function getNom_activite() {
        return $this->nom_activite;
    }

    public function setNom_activite($nom_activite) {
        $this->nom_activite = $nom_activite;
        return $this;
    }

    public function exchangeArray($data) {
        $this->id_filiere = (isset($data['id_filiere'])) ? $data['id_filiere'] : NULL;
        $this->id_utilisateur = (isset($data['id_utilisateur'])) ? $data['id_utilisateur'] : NULL;
        $this->date_creation = (isset($data['date_creation'])) ? $data['date_creation'] : NULL;
        $this->nom_activite = (isset($data['nom_activite'])) ? $data['nom_activite'] : NULL;
        $this->code_activite = (isset($data['code_activite'])) ? $data['code_activite'] : NULL;
    }

    public function toArray() {
        $data = array(
            'code_activite' => $this->code_activite,
            'id_filiere' => $this->id_filiere,
            'date_creation' => $this->date_creation,
            'nom_activite' => $this->nom_activite,
            'id_utilisateur' => $this->id_utilisateur
        );
        return $data;
    }

}

?>
