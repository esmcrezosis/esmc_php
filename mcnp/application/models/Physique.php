<?php

class Application_Model_Physique {

    protected $numidentp;
    protected $photo;
    protected $nom;
    protected $prenom;
    protected $sexe;
    protected $datenais;
    protected $lieunais;
    protected $nationalite;
    protected $prof;
    protected $formation;
    protected $pere;
    protected $mere;
    protected $sitmatr;
    protected $nbrenf;
    protected $qartresid;
    protected $ville;
    protected $bp;
    protected $tel;
    protected $email;
    protected $dateident;
    protected $portable;
    protected $numcompbq;
    protected $emprunt;
    protected $agence;
    protected $heurid;
    protected $religion;
    protected $user;
	protected $code_membre;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        return $this->$method();
    }
    
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    function getNumidentp() {
        return $this->numidentp;
    }

    function setNumidentp($numidentp) {
        $this->numidentp = $numidentp;
        return $this;
    }

    function getPhoto() {
        return $this->photo;
    }

    function setPhoto($photo) {
        $this->photo = $photo;
        return $this;
    }

    function getNom() {
        return $this->nom;
    }

    function setNom($nom) {
        $this->nom = (string)$nom;
        return $this;
    }
    
    function getPrenom() {
        return $this->prenom;
    }

    function setPrenom($prenom) {
        $this->prenom = (string)$prenom;
        return $this;
    }
    
    function getSexe() {
        return $this->sexe;
    }

    function setSexe($sexe) {
        $this->sexe = $sexe;
        return $this;
    }
    
    function getDatenais() {
        return $this->datenais;
    }

    function setDatenais($datenais) {
        $this->datenais = $datenais;
        return $this;
    }
    
    function getLieunais() {
        return $this->lieunais;
    }

    function setLieunais($lieunais) {
        $this->lieunais = (string)$lieunais;
        return $this;
    }
    
    function getNationalite() {
        return $this->nationalite;
    }

    function setNationalite($nationalite) {
        $this->nationalite = (string)$nationalite;
        return $this;
    }
    
    function getProf() {
        return $this->prof;
    }

    function setProf($prof) {
        $this->prof = $prof;
        return $this;
    }
    
    function getFormation() {
        return $this->formation;
    }

    function setFormation($formation) {
        $this->formation = (string)$formation;
        return $this;
    }
    
    function getPere() {
        return $this->pere;
    }

    function setPere($pere) {
        $this->pere = (string)$pere;
        return $this;
    }
    
    function getMere() {
        return $this->mere;
    }

    function setMere($mere) {
        $this->mere = (string)$mere;
        return $this;
    }
    
    function getSitmatr() {
        return $this->sitmatr;
    }

    function setSitmatr($sitmatr) {
        $this->sitmatr = $sitmatr;
        return $this;
    }
    
    function getNbrenf() {
        return $this->nbrenf;
    }

    function setNbrenf($nbrenf) {
        $this->nbrenf = $nbrenf;
        return $this;
    }
    
    function getQartresid() {
        return $this->qartresid;
    }

    function setQartresid($qartresid) {
        $this->qartresid = $qartresid;
        return $this;
    }
    
    function getVille() {
        return $this->ville;
    }

    function setVille($ville) {
        $this->ville = $ville;
        return $this;
    }
    
    function getBp() {
        return $this->bp;
    }

    function setBp($bp) {
        $this->bp = $bp;
        return $this;
    }
    
    function getTel() {
        return $this->tel;
    }

    function setTel($tel) {
        $this->tel = $tel;
        return $this;
    }
    
    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
        return $this;
    }
    
    function getDateident() {
        return $this->dateident;
    }

    function setDateident($dateident) {
        $this->dateident = $dateident;
        return $this;
    }
    
    function getPortable() {
        return $this->portable;
    }

    function setPortable($portable) {
        $this->portable = $portable;
        return $this;
    }
    
    function getNumcompbq() {
        return $this->numcompbq;
    }

    function setNumcompbq($numcompbq) {
        $this->numcompbq = $numcompbq;
        return $this;
    }
    
    function getEmprunt() {
        return $this->emprunt;
    }

    function setEmprunt($emprunt) {
        $this->emprunt = $emprunt;
        return $this;
    }
    
    function getAgence() {
        return $this->agence;
    }

    function setAgence($agence) {
        $this->agence = $agence;
        return $this;
    }
    
    
    function getHeurid() {
        return $this->heurid;
    }

    function setHeurid($heurid) {
        $this->heurid = $heurid;
        return $this;
    }
    
    
    function getReligion() {
        return $this->religion;
    }

    function setReligion($religion) {
        $this->religion = $religion;
        return $this;
    }
     
    function getUser() {
        return $this->user;
    }
    
    function setUser($user) {
        $this->user = $user;
        return $this;
    }
    
    function getEtat_contrat() {
        return $this->etat_contrat;
    }
    
    function setEtat_contrat($etat_contrat) {
        $this->etat_contrat = $etat_contrat;
        return $this;
    }
	
	function getCode_membre() {
        return $this->code_membre;
    }
    
    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
	
      
}