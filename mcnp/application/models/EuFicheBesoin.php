<?php

class Application_Model_EuFicheBesoin {
	
	protected $id_fiche_besoin;
    protected $designation_besoin;
    protected $debut_periode_besoin;
	protected $fin_periode_besoin;
	protected $date_besoin_exprime;
    protected $code_membre_demandeur;
	protected $designation_demande;
	protected $date_demande;
	protected $valider;
	protected $livrer;
	protected $rejeter;
	protected $code_membre_prestataire;

  
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
	
	
	function getId_fiche_besoin() {
      return $this->id_fiche_besoin;
    }
    
    function setId_fiche_besoin($id_fiche_besoin) {
      $this->id_fiche_besoin = $id_fiche_besoin;
      return $this;
    }
	
	
	function getDesignation_besoin() {
      return $this->designation_besoin;
    }
    
    function setDesignation_besoin($designation_besoin) {
      $this->designation_besoin = $designation_besoin;
      return $this;
    }
	
	
	function getDebut_periode_besoin() {
      return $this->debut_periode_besoin;
    }
    
    function setDebut_periode_besoin($debut_periode_besoin) {
      $this->debut_periode_besoin = $debut_periode_besoin;
      return $this;
    }
	
	function getFin_periode_besoin() {
      return $this->fin_periode_besoin;
    }
    
    function setFin_periode_besoin($fin_periode_besoin) {
      $this->fin_periode_besoin = $fin_periode_besoin;
      return $this;
    }
	
	
	function getDate_besoin_exprime() {
      return $this->date_besoin_exprime;
    }
    
    function setDate_besoin_exprime($date_besoin_exprime) {
      $this->date_besoin_exprime = $date_besoin_exprime;
      return $this;
    }
	
	
	function getCode_membre_demandeur() {
      return $this->code_membre_demandeur;
    }
    
    function setCode_membre_demandeur($code_membre_demandeur) {
      $this->code_membre_demandeur = $code_membre_demandeur;
      return $this;
    }
	
	
	function getDesignation_demande() {
      return $this->designation_demande;
    }
    
    function setDesignation_demande($designation_demande) {
      $this->designation_demande = $designation_demande;
      return $this;
    }
	
	function getDate_demande() {
      return $this->date_demande;
    }
    
    function setDate_demande($date_demande) {
      $this->date_demande = $date_demande;
      return $this;
    }
	
	function getValider() {
      return $this->valider;
    }
    
    function setValider($valider) {
      $this->valider = $valider;
      return $this;
    }
	
	
	function getLivrer() {
      return $this->livrer;
    }
    
    function setLivrer($livrer) {
      $this->livrer = $livrer;
      return $this;
    }
	
	
	function getRejeter() {
      return $this->rejeter;
    }
    
    function setRejeter($rejeter) {
      $this->rejeter = $rejeter;
      return $this;
    }
	
	function getCode_membre_prestataire() {
      return $this->code_membre_prestataire;
    }
    
    function setCode_membre_prestataire($code_membre_prestataire) {
      $this->code_membre_prestataire = $code_membre_prestataire;
      return $this;
    }
	
	
	
}


