<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuTegc
 *
 * @author user
 */
 
class Application_Model_EuTegc { 
    //put your code here
    protected $code_tegc;
    protected $code_membre;
    protected $id_filiere;
    protected $mdv;
    protected $montant;
	protected $montant_utilise;
	protected $recurrent_illimite;
	protected $recurrent_limite;
	protected $nonrecurrent;
	protected $periode1;
	protected $periode2;
	protected $periode3;
	protected $special;
	protected $ordinaire;
	protected $nom_tegc;
	protected $date_tegc;
	protected $nom_produit;
	protected $id_utilisateur;
	protected $tranche_payement;
	protected $subvention;
	protected $code_zone;
	protected $id_pays;
	protected $id_region;
	protected $id_prefecture;
	protected $id_canton;
	protected $formel;
	protected $regime_tva;
	protected $type_tegc;
	protected $code_membre_physique;
	
	
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

    public function getCode_tegc() {
        return $this->code_tegc;
    }

    public function setCode_tegc($code_tegc) {
        $this->code_tegc = $code_tegc;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getId_filiere() {
        return $this->id_filiere;
    }

    public function setId_filiere($id_filiere) {
        $this->id_filiere = $id_filiere;
        return $this;
    }

    public function getMdv() {
        return $this->mdv;
    }

    public function setMdv($mdv) {
        $this->mdv = $mdv;
        return $this;
    }

    public function getMontant() {
        return $this->montant;
    }

    public function setMontant($montant) {
        $this->montant = $montant;
        return $this;
    }
	
	public function getMontant_utilise() {
        return $this->montant_utilise;
    }

    public function setMontant_utilise($montant_utilise) {
           $this->montant_utilise = $montant_utilise;
           return $this;
    }
	
	public function getSolde_tegc() {
           return $this->solde_tegc;
    }

    public function setSolde_tegc($solde_tegc) {
        $this->solde_tegc = $solde_tegc;
        return $this;
    }
	
	public function getRecurrent_illimite() {
           return $this->recurrent_illimite;
    }

    public function setRecurrent_illimite($recurrent_illimite) {
        $this->recurrent_illimite = $recurrent_illimite;
        return $this;
    }
	
	public function getRecurrent_limite() {
           return $this->recurrent_limite;
    }

    public function setRecurrent_limite($recurrent_limite) {
        $this->recurrent_limite = $recurrent_limite;
        return $this;
    }
	
	
	public function getNonrecurrent() {
        return $this->nonrecurrent;
    }
	
	public function setNonrecurrent($nonrecurrent) {
       $this->nonrecurrent = $nonrecurrent;
       return $this;
    }
	
	public function getPeriode1() {
      return $this->periode1;
    }
	
	public function setPeriode1($periode1) {
       $this->periode1 = $periode1;
       return $this;
    }
	
	public function getPeriode2() {
      return $this->periode2;
    }
	
	public function setPeriode2($periode2) {
       $this->periode2 = $periode2;
       return $this;
    }
	
	public function getPeriode3() {
      return $this->periode3;
    }
	
	public function setPeriode3($periode3) {
       $this->periode3 = $periode3;
       return $this;
    }
	
	
	public function getSpecial() {
      return $this->special;
    }
	
	public function setSpecial($special) {
       $this->special = $special;
       return $this;
    }
	
	public function getOrdinaire() {
      return $this->ordinaire;
    }
	
	public function setOrdinaire($ordinaire) {
       $this->ordinaire = $ordinaire;
       return $this;
    }
	
	public function getNom_tegc() {
      return $this->nom_tegc;
    }
	
	
	public function setNom_tegc($nom_tegc) {
       $this->nom_tegc = $nom_tegc;
       return $this;
    }
	
	public function getDate_tegc() {
      return $this->date_tegc;
    }
	
	
	public function setDate_tegc($date_tegc) {
       $this->date_tegc = $date_tegc;
       return $this;
    }
	
	
	public function getNom_produit() {
      return $this->nom_produit;
    }
	
	
	public function setNom_produit($nom_produit) {
       $this->nom_produit = $nom_produit;
       return $this;
    }
	
	public function getId_utilisateur() {
      return $this->id_utilisateur;
    }
	
	
	public function setId_utilisateur($id_utilisateur) {
       $this->id_utilisateur = $id_utilisateur;
       return $this;
    }
	
	public function getTranche_payement() {
      return $this->tranche_payement;
    }
	
	
	public function setTranche_payement($tranche_payement) {
       $this->tranche_payement = $tranche_payement;
       return $this;
    }
	
	
	public function getSubvention() {
      return $this->subvention;
    }
	
	
	public function setSubvention($subvention) {
       $this->subvention = $subvention;
       return $this;
    }
	
	public function getCode_zone() {
      return $this->code_zone;
    }
	
	public function setCode_zone($code_zone) {
       $this->code_zone = $code_zone;
       return $this;
    }
	
	public function getId_pays() {
      return $this->id_pays;
    }
	
	public function setId_pays($id_pays) {
       $this->id_pays = $id_pays;
       return $this;
    }
	
	public function getId_region() {
      return $this->id_region;
    }
	
	public function setId_region($id_region) {
       $this->id_region = $id_region;
       return $this;
    }
	
	
	public function getId_prefecture() {
      return $this->id_prefecture;
    }
	
	public function setId_prefecture($id_prefecture) {
       $this->id_prefecture = $id_prefecture;
       return $this;
    }
	
	public function getId_canton() {
      return $this->id_canton;
    }
	
	public function setId_canton($id_canton) {
       $this->id_canton = $id_canton;
       return $this;
    }
	
	public function getFormel() {
      return $this->formel;
    }
	
	public function setFormel($formel) {
       $this->formel = $formel;
       return $this;
    }
	
	public function getRegime_tva() {
      return $this->regime_tva;
    }
	
	public function setRegime_tva($regime_tva) {
       $this->regime_tva = $regime_tva;
       return $this;
    }
	
	public function getType_tegc() {
      return $this->type_tegc;
    }
	
	public function setType_tegc($type_tegc) {
       $this->type_tegc = $type_tegc;
       return $this;
    }
	
	public function getCode_membre_physique() {
      return $this->code_membre_physique;
    }
	
	public function setCode_membre_physique($code_membre_physique) {
       $this->code_membre_physique = $code_membre_physique;
       return $this;
    }
	
	

}

?>
