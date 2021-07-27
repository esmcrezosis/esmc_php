<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuCnpEntree
 *
 * @author user
 */
class Application_Model_EuDemandePaiement {

    //put your code here
    protected $id_demande_paiement;
    protected $montant_demande_paiement;
    protected $date_demande_paiement;
    protected $code_membre_employeur;
    protected $payer;
    protected $date_debut;
    protected $date_fin;
    protected $type_demande;
    protected $numero_demande_paiement;
    protected $libelle_type_demande;
    

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

    public function getId_demande_paiement() {
        return $this->id_demande_paiement;
    }

    public function setId_demande_paiement($id_demande_paiement) {
        $this->id_demande_paiement = $id_demande_paiement;
        return $this;
    }

    public function getCode_membre_employeur() {
        return $this->code_membre_employeur;
    }

    public function setCode_membre_employeur($code_membre_employeur) {
        $this->code_membre_employeur = $code_membre_employeur;
        return $this;
    }

    public function getMontant_demande_paiement() {
        return $this->montant_demande_paiement;
    }

    public function setMontant_demande_paiement($montant_demande_paiement) {
        $this->montant_demande_paiement = $montant_demande_paiement;
        return $this;
    }

    public function getDate_demande_paiement() {
        return $this->date_demande_paiement;
    }

    public function setDate_demande_paiement($date_demande_paiement) {
        $this->date_demande_paiement = $date_demande_paiement;
        return $this;
    }

    public function getPayer() {
        return $this->payer;
    }

    public function setPayer($payer) {
        $this->payer = $payer;
        return $this;
    }
    

    public function getDate_debut() {
        return $this->date_debut;
    }

    public function setDate_debut($date_debut) {
        $this->date_debut = $date_debut;
        return $this;
    }
    

    public function getDate_fin() {
        return $this->date_fin;
    }

    public function setDate_fin($date_fin) {
        $this->date_fin = $date_fin;
        return $this;
    }
    
	public function getType_demande() {
        return $this->type_demande;
    }

    public function setType_demande($type_demande) {
        $this->type_demande = $type_demande;
        return $this;
    }

    public function getNumero_demande_paiement() {
        return $this->numero_demande_paiement;
    }

    public function setNumero_demande_paiement($numero_demande_paiement) {
        $this->numero_demande_paiement = $numero_demande_paiement;
        return $this;
    }
    
    public function getLibelle_type_demande() {
        return $this->libelle_type_demande;
    }

    public function setLibelle_type_demande($libelle_type_demande) {
        $this->libelle_type_demande = $libelle_type_demande;
        return $this;
    }
	
	
}



?>
