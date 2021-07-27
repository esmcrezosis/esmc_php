<?php
 
class Application_Model_EuDetailTpagcp {

    //put your code here
    protected $id_tpagcp;
    protected $code_tegc;
    protected $montant;

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

    public function getId_tpagcp() {
        return $this->id_tpagcp;
    }

    public function setId_tpagcp($id_tpagcp) {
        $this->id_tpagcp = $id_tpagcp;
        return $this;
    }

    public function getCode_tegc() {
        return $this->code_tegc;
    }

    public function setCode_tegc($code_tegc) {
        $this->code_tegc = $code_tegc;
        return $this;
    }

    public function getMontant() {
        return $this->montant;
    }

    public function setMontant($montant) {
        $this->montant = $montant;
        return $this;
    }


}

?>
