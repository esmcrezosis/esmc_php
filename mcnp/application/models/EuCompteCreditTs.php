<?php

class Application_Model_EuCompteCreditTs {

    protected $id_credit;
    protected $code_membre;
    protected $montant;
    protected $source;
    protected $code_compte;
    protected $id_operation;
    protected $datedeb;
    protected $datefin;
    protected $id_codebarre;
    protected $code_produit;
    protected $code_type_credit;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

	
	
    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid credit property');
        }
        $this->$method($value);
    }

	
	
    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid credit property');
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

    function getId_credit() {
        return $this->id_credit;
    }

    function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }

    function getMontant() {
        return $this->montant;
    }

    function setMontant($montant) {
        $this->montant = $montant;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    function getSource() {
        return $this->source;
    }

    function setSource($source) {
        $this->source = $source;
        return $this;
    }

    function getCode_compte() {
        return $this->code_compte;
    }

    function setCode_compte($code_compte) {
        $this->code_compte = $code_compte;
        return $this;
    }

    function getId_operation() {
        return $this->id_operation;
    }

    function setId_operation($id_operation) {
        $this->id_operation = $id_operation;
        return $this;
    }

    function getDatedeb() {
        return $this->datedeb;
    }

    function setDatedeb($datedeb) {
        $this->datedeb = $datedeb;
        return $this;
    }

    function getDatefin() {
        return $this->datefin;
    }

    function setDatefin($datefin) {
        $this->datefin = $datefin;
        return $this;
    }

    function getId_codebarre() {
        return $this->id_codebarre;
    }

    function setId_codebarre($id_codebarre) {
        $this->id_codebarre = $id_codebarre;
        return $this;
    }

    function getCode_produit() {
        return $this->code_produit;
    }

    function setCode_produit($code_produit) {
        $this->code_produit = $code_produit;
        return $this;
    }

    function getCode_type_credit() {
        return $this->code_type_credit;
    }

    function setCode_type_credit($code_type_credit) {
        $this->code_type_credit = $code_type_credit;
        return $this;
    }
	
}

