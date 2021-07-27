<?php

class Application_Model_EuDetailBonEntreeStock {

    //put your code here
    protected $id_detail_bon_entree_stock;
    protected $id_bon_entree_stock;
    protected $reference_articles;
    protected $designation_articles;
    protected $unite_comptage;
    protected $quantite;
    protected $prix_unitaire;
    protected $montant;
    protected $observations;
    protected $etat;
/*
CREATE TABLE `eu_detail_bon_entree_stock` (
    `id_detail_bon_entree_stock` INT(11) NOT NULL AUTO_INCREMENT,
    `designation_articles` VARCHAR(255) NOT NULL,
    `unite_comptage` INT(11) NOT NULL DEFAULT '0',
    `quantite` INT(11) NOT NULL DEFAULT '0',
    `prix_unitaire` INT(11) NOT NULL DEFAULT '0',
    `montant` INT(11) NOT NULL DEFAULT '0',
    `observations` LONGTEXT NOT NULL,
    PRIMARY KEY (`id_detail_bon_entree_stock`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
*/
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

    public function getId_detail_bon_entree_stock() {
        return $this->id_detail_bon_entree_stock;
    }

    public function setId_detail_bon_entree_stock($id_detail_bon_entree_stock) {
        $this->id_detail_bon_entree_stock = $id_detail_bon_entree_stock;
        return $this;
    }

    public function getId_bon_entree_stock() {
        return $this->id_bon_entree_stock;
    }

    public function setId_bon_entree_stock($id_bon_entree_stock) {
        $this->id_bon_entree_stock = $id_bon_entree_stock;
        return $this;
    }
    
    public function getReference_articles() {
        return $this->reference_articles;
    }

    public function setReference_articles($reference_articles) {
        $this->reference_articles = $reference_articles;
        return $this;
    }
    
    public function getDesignation_articles() {
        return $this->designation_articles;
    }

    public function setDesignation_articles($designation_articles) {
        $this->designation_articles = $designation_articles;
        return $this;
    }

    public function getUnite_comptage() {
        return $this->unite_comptage;
    }

    public function setUnite_comptage($unite_comptage) {
        $this->unite_comptage = $unite_comptage;
        return $this;
    }
      
    public function getQuantite() {
        return $this->quantite;
    }

    public function setQuantite($quantite) {
        $this->quantite = $quantite;
        return $this;
    }
    
    public function getPrix_unitaire() {
        return $this->prix_unitaire;
    }

    public function setPrix_unitaire($prix_unitaire) {
        $this->prix_unitaire = $prix_unitaire;
        return $this;
    }
    
    public function getMontant() {
        return $this->montant;
    }

    public function setMontant($montant) {
        $this->montant = $montant;
        return $this;
    }   
    
    public function getObservations() {
        return $this->observations;
    }

    public function setObservations($observations) {
        $this->observations = $observations;
        return $this;
    }   

    public function getEtat() {
        return $this->etat;
    }

    public function setEtat($etat) {
        $this->etat = $etat;
        return $this;
    }
    
}

?>
