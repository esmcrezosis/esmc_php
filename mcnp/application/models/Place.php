<?php
 
class Application_Model_EuAcheteur {

    //put your code here
    protected $num;
    protected $membre;
    protected $montant;
    protected $lib;
    protected $datedepot;
    protected $agence;
    protected $heureid;
    protected $cais;
    

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
	
    public function getNum() {
        return $this->num;
    }

    public function setNum($num) {
        $this->num = $num;
        return $this;
    }

    public function getMembre() {
        return $this->membre;
    }

    public function setMembre($membre) {
        $this->membre = $membre;
        return $this;
    }
	
    public function getMontant() {
        return $this->montant;
    }

    public function setMontant($montant) {
        $this->montant = $montant;
        return $this;
    }


    public function getLib() {
        return $this->lib;
    }

    public function setLib($lib) {
        $this->lib = $lib;
        return $this;
    }
    protected $cais;
	
	
    public function getDatedepot() {
        return $this->datedepot;
    }

    public function setDatedepot($datedepot) {
        $this->datedepot = $datedepot;
        return $this;
    }

    public function getAgence() {
        return $this->agence;
    }

    public function setAgence($agence) {
        $this->agence = $agence;
        return $this;
    }

    public function getHeureid() {
        return $this->heureid;
    }

    public function setHeureid($heureid) {
        $this->heureid = $heureid;
        return $this;
    }

    public function getCais() {
        return $this->cais;
    }

    public function setCais($cais) {
        $this->cais = $cais;
        return $this;
    }

}

?>
