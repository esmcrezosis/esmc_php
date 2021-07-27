<?php

class Application_Model_EuFacture {

    protected $code_facture;
    protected $code_commande;
    protected $code_membre_client;
    protected $code_membre_fournisseur;
    protected $date_facture;
    protected $etat_facture;
    protected $montant_ht;
    protected $id_utilisateur;
	protected $id_taxe;
   

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid contrat property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid contrat property');
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

    function getCode_facture() {
        return $this->code_facture;
    }

    function setCode_facture($code_facture) {
        $this->code_facture = $code_facture;
        return $this;
    }

    function getCode_commande() {
        return $this->code_commande;
    }

    function setCode_commande($code_commande) {
        $this->code_commande =$code_commande;
        return $this;
    }

    function getCode_membre_client() {
        return $this->code_membre_client;
    }

    function setCode_membre_client($code_membre_client) {
        $this->code_membre_client =$code_membre_client;
        return $this;
    }
    function getCode_membre_fournisseur() {
        return $this->code_membre_fournisseur;
    }

    function setCode_membre_fournisseur($code_membre_fournisseur) {
        $this->code_membre_fournisseur =$code_membre_fournisseur;
        return $this;
    }
     function getDate_facture() {
        return $this->date_facture;
    }

    function setDate_facture($date_facture) {
        $this->date_facture =$date_facture;
        return $this;
    }
     
    function getEtat_facture() {
        return $this->etat_facture;
    }

    function setEtat_facture($etat_facture) {
        $this->etat_facture =$etat_facture;
        return $this;
    }
      
    function getMontant_ht() {
        return $this->montant_ht;
    }

    function setMontant_ht($montant_ht) {
        $this->montant_ht =$montant_ht;
        return $this;
    }
      
    function getId_utilisateur() {
        return $this->id_utilisateur;
    }
    
    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur =$id_utilisateur;
        return $this;
    }
	
	function getId_taxe() {
        return $this->id_taxe;
    }
    
    function setId_taxe($id_taxe) {
        $this->id_taxe =$id_taxe;
        return $this;
    }
}
