<?php

class Application_Model_EuMembreMorale {

    protected $code_membre_morale;
    protected $id_filiere;
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
    protected $code_agence;
    protected $date_identification;
    protected $heure_identification;
    protected $id_utilisateur;
    protected $auto_enroler;
    protected $etat_membre;
    protected $codesecret;
    protected $id_canton;
    protected $type_fournisseur;
    protected $desactiver;

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

    function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }

    function getId_filiere() {
        return $this->id_filiere;
    }

    function setId_filiere($id_filiere) {
        $this->id_filiere = $id_filiere;
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
        return ($this->raison_sociale);
    }

    function setRaison_sociale($raison_sociale) {
        $this->raison_sociale = ($raison_sociale);
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
        return ($this->quartier_membre);
    }

    function setQuartier_membre($quartier_membre) {
        $this->quartier_membre = ($quartier_membre);
        return $this;
    }

    function getVille_membre() {
        return ($this->ville_membre);
    }

    function setVille_membre($ville_membre) {
        $this->ville_membre = ($ville_membre);
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
        return ($this->domaine_activite);
    }

    function setDomaine_activite($domaine_activite) {
        $this->domaine_activite = ($domaine_activite);
        return $this;
    }

    function getNum_registre_membre() {
        return $this->num_registre_membre;
    }

    function setNum_registre_membre($num_registre_membre) {
        $this->num_registre_membre = $num_registre_membre;
        return $this;
    }

    function getCode_agence() {
        return $this->code_agence;
    }

    function setCode_agence($code_agence) {
        $this->code_agence = $code_agence;
        return $this;
    }

    function getDate_identification() {
        return $this->date_identification;
    }

    function setDate_identification($date_identification) {
        $this->date_identification = $date_identification;
        return $this;
    }

    function getHeure_identification() {
        return $this->heure_identification;
    }

    function setHeure_identification($heure_identification) {
        $this->heure_identification = $heure_identification;
        return $this;
    }

    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    function getAuto_enroler() {
        return $this->auto_enroler;
    }

    function setAuto_enroler($auto_enroler) {
        $this->auto_enroler = $auto_enroler;
        return $this;
    }

    function getEtat_membre() {
        return $this->etat_membre;
    }

    function setEtat_membre($etat_membre) {
        $this->etat_membre = $etat_membre;
        return $this;
    }
	
	function getCodesecret() {
        return $this->codesecret;
    }

    function setCodesecret($codesecret) {
        $this->codesecret = $codesecret;
        return $this;
    }
	

    public function getId_canton() {
        return $this->id_canton;
    }

    public function setId_canton($id_canton) {
        $this->id_canton = $id_canton;
        return $this;
    }
	
	public function getType_fournisseur() {
        return $this->type_fournisseur;
    }

    public function setType_fournisseur($type_fournisseur) {
        $this->type_fournisseur = $type_fournisseur;
        return $this;
    }


    public function getDesactiver() {
        return $this->desactiver;
    }

    public function setDesactiver($desactiver) {
        $this->desactiver = $desactiver;
        return $this;
    }
	
	

}
