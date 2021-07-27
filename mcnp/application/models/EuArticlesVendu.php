<?php

class Application_Model_EuArticlesVendu {

    //put your code here
    protected $id_article_vendu;
    protected $code_barre;
    protected $reference;
    protected $date_vente;
    protected $code_membre_acheteur;
    protected $code_membre_vendeur;
    protected $designation;
    protected $quantite;
    protected $prix_unitaire;
    protected $bon_id;

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

    public function getCode_barre() {
        return $this->code_barre;
    }

    public function setCode_barre($code_barre) {
        $this->code_barre = $code_barre;
        return $this;
    }


    public function getDate_vente() {
        return $this->date_vente;
    }

    public function setDate_vente($date_vente) {
        $this->date_vente = $date_vente;
        return $this;
    }

    public function getCode_membre_vendeur() {
        return $this->code_membre_vendeur;
    }

    public function setCode_membre_vendeur($code_membre_vendeur) {
        $this->code_membre_vendeur = $code_membre_vendeur;
        return $this;
    }

    public function getCode_membre_acheteur() {
        return $this->code_membre_acheteur;
    }

    public function setCode_membre_acheteur($code_membre_acheteur) {
        $this->code_membre_acheteur = $code_membre_acheteur;
        return $this;
    }

    public function getReference() {
        return $this->reference;
    }

    public function setReference($reference) {
        $this->reference = $reference;
        return $this;
    }

    public function getId_article_vendu() {
        return $this->id_article_vendu;
    }

    public function setId_article_vendu($id_article_vendu) {
        $this->id_article_vendu = $id_article_vendu;
        return $this;
    }

    public function getDesignation() {
        return $this->designation;
    }

    public function setDesignation($designation) {
        $this->designation = $designation;
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

    public function getBon_id() {
        return $this->bon_id;
    }

    public function setBon_id($bon_id) {
        $this->bon_id = $bon_id;
        return $this;
    }

    
}

?>
