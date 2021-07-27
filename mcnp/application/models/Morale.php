<?php

class Application_Model_Morale {

    protected $numIdentm;
    protected $nomm;
    protected $representant;
    protected $qart;
    protected $rue;
    protected $ville;
    protected $bp;
    protected $tel;
    protected $portable;
    protected $email;
    protected $site;
    protected $dateIdent;
    protected $numCompBq;
    protected $agence;
    protected $montant;
    protected $heurid;
    protected $user;
    protected $etat_contrat;
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

    function getNumIdentm() {
        return $this->numIdentm;
    }

    function setNumIdentm($numIdentm) {
        $this->numIdentm = $numIdentm;
        return $this;
    }

    function getNomm() {
        return $this->nomm;
    }

    function setNomm($nomm) {
        $this->nomm = $nomm;
        return $this;
    }

    function getRepresentant() {
        return $this->representant;
    }

    function setRepresentant($representant) {
        $this->representant =$representant;
        return $this;
    }
    
    function getQart() {
        return $this->qart;
    }

    function setQart($qart) {
        $this->qart =$qart;
        return $this;
    }
    
    function getRue() {
        return $this->rue;
    }

    function setRue($rue) {
        $this->rue =$rue;
        return $this;
    }
    
    function getVille() {
        return $this->ville;
    }

    function setVille($ville) {
        $this->ville =$ville;
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
        $this->tel =$tel;
        return $this;
    }
    
    function getPortable() {
        return $this->portable;
    }

    function setPortable($portable) {
        $this->portable =$portable;
        return $this;
    }
    
    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
        return $this;
    }
    
    function getSite() {
        return $this->site;
    }

    function setSite($site) {
        $this->site =$site;
        return $this;
    }
    
    function getDateIdent() {
        return $this->dateIdent;
    }

    function setDateIdent($dateIdent) {
        $this->dateIdent = $dateIdent;
        return $this;
    }
    
    function getNumCompBq() {
        return $this->numCompBq;
    }

    function setNumCompBq($numCompBq) {
        $this->numCompBq = $numCompBq;
        return $this;
    }
    
    function getAgence() {
        return $this->agence;
    }

    function setAgence($agence) {
        $this->agence = $agence;
        return $this;
    }
    
    function getMontant() {
        return $this->montant;
    }

    function setMontant($montant) {
        $this->montant = $montant;
        return $this;
    }
    
    function getHeurid() {
        return $this->heurid;
    }

    function setHeurid($heurid) {
        $this->heurid = $heurid;
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

