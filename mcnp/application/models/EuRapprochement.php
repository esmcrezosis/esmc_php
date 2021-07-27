<?php

class Application_Model_EuRapprochement {

    //put your code here
    protected $id_rappro;
    protected $debit_rappro;
    protected $credit_rappro;
    protected $solde_rappro;
    protected $source_credit;
    protected $source;
    protected $code_smcipn;
    protected $code_smcipnp;
    protected $code_domicilier;
    protected $id_credit;
    protected $type_rappro;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
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

    public function getId_rappro() {
        return $this->id_rappro;
    }

    public function setId_rappro($id_rappro) {
        $this->id_rappro = $id_rappro;
        return $this;
    }

    public function getDebit_rappro() {
        return $this->debit_rappro;
    }

    public function setDebit_rappro($debit_rappro) {
        $this->debit_rappro = $debit_rappro;
        return $this;
    }

    public function getCredit_rappro() {
        return $this->credit_rappro;
    }

    public function setCredit_rappro($credit_rappro) {
        $this->credit_rappro = $credit_rappro;
        return $this;
    }

    public function getSolde_rappro() {
        return $this->solde_rappro;
    }

    public function setSolde_rappro($solde_rappro) {
        $this->solde_rappro = $solde_rappro;
        return $this;
    }

    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
        return $this;
    }

    public function getSource_credit() {
        return $this->source_credit;
    }

    public function setSource_credit($source_credit) {
        $this->source_credit = $source_credit;
        return $this;
    }

    public function getCode_smcipn() {
        return $this->code_smcipn;
    }

    public function setCode_smcipn($code_smcipn) {
        $this->code_smcipn = $code_smcipn;
        return $this;
    }

    public function getCode_smcipnp() {
        return $this->code_smcipnp;
    }

    public function setCode_smcipnp($code_smcipnp) {
        $this->code_smcipnp = $code_smcipnp;
        return $this;
    }

    public function getCode_domicilier() {
        return $this->code_domicilier;
    }

    public function setCode_domicilier($code_domicilier) {
        $this->code_domicilier = $code_domicilier;
        return $this;
    }

    public function getId_credit() {
        return $this->id_credit;
    }

    public function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }
    
    public function getType_rappro() {
        return $this->type_rappro;
    }

    public function setType_rappro($type_rappro) {
        $this->type_rappro = $type_rappro;
        return $this;
    }

}

?>
