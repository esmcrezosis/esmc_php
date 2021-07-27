<?php
 
class Application_Model_EuMscm {

    //put your code here
    protected $id_mscm;
    protected $credit_mscm;
    protected $debit_numero;
    protected $solde_mscm;
    

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

    public function getId_mscm() {
      return $this->id_mscm;
    }

    public function setId_mscm($id_mscm) {
        $this->id_mscm = $id_mscm;
        return $this;
    }
	
    public function getCredit_mscm() {
        return $this->credit_mscm;
    }

    public function setCredit_mscm($credit_mscm) {
        $this->credit_mscm = $credit_mscm;
        return $this;
    }


    public function getDebit_mscm() {
        return $this->debit_mscm;
    }

    public function setDebit_mscm($debit_mscm) {
        $this->debit_mscm = $debit_mscm;
        return $this;
    }
	
    public function getSolde_mscm() {
        return $this->solde_mscm;
    }

    public function setSolde_mscm($solde_mscm) {
        $this->solde_mscm = $solde_mscm;
        return $this;
    }

    

}

?>
