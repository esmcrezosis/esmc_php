<?php
 
class Application_Model_EuRelevesmsdetail {

    //put your code here
    protected $relevesmsdetail_id;
    protected $relevesmsdetail_relevesms;
    protected $relevesmsdetail_libelle;
    protected $relevesmsdetail_numero;
    protected $relevesmsdetail_date;
    protected $publier;
    protected $relevesmsdetail_montant;
    protected $relevesmsdetail_date_valeur;

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

    public function getRelevesmsdetail_id() {
        return $this->relevesmsdetail_id;
    }

    public function setRelevesmsdetail_id($relevesmsdetail_id) {
        $this->relevesmsdetail_id = $relevesmsdetail_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getRelevesmsdetail_relevesms() {
        return ($this->relevesmsdetail_relevesms);
    }

    public function setRelevesmsdetail_relevesms($relevesmsdetail_relevesms) {
        $this->relevesmsdetail_relevesms = ($relevesmsdetail_relevesms);
        return $this;
    }

    public function getRelevesmsdetail_libelle() {
        return $this->relevesmsdetail_libelle;
    }

    public function setRelevesmsdetail_libelle($relevesmsdetail_libelle) {
        $this->relevesmsdetail_libelle = $relevesmsdetail_libelle;
        return $this;
    }

    public function getRelevesmsdetail_numero() {
        return $this->relevesmsdetail_numero;
    }

    public function setRelevesmsdetail_numero($relevesmsdetail_numero) {
        $this->relevesmsdetail_numero = $relevesmsdetail_numero;
        return $this;
    }

    public function getRelevesmsdetail_date() {
        return $this->relevesmsdetail_date;
    }

    public function setRelevesmsdetail_date($relevesmsdetail_date) {
        $this->relevesmsdetail_date = $relevesmsdetail_date;
        return $this;
    }

    public function getRelevesmsdetail_montant() {
        return $this->relevesmsdetail_montant;
    }

    public function setRelevesmsdetail_montant($relevesmsdetail_montant) {
        $this->relevesmsdetail_montant = $relevesmsdetail_montant;
        return $this;
    }

    public function getRelevesmsdetail_date_valeur() {
        return $this->relevesmsdetail_date_valeur;
    }

    public function setRelevesmsdetail_date_valeur($relevesmsdetail_date_valeur) {
        $this->relevesmsdetail_date_valeur = $relevesmsdetail_date_valeur;
        return $this;
    }


}

?>
