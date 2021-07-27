<?php

class Application_Model_EuCommande
{
    protected $code_commande;
    protected $date_commande;
    protected $montant_commande;
    protected $code_membre_acheteur;
    protected $code_membre_vendeur;
    protected $quartier_acheteur;
    protected $ville_acheteur;
    protected $tel_acheteur;
    protected $adresse_livraison;
    protected $code_confirmation;
    protected $code_livraison;
    protected $executer;
    protected $montant_livraison;
    protected $code_zone;
    protected $id_pays;
    protected $id_region;
    protected $id_prefecture;
    protected $code_membre_livreur;
    protected $code_membre_transitaire;
    protected $code_membre_transporteur;
    protected $mode_livraison;
    protected $frais_livraison;
    protected $frais_transit;
    protected $frais_transport;
    protected $date_livraison;
    protected $livrer;
    protected $type_recurrent;
    protected $periode_recurrent;
    protected $type_bon;
    protected $enligne;
    
    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        return $this->$method();
    }
    
     public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }


    function getCode_commande() {
        return $this->code_commande;
    }

    function setCode_commande($code_commande) {
        $this->code_commande = $code_commande;
        return $this;
    }
    
    function getDate_commande() {
        return $this->date_commande;
    }
    function setDate_commande($date_commande) {
        $this->date_commande =$date_commande;
        return $this;
    }
    
    function getMontant_commande() {
        return $this->montant_commande;
    }
    function setMontant_commande($montant_commande) {
        $this->montant_commande =$montant_commande;
        return $this;
    }

    function getCode_membre_acheteur() {
        return $this->code_membre_acheteur;
    }

    function setCode_membre_acheteur($code_membre_acheteur) {
        $this->code_membre_acheteur = $code_membre_acheteur;
        return $this;
    }


    function getCode_membre_vendeur() {
        return $this->code_membre_vendeur;
    }

    function setCode_membre_vendeur($code_membre_vendeur) {
        $this->code_membre_vendeur = $code_membre_vendeur;
        return $this;
    }
    
    function getQuartier_acheteur() {
        return $this->quartier_acheteur;
    }
    function setQuartier_acheteur($quartier_acheteur) {
        $this->quartier_acheteur = $quartier_acheteur;
        return $this;
    }
    
    function getVille_acheteur() {
        return $this->ville_acheteur;
    }
    function setVille_acheteur($ville_acheteur) {
        $this->ville_acheteur = $ville_acheteur;
        return $this;
    }
    
    
    function getTel_acheteur() {
        return $this->tel_acheteur;
    }
    function setTel_acheteur($tel_acheteur) {
        $this->tel_acheteur = $tel_acheteur;
        return $this;
    }

    function getAdresse_livraison() {
        return $this->adresse_livraison;
    }
    function setAdresse_livraison($adresse_livraison) {
        $this->adresse_livraison = $adresse_livraison;
        return $this;
    }
    
    function getCode_livraison() {
        return $this->code_livraison;
    }
    function setCode_livraison($code_livraison) {
        $this->code_livraison = $code_livraison;
        return $this;
    }
    
    function getCode_confirmation() {
        return $this->code_confirmation;
    }
    function setCode_confirmation($code_confirmation) {
        $this->code_confirmation = $code_confirmation;
        return $this;
    }
    function getExecuter() {
        return $this->executer;
    }
    function setExecuter($executer) {
        $this->executer = $executer;
        return $this;
    }
    
    function getMontant_livraison() {
        return $this->montant_livraison;
    }
    function setMontant_livraison($montant_livraison) {
        $this->montant_livraison = $montant_livraison;
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

    function getCode_membre_livreur() {
        return $this->code_membre_livreur;
    }

    function setCode_membre_livreur($code_membre_livreur) {
        $this->code_membre_livreur = $code_membre_livreur;
        return $this;
    }

    function getCode_membre_transitaire() {
        return $this->code_membre_transitaire;
    }

    function setCode_membre_transitaire($code_membre_transitaire) {
        $this->code_membre_transitaire = $code_membre_transitaire;
        return $this;
    }

    function getCode_membre_transporteur() {
        return $this->code_membre_transporteur;
    }

    function setCode_membre_transporteur($code_membre_transporteur) {
        $this->code_membre_transporteur = $code_membre_transporteur;
        return $this;
    }

    function getMode_livraison() {
        return $this->mode_livraison;
    }

    function setMode_livraison($mode_livraison) {
        $this->mode_livraison = $mode_livraison;
        return $this;
    }

    function getFrais_livraison() {
        return $this->frais_livraison;
    }

    function setFrais_livraison($frais_livraison) {
        $this->frais_livraison = $frais_livraison;
        return $this;
    }

    function getFrais_transit() {
        return $this->frais_transit;
    }

    function setFrais_transit($frais_transit) {
        $this->frais_transit = $frais_transit;
        return $this;
    }

    function getFrais_transport() {
        return $this->frais_transport;
    }

    function setFrais_transport($frais_transport) {
        $this->frais_transport = $frais_transport;
        return $this;
    }

    function getDate_livraison() {
        return $this->date_livraison;
    }

    function setDate_livraison($date_livraison) {
        $this->date_livraison = $date_livraison;
        return $this;
    }

    function getLivrer() {
        return $this->livrer;
    }

    function setLivrer($livrer) {
        $this->livrer = $livrer;
        return $this;
    }

    
    function getType_recurrent() {
        return $this->type_recurrent;
    }
    function setType_recurrent($type_recurrent) {
        $this->type_recurrent = $type_recurrent;
        return $this;
    }
    
    function getPeriode_recurrent() {
        return $this->periode_recurrent;
    }
    function setPeriode_recurrent($periode_recurrent) {
        $this->periode_recurrent = $periode_recurrent;
        return $this;
    }
    
    function getType_bon() {
        return $this->type_bon;
    }
    function setType_bon($type_bon) {
        $this->type_bon = $type_bon;
        return $this;
    }
    
    function getEnligne() {
        return $this->enligne;
    }
    function setEnligne($enligne) {
        $this->enligne = $enligne;
        return $this;
    }

}
