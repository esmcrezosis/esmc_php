<?php

class Application_Model_EuUtilisateur {

    protected $id_utilisateur;
    protected $id_utilisateur_parent;
    protected $login;
    protected $pwd;
    protected $description;
    protected $ulock;
    protected $ch_pwd_flog;
    protected $code_groupe;
    protected $connecte;
    protected $code_membre;
    protected $code_secteur;
    protected $code_zone;
    protected $code_agence;
    protected $id_filiere;
    protected $code_acteur;
    protected $nom_utilisateur;
    protected $prenom_utilisateur;
    protected $question_secrete;
    protected $reponse;
    protected $id_pays;
    protected $code_passe;
    protected $code_gac_filiere;
	protected $code_groupe_create;
    protected $id_canton;
	protected $code_tegc;
    protected $role;
	protected $section;
	protected $odd;
	protected $gac;

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

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
    
    public function getId_utilisateur_parent() {
        return $this->id_utilisateur_parent;
    }

    public function setId_utilisateur_parent($id_utilisateur_parent) {
        $this->id_utilisateur_parent = $id_utilisateur_parent;
        return $this;
    }
    
    

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
        return $this;
    }

    public function getPwd() {
        return $this->pwd;
    }

    public function setPwd($pwd) {
        $this->pwd = $pwd;
        return $this;
    }

    public function getDescription() {
        return ($this->description);
    }

    public function setDescription($description) {
        $this->description = ($description);
        return $this;
    }

    public function getUlock() {
        return $this->ulock;
    }

    public function setUlock($ulock) {
        $this->ulock = $ulock;
        return $this;
    }

    public function getCh_pwd_flog() {
        return $this->ch_pwd_flog;
    }

    public function setCh_pwd_flog($ch_pwd_flog) {
        $this->ch_pwd_flog = $ch_pwd_flog;
        return $this;
    }

    function getCode_groupe() {
        return $this->code_groupe;
    }

    function setCode_groupe($code_groupe) {
        $this->code_groupe = $code_groupe;
        return $this;
    }

    public function getConnecte() {
        return $this->connecte;
    }

    public function setConnecte($connecte) {
        $this->connecte = $connecte;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getCode_secteur() {
        return $this->code_secteur;
    }

    public function setCode_secteur($code_secteur) {
        $this->code_secteur = $code_secteur;
        return $this;
    }

    public function getCode_zone() {
        return $this->code_zone;
    }

    public function setCode_zone($code_zone) {
        $this->code_zone = $code_zone;
        return $this;
    }

    public function getCode_agence() {
        return $this->code_agence;
    }

    public function setCode_agence($code_agence) {
        $this->code_agence = $code_agence;
        return $this;
    }

    public function getId_filiere() {
        return $this->id_filiere;
    }

    public function setId_filiere($id_filiere) {
        $this->id_filiere = $id_filiere;
        return $this;
    }

    public function getCode_acteur() {
        return $this->code_acteur;
    }

    public function setCode_acteur($code_acteur) {
        $this->code_acteur = $code_acteur;
        return $this;
    }

    public function getNom_utilisateur() {
        return ($this->nom_utilisateur);
    }

    public function setNom_utilisateur($nom_utilisateur) {
        $this->nom_utilisateur = ($nom_utilisateur);
        return $this;
    }

    public function getPrenom_utilisateur() {
        return ($this->prenom_utilisateur);
    }

    public function setPrenom_utilisateur($prenom_utilisateur) {
        $this->prenom_utilisateur = ($prenom_utilisateur);
        return $this;
    }

    public function getQuestion_secrete() {
        return $this->question_secrete;
    }

    public function setQuestion_secrete($question_secrete) {
        $this->question_secrete = $question_secrete;
        return $this;
    }

    public function getReponse() {
        return $this->reponse;
    }

    public function setReponse($reponse) {
        $this->reponse = $reponse;
        return $this;
    }
	

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
        return $this;
    }
	
	public function getId_pays() {
           return $this->id_pays;
    }

    public function setId_pays($id_pays) {
        $this->id_pays = $id_pays;
        return $this;
    }
	
	
	public function getCode_passe() {
           return $this->code_passe;
    }

    public function setCode_passe($code_passe) {
        $this->code_passe = $code_passe;
        return $this;
    }
	
    public function getCode_gac_filiere() {
        return $this->code_gac_filiere;
    }

    public function setCode_gac_filiere($code_gac_filiere) {
        $this->code_gac_filiere = $code_gac_filiere;
        return $this;
    }
	
	 public function getCode_groupe_create() {
        return $this->code_groupe_create;
    }

    public function setCode_groupe_create($code_groupe_create) {
        $this->code_groupe_create = $code_groupe_create;
        return $this;
    }
	

    public function getId_canton() {
        return $this->id_canton;
    }

    public function setId_canton($id_canton) {
        $this->id_canton = $id_canton;
        return $this;
    }
	
	public function getCode_tegc() {
        return $this->code_tegc;
    }

    public function setCode_tegc($code_tegc) {
        $this->code_tegc = $code_tegc;
        return $this;
    }
	
	
	public function getSection() {
        return $this->section;
    }

    public function setSection($section) {
        $this->section = $section;
        return $this;
    }
	
	public function getOdd() {
        return $this->odd;
    }

    public function setOdd($odd) {
        $this->odd = $odd;
        return $this;
    }
	
	public function getGac() {
        return $this->gac;
    }

    public function setGac($gac) {
        $this->gac = $gac;
        return $this;
    }


}

