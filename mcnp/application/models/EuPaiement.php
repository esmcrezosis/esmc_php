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
class Application_Model_EuPaiement {

    //put your code here
    protected $id_paiement;
    protected $montant_paiement;
    protected $date_paiement;
    protected $code_membre_employe;
    protected $id_demande_paiement;
    protected $taux_horaire;
    protected $nombre_heure;
    protected $payer;
    

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

    public function getId_paiement() {
        return $this->id_paiement;
    }

    public function setId_paiement($id_paiement) {
        $this->id_paiement = $id_paiement;
        return $this;
    }

    public function getCode_membre_employe() {
        return $this->code_membre_employe;
    }

    public function setCode_membre_employe($code_membre_employe) {
        $this->code_membre_employe = $code_membre_employe;
        return $this;
    }

    public function getMontant_paiement() {
        return $this->montant_paiement;
    }

    public function setMontant_paiement($montant_paiement) {
        $this->montant_paiement = $montant_paiement;
        return $this;
    }

    public function getDate_paiement() {
        return $this->date_paiement;
    }

    public function setDate_paiement($date_paiement) {
        $this->date_paiement = $date_paiement;
        return $this;
    }

    public function getId_demande_paiement() {
        return $this->id_demande_paiement;
    }

    public function setId_demande_paiement($id_demande_paiement) {
        $this->id_demande_paiement = $id_demande_paiement;
        return $this;
    }
    

    public function getTaux_horaire() {
        return $this->taux_horaire;
    }

    public function setTaux_horaire($taux_horaire) {
        $this->taux_horaire = $taux_horaire;
        return $this;
    }

    public function getNombre_heure() {
        return $this->nombre_heure;
    }

    public function setNombre_heure($nombre_heure) {
        $this->nombre_heure = $nombre_heure;
        return $this;
    }

    public function getPayer() {
        return $this->payer;
    }

    public function setPayer($payer) {
        $this->payer = $payer;
        return $this;
    }
	
	
	
}



?>
