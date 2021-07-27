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
class Application_Model_EuDetailPaiement {

    //put your code here
    protected $id_detail_paiement;
    protected $id_paiement;
    protected $id_pointage;
    protected $montant_paiement;
    protected $bon_neutre_appro_id;
    protected $souscription_id;
    protected $table;
    protected $id_table;
    protected $taux_horaire;
    protected $nombre_heure;
    

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

    public function getId_detail_paiement() {
        return $this->id_detail_paiement;
    }

    public function setId_detail_paiement($id_detail_paiement) {
        $this->id_detail_paiement = $id_detail_paiement;
        return $this;
    }

    public function getId_pointage() {
        return $this->id_pointage;
    }

    public function setId_pointage($id_pointage) {
        $this->id_pointage = $id_pointage;
        return $this;
    }

    public function getId_paiement() {
        return $this->id_paiement;
    }

    public function setId_paiement($id_paiement) {
        $this->id_paiement = $id_paiement;
        return $this;
    }

    public function getMontant_paiement() {
        return $this->montant_paiement;
    }

    public function setMontant_paiement($montant_paiement) {
        $this->montant_paiement = $montant_paiement;
        return $this;
    }
    
	public function getBon_neutre_appro_id() {
        return $this->bon_neutre_appro_id;
    }

    public function setBon_neutre_appro_id($bon_neutre_appro_id) {
        $this->bon_neutre_appro_id = $bon_neutre_appro_id;
        return $this;
    }
	
	public function getSouscription_id() {
        return $this->souscription_id;
    }

    public function setSouscription_id($souscription_id) {
        $this->souscription_id = $souscription_id;
        return $this;
    }

    
    public function getTable() {
        return $this->table;
    }

    public function setTable($table) {
        $this->table = $table;
        return $this;
    }
    
    public function getId_table() {
        return $this->id_table;
    }

    public function setId_table($id_table) {
        $this->id_table = $id_table;
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
    
}



?>
