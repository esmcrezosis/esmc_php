<?php
 
class Application_Model_EuProjet {

    //put your code here
    protected $projet_id;
    protected $projet_libelle;
	protected $projet_code_membre;
    protected $projet_description;
    protected $projet_type;
    protected $projet_libelle_espace;
    protected $projet_superficie_espace;
    protected $projet_description_espace;
    protected $projet_adresse_espace;
    protected $projet_statut;
    protected $projet_centrale;
    protected $projet_date;
    protected $projet_stockage;
    protected $publier;
    protected $projet_montant;
    protected $projet_montant_final;
    protected $projet_observation;
    protected $projet_utilisateur;
    protected $code_zone;
    protected $id_pays;
    protected $id_region;
    protected $id_prefecture;
    protected $id_canton;

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

    public function getProjet_id() {
        return $this->projet_id;
    }

    public function setProjet_id($projet_id) {
        $this->projet_id = $projet_id;
        return $this;
    }

    public function getProjet_type() {
        return $this->projet_type;
    }

    public function setProjet_type($projet_type) {
        $this->projet_type = $projet_type;
        return $this;
    }

	public function getProjet_code_membre() {
        return $this->projet_code_membre;
    }

    public function setProjet_code_membre($projet_code_membre) {
        $this->projet_code_membre = $projet_code_membre;
        return $this;
    }
	
	
    public function getProjet_description() {
        return $this->projet_description;
    }

    public function setProjet_description($projet_description) {
        $this->projet_description = $projet_description;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getProjet_libelle() {
        return ($this->projet_libelle);
    }

    public function setProjet_libelle($projet_libelle) {
        $this->projet_libelle = ($projet_libelle);
        return $this;
    }

    public function getProjet_centrale() {
        return $this->projet_centrale;
    }

    public function setProjet_centrale($projet_centrale) {
        $this->projet_centrale = $projet_centrale;
        return $this;
    }


    public function getProjet_date() {
        return $this->projet_date;
    }

    public function setProjet_date($projet_date) {
        $this->projet_date = $projet_date;
        return $this;
    }

    public function getProjet_stockage() {
        return $this->projet_stockage;
    }

    public function setProjet_stockage($projet_stockage) {
        $this->projet_stockage = $projet_stockage;
        return $this;
    }


    public function getProjet_montant() {
        return ($this->projet_montant);
    }

    public function setProjet_montant($projet_montant) {
        $this->projet_montant = ($projet_montant);
        return $this;
    }

    public function getProjet_montant_final() {
        return $this->projet_montant_final;
    }

    public function setProjet_montant_final($projet_montant_final) {
        $this->projet_montant_final = $projet_montant_final;
        return $this;
    }

    public function getProjet_observation() {
        return $this->projet_observation;
    }

    public function setProjet_observation($projet_observation) {
        $this->projet_observation = $projet_observation;
        return $this;
    }

    public function getProjet_utilisateur() {
        return ($this->projet_utilisateur);
    }

    public function setProjet_utilisateur($projet_utilisateur) {
        $this->projet_utilisateur = ($projet_utilisateur);
        return $this;
    }

    public function getCode_zone() {
        return ($this->code_zone);
    }

    public function setCode_zone($code_zone) {
        $this->code_zone = ($code_zone);
        return $this;
    }

    public function getId_pays() {
        return ($this->id_pays);
    }

    public function setId_pays($id_pays) {
        $this->id_pays = ($id_pays);
        return $this;
    }

    public function getId_region() {
        return ($this->id_region);
    }

    public function setId_region($id_region) {
        $this->id_region = ($id_region);
        return $this;
    }

    public function getId_prefecture() {
        return ($this->id_prefecture);
    }

    public function setId_prefecture($id_prefecture) {
        $this->id_prefecture = ($id_prefecture);
        return $this;
    }

    public function getId_canton() {
        return ($this->id_canton);
    }

    public function setId_canton($id_canton) {
        $this->id_canton = ($id_canton);
        return $this;
    }


}

?>
