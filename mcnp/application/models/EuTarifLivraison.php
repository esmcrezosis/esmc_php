<?php

class Application_Model_EuTarifLivraison {

    protected  $id_tarif_livraison;
    protected  $code_zone;
    protected  $id_pays;
    protected  $id_region;
    protected  $id_prefecture;
    protected  $montant_tarif_livraison;
    protected  $code_membre;
    protected  $statut;    
    
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

    function getId_tarif_livraison() {
        return $this->id_tarif_livraison;
    }

    function setId_tarif_livraison($id_tarif_livraison) {
        $this->id_tarif_livraison = $id_tarif_livraison;
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
        return $this->id_prefecture;
    }

    function setId_prefecture($id_prefecture) {
        $this->id_prefecture = $id_prefecture;
        return $this;
    }


    function getMontant_tarif_livraison() {
        return $this->montant_tarif_livraison;
    }

    function setMontant_tarif_livraison($montant_tarif_livraison) {
        $this->montant_tarif_livraison = $montant_tarif_livraison;
        return $this;
    }

    function getStatut() {
        return $this->statut;
    }

    function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
}