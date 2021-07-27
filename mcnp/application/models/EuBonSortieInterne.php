<?php

class Application_Model_EuBonSortieInterne {

    //put your code here
    protected $id_bon_sortie_interne;
    protected $reference_bon_sortie_interne;
    protected $date_bon_sortie_interne;
    protected $nature_article;
    protected $objet_bon_sortie;
    protected $quantite_article;
    protected $prix_unitaire;
    protected $montant_total_bon_sortie_interne;
    protected $imputation;
    protected $nom_beneficiaire;
    protected $no_vehicule;
    protected $date_livraison;
    protected $rejet;
    protected $code_membre;
    protected $valider_up;
    protected $valider_down;
/*
    id_bon_sortie_interne
    reference_bon_sortie_interne
    date_bon_sortie_interne
    nature_article
    objet_bon_sortie
    quantite_article
    prix_unitaire
    montant_total_bon_sortie_interne
    imputation
    nom_beneficiaire
    no_vehicule
    date_livraison
    rejet
    code_membre
    valider_up
    valider_down
    PRIMARY KEY (`id_bon_sortie_interne`)
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

    public function getId_bon_sortie_interne() {
        return $this->id_bon_sortie_interne;
    }

    public function setId_bon_sortie_interne($id_bon_sortie_interne) {
        $this->id_bon_sortie_interne = $id_bon_sortie_interne;
        return $this;
    }
    
    public function getReference_bon_sortie_interne() {
        return $this->reference_bon_sortie_interne;
    }

    public function setReference_bon_sortie_interne($reference_bon_sortie_interne) {
        $this->reference_bon_sortie_interne = $reference_bon_sortie_interne;
        return $this;
    }

    public function getDate_bon_sortie_interne() {
        return $this->date_bon_sortie_interne;
    }

    public function setDate_bon_sortie_interne($date_bon_sortie_interne) {
        $this->date_bon_sortie_interne = $date_bon_sortie_interne;
        return $this;
    }
    
    public function getNature_article() {
        return $this->nature_article;
    }

    public function setNature_article($nature_article) {
        $this->nature_article = $nature_article;
        return $this;
    }

    public function getObjet_bon_sortie() {
        return $this->objet_bon_sortie;
    }

    public function setObjet_bon_sortie($objet_bon_sortie) {
        $this->objet_bon_sortie = $objet_bon_sortie;
        return $this;
    }
    
    public function getQuantite_article() {
        return $this->quantite_article;
    }

    public function setQuantite_article($quantite_article) {
        $this->quantite_article = $quantite_article;
        return $this;
    }

    public function getPrix_unitaire() {
        return $this->prix_unitaire;
    }

    public function setPrix_unitaire($prix_unitaire) {
        $this->prix_unitaire = $prix_unitaire;
        return $this;
    }
    
    public function getMontant_total_bon_sortie_interne() {
        return $this->montant_total_bon_sortie_interne;
    }

    public function setMontant_total_bon_sortie_interne($montant_total_bon_sortie_interne) {
        $this->montant_total_bon_sortie_interne = $montant_total_bon_sortie_interne;
        return $this;
    }

    public function getImputation() {
        return $this->imputation;
    }

    public function setImputation($imputation) {
        $this->imputation = $imputation;
        return $this;
    }
    
    public function getNom_beneficiaire() {
        return $this->nom_beneficiaire;
    }

    public function setNom_beneficiaire($nom_beneficiaire) {
        $this->nom_beneficiaire = $nom_beneficiaire;
        return $this;
    }
    
    public function getNo_vehicule() {
        return $this->no_vehicule;
    }

    public function setNo_vehicule($no_vehicule) {
        $this->no_vehicule = $no_vehicule;
        return $this;
    }
    
    public function getDate_livraison() {
        return $this->date_livraison;
    }

    public function setDate_livraison($date_livraison) {
        $this->date_livraison = $date_livraison;
        return $this;
    }
    
    public function getRejet() {
        return $this->rejet;
    }

    public function setRejet($rejet) {
        $this->rejet = $rejet;
        return $this;
    }


    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
    
    public function getValider_up() {
        return $this->valider_up;
    }

    public function setValider_up($valider_up) {
        $this->valider_up = $valider_up;
        return $this;
    }
    
    public function getValider_down() {
        return $this->valider_down;
    }

    public function setValider_down($valider_down) {
        $this->valider_down = $valider_down;
        return $this;
    }
}

?>
