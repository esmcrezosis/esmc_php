<?php

class Application_Model_EuAppelOffre {

    //put your code here
    protected $id_appel_offre;
    protected $numero_offre;
    protected $nom_appel_offre;
    protected $descrip_appel_offre;
    protected $type_appel_offre;
    protected $date_creation;
    protected $duree_projet;
    protected $publier;
    protected $id_utilisateur;
    protected $id_demande;
    protected $code_membre_morale;
    protected $membre_morale_executante;

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

    public function getId_appel_offre() {
        return $this->id_appel_offre;
    }

    public function setId_appel_offre($id_appel_offre) {
        $this->id_appel_offre = $id_appel_offre;
        return $this;
    }

    public function getNom_appel_offre() {
        return $this->nom_appel_offre;
    }

    public function setNom_appel_offre($nom_appel_offre) {
        $this->nom_appel_offre = $nom_appel_offre;
        return $this;
    }

    public function getDescrip_appel_offre() {
        return $this->descrip_appel_offre;
    }

    public function setDescrip_appel_offre($descrip_appel_offre) {
        $this->descrip_appel_offre = $descrip_appel_offre;
        return $this;
    }

    public function getType_appel_offre() {
        return $this->type_appel_offre;
    }

    public function setType_appel_offre($type_appel_offre) {
        $this->type_appel_offre = $type_appel_offre;
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

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getNumero_offre() {
        return $this->numero_offre;
    }

    public function setNumero_offre($numero_offre) {
        $this->numero_offre = $numero_offre;
        return $this;
    }

    public function getDuree_projet() {
        return $this->duree_projet;
    }

    public function setDuree_projet($duree_projet) {
        $this->duree_projet = $duree_projet;
        return $this;
    }
	
    public function getId_demande() {
        return $this->id_demande;
    }

    public function setId_demande($id_demande) {
        $this->id_demande = $id_demande;
        return $this;
    }
	
    public function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    public function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }
	
    public function getMembre_morale_executante() {
        return $this->membre_morale_executante;
    }

    public function setMembre_morale_executante($membre_morale_executante) {
        $this->membre_morale_executante = $membre_morale_executante;
        return $this;
    }
}

?>
