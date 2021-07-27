<?php

class Application_Model_EuRecurrentJournalier {

    //put your code here
    protected $id_recurrent_journalier;
    protected $id_type_produit;
    protected $montant_journalier;
    protected $montant_total;
    protected $frequence_cumul;
    protected $id_canton;
    protected $code_membre;
    protected $date_creation;
    protected $date_debut;
    
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

    public function getId_recurrent_journalier() {
        return $this->id_recurrent_journalier;
    }

    public function setId_recurrent_journalier($id_recurrent_journalier) {
        $this->id_recurrent_journalier = $id_recurrent_journalier;
        return $this;
    }

    public function getId_type_produit() {
        return $this->id_type_produit;
    }

    public function setId_type_produit($id_type_produit) {
        $this->id_type_produit = $id_type_produit;
        return $this;
    }

    public function getMontant_journalier() {
        return $this->montant_journalier;
    }

    public function setMontant_journalier($montant_journalier) {
        $this->montant_journalier = $montant_journalier;
        return $this;
    }

    public function getMontant_total() {
        return $this->montant_total;
    }

    public function setMontant_total($montant_total) {
        $this->montant_total = $montant_total;
        return $this;
    }

    public function getFrequence_cumul() {
        return $this->frequence_cumul;
    }

    public function setFrequence_cumul($frequence_cumul) {
        $this->frequence_cumul = $frequence_cumul;
        return $this;
    }

    public function getId_canton() {
        return $this->id_canton;
    }

    public function setId_canton($id_canton) {
        $this->id_canton = $id_canton;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getDate_creation() {
        return $this->date_creation;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }

    public function getDate_debut() {
        return $this->date_debut;
    }

    public function setDate_debut($date_debut) {
        $this->date_debut = $date_debut;
        return $this;
    }
	
	
}

?>
