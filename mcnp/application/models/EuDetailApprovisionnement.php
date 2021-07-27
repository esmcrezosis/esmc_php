<?php
 
class Application_Model_EuDetailApprovisionnement {

    //put your code here
    protected $id_detail_approvisionnement;
    protected $id_approvisionnement;
	protected $id_credit;
    protected $code_compte;
    protected $montant_detail_approvisionnement;

	
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
	
	
    public function getId_detail_approvisionnement() {
        return $this->id_detail_approvisionnement;
    }

    public function setId_detail_approvisionnement($id_detail_approvisionnement) {
        $this->id_detail_approvisionnement = $id_detail_approvisionnement;
        return $this;
    }

    public function getId_approvisionnement() {
        return $this->id_approvisionnement;
    }

    public function setId_approvisionnement($id_approvisionnement) {
        $this->id_approvisionnement = $id_approvisionnement;
        return $this;
    }
	
    public function getId_credit() {
        return $this->id_credit;
    }

    public function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }
	
	
    public function getCode_compte() {
        return $this->code_compte;
    }

    public function setCode_compte($code_compte) {
        $this->code_compte = $code_compte;
        return $this;
    }
	
    public function getMontant_detail_approvisionnement() {
        return $this->montant_detail_approvisionnement;
    }

    public function setMontant_detail_approvisionnement($montant_detail_approvisionnement) {
        $this->montant_detail_approvisionnement = $montant_detail_approvisionnement;
        return $this;
    }
  

}

?>
