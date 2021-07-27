<?php
 
class Application_Model_EuBanApproDetail {

    //put your code here
    protected $ban_appro_detail_id;
    protected $association_id;
    protected $membreasso_id;
    protected $bon_neutre_appro_id;
    protected $ban_appro_detail_montant;
    protected $ban_appro_detail_commission;
    protected $ban_appro_detail_date;
    protected $payer;

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

    public function getBan_appro_detail_id() {
        return $this->ban_appro_detail_id;
    }

    public function setBan_appro_detail_id($ban_appro_detail_id) {
        $this->ban_appro_detail_id = $ban_appro_detail_id;
        return $this;
    }

    public function getBon_neutre_appro_id() {
        return $this->bon_neutre_appro_id;
    }

    public function setBon_neutre_appro_id($bon_neutre_appro_id) {
        $this->bon_neutre_appro_id = $bon_neutre_appro_id;
        return $this;
    }

    public function getMembreasso_id() {
        return $this->membreasso_id;
    }

    public function setMembreasso_id($membreasso_id) {
        $this->membreasso_id = $membreasso_id;
        return $this;
    }

    public function getPayer() {
        return $this->payer;
    }

    public function setPayer($payer) {
        $this->payer = $payer;
        return $this;
    }

    public function getAssociation_id() {
        return ($this->association_id);
    }

    public function setAssociation_id($association_id) {
        $this->association_id = ($association_id);
        return $this;
    }

    public function getBan_appro_detail_montant() {
        return $this->ban_appro_detail_montant;
    }

    public function setBan_appro_detail_montant($ban_appro_detail_montant) {
        $this->ban_appro_detail_montant = $ban_appro_detail_montant;
        return $this;
    }

    public function getBan_appro_detail_commission() {
        return $this->ban_appro_detail_commission;
    }

    public function setBan_appro_detail_commission($ban_appro_detail_commission) {
        $this->ban_appro_detail_commission = $ban_appro_detail_commission;
        return $this;
    }

    public function getBan_appro_detail_date() {
        return $this->ban_appro_detail_date;
    }

    public function setBan_appro_detail_date($ban_appro_detail_date) {
        $this->ban_appro_detail_date = $ban_appro_detail_date;
        return $this;
    }


}

?>
