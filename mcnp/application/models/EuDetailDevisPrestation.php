<?php

class Application_Model_EuDetailDevisPrestation   {
	
	protected $id_detail_devis_prestation;
    protected $id_devis_prestation;
    protected $designation_article;
	protected $quantite;
	protected $prix_unitaire;
    protected $designation_prestation;
	protected $montant_total;
	protected $approuver;

  
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
	
	
	function getId_detail_devis_prestation() {
      return $this->id_detail_devis_prestation;
    }
    
    function setId_detail_devis_prestation($id_detail_devis_prestation) {
      $this->id_detail_devis_prestation = $id_detail_devis_prestation;
      return $this;
    }
	
	
	function getId_devis_prestation() {
      return $this->id_devis_prestation;
    }
    
    function setId_devis_prestation($id_devis_prestation) {
      $this->id_devis_prestation = $id_devis_prestation;
      return $this;
    }
	
	
	function getDesignation_article() {
      return $this->designation_article;
    }
    
    function setDesignation_article($designation_article) {
      $this->designation_article = $designation_article;
      return $this;
    }
	
	function getQuantite() {
      return $this->quantite;
    }
    
    function setQuantite($quantite) {
      $this->quantite = $quantite;
      return $this;
    }
	
	
	function getPrix_unitaire() {
      return $this->prix_unitaire;
    }
    
    function setPrix_unitaire($prix_unitaire) {
      $this->prix_unitaire = $prix_unitaire;
      return $this;
    }
	
	
	function getDesignation_prestation() {
      return $this->designation_prestation;
    }
    
    function setDesignation_prestation($designation_prestation) {
      $this->designation_prestation = $designation_prestation;
      return $this;
    }
	
	function getMontant_total() {
      return $this->montant_total;
    }
    
    function setMontant_total($montant_total) {
      $this->montant_total = $montant_total;
      return $this;
    }
	
	
	
	function getApprouver() {
      return $this->approuver;
    }
    
    function setApprouver($approuver) {
      $this->approuver = $approuver;
      return $this;
    }
	
	
	
	
	
}
