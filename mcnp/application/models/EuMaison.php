<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuMaison {
      protected $id_maison;
      protected $designation;
      protected $id_proprietaire;
      protected $code_membre;
      protected $type_maison;
      protected $eau;
	  protected $tel;
      protected $date_enregistrement;
      protected $electrifier;
      protected $wc_douche;
      protected $statut;
      protected $desc_maison;
      protected $frais_eau;
      protected $frais_electricite;
      protected $frais_vidange;
	  protected $montant_loyer;
	  protected $autre_charge;
      protected $taxe;
      protected $frais_tel;
      protected $rue;
      protected $num_maison;
      protected $num_police_electricite;
      protected $num_compteur_eau;
      protected $num_ligne_tel;
      protected $id_utilisateur;
      protected $quartier;
      

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
    
    
    function getId_maison() {
        return $this->id_maison;
    }

    function setId_maison($id_maison) {
        $this->id_maison = $id_maison;
        return $this;
    }
    
    
    function getDesignation() {
        return $this->designation;
    }

    function setDesignation($designation) {
        $this->designation = $designation;
        return $this;
    }

    function getId_proprietaire() {
        return $this->id_proprietaire;
    }

    function setId_proprietaire($id_proprietaire) {
        $this->id_proprietaire = $id_proprietaire;
        return $this;
    }
    
     function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
    
    function getType_maison() {
        return $this->type_maison;
    }

    function setType_maison($type_maison) {
        $this->type_maison = $type_maison;
        return $this;
    }
    
    function getEau() {
        return $this->eau;
    }

    function setEau($eau) {
        $this->eau = $eau;
        return $this;
    }
    
    function getDate_enregistrement() {
        return $this->date_enregistrement;
    }

    function setDate_enregistrement($date_enregistrement) {
        $this->date_enregistrement = $date_enregistrement;
        return $this;
    }
    
    
    function getElectrifier() {
        return $this->electrifier;
    }

    function setElectrifier($electrifier) {
        $this->electrifier = $electrifier;
        return $this;
    }
    
    function getWc_douche() {
        return $this->wc_douche;
    }

    function setWc_douche($wc_douche) {
        $this->wc_douche = $wc_douche;
        return $this;
    }
    
    function getStatut() {
        return $this->statut;
    }

    function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }
    
    function getDesc_maison() {
        return $this->desc_maison;
    }

    function setDesc_maison($desc_maison) {
        $this->desc_maison = $desc_maison;
        return $this;
    }
    
    function getFrais_eau() {
        return $this->frais_eau;
    }

    function setFrais_eau($frais_eau) {
        $this->frais_eau = $frais_eau;
        return $this;
    }
    
    function getFrais_electricite() {
        return $this->frais_electricite;
    }

    function setFrais_electricite($frais_electricite) {
        $this->frais_electricite = $frais_electricite;
        return $this;
    }
    
    function getFrais_vidange() {
        return $this->frais_vidange;
    }

    function setFrais_vidange($frais_vidange) {
        $this->frais_vidange = $frais_vidange;
        return $this;
    }
    
    function getTaxe() {
        return $this->taxe;
    }

    function setTaxe($taxe) {
        $this->taxe = $taxe;
        return $this;
    }
    
    function getFrais_tel() {
        return $this->frais_tel;
    }

    function setFrais_tel($frais_tel) {
        $this->frais_tel = $frais_tel;
        return $this;
    }
    
    function getRue() {
        return $this->rue;
    }

    function setRue($rue) {
        $this->rue = $rue;
        return $this;
    }
    
    function getNum_maison() {
        return $this->num_maison;
    }

    function setNum_maison($num_maison) {
        $this->num_maison = $num_maison;
        return $this;
    }
    
    function getNum_police_electricite() {
        return $this->num_police_electricite;
    }

    function setNum_police_electricite($num_police_electricite) {
        $this->num_police_electricite = $num_police_electricite;
        return $this;
    }
    
    function getNum_compteur_eau() {
        return $this->num_compteur_eau;
    }

    function setNum_compteur_eau($num_compteur_eau) {
        $this->num_compteur_eau = $num_compteur_eau;
        return $this;
    }
    
    function getNum_ligne_tel() {
        return $this->num_ligne_tel;
    }

    function setNum_ligne_tel($num_ligne_tel) {
        $this->num_ligne_tel = $num_ligne_tel;
        return $this;
    }
    
    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
    
    function getQuartier() {
        return $this->quartier;
    }

    function setQuartier($quartier) {
        $this->quartier = $quartier;
        return $this;
    }

    function getCode_agence() {
        return $this->code_agence;
    }

    function setCode_agence($code_agence) {
        $this->code_agence = $code_agence;
        return $this;
    }
	
	
	function getTel() {
        return $this->tel;
    }

    function setTel($tel) {
        $this->tel = $tel;
        return $this;
    }
	
	
	function getMontant_loyer() {
        return $this->montant_loyer;
    }
      
    function setMontant_loyer($montant_loyer) {
        $this->montant_loyer = $montant_loyer;
        return $this;
    }
	
	
	function getAutre_charge() {
        return $this->autre_charge;
    }
      
    function setAutre_charge($autre_charge) {
        $this->autre_charge = $autre_charge;
        return $this;
    }
	
	
	
	
    
}

?>
