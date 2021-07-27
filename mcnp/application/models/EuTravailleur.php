<?php
 
class Application_Model_EuTravailleur {

    //put your code here
    protected $travailleur_id;
    protected $travailleur_libelle;
	protected $travailleur_code_membre;
    protected $travailleur_experience;
    protected $travailleur_type;
    protected $travailleur_niveau;
    protected $travailleur_date;
    protected $travailleur_formation;
    protected $publier;
    protected $travailleur_education;
    protected $travailleur_adresse;
    protected $travailleur_observation;
    protected $travailleur_utilisateur;
    protected $code_zone;
    protected $id_pays;
    protected $id_region;
    protected $id_prefecture;
    protected $id_canton;
    protected $id_postes;
	protected $montant_prestation;
    protected $travailleur_numero_cin;
    protected $travailleur_date_delivrance_cin;
    protected $travailleur_date_expiration_cin;
    

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

    public function getTravailleur_id() {
        return $this->travailleur_id;
    }

    public function setTravailleur_id($travailleur_id) {
        $this->travailleur_id = $travailleur_id;
        return $this;
    }

    public function getTravailleur_type() {
        return $this->travailleur_type;
    }

    public function setTravailleur_type($travailleur_type) {
        $this->travailleur_type = $travailleur_type;
        return $this;
    }

	public function getTravailleur_code_membre() {
        return $this->travailleur_code_membre;
    }

    public function setTravailleur_code_membre($travailleur_code_membre) {
        $this->travailleur_code_membre = $travailleur_code_membre;
        return $this;
    }
	
	
    public function getTravailleur_experience() {
        return $this->travailleur_experience;
    }

    public function setTravailleur_experience($travailleur_experience) {
        $this->travailleur_experience = $travailleur_experience;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getTravailleur_libelle() {
        return ($this->travailleur_libelle);
    }

    public function setTravailleur_libelle($travailleur_libelle) {
        $this->travailleur_libelle = ($travailleur_libelle);
        return $this;
    }

    public function getTravailleur_niveau() {
        return $this->travailleur_niveau;
    }

    public function setTravailleur_niveau($travailleur_niveau) {
        $this->travailleur_niveau = $travailleur_niveau;
        return $this;
    }


    public function getTravailleur_date() {
        return $this->travailleur_date;
    }

    public function setTravailleur_date($travailleur_date) {
        $this->travailleur_date = $travailleur_date;
        return $this;
    }

    public function getTravailleur_formation() {
        return $this->travailleur_formation;
    }

    public function setTravailleur_formation($travailleur_formation) {
        $this->travailleur_formation = $travailleur_formation;
        return $this;
    }


    public function getTravailleur_education() {
        return ($this->travailleur_education);
    }

    public function setTravailleur_education($travailleur_education) {
        $this->travailleur_education = ($travailleur_education);
        return $this;
    }

    public function getTravailleur_adresse() {
        return $this->travailleur_adresse;
    }

    public function setTravailleur_adresse($travailleur_adresse) {
        $this->travailleur_adresse = $travailleur_adresse;
        return $this;
    }

    public function getTravailleur_observation() {
        return $this->travailleur_observation;
    }

    public function setTravailleur_observation($travailleur_observation) {
        $this->travailleur_observation = $travailleur_observation;
        return $this;
    }

    public function getTravailleur_utilisateur() {
        return ($this->travailleur_utilisateur);
    }

    public function setTravailleur_utilisateur($travailleur_utilisateur) {
        $this->travailleur_utilisateur = ($travailleur_utilisateur);
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

    public function getId_postes() {
        return ($this->id_postes);
    }

    public function setId_postes($id_postes) {
        $this->id_postes = ($id_postes);
        return $this;
    }

    public function getMontant_prestation() {
        return ($this->montant_prestation);
    }

    public function setMontant_prestation($montant_prestation) {
        $this->montant_prestation = ($montant_prestation);
        return $this;
    }

    public function getTravailleur_numero_cin() {
        return ($this->travailleur_numero_cin);
    }

    public function setTravailleur_numero_cin($travailleur_numero_cin) {
        $this->travailleur_numero_cin = ($travailleur_numero_cin);
        return $this;
    }

    public function getTravailleur_date_delivrance_cin() {
        return ($this->travailleur_date_delivrance_cin);
    }

    public function setTravailleur_date_delivrance_cin($travailleur_date_delivrance_cin) {
        $this->travailleur_date_delivrance_cin = ($travailleur_date_delivrance_cin);
        return $this;
    }


    public function getTravailleur_date_expiration_cin() {
        return ($this->travailleur_date_expiration_cin);
    }

    public function setTravailleur_date_expiration_cin($travailleur_date_expiration_cin) {
        $this->travailleur_date_expiration_cin = ($travailleur_date_expiration_cin);
        return $this;
    }


}

?>
