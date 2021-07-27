<?php

class Application_Model_EuCoincidence {

    //put your code here
    protected $id_coincidence;
    protected $date_coincidence;
    protected $type_bon_apporteur;
    protected $code_membre_apporteur;
    protected $montant_apporteur;
    protected $cat_produit_apporteur;
    protected $code_tegc_apporteur;
    protected $type_compte_apporteur;
    protected $code_apporteur;
    protected $type_bon_beneficiaire;
    protected $code_membre_beneficiaire;
    protected $montant_beneficiaire;
    protected $cat_produit_beneficiaire;
    protected $code_tegc_beneficiaire;
    protected $type_compte_beneficiaire;
    protected $code_beneficiaire;
    protected $publier;
    protected $id_canton_apporteur;
    protected $id_canton_beneficiaire;

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

    public function getId_coincidence() {
        return $this->id_coincidence;
    }

    public function setId_coincidence($id_coincidence) {
        $this->id_coincidence = $id_coincidence;
        return $this;
    }

    public function getType_bon_apporteur() {
        return $this->type_bon_apporteur;
    }

    public function setType_bon_apporteur($type_bon_apporteur) {
        $this->type_bon_apporteur = $type_bon_apporteur;
        return $this;
    }

    public function getCode_membre_apporteur() {
        return $this->code_membre_apporteur;
    }

    public function setCode_membre_apporteur($code_membre_apporteur) {
        $this->code_membre_apporteur = $code_membre_apporteur;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }
	
    public function getDate_coincidence() {
        return $this->date_coincidence;
    }

    public function setDate_coincidence($date_coincidence) {
        $this->date_coincidence = $date_coincidence;
        return $this;
    }

    public function getMontant_apporteur() {
        return $this->montant_apporteur;
    }

    public function setMontant_apporteur($montant_apporteur) {
        $this->montant_apporteur = $montant_apporteur;
        return $this;
    }

    public function getMontant_beneficiaire() {
        return $this->montant_beneficiaire;
    }

    public function setMontant_beneficiaire($montant_beneficiaire) {
        $this->montant_beneficiaire = $montant_beneficiaire;
        return $this;
    }
	
    public function getCat_produit_apporteur() {
        return $this->cat_produit_apporteur;
    }

    public function setCat_produit_apporteur($cat_produit_apporteur) {
        $this->cat_produit_apporteur = $cat_produit_apporteur;
        return $this;
    }

    public function getCode_tegc_apporteur() {
        return $this->code_tegc_apporteur;
    }

    public function setCode_tegc_apporteur($code_tegc_apporteur) {
        $this->code_tegc_apporteur = $code_tegc_apporteur;
        return $this;
    }

    public function getCode_membre_beneficiaire() {
        return $this->code_membre_beneficiaire;
    }

    public function setCode_membre_beneficiaire($code_membre_beneficiaire) {
        $this->code_membre_beneficiaire = $code_membre_beneficiaire;
        return $this;
    }

    public function getCode_tegc_beneficiaire() {
        return $this->code_tegc_beneficiaire;
    }

    public function setCode_tegc_beneficiaire($code_tegc_beneficiaire) {
        $this->code_tegc_beneficiaire = $code_tegc_beneficiaire;
        return $this;
    }

    public function getCode_apporteur() {
        return $this->code_apporteur;
    }

    public function setCode_apporteur($code_apporteur) {
        $this->code_apporteur = $code_apporteur;
        return $this;
    }

    public function getCode_beneficiaire() {
        return $this->code_beneficiaire;
    }

    public function setCode_beneficiaire($code_beneficiaire) {
        $this->code_beneficiaire = $code_beneficiaire;
        return $this;
    }
	
    public function getPublier_membre() {
        return $this->type_bon_beneficiaire;
    }

    public function setPublier_membre($type_bon_beneficiaire) {
        $this->type_bon_beneficiaire = $type_bon_beneficiaire;
        return $this;
    }
	
    public function getNum_offre_demande() {
        return $this->cat_produit_beneficiaire;
    }

    public function setNum_offre_demande($cat_produit_beneficiaire) {
        $this->cat_produit_beneficiaire = $cat_produit_beneficiaire;
        return $this;
    }
	
    public function getType_compte_apporteur() {
        return $this->type_compte_apporteur;
    }

    public function setType_compte_apporteur($type_compte_apporteur) {
        $this->type_compte_apporteur = $type_compte_apporteur;
        return $this;
    }

    public function getType_compte_beneficiaire() {
        return $this->type_compte_beneficiaire;
    }

    public function setType_compte_beneficiaire($type_compte_beneficiaire) {
        $this->type_compte_beneficiaire = $type_compte_beneficiaire;
        return $this;
    }
	
    public function getId_canton_apporteur() {
        return $this->id_canton_apporteur;
    }

    public function setId_canton_apporteur($id_canton_apporteur) {
        $this->id_canton_apporteur = $id_canton_apporteur;
        return $this;
    }

    public function getId_canton_beneficiaire() {
        return $this->id_canton_beneficiaire;
    }

    public function setId_canton_beneficiaire($id_canton_beneficiaire) {
        $this->id_canton_beneficiaire = $id_canton_beneficiaire;
        return $this;
    }
	
}

?>
