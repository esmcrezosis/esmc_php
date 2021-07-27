<?php

class Application_Model_EuOffreDemande {

    //put your code here
    protected $id_offre_demande;
    protected $type_offre_demande;
    protected $date_offre_demande;
    protected $code_membre;
    protected $code_compte;
    protected $code_cat;
    protected $id_credit;
    protected $type_credit_of;
    protected $type_credit_de;
    protected $num_offre_demande;

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

    public function getId_offre_demande() {
        return $this->id_offre_demande;
    }

    public function setId_offre_demande($id_offre_demande) {
        $this->id_offre_demande = $id_offre_demande;
        return $this;
    }

    public function getDate_offre_demande() {
        return $this->date_offre_demande;
    }

    public function setDate_offre_demande($date_offre_demande) {
        $this->date_offre_demande = $date_offre_demande;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getType_offre_demande() {
        return $this->type_offre_demande;
    }

    public function setType_offre_demande($type_offre_demande) {
        $this->type_offre_demande = $type_offre_demande;
        return $this;
    }
    public function getType_credit_of() {
        return $this->type_credit_of;
    }

    public function setType_credit_of($type_credit_of) {
        $this->type_credit_of = $type_credit_of;
        return $this;
    }

    public function getType_credit_de() {
        return $this->type_credit_de;
    }

    public function setType_credit_de($type_credit_de) {
        $this->type_credit_de = $type_credit_de;
        return $this;
    }
	
    public function getNum_offre_demande() {
        return $this->num_offre_demande;
    }

    public function setNum_offre_demande($num_offre_demande) {
        $this->num_offre_demande = $num_offre_demande;
        return $this;
    }
	
    public function getCode_compte() {
        return $this->code_compte;
    }

    public function setCode_compte($code_compte) {
        $this->code_compte = $code_compte;
        return $this;
    }

    public function getCode_cat() {
        return $this->code_cat;
    }

    public function setCode_cat($code_cat) {
        $this->code_cat = $code_cat;
        return $this;
    }
	
    public function getId_credit() {
        return $this->id_credit;
    }

    public function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }

}

?>
