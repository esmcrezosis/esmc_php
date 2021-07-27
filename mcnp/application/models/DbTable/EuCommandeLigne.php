<?php

class Application_Model_EuCommandeLigne {

    protected  $id_commande_ligne;
    protected  $code_commande_ligne;
    protected  $date_commande_ligne;
    protected  $montant_commande_ligne;
    protected  $code_membre;
    protected  $code_zone;
    protected  $id_pays;
    protected  $id_region;
    protected  $id_prefecture;
    protected  $mode_livraison;
    protected  $statut;
    protected  $montant_livraison;    
    
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

    function getId_commande_ligne() {
        return $this->id_commande_ligne;
    }

    function setId_commande_ligne($id_commande_ligne) {
        $this->id_commande_ligne = $id_commande_ligne;
        return $this;
    }
    
    function getCode_commande_ligne() {
        return $this->code_commande_ligne;
    }

    function setCode_commande_ligne($code_commande_ligne) {
        $this->code_commande_ligne = $code_commande_ligne;
        return $this;
    }

    function getDate_commande_ligne() {
        return $this->date_commande_ligne;
    }

    function setDate_commande_ligne($date_commande_ligne) {
        $this->date_commande_ligne = $date_commande_ligne;
        return $this;
    }


    function getMontant_commande_ligne() {
        return $this->montant_commande_ligne;
    }

    function setMontant_commande_ligne($montant_commande_ligne) {
        $this->montant_commande_ligne = $montant_commande_ligne;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    function getCode_zone() {
        return $this->code_zone;
    }

    function setCode_zone($code_zone) {
        $this->code_zone = $code_zone;
        return $this;
    }

    function getId_pays() {
        return $this->id_pays;
    }

    function setId_pays($id_pays) {
        $this->id_pays = $id_pays;
        return $this;
    }


    function getId_region() {
        return $this->id_region;
    }

    function setId_region($id_region) {
        $this->id_region = $id_region;
        return $this;
    }


    function getId_prefecture() {
        return $this->id_region;
    }

    function setId_prefecture($id_prefecture) {
        $this->id_prefecture = $id_prefecture;
        return $this;
    }

    function getMode_livraison() {
        return $this->mode_livraison;
    }

    function setMode_livraison($mode_livraison) {
        $this->mode_livraison = $mode_livraison;
        return $this;
    }

    function getStatut() {
        return $this->statut;
    }

    function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }

    function getMontant_livraison() {
        return $this->montant_livraison;
    }

    function setMontant_livraison($montant_livraison) {
        $this->montant_livraison = $montant_livraison;
        return $this;
    }
}