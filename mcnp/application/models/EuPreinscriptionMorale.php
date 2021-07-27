<?php

class Application_Model_EuPreinscriptionMorale {

    protected $id_preinscription_morale;
    protected $code_type_acteur;
    protected $code_statut;
    protected $raison_sociale;
    protected $id_pays;
    protected $ville_membre;
    protected $quartier_membre;
    protected $tel_membre;
    protected $portable_membre;
    protected $email_membre;
    protected $bp_membre;
    protected $site_web;
    protected $domaine_activite;
    protected $num_registre_membre;
    protected $code_membre_morale;
    protected $date_inscription;
    protected $heure_inscription;
    protected $numero_contrat;
    protected $numero_agrement_filiere;
    protected $numero_agrement_acnev;
    protected $numero_agrement_technopole;
    protected $categorie_membre;
    protected $code_fs;
    protected $code_fl;
	protected $code_fkps;
    protected $code_rep;
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

    function getId_preinscription_morale() {
        return $this->id_preinscription_morale;
    }

    function setId_preinscription_morale($id_preinscription_morale) {
        $this->id_preinscription_morale = $id_preinscription_morale;
        return $this;
    }

    function getNumero_contrat() {
        return $this->numero_contrat;
    }

    function setNumero_contrat($numero_contrat) {
        $this->numero_contrat = $numero_contrat;
        return $this;
    }

    function getCode_type_acteur() {
        return $this->code_type_acteur;
    }

    function setCode_type_acteur($code_type_acteur) {
        $this->code_type_acteur = $code_type_acteur;
        return $this;
    }

    function getCode_statut() {
        return $this->code_statut;
    }

    function setCode_statut($code_statut) {
        $this->code_statut = $code_statut;
        return $this;
    }

    function getRaison_sociale() {
        return $this->raison_sociale;
    }

    function setRaison_sociale($raison_sociale) {
        $this->raison_sociale = $raison_sociale;
        return $this;
    }

    function getId_pays() {
        return $this->id_pays;
    }

    function setId_pays($id_pays) {
        $this->id_pays = $id_pays;
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

    function getTel_membre() {
        return $this->tel_membre;
    }

    function setTel_membre($tel_membre) {
        $this->tel_membre = $tel_membre;
        return $this;
    }

    function getPortable_membre() {
        return $this->portable_membre;
    }

    function setPortable_membre($portable_membre) {
        $this->portable_membre = $portable_membre;
        return $this;
    }

    function getEmail_membre() {
        return $this->email_membre;
    }

    function setEmail_membre($email_membre) {
        $this->email_membre = $email_membre;
        return $this;
    }

    function getBp_membre() {
        return $this->bp_membre;
    }

    function setBp_membre($bp_membre) {
        $this->bp_membre = $bp_membre;
        return $this;
    }

    function getSite_web() {
        return $this->site_web;
    }

    function setSite_web($site_web) {
        $this->site_web = $site_web;
        return $this;
    }

    function getDomaine_activite() {
        return $this->domaine_activite;
    }

    function setDomaine_activite($domaine_activite) {
        $this->domaine_activite = $domaine_activite;
        return $this;
    }

    function getNum_registre_membre() {
        return $this->num_registre_membre;
    }

    function setNum_registre_membre($num_registre_membre) {
        $this->num_registre_membre = $num_registre_membre;
        return $this;
    }

    function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }

    function getDate_inscription() {
        return $this->date_inscription;
    }

    function setDate_inscription($date_inscription) {
        $this->date_inscription = $date_inscription;
        return $this;
    }

    function getHeure_inscription() {
        return $this->heure_inscription;
    }

    function setHeure_inscription($heure_inscription) {
        $this->heure_inscription = $heure_inscription;
        return $this;
    }

    function getNumero_agrement_filiere() {
        return $this->numero_agrement_filiere;
    }

    function setNumero_agrement_filiere($numero_agrement_filiere) {
        $this->numero_agrement_filiere = $numero_agrement_filiere;
        return $this;
    }

    function getNumero_agrement_acnev() {
        return $this->numero_agrement_acnev;
    }

    function setNumero_agrement_acnev($numero_agrement_acnev) {
        $this->numero_agrement_acnev = $numero_agrement_acnev;
        return $this;
    }

    function getNumero_agrement_technopole() {
        return $this->numero_agrement_technopole;
    }

    function setNumero_agrement_technopole($numero_agrement_technopole) {
        $this->numero_agrement_technopole = $numero_agrement_technopole;
        return $this;
    }
	
	function getCategorie_membre() {
        return $this->categorie_membre;
    }

    function setCategorie_membre($categorie_membre) {
        $this->categorie_membre = $categorie_membre;
        return $this;
    }

    function getCode_fs() {
        return $this->code_fs;
    }

    function setCode_fs($code_fs) {
        $this->code_fs = $code_fs;
        return $this;
    }
    
	
	function getCode_fkps() {
        return $this->code_fkps;
    }

    function setCode_fkps($code_fkps) {
        $this->code_fkps = $code_fkps;
        return $this;
    }
	
    function getCode_fl() {
        return $this->code_fl;
    }

    function setCode_fl($code_fl) {
        $this->code_fl = $code_fl;
        return $this;
    }
    
    public function getCode_rep(){
        return $this->code_rep;
    }
    
    public function setCode_rep($code_rep){
        $this->code_rep = $code_rep;
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
