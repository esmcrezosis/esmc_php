<?php
class Application_Model_EuPreinscription {

    protected $id_preinscription;
    protected $nom_membre;
    protected $prenom_membre;
    protected $sexe_membre;
    protected $date_nais_membre;
    protected $lieu_nais_membre;
    protected $profession_membre;
    protected $formation;
    protected $pere_membre;
    protected $mere_membre;
    protected $sitfam_membre;
    protected $nbr_enf_membre;
    protected $quartier_membre;
    protected $ville_membre;
    protected $bp_membre;
    protected $email_membre;
    protected $tel_membre;
    protected $date_inscription;
    protected $portable_membre;
    protected $code_membre;
    protected $heure_inscription;
    protected $id_religion_membre;
    protected $code_fs;
    protected $code_fl;
	protected $code_fkps;
    protected $id_pays;
    protected $publier;
	protected $code_agence;
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

    function getId_preinscription() {
        return $this->id_preinscription;
    }

    function setId_preinscription($id_preinscription) {
        $this->id_preinscription = $id_preinscription;
        return $this;
    }
    
    function getNom_membre() {
        return $this->nom_membre;
    }

    function setNom_membre($nom_membre) {
        $this->nom_membre = (string) $nom_membre;
        return $this;
    }

    function getPrenom_membre() {
        return $this->prenom_membre;
    }

    function setPrenom_membre($prenom_membre) {
        $this->prenom_membre = (string) $prenom_membre;
        return $this;
    }

    function getSexe_membre() {
        return $this->sexe_membre;
    }

    function setSexe_membre($sexe_membre) {
        $this->sexe_membre = $sexe_membre;
        return $this;
    }

    function getDate_nais_membre() {
        return $this->date_nais_membre;
    }

    function setDate_nais_membre($date_nais_membre) {
        $this->date_nais_membre = $date_nais_membre;
        return $this;
    }

    function getLieu_nais_membre() {
        return $this->lieu_nais_membre;
    }

    function setLieu_nais_membre($lieu_nais_membre) {
        $this->lieu_nais_membre = $lieu_nais_membre;
        return $this;
    }

    function getProfession_membre() {
        return $this->profession_membre;
    }

    function setProfession_membre($profession_membre) {
        $this->profession_membre = $profession_membre;
        return $this;
    }

    function getFormation() {
        return $this->formation;
    }
    function setFormation($formation) {
        $this->formation = $formation;
        return $this;
    }
    function getPere_membre() {
        return $this->pere_membre;
    }
    function setPere_membre($pere_membre) {
        $this->pere_membre = $pere_membre;
        return $this;
    }

    function getMere_membre() {
        return $this->mere_membre;
    }

    function setMere_membre($mere_membre) {
        $this->mere_membre = $mere_membre;
        return $this;
    }

    function getSitfam_membre() {
        return $this->sitfam_membre;
    }

    function setSitfam_membre($sitfam_membre) {
        $this->sitfam_membre = $sitfam_membre;
        return $this;
    }

    function getNbr_enf_membre() {
        return $this->nbr_enf_membre;
    }

    function setNbr_enf_membre($nbr_enf_membre) {
        $this->nbr_enf_membre = $nbr_enf_membre;
        return $this;
    }

    function getQuartier_membre() {
        return $this->quartier_membre;
    }

    function setQuartier_membre($quartier_membre) {
        $this->quartier_membre = $quartier_membre;
        return $this;
    }

    function getVille_membre() {
        return $this->ville_membre;
    }

    function setVille_membre($ville_membre) {
        $this->ville_membre = $ville_membre;
        return $this;
    }

    function getBp_membre() {
        return $this->bp_membre;
    }

    function setBp_membre($bp_membre) {
        $this->bp_membre = $bp_membre;
        return $this;
    }

    function getTel_membre() {
        return $this->tel_membre;
    }

    function setTel_membre($tel_membre) {
        $this->tel_membre = $tel_membre;
        return $this;
    }

    function getEmail_membre() {
        return $this->email_membre;
    }

    function setEmail_membre($email_membre) {
        $this->email_membre = $email_membre;
        return $this;
    }

    function getDate_inscription() {
        return $this->date_inscription;
    }

    function setDate_inscription($date_inscription) {
        $this->date_inscription = $date_inscription;
        return $this;
    }

    function getPortable_membre() {
        return $this->portable_membre;
    }

    function setPortable_membre($portable_membre) {
        $this->portable_membre = $portable_membre;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    function getHeure_inscription() {
        return $this->heure_inscription;
    }

    function setHeure_inscription($heure_inscription) {
        $this->heure_inscription = $heure_inscription;
        return $this;
    }

    function getId_religion_membre() {
        return $this->id_religion_membre;
    }

    function setId_religion_membre($id_religion_membre) {
        $this->id_religion_membre = $id_religion_membre;
        return $this;
    }

    function getCode_fs() {
        return $this->code_fs;
    }

    function setCode_fs($code_fs) {
        $this->code_fs = $code_fs;
        return $this;
    }
    
    public function getCode_fl(){
        return $this->code_fl;
    }
    
    public function setCode_fl($code_fl){
        $this->code_fl = $code_fl;
        return $this;
    }
	
	function getCode_fkps() {
        return $this->code_fkps;
    }

    function setCode_fkps($code_fkps) {
        $this->code_fkps = $code_fkps;
        return $this;
    }
	
	function getId_pays() {
        return $this->id_pays;
    }

    function setId_pays($id_pays) {
        $this->id_pays = $id_pays;
        return $this;
    }
	
	function getPublier() {
        return $this->publier;
    }

    function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }
	
	function getCode_agence() {
        return $this->code_agence;
    }

    function setCode_agence($code_agence) {
        $this->code_agence = $code_agence;
        return $this;
    }
	

    public function getId_canton() {
        return $this->id_canton;
    }

    public function setId_canton($id_canton) {
        $this->id_canton = $id_canton;
        return $this;
    }
	
	
	
	
}

