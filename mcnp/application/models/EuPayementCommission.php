<?php
 
class Application_Model_EuPayementCommission {

    //put your code here
    protected $payement_commission_id;
    protected $payement_commission_montant;
    protected $payement_commission_demande;
    protected $payement_commission_date_demande;
    protected $payement_commission_payer;
    protected $payement_commission_date_payer;
    protected $payement_commission_date_debut;
    protected $membreasso_id;
    protected $id_type_commission;
    protected $id_mode_payement;
    protected $payement_commission_type;

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

    public function getPayement_commission_id() {
        return $this->payement_commission_id;
    }

    public function setPayement_commission_id($payement_commission_id) {
        $this->payement_commission_id = $payement_commission_id;
        return $this;
    }

    public function getPayement_commission_date_demande() {
        return $this->payement_commission_date_demande;
    }

    public function setPayement_commission_date_demande($payement_commission_date_demande) {
        $this->payement_commission_date_demande = $payement_commission_date_demande;
        return $this;
    }

    public function getPayement_commission_demande() {
        return $this->payement_commission_demande;
    }

    public function setPayement_commission_demande($payement_commission_demande) {
        $this->payement_commission_demande = $payement_commission_demande;
        return $this;
    }

    public function getPayement_commission_montant() {
        return ($this->payement_commission_montant);
    }

    public function setPayement_commission_montant($payement_commission_montant) {
        $this->payement_commission_montant = ($payement_commission_montant);
        return $this;
    }

    public function getPayement_commission_payer() {
        return $this->payement_commission_payer;
    }

    public function setPayement_commission_payer($payement_commission_payer) {
        $this->payement_commission_payer = $payement_commission_payer;
        return $this;
    }

    public function getPayement_commission_date_payer() {
        return $this->payement_commission_date_payer;
    }

    public function setPayement_commission_date_payer($payement_commission_date_payer) {
        $this->payement_commission_date_payer = $payement_commission_date_payer;
        return $this;
    }

    public function getPayement_commission_date_debut() {
        return $this->payement_commission_date_debut;
    }

    public function setPayement_commission_date_debut($payement_commission_date_debut) {
        $this->payement_commission_date_debut = $payement_commission_date_debut;
        return $this;
    }

    public function getPayement_commission_date_fin() {
        return $this->payement_commission_date_fin;
    }

    public function setPayement_commission_date_fin($payement_commission_date_fin) {
        $this->payement_commission_date_fin = $payement_commission_date_fin;
        return $this;
    }


    public function getMembreasso_id() {
        return $this->membreasso_id;
    }

    public function setMembreasso_id($membreasso_id) {
        $this->membreasso_id = $membreasso_id;
        return $this;
    }

    public function getId_type_commission() {
        return $this->id_type_commission;
    }

    public function setId_type_commission($id_type_commission) {
        $this->id_type_commission = $id_type_commission;
        return $this;
    }

    public function getId_mode_payement() {
        return $this->id_mode_payement;
    }

    public function setId_mode_payement($id_mode_payement) {
        $this->id_mode_payement = $id_mode_payement;
        return $this;
    }

    public function getPayement_commission_type() {
        return $this->payement_commission_type;
    }

    public function setPayement_commission_type($payement_commission_type) {
        $this->payement_commission_type = $payement_commission_type;
        return $this;
    }


}

?>
