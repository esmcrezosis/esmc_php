<?php

class Application_Model_EuFacturePrestation {
	
	protected $id_facture_prestation;
	protected $numero_facture_prestation;
	protected $libelle_facture_prestation;
    protected $id_devis_prestation;
    protected $montant_facture_prestation;
	protected $date_facture_prestation;
    protected $visa;
	protected $payer;

  
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
	
	
	function getId_facture_prestation() {
      return $this->id_facture_prestation;
    }
    
    function setId_facture_prestation($id_facture_prestation) {
      $this->id_facture_prestation = $id_facture_prestation;
      return $this;
    }
	
	
	function getNumero_facture_prestation() {
      return $this->numero_facture_prestation;
    }
    
    function setNumero_facture_prestation($numero_facture_prestation) {
      $this->numero_facture_prestation = $numero_facture_prestation;
      return $this;
    }
	
	
	function getId_devis_prestation() {
      return $this->id_devis_prestation;
    }
    
    function setId_devis_prestation($id_devis_prestation) {
      $this->id_devis_prestation = $id_devis_prestation;
      return $this;
    }
	
	
	function getLibelle_facture_prestation() {
      return $this->libelle_facture_prestation;
    }
    
    function setLibelle_facture_prestation($libelle_facture_prestation) {
      $this->libelle_facture_prestation = $libelle_facture_prestation;
      return $this;
    }
	
	
	function getMontant_facture_prestation() {
      return $this->montant_facture_prestation;
    }
    
    function setMontant_facture_prestation($montant_facture_prestation) {
      $this->montant_facture_prestation = $montant_facture_prestation;
      return $this;
    }
	
	
	function getDate_facture_prestation() {
      return $this->date_facture_prestation;
    }
    
    function setDate_facture_prestation($date_facture_prestation) {
      $this->date_facture_prestation = $date_facture_prestation;
      return $this;
    }
	
	
	function getVisa() {
      return $this->visa;
    }
    
    function setVisa($visa) {
      $this->visa = $visa;
      return $this;
    }
	
	
	function getPayer() {
      return $this->payer;
    }
    
    function setPayer($payer) {
      $this->payer = $payer;
      return $this;
    }
	
}


