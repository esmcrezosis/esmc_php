<?php

/**
 * Description of EuOperation
 *
 * @author user
 */
class Application_Model_EuAncienMembre {

    //put your code here
    protected $ancien_code_membre;
    protected $code_gac_filiere;
    protected $code_type_acteur;
    protected $type_membre;
    protected $raison_sociale;
    protected $nom_membre;
    protected $prenom_membre;
    protected $sexe_membre;
    protected $date_nais_membre;
    protected $id_pays;
	protected $pere_membre;
	protected $mere_membre;
	protected $sitfam_membre;
	protected $nbr_enf_membre;
	protected $id_religion_membre;
	protected $profession_membre;
	protected $formation;
	protected $quartier_membre;
	protected $ville_membre;
	protected $bp_membre;
	protected $tel_membre;
	protected $portable_membre;
	protected $email_membre;
	protected $site_web;
	protected $photo_membre;
	protected $domaine_activite;
	protected $num_registre_membre;
	protected $code_agence;
	protected $empreinte_membre;
	protected $date_identification;
	protected $heure_identification;
	protected $id_utilisateur;
	protected $auto_enroler;
	protected $etat_contrat;
	protected $code_membre;


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
	
	 
    public function getAncien_code_membre() {
        return $this->ancien_code_membre;
    }


    public function setAncien_code_membre($ancien_code_membre) {
        $this->ancien_code_membre = $ancien_code_membre;
        return $this;
    }


    public function getCode_gac_filiere() {
        return $this->code_gac_filiere;
    }

    public function setCode_gac_filiere($code_gac_filiere) {
        $this->code_gac_filiere = $code_gac_filiere;
        return $this;
    }

    public function getCode_type_acteur() {
        return $this->code_type_acteur;
    }

    public function setCode_type_acteur($code_type_acteur) {
        $this->code_type_acteur = $code_type_acteur;
        return $this;
    }

    public function getType_membre() {
        return $this->type_membre;
    }

    public function setType_membre($type_membre) {
        $this->type_membre = $type_membre;
        return $this;
    }

    public function getRaison_sociale() {
        return $this->raison_sociale;
    }

    public function setRaison_sociale($raison_sociale) {
        $this->raison_sociale = $raison_sociale;
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
	
	
	public function getSexe_membre() {
        return $this->sexe_membre;
    }

    public function setSexe_membre($sexe_membre) {
        $this->sexe_membre = $sexe_membre;
        return $this;
    }
	
    public function getDate_nais_membre() {
        return $this->date_nais_membre;
    }

    public function setDate_nais_membre($date_nais_membre) {
        $this->date_nais_membre = $date_nais_membre;
        return $this;
    }	

    public function getId_pays() {
        return $this->id_pays;
    }

    public function setId_pays($id_pays) {
        $this->id_pays = $id_pays;
        return $this;
    }
	
	public function getPere_membre() {
        return $this->pere_membre;
    }

    public function setPere_membre($pere_membre) {
        $this->pere_membre = $pere_membre;
        return $this;
    }
     
	 public function getMere_membre() {
        return $this->mere_membre;
    }

    public function setMere_membre($mere_membre) {
        $this->mere_membre = $mere_membre;
        return $this;
    }
    
	public function getSitfam_membre() {
        return $this->sitfam_membre;
    }

    public function setSitfam_membre($sitfam_membre) {
        $this->sitfam_membre = $sitfam_membre;
        return $this;
    }
	
    public function getNbr_enf_membre() {
        return $this->nbr_enf_membre;
    }

    public function setNbr_enf_membre($nbr_enf_membre) {
        $this->nbr_enf_membre = $nbr_enf_membre;
        return $this;
    }

    public function getId_religion_membre() {
        return $this->id_religion_membre;
    }

    public function setId_religion_membre($id_religion_membre) {
        $this->id_religion_membre = $id_religion_membre;
        return $this;
    }

    public function getProfession_membre() {
        return $this->profession_membre;
    }

    public function setProfession_membre($profession_membre) {
        $this->profession_membre = $profession_membre;
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
	
	public function getVille_membre() {
        return $this->ville_membre;
    }

    public function setVille_membre($ville_membre) {
        $this->ville_membre = $ville_membre;
        return $this;
    }
	
	public function getBp_membre() {
        return $this->bp_membre;
    }

    public function setBp_membre($bp_membre) {
        $this->bp_membre = $bp_membre;
        return $this;
    }
	
	public function getTel_membre() {
        return $this->tel_membre;
    }

    public function setTel_membre($tel_membre) {
        $this->tel_membre = $tel_membre;
        return $this;
    }
	
	public function getPortable_membre() {
        return $this->portable_membre;
    }

    public function setPortable_membre($portable_membre) {
        $this->portable_membre = $portable_membre;
        return $this;
    }
	
	public function getEmail_membre() {
        return $this->email_membre;
    }

    public function setEmail_membre($email_membre) {
        $this->email_membre = $email_membre;
        return $this;
    }
	
	public function getSite_web() {
        return $this->site_web;
    }

    public function setSite_web($site_web) {
        $this->site_web = $site_web;
        return $this;
    }
	
	public function getPhoto_membre() {
        return $this->photo_membre;
    }

    public function setPhoto_membre($photo_membre) {
        $this->photo_membre = $photo_membre;
        return $this;
    }
	
	public function getDomaine_activite() {
        return $this->domaine_activite;
    }

    public function setDomaine_activite($domaine_activite) {
        $this->domaine_activite = $domaine_activite;
        return $this;
    }
	
	public function getNum_registre_membre() {
        return $this->num_registre_membre;
    }

    public function setNum_registre_membre($num_registre_membre) {
        $this->num_registre_membre = $num_registre_membre;
        return $this;
    }
	
	public function getCode_agence() {
        return $this->code_agence;
    }

    public function setCode_agence($code_agence) {
        $this->code_agence = $code_agence;
        return $this;
    }
	
	public function getEmpreinte_membre() {
        return $this->empreinte_membre;
    }

    public function setEmpreinte_membre($empreinte_membre) {
        $this->empreinte_membre = $empreinte_membre;
        return $this;
    }
	
	public function getDate_identification() {
        return $this->date_identification;
    }

    public function setDate_identification($date_identification) {
        $this->date_identification = $date_identification;
        return $this;
    }
	
	public function getHeure_identification() {
        return $this->heure_identification;
    }

    public function setHeure_identification($heure_identification) {
        $this->heure_identification = $heure_identification;
        return $this;
    }
	
	public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
	
	public function getAuto_enroler() {
        return $this->auto_enroler;
    }

    public function setAuto_enroler($auto_enroler) {
        $this->auto_enroler = $auto_enroler;
        return $this;
    }
	
	public function getEtat_contrat() {
        return $this->etat_contrat;
    }

    public function setEtat_contrat($etat_contrat) {
        $this->etat_contrat = $etat_contrat;
        return $this;
    }
	
	public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
	
	
	
	
	
	
	
	
}

?>
