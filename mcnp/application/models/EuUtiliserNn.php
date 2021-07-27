<?php

class Application_Model_EuUtiliserNn {

    //put your code here
    protected $id_utiliser_nn;
    protected $code_membre_nn;
    protected $code_membre_nb;
    protected $mont_transfert;
    protected $date_transfert;
    protected $code_produit;
    protected $id_utilisateur;
    protected $code_sms;
    protected $num_bon;
    protected $id_operation;
    protected $code_produit_nn;
	protected $motif;

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

    public function getId_utiliser_nn() {
        return $this->id_utiliser_nn;
    }

    public function setId_utiliser_nn($id_utiliser_nn) {
        $this->id_utiliser_nn = $id_utiliser_nn;
        return $this;
    }

    public function getCode_membre_nb() {
        return $this->code_membre_nb;
    }

    public function setCode_membre_nb($code_membre_nb) {
        $this->code_membre_nb = $code_membre_nb;
        return $this;
    }

    public function getMont_transfert() {
        return $this->mont_transfert;
    }

    public function setMont_transfert($mont_transfert) {
        $this->mont_transfert = $mont_transfert;
        return $this;
    }

    public function getDate_transfert() {
        return $this->date_transfert;
    }

    public function setDate_transfert($date_transfert) {
        $this->date_transfert = $date_transfert;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getCode_produit() {
        return $this->code_produit;
    }

    public function setCode_produit($code_produit) {
        $this->code_produit = $code_produit;
        return $this;
    }

    public function getCode_membre_nn() {
        return $this->code_membre_nn;
    }

    public function setCode_membre_nn($code_membre_nn) {
        $this->code_membre_nn = $code_membre_nn;
        return $this;
    }

    public function getCode_sms() {
        return $this->code_sms;
    }

    public function setCode_sms($code_sms) {
        $this->code_sms = $code_sms;
        return $this;
    }
	
    public function getNum_bon() {
        return $this->num_bon;
    }

    public function setNum_bon($num_bon) {
        $this->num_bon = $num_bon;
        return $this;
    }
	
    public function getId_operation() {
        return $this->id_operation;
    }

    public function setId_operation($id_operation) {
        $this->id_operation = $id_operation;
        return $this;
    }
	
    public function getCode_produit_nn() {
        return $this->code_produit_nn;
    }

    public function setCode_produit_nn($code_produit_nn) {
        $this->code_produit_nn = $code_produit_nn;
        return $this;
    }
	
	public function getMotif() {
        return $this->motif;
    }

    public function setMotif($motif) {
        $this->motif = $motif;
        return $this;
    }
	
	
	
	
	
	
}

?>
