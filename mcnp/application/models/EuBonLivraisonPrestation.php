<?php

class Application_Model_EuBonLivraisonPrestation {
	
	protected $id_bon_livraison_prestation;
    protected $id_devis_prestation;
	protected $libelle_bon_livraison;
    protected $montant_bon_livraison;
	protected $date_bon_livraison;
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
	
	
	function getId_bon_livraison_prestation() {
       return $this->id_bon_livraison_prestation;
    }
    
    function setId_bon_livraison_prestation($id_bon_livraison_prestation) {
       $this->id_bon_livraison_prestation = $id_bon_livraison_prestation;
       return $this;
    }
	
	function getId_devis_prestation() {
       return $this->id_devis_prestation;
    }
    
    function setId_devis_prestation($id_devis_prestation) {
       $this->id_devis_prestation = $id_devis_prestation;
       return $this;
    }
	
	
	function getLibelle_bon_livraison() {
       return $this->libelle_bon_livraison;
    }
    
    function setLibelle_bon_livraison($libelle_bon_livraison) {
       $this->libelle_bon_livraison = $libelle_bon_livraison;
       return $this;
    }
	
	function getMontant_bon_livraison() {
       return $this->montant_bon_livraison;
    }
    
    function setMontant_bon_livraison($montant_bon_livraison) {
       $this->montant_bon_livraison = $montant_bon_livraison;
       return $this;
    }
	
	function getDate_bon_livraison() {
       return $this->date_bon_livraison;
    }
    
    function setDate_bon_livraison($date_bon_livraison) {
       $this->date_bon_livraison = $date_bon_livraison;
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


