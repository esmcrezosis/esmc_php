<?php

class Application_Model_EuDetailContratLivraisonIrrevocable
{
    protected $id_detail_contrat;
    protected $id_contrat;
    protected $quantite;
    protected $prix_unitaire;
    protected $libelle_produit;
    protected $montant_produit;
    protected $statut;
    
    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
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

    function getId_detail_contrat() {
        return $this->id_detail_contrat;
    }

    function setId_detail_contrat($id_detail_contrat) {
        $this->id_detail_contrat = $id_detail_contrat;
        return $this;
    }
	
    function getId_contrat() {
        return $this->id_contrat;
    }
    function setId_contrat($id_contrat) {
        $this->id_contrat = $id_contrat;
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
    
    function getLibelle_produit() {
        return $this->libelle_produit;
    }
    function setLibelle_produit($libelle_produit) {
        $this->libelle_produit = $libelle_produit;
        return $this;
    }
  
    function getMontant_produit() {
        return $this->montant_produit;
    }
    function setMontant_produit($montant_produit) {
        $this->montant_produit = $montant_produit;
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


