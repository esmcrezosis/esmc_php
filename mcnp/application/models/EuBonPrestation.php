<?php

class Application_Model_EuBonPrestation {
	
	protected $id_bon_prestation;
	protected $libelle_bon_prestation;
    protected $id_devis_prestation;
    protected $montant_bon_prestation;
	protected $date_bon_prestation;
    protected $visa;

  
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
	
	
	function getId_bon_prestation() {
      return $this->id_bon_prestation;
    }
    
    function setId_bon_prestation($id_bon_prestation) {
      $this->id_bon_prestation = $id_bon_prestation;
      return $this;
    }
	
	function getLibelle_bon_prestation() {
      return $this->libelle_bon_prestation;
    }
    
    function setLibelle_bon_prestation($libelle_bon_prestation) {
      $this->libelle_bon_prestation = $libelle_bon_prestation;
      return $this;
    }
	
	function getId_devis_prestation() {
      return $this->id_devis_prestation;
    }
    
    function setId_devis_prestation($id_devis_prestation) {
      $this->id_devis_prestation = $id_devis_prestation;
      return $this;
    }
	
	function getMontant_bon_prestation() {
      return $this->montant_bon_prestation;
    }
    
    function setMontant_bon_prestation($montant_bon_prestation) {
      $this->montant_bon_prestation = $montant_bon_prestation;
      return $this;
    }
	
	
	function getDate_bon_prestation() {
      return $this->date_bon_prestation;
    }
    
    function setDate_bon_prestation($date_bon_prestation) {
      $this->date_bon_prestation = $date_bon_prestation;
      return $this;
    }
	
	
	function getVisa() {
      return $this->visa;
    }
    
    function setVisa($visa) {
      $this->visa = $visa;
      return $this;
    }
	
	
}


