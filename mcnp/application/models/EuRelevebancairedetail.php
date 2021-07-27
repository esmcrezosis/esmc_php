<?php
 
class Application_Model_EuRelevebancairedetail {

    //put your code here
    protected $relevebancairedetail_id;
    protected $relevebancairedetail_relevebancaire;
    protected $relevebancairedetail_libelle;
    protected $relevebancairedetail_numero;
    protected $relevebancairedetail_date;
    protected $publier;
    protected $relevebancairedetail_montant;
    protected $relevebancairedetail_date_valeur;

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

    public function getRelevebancairedetail_id() {
        return $this->relevebancairedetail_id;
    }

    public function setRelevebancairedetail_id($relevebancairedetail_id) {
        $this->relevebancairedetail_id = $relevebancairedetail_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getRelevebancairedetail_relevebancaire() {
        return ($this->relevebancairedetail_relevebancaire);
    }

    public function setRelevebancairedetail_relevebancaire($relevebancairedetail_relevebancaire) {
        $this->relevebancairedetail_relevebancaire = ($relevebancairedetail_relevebancaire);
        return $this;
    }

    public function getRelevebancairedetail_libelle() {
        return $this->relevebancairedetail_libelle;
    }

    public function setRelevebancairedetail_libelle($relevebancairedetail_libelle) {
        $this->relevebancairedetail_libelle = $relevebancairedetail_libelle;
        return $this;
    }

    public function getRelevebancairedetail_numero() {
        return $this->relevebancairedetail_numero;
    }

    public function setRelevebancairedetail_numero($relevebancairedetail_numero) {
        $this->relevebancairedetail_numero = $relevebancairedetail_numero;
        return $this;
    }

    public function getRelevebancairedetail_date() {
        return $this->relevebancairedetail_date;
    }

    public function setRelevebancairedetail_date($relevebancairedetail_date) {
        $this->relevebancairedetail_date = $relevebancairedetail_date;
        return $this;
    }

    public function getRelevebancairedetail_montant() {
        return $this->relevebancairedetail_montant;
    }

    public function setRelevebancairedetail_montant($relevebancairedetail_montant) {
        $this->relevebancairedetail_montant = $relevebancairedetail_montant;
        return $this;
    }

    public function getRelevebancairedetail_date_valeur() {
        return $this->relevebancairedetail_date_valeur;
    }

    public function setRelevebancairedetail_date_valeur($relevebancairedetail_date_valeur) {
        $this->relevebancairedetail_date_valeur = $relevebancairedetail_date_valeur;
        return $this;
    }


}

?>
