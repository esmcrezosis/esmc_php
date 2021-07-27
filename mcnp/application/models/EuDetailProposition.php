<?php

class Application_Model_EuDetailProposition {

    //put your code here
    protected $id_detail_proposition;
    protected $id_proposition;
    protected $libelle_produit;
    protected $prix_unitaire;
    protected $quantite;
    protected $type_produit;
    protected $unite_mesure;
    protected $appartenance;
    protected $code_membre_morale;
    protected $mdv;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid detail property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid detail property');
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

    public function getId_detail_proposition() {
        return $this->id_detail_proposition;
    }

    public function setId_detail_proposition($id_detail_proposition) {
        $this->id_detail_proposition = $id_detail_proposition;
        return $this;
    }

    public function getId_proposition() {
        return $this->id_proposition;
    }

    public function setId_proposition($id_proposition) {
        $this->id_proposition = $id_proposition;
        return $this;
    }

    public function getLibelle_produit() {
        return $this->libelle_produit;
    }

    public function setLibelle_produit($libelle_produit) {
        $this->libelle_produit = $libelle_produit;
        return $this;
    }

    public function getPrix_unitaire() {
        return $this->prix_unitaire;
    }

    public function setPrix_unitaire($prix_unitaire) {
        $this->prix_unitaire = $prix_unitaire;
        return $this;
    }

    public function getQuantite() {
        return $this->quantite;
    }

    public function setQuantite($quantite) {
        $this->quantite = $quantite;
        return $this;
    }

    public function getType_produit() {
        return $this->type_produit;
    }

    public function setType_produit($type_produit) {
        $this->type_produit = $type_produit;
        return $this;
    }

    public function getUnite_mesure() {
        return $this->unite_mesure;
    }

    public function setUnite_mesure($unite_mesure) {
        $this->unite_mesure = $unite_mesure;
        return $this;
    }

    public function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    public function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }

    public function getMdv() {
        return $this->mdv;
    }

    public function setMdv($mdv) {
        $this->mdv = $mdv;
        return $this;
    }

    public function getAppartenance() {
        return $this->appartenance;
    }

    public function setAppartenance($appartenance) {
        $this->appartenance = $appartenance;
        return $this;
    }

	
}

?>
