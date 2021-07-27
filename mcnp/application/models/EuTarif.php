<?php

class Application_Model_EuTarif {
    
    protected $id_tarif;
    protected $montant_inferieur;
    protected $montant_superieur;
    protected $montant_tarif;
    protected $mode_paiement;
    protected $statut;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        $this->$method($value);
    }
 
    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
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
	

    function getId_tarif() {
      return $this->id_tarif;
    }

    function setId_tarif($id_tarif) {
      $this->id_tarif = $id_tarif;
      return $this;
    }

    function getMontant_inferieur() {
        return $this->montant_inferieur;
    }

    function setMontant_inferieur($montant_inferieur) {
        $this->montant_inferieur = $montant_inferieur;
        return $this;
    }

    function getMontant_superieur() {
        return $this->montant_superieur;
    }

    function setMontant_superieur($montant_superieur) {
        $this->montant_superieur = $montant_superieur;
        return $this;
    }

	
    function getMontant_tarif() {
      return $this->montant_tarif;
    }

    function setMontant_tarif($montant_tarif) {
      $this->montant_tarif = $montant_tarif;
      return $this;
    }
	
	
    function getMode_paiement() {
      return $this->mode_paiement;
    }

    function setMode_paiement($mode_paiement) {
      $this->mode_paiement = $mode_paiement;
      return $this;
    }
	
    function getStatut() {
      return $this->statut;
    }

    function setStatut($statut) {
      $this->statut = $statut;
      return $this;
    }
	
	
	
	
    
}

