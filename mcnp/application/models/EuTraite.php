<?php
 
class Application_Model_EuTraite {

    //put your code here
    protected $traite_id;
    protected $traite_tegcp;
    protected $traite_code_banque;
    protected $traiter;
    protected $bon_id;
    protected $traite_numero;
    protected $traite_date_debut;
    protected $traite_date_fin;
    protected $traite_disponible;
    protected $traite_imprimer;
    protected $traite_escompte_nature;
    protected $traite_montant;
    protected $traite_payer;
    protected $traite_avant_vte;
    protected $traite_statut;
    protected $id_utilisateur;
    protected $mode_paiement;
    protected $reference_paiement;
    protected $bon_type;
        


    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
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

    public function getTraite_id() {
        return $this->traite_id;
    }

    public function setTraite_id($traite_id) {
        $this->traite_id = $traite_id;
        return $this;
    }


    public function getTraiter() {
        return $this->traiter;
    }

    public function setTraiter($traiter) {
        $this->traiter = $traiter;
        return $this;
    }

    public function getTraite_tegcp() {
        return $this->traite_tegcp;
    }

    public function setTraite_tegcp($traite_tegcp) {
        $this->traite_tegcp = $traite_tegcp;
        return $this;
    }

    public function getTraite_code_banque() {
        return $this->traite_code_banque;
    }

    public function setTraite_code_banque($traite_code_banque) {
        $this->traite_code_banque = $traite_code_banque;
        return $this;
    }

    public function getBon_id() {
        return $this->bon_id;
    }

    public function setBon_id($bon_id) {
        $this->bon_id = $bon_id;
        return $this;
    }


    public function getTraite_numero() {
        return $this->traite_numero;
    }

    public function setTraite_numero($traite_numero) {
        $this->traite_numero = $traite_numero;
        return $this;
    }

    public function getTraite_date_debut() {
        return $this->traite_date_debut;
    }

    public function setTraite_date_debut($traite_date_debut) {
        $this->traite_date_debut = $traite_date_debut;
        return $this;
    }

    public function getTraite_date_fin() {
        return $this->traite_date_fin;
    }

    public function setTraite_date_fin($traite_date_fin) {
        $this->traite_date_fin = $traite_date_fin;
        return $this;
    }

    public function getTraite_disponible() {
        return $this->traite_disponible;
    }

    public function setTraite_disponible($traite_disponible) {
        $this->traite_disponible = $traite_disponible;
        return $this;
    }

    public function getTraite_imprimer() {
        return $this->traite_imprimer;
    }

    public function setTraite_imprimer($traite_imprimer) {
        $this->traite_imprimer = $traite_imprimer;
        return $this;
    }

    public function getTraite_escompte_nature() {
        return $this->traite_escompte_nature;
    }

    public function setTraite_escompte_nature($traite_escompte_nature) {
        $this->traite_escompte_nature = $traite_escompte_nature;
        return $this;
    }


    public function getTraite_montant() {
        return $this->traite_montant;
    }

    public function setTraite_montant($traite_montant) {
        $this->traite_montant = $traite_montant;
        return $this;
    }


    public function getTraite_payer() {
        return $this->traite_payer;
    }

    public function setTraite_payer($traite_payer) {
        $this->traite_payer = $traite_payer;
        return $this;
    }


    public function getTraite_avant_vte() {
        return $this->traite_avant_vte;
    }

    public function setTraite_avant_vte($traite_avant_vte) {
        $this->traite_avant_vte = $traite_avant_vte;
        return $this;
    }

    public function getTraite_statut() {
        return $this->traite_statut;
    }

    public function setTraite_statut($traite_statut) {
        $this->traite_statut = $traite_statut;
        return $this;
    }
    
    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
    
    
    public function getMode_paiement() {
        return $this->mode_paiement;
    }

    public function setMode_paiement($mode_paiement) {
        $this->mode_paiement = $mode_paiement;
        return $this;
    }
    
    public function getReference_paiement() {
        return $this->reference_paiement;
    }

    public function setReference_paiement($reference_paiement) {
        $this->reference_paiement = $reference_paiement;
        return $this;
    }
    
    public function getBon_type() {
        return $this->bon_type;
    }

    public function setBon_type($bon_type) {
        $this->bon_type = $bon_type;
        return $this;
    }
    
    
    
    
    
    
}

?>
