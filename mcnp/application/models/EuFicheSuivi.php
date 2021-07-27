<?php

class Application_Model_EuFicheSuivi {
	
	protected $id_fiche_suivi;
    protected $libelle_fiche_suivi;
    protected $id_facture_prestation;
	protected $id_fiche_besoin;
	protected $date_fiche_suivi;

  
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
	
	
	function getId_fiche_suivi() {
      return $this->id_fiche_suivi;
    }
    
    function setId_fiche_suivi($id_fiche_suivi) {
      $this->id_fiche_suivi = $id_fiche_suivi;
      return $this;
    }
	
	function getLibelle_fiche_suivi() {
      return $this->libelle_fiche_suivi;
    }
    
    function setLibelle_fiche_suivi($libelle_fiche_suivi) {
      $this->libelle_fiche_suivi = $libelle_fiche_suivi;
      return $this;
    }
	
	function getId_facture_prestation() {
      return $this->id_facture_prestation;
    }
    
    function setId_facture_prestation($id_facture_prestation) {
      $this->id_facture_prestation = $id_facture_prestation;
      return $this;
    }
	
	
	function getId_fiche_besoin() {
      return $this->id_fiche_besoin;
    }
    
    function setId_fiche_besoin($id_fiche_besoin) {
      $this->id_fiche_besoin = $id_fiche_besoin;
      return $this;
    }
	
	function getDate_fiche_suivi() {
      return $this->date_fiche_suivi;
    }
    
    function setDate_fiche_suivi($date_fiche_suivi) {
      $this->date_fiche_suivi = $date_fiche_suivi;
      return $this;
    }
	
	
	
	
	
}


