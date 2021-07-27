<?php
 
class Application_Model_EuRecu {

    //put your code here
    protected $recu_id;
    protected $recu_numero;
    protected $recu_montant;
    protected $recu_montant_credit;
    protected $recu_bps;
    protected $recu_code_membre;
    protected $recu_utilisateur;
    protected $recu_date;
    protected $recu_date_debut;
    protected $recu_date_fin;
    protected $recu_facture;
    protected $publier;

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

    public function getRecu_id() {
        return $this->recu_id;
    }

    public function setRecu_id($recu_id) {
        $this->recu_id = $recu_id;
        return $this;
    }

    public function getRecu_bps() {
        return $this->recu_bps;
    }

    public function setRecu_bps($recu_bps) {
        $this->recu_bps = $recu_bps;
        return $this;
    }

    public function getRecu_montant() {
        return $this->recu_montant;
    }

    public function setRecu_montant($recu_montant) {
        $this->recu_montant = $recu_montant;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getRecu_numero() {
        return ($this->recu_numero);
    }

    public function setRecu_numero($recu_numero) {
        $this->recu_numero = ($recu_numero);
        return $this;
    }

    public function getRecu_code_membre() {
        return $this->recu_code_membre;
    }

    public function setRecu_code_membre($recu_code_membre) {
        $this->recu_code_membre = $recu_code_membre;
        return $this;
    }

    public function getRecu_utilisateur() {
        return $this->recu_utilisateur;
    }

    public function setRecu_utilisateur($recu_utilisateur) {
        $this->recu_utilisateur = $recu_utilisateur;
        return $this;
    }

    public function getRecu_date() {
        return $this->recu_date;
    }

    public function setRecu_date($recu_date) {
        $this->recu_date = $recu_date;
        return $this;
    }


    public function getRecu_montant_credit() {
        return $this->recu_montant_credit;
    }

    public function setRecu_montant_credit($recu_montant_credit) {
        $this->recu_montant_credit = $recu_montant_credit;
        return $this;
    }

    public function getRecu_date_debut() {
        return $this->recu_date_debut;
    }

    public function setRecu_date_debut($recu_date_debut) {
        $this->recu_date_debut = $recu_date_debut;
        return $this;
    }

    public function getRecu_date_fin() {
        return $this->recu_date_fin;
    }

    public function setRecu_date_fin($recu_date_fin) {
        $this->recu_date_fin = $recu_date_fin;
        return $this;
    }

    public function getRecu_facture() {
        return $this->recu_facture;
    }

    public function setRecu_facture($recu_facture) {
        $this->recu_facture = $recu_facture;
        return $this;
    }


}

?>
