<?php
 
class Application_Model_EuBonNeutre {

    //put your code here
    protected $bon_neutre_id;
    protected $bon_neutre_code;
    protected $bon_neutre_montant;
    protected $bon_neutre_montant_utilise;
    protected $bon_neutre_type;
    protected $bon_neutre_code_membre;
    protected $bon_neutre_montant_solde;
    protected $bon_neutre_date;
    protected $bon_neutre_nom;
    protected $bon_neutre_prenom;
    protected $bon_neutre_mobile;
    protected $bon_neutre_email;
    protected $bon_neutre_codebarre;
    protected $bon_neutre_raison;

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

    public function getBon_neutre_id() {
        return $this->bon_neutre_id;
    }

    public function setBon_neutre_id($bon_neutre_id) {
        $this->bon_neutre_id = $bon_neutre_id;
        return $this;
    }

    public function getBon_neutre_type() {
        return $this->bon_neutre_type;
    }

    public function setBon_neutre_type($bon_neutre_type) {
        $this->bon_neutre_type = $bon_neutre_type;
        return $this;
    }

    public function getBon_neutre_montant() {
        return $this->bon_neutre_montant;
    }

    public function setBon_neutre_montant($bon_neutre_montant) {
        $this->bon_neutre_montant = $bon_neutre_montant;
        return $this;
    }

    public function getBon_neutre_code() {
        return ($this->bon_neutre_code);
    }

    public function setBon_neutre_code($bon_neutre_code) {
        $this->bon_neutre_code = ($bon_neutre_code);
        return $this;
    }

    public function getBon_neutre_code_membre() {
        return $this->bon_neutre_code_membre;
    }

    public function setBon_neutre_code_membre($bon_neutre_code_membre) {
        $this->bon_neutre_code_membre = $bon_neutre_code_membre;
        return $this;
    }

    public function getBon_neutre_montant_solde() {
        return $this->bon_neutre_montant_solde;
    }

    public function setBon_neutre_montant_solde($bon_neutre_montant_solde) {
        $this->bon_neutre_montant_solde = $bon_neutre_montant_solde;
        return $this;
    }

    public function getBon_neutre_date() {
        return $this->bon_neutre_date;
    }

    public function setBon_neutre_date($bon_neutre_date) {
        $this->bon_neutre_date = $bon_neutre_date;
        return $this;
    }


    public function getBon_neutre_montant_utilise() {
        return $this->bon_neutre_montant_utilise;
    }

    public function setBon_neutre_montant_utilise($bon_neutre_montant_utilise) {
        $this->bon_neutre_montant_utilise = $bon_neutre_montant_utilise;
        return $this;
    }


    public function getBon_neutre_nom() {
        return htmlentities($this->bon_neutre_nom);
    }

    public function setBon_neutre_nom($bon_neutre_nom) {
        $this->bon_neutre_nom = html_entity_decode($bon_neutre_nom);
        return $this;
    }

    public function getBon_neutre_prenom() {
        return htmlentities($this->bon_neutre_prenom);
    }

    public function setBon_neutre_prenom($bon_neutre_prenom) {
        $this->bon_neutre_prenom = html_entity_decode($bon_neutre_prenom);
        return $this;
    }

    public function getBon_neutre_mobile() {
        return $this->bon_neutre_mobile;
    }

    public function setBon_neutre_mobile($bon_neutre_mobile) {
        $this->bon_neutre_mobile = $bon_neutre_mobile;
        return $this;
    }

    public function getBon_neutre_email() {
        return htmlentities($this->bon_neutre_email);
    }

    public function setBon_neutre_email($bon_neutre_email) {
        $this->bon_neutre_email = html_entity_decode($bon_neutre_email);
        return $this;
    }

    public function getBon_neutre_raison() {
        return htmlentities($this->bon_neutre_raison);
    }

    public function setBon_neutre_raison($bon_neutre_raison) {
        $this->bon_neutre_raison = html_entity_decode($bon_neutre_raison);
        return $this;
    }

    public function getBon_neutre_codebarre() {
        return htmlentities($this->bon_neutre_codebarre);
    }

    public function setBon_neutre_codebarre($bon_neutre_codebarre) {
        $this->bon_neutre_codebarre = html_entity_decode($bon_neutre_codebarre);
        return $this;
    }

}

?>
