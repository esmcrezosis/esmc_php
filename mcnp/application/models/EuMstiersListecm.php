<?php
 
class Application_Model_EuMstiersListecm {

    //put your code here
    protected $id_mstiers_listecm;
    protected $code_membre_apporteur;
    protected $code_membre_beneficiaire;
    protected $nom_membre;
    protected $prenom_membre;
    protected $date_nais_membre;
    protected $lieu_nais_membre;
    protected $mere_membre;
    protected $pere_membre;
    protected $nbr_enf_membre;
    protected $portable_membre;
    protected $bp_membre;
    protected $codesecret;
    protected $email_membre;
    protected $formation;
    protected $quartier_membre;
    protected $sexe_membre;
    protected $sitfam_membre;
    protected $ville_membre;
    protected $id_pays;
    protected $id_canton;
    protected $id_religion_membre;
    protected $code_agence;
    protected $date_listecm;
    protected $code_caps;
    protected $utilisateur;
    protected $code_zone;
    protected $profession_membre;
    protected $statut;
    protected $type_liste;
    protected $doublon;
	
	
    public function __construct(array $options = NULL) {
        if(is_array($options)) {
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

    public function getId_mstiers_listecm() {
      return $this->id_mstiers_listecm;
    }

    public function setId_mstiers_listecm($id_mstiers_listecm) {
        $this->id_mstiers_listecm = $id_mstiers_listecm;
        return $this;
    }
	

    public function getCode_membre_apporteur() {
        return $this->code_membre_apporteur;
    }

    public function setCode_membre_apporteur($code_membre_apporteur) {
        $this->code_membre_apporteur = $code_membre_apporteur;
        return $this;
    }
	
    public function getCode_membre_beneficiaire() {
        return $this->code_membre_beneficiaire;
    }

    public function setCode_membre_beneficiaire($code_membre_beneficiaire) {
        $this->code_membre_beneficiaire = $code_membre_beneficiaire;
        return $this;
    }


    public function getNom_membre() {
        return $this->nom_membre;
    }

    public function setNom_membre($nom_membre) {
        $this->nom_membre = $nom_membre;
        return $this;
    }
	
    public function getPrenom_membre() {
        return $this->prenom_membre;
    }

    public function setPrenom_membre($prenom_membre) {
        $this->prenom_membre = $prenom_membre;
        return $this;
    }
	
	
	public function getDate_nais_membre() {
        return $this->date_nais_membre;
    }

    public function setDate_nais_membre($date_nais_membre) {
        $this->date_nais_membre = $date_nais_membre;
        return $this;
    }
	
	
	public function getLieu_nais_membre() {
        return $this->lieu_nais_membre;
    }

    public function setLieu_nais_membre($lieu_nais_membre) {
        $this->lieu_nais_membre = $lieu_nais_membre;
        return $this;
    }
	
	
	public function getMere_membre() {
        return $this->mere_membre;
    }

    public function setMere_membre($mere_membre) {
        $this->mere_membre = $mere_membre;
        return $this;
    }
	
	
	public function getPere_membre() {
        return $this->pere_membre;
    }

    public function setPere_membre($pere_membre) {
        $this->pere_membre = $pere_membre;
        return $this;
    }
	
	
	public function getNbr_enf_membre() {
        return $this->nbr_enf_membre;
    }

    public function setNbr_enf_membre($nbr_enf_membre) {
        $this->nbr_enf_membre = $nbr_enf_membre;
        return $this;
    }
	
	
	public function getPortable_membre() {
        return $this->portable_membre;
    }

    public function setPortable_membre($portable_membre) {
        $this->portable_membre = $portable_membre;
        return $this;
    }
	
	
	public function getBp_membre() {
        return $this->bp_membre;
    }

    public function setBp_membre($bp_membre) {
        $this->bp_membre = $bp_membre;
        return $this;
    }
	
	
	public function getCodesecret() {
        return $this->codesecret;
    }

    public function setCodesecret($codesecret) {
        $this->codesecret = $codesecret;
        return $this;
    }
	
	public function getEmail_membre() {
        return $this->email_membre;
    }

    public function setEmail_membre($email_membre) {
        $this->email_membre = $email_membre;
        return $this;
    }
	
	
	public function getFormation() {
        return $this->formation;
    }

    public function setFormation($formation) {
        $this->formation = $formation;
        return $this;
    }
	
	
	public function getQuartier_membre() {
        return $this->quartier_membre;
    }

    public function setQuartier_membre($quartier_membre) {
        $this->quartier_membre = $quartier_membre;
        return $this;
    }
	
	public function getSexe_membre() {
        return $this->sexe_membre;
    }

    public function setSexe_membre($sexe_membre) {
        $this->sexe_membre = $sexe_membre;
        return $this;
    }
	
	
	public function getSitfam_membre() {
      return $this->sitfam_membre;
    }

    public function setSitfam_membre($sitfam_membre) {
        $this->sitfam_membre = $sitfam_membre;
        return $this;
    }
	
	
	public function getVille_membre() {
        return $this->ville_membre;
    }

    public function setVille_membre($ville_membre) {
        $this->ville_membre = $ville_membre;
        return $this;
    }
	
	
	public function getId_pays() {
        return $this->id_pays;
    }

    public function setId_pays($id_pays) {
        $this->id_pays = $id_pays;
        return $this;
    }
	
	public function getId_canton() {
        return $this->id_canton;
    }

    public function setId_canton($id_canton) {
        $this->id_canton = $id_canton;
        return $this;
    }
	
	public function getId_religion_membre() {
        return $this->id_religion_membre;
    }

    public function setId_religion_membre($id_religion_membre) {
        $this->id_religion_membre = $id_religion_membre;
        return $this;
    }
	
	public function getCode_agence() {
        return $this->code_agence;
    }

    public function setCode_agence($code_agence) {
        $this->code_agence = $code_agence;
        return $this;
    }
	
	public function getDate_listecm() {
        return $this->date_listecm;
    }

    public function setDate_listecm($date_listecm) {
        $this->date_listecm = $date_listecm;
        return $this;
    }
	
	public function getCode_caps() {
        return $this->code_caps;
    }

    public function setCode_caps($code_caps) {
        $this->code_caps = $code_caps;
        return $this;
    }
	
	public function getUtilisateur() {
        return $this->utilisateur;
    }

    public function setUtilisateur($utilisateur) {
        $this->utilisateur = $utilisateur;
        return $this;
    }
	
	public function getCode_zone() {
        return $this->code_zone;
    }

    public function setCode_zone($code_zone) {
        $this->code_zone = $code_zone;
        return $this;
    }
	
	
    public function getProfession_membre() {
        return $this->profession_membre;
    }

    public function setProfession_membre($profession_membre) {
        $this->profession_membre = $profession_membre;
        return $this;
    }

    
    public function getStatut() {
        return $this->statut;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }


    public function getType_liste() {
        return $this->type_liste;
    }

    public function setType_liste($type_liste) {
        $this->type_liste = $type_liste;
        return $this;
    }


    public function getDoublon() {
        return $this->doublon;
    }

    public function setDoublon($doublon) {
        $this->doublon = $doublon;
        return $this;
    }
	
	
	
    

}

?>
