<?php

class Application_Model_EuOffreDemandeCloture {

    //put your code here
    protected $id_cloture;
    protected $id_offre;
    protected $id_demande;
    protected $cloture;
    protected $date_cloture;
    protected $montant_offre;
    protected $montant_demande;
    protected $id_credit_offre;
    protected $id_credit_demande;
    protected $code_membre_offre;
    protected $code_membre_demande;
    protected $code_compte_offre;
    protected $code_compte_demande;
    protected $cloture_membre;
    protected $num_offre_demande;
    protected $code_sms_offre;
    protected $code_sms_demande;

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

    public function getId_cloture() {
        return $this->id_cloture;
    }

    public function setId_cloture($id_cloture) {
        $this->id_cloture = $id_cloture;
        return $this;
    }

    public function getId_offre() {
        return $this->id_offre;
    }

    public function setId_offre($id_offre) {
        $this->id_offre = $id_offre;
        return $this;
    }

    public function getId_demande() {
        return $this->id_demande;
    }

    public function setId_demande($id_demande) {
        $this->id_demande = $id_demande;
        return $this;
    }

    public function getCloture() {
        return $this->cloture;
    }

    public function setCloture($cloture) {
        $this->cloture = $cloture;
        return $this;
    }
	
    public function getDate_cloture() {
        return $this->date_cloture;
    }

    public function setDate_cloture($date_cloture) {
        $this->date_cloture = $date_cloture;
        return $this;
    }

    public function getMontant_offre() {
        return $this->montant_offre;
    }

    public function setMontant_offre($montant_offre) {
        $this->montant_offre = $montant_offre;
        return $this;
    }

    public function getMontant_demande() {
        return $this->montant_demande;
    }

    public function setMontant_demande($montant_demande) {
        $this->montant_demande = $montant_demande;
        return $this;
    }
	
    public function getId_credit_offre() {
        return $this->id_credit_offre;
    }

    public function setId_credit_offre($id_credit_offre) {
        $this->id_credit_offre = $id_credit_offre;
        return $this;
    }

    public function getId_credit_demande() {
        return $this->id_credit_demande;
    }

    public function setId_credit_demande($id_credit_demande) {
        $this->id_credit_demande = $id_credit_demande;
        return $this;
    }

    public function getCode_membre_offre() {
        return $this->code_membre_offre;
    }

    public function setCode_membre_offre($code_membre_offre) {
        $this->code_membre_offre = $code_membre_offre;
        return $this;
    }

    public function getCode_membre_demande() {
        return $this->code_membre_demande;
    }

    public function setCode_membre_demande($code_membre_demande) {
        $this->code_membre_demande = $code_membre_demande;
        return $this;
    }

    public function getCode_compte_offre() {
        return $this->code_compte_offre;
    }

    public function setCode_compte_offre($code_compte_offre) {
        $this->code_compte_offre = $code_compte_offre;
        return $this;
    }

    public function getCode_compte_demande() {
        return $this->code_compte_demande;
    }

    public function setCode_compte_demande($code_compte_demande) {
        $this->code_compte_demande = $code_compte_demande;
        return $this;
    }
	
    public function getCloture_membre() {
        return $this->cloture_membre;
    }

    public function setCloture_membre($cloture_membre) {
        $this->cloture_membre = $cloture_membre;
        return $this;
    }
	
    public function getNum_offre_demande() {
        return $this->num_offre_demande;
    }

    public function setNum_offre_demande($num_offre_demande) {
        $this->num_offre_demande = $num_offre_demande;
        return $this;
    }
	
    public function getCode_sms_offre() {
        return $this->code_sms_offre;
    }

    public function setCode_sms_offre($code_sms_offre) {
        $this->code_sms_offre = $code_sms_offre;
        return $this;
    }

    public function getCode_sms_demande() {
        return $this->code_sms_demande;
    }

    public function setCode_sms_demande($code_sms_demande) {
        $this->code_sms_demande = $code_sms_demande;
        return $this;
    }
	
	
}

?>
