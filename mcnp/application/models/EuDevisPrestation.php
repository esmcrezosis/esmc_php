<?php

class Application_Model_EuDevisPrestation {
	
	protected $id_devis_prestation;
    protected $id_fiche_besoin;
    protected $montant_devis_prestation;
	protected $libelle_devis_prestation;
	protected $date_devis_prestation;
    protected $code_membre_fournisseur;
	protected $viser;

  
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
	
	
	function getId_devis_prestation() {
      return $this->id_devis_prestation;
    }
    
    function setId_devis_prestation($id_devis_prestation) {
      $this->id_devis_prestation = $id_devis_prestation;
      return $this;
    }
	
	
	function getId_fiche_besoin() {
      return $this->id_fiche_besoin;
    }
    
    function setId_fiche_besoin($id_fiche_besoin) {
      $this->id_fiche_besoin = $id_fiche_besoin;
      return $this;
    }
	
	
	function getMontant_devis_prestation() {
      return $this->montant_devis_prestation;
    }
    
    function setMontant_devis_prestation($montant_devis_prestation) {
      $this->montant_devis_prestation = $montant_devis_prestation;
      return $this;
    }
	
	function getDate_devis_prestation() {
      return $this->date_devis_prestation;
    }
    
    function setDate_devis_prestation($date_devis_prestation) {
      $this->date_devis_prestation = $date_devis_prestation;
      return $this;
    }
	
	
	function getLibelle_devis_prestation() {
      return $this->libelle_devis_prestation;
    }
    
    function setLibelle_devis_prestation($libelle_devis_prestation) {
      $this->libelle_devis_prestation = $libelle_devis_prestation;
      return $this;
    }
	
	
	function getCode_membre_fournisseur() {
      return $this->code_membre_fournisseur;
    }
    
    function setCode_membre_fournisseur($code_membre_fournisseur) {
      $this->code_membre_fournisseur = $code_membre_fournisseur;
      return $this;
    }
	
	
	function getViser() {
      return $this->viser;
    }
    
    function setViser($viser) {
      $this->viser = $viser;
      return $this;
    }
	
	
	
}


