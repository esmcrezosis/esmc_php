<?php

class Application_Model_EuDetailFicheStock {

    //put your code here
    protected $id_detail_fiche_stock;
    protected $date_article;
    protected $reference_article_fiche_stock;
    protected $entree_qte_article;
    protected $id_fiche_stock;
    protected $entree_prix_unitaire;
    protected $entree_valeur;
    protected $sortie_qte_article;
    protected $sortie_prix_unitaire;
    protected $sortie_valeur;
    protected $stocks_qte_article;
    protected $stocks_prix_unitaire;
    protected $stocks_valeur;
    protected $etat;
/*
    `id_detail_fiche_stock` INT(11) NULL DEFAULT NULL,
    `date_article` INT(11) NULL DEFAULT NULL,
    `reference_article_fiche_stock` VARCHAR(50) NULL DEFAULT NULL,
    `entree_qte_article` INT(11) NULL DEFAULT NULL,
    `id_fiche_stock` INT(11) NULL DEFAULT NULL,
    `entree_prix_unitaire` INT(11) NULL DEFAULT NULL,
    `entree_valeur` INT(11) NULL DEFAULT NULL,
    `sortie_qte_article` INT(11) NULL DEFAULT NULL,
    `sortie_prix_unitaire` INT(11) NULL DEFAULT NULL,
    `sortie_valeur` INT(11) NULL DEFAULT NULL,
    `stocks_qte_article` INT(11) NULL DEFAULT NULL,
    `stocks_prix_unitaire` INT(11) NULL DEFAULT NULL,
    `stocks_valeur` INT(11) NULL DEFAULT NULL
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

    public function getId_detail_fiche_stock() {
        return $this->id_detail_fiche_stock;
    }

    public function setId_detail_fiche_stock($id_detail_fiche_stock) {
        $this->id_detail_fiche_stock = $id_detail_fiche_stock;
        return $this;
    }
    
    public function getDate_article() {
        return $this->date_article;
    }

    public function setDate_article($date_article) {
        $this->date_article = $date_article;
        return $this;
    }

    public function getReference_article_fiche_stock() {
        return $this->reference_article_fiche_stock;
    }

    public function setReference_article_fiche_stock($reference_article_fiche_stock) {
        $this->reference_article_fiche_stock = $reference_article_fiche_stock;
        return $this;
    }
    
    public function getEntree_qte_article() {
        return $this->entree_qte_article;
    }

    public function setEntree_qte_article($entree_qte_article) {
        $this->entree_qte_article = $entree_qte_article;
        return $this;
    }

    public function getId_fiche_stock() {
        return $this->id_fiche_stock;
    }

    public function setId_fiche_stock($id_fiche_stock) {
        $this->id_fiche_stock = $id_fiche_stock;
        return $this;
    }
    
    public function getEntree_prix_unitaire() {
        return $this->entree_prix_unitaire;
    }

    public function setEntree_prix_unitaire($entree_prix_unitaire) {
        $this->entree_prix_unitaire = $entree_prix_unitaire;
        return $this;
    }

    public function getEntree_valeur() {
        return $this->entree_valeur;
    }

    public function setEntree_valeur($entree_valeur) {
        $this->entree_valeur = $entree_valeur;
        return $this;
    }
    
    public function getSortie_qte_unitaire() {
        return $this->sortie_qte_unitaire;
    }

    public function setSortie_qte_unitaire($sortie_qte_unitaire) {
        $this->sortie_qte_unitaire = $sortie_qte_unitaire;
        return $this;
    }

    public function getSortie_prix_unitaire() {
        return $this->sortie_prix_unitaire;
    }

    public function setSortie_prix_unitaire($sortie_prix_unitaire) {
        $this->sortie_prix_unitaire = $sortie_prix_unitaire;
        return $this;
    }
    
    public function getSortie_valeur() {
        return $this->sortie_valeur;
    }

    public function setSortie_valeur($sortie_valeur) {
        $this->sortie_valeur = $sortie_valeur;
        return $this;
    }
    
    public function getStocks_qte_article() {
        return $this->stocks_qte_article;
    }

    public function setStocks_qte_article($stocks_qte_article) {
        $this->stocks_qte_article = $stocks_qte_article;
        return $this;
    }
    
    public function getStocks_prix_unitaire() {
        return $this->stocks_prix_unitaire;
    }

    public function setStocks_prix_unitaire($stocks_prix_unitaire) {
        $this->stocks_prix_unitaire = $stocks_prix_unitaire;
        return $this;
    }
    
    public function getStocks_valeur() {
        return $this->stocks_valeur;
    }

    public function setStocks_valeur($stocks_valeur) {
        $this->stocks_valeur = $stocks_valeur;
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
