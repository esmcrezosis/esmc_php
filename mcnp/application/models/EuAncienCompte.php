<?php

class Application_Model_EuAncienCompte {
    
    protected $code_compte;
    protected $code_membre;
    protected $solde;
    protected $lib_compte;
    protected $numero_carte;
    protected $date_alloc;
    protected $desactiver;
    protected $code_type_compte;
    protected $code_cat;
    protected $MifareCard;
    protected $CardPrintedDate;
    protected $CardPrintedIDDate;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
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

    function getCode_compte() {
        return $this->code_compte;
    }

    function setCode_compte($code_compte) {
        $this->code_compte = $code_compte;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
    
    function getSolde(){
        return $this->solde;
    }
    
    function setSolde($solde){
        $this->solde = $solde;
        return $this;
    }

    function getLib_compte() {
        return $this->lib_compte;
    }

    function setLib_compte($lib_compte) {
        $this->lib_compte = (string) $lib_compte;
        return $this;
    }

    function getNumero_carte() {
        return $this->numero_carte;
    }

    function setNumero_carte($numero_carte) {
        $this->numero_carte = $numero_carte;
        return $this;
    }

    function getDate_alloc() {
        return $this->date_alloc;
    }

    function setDate_alloc($date_alloc) {
        $this->date_alloc = $date_alloc;
        return $this;
    }

    function getDesactiver() {
        return $this->desactiver;
    }

    function setDesactiver($desactiver) {
        $this->desactiver = $desactiver;
        return $this;
    }

    function getCode_cat() {
        return $this->code_cat;
    }

    function setCode_cat($code_cat) {
        $this->code_cat = $code_cat;
        return $this;
    }
    
    function getCode_type_compte() {
        return $this->code_type_compte;
    }

    function setCode_type_compte($code_type_compte) {
        $this->code_type_compte = $code_type_compte;
        return $this;
    }
	
	public function getMifareCard() {
        return $this->MifareCard;
    }

    public function setMifareCard($MifareCard) {
        $this->MifareCard = $MifareCard;
        return $this;
    }

    public function getCardPrintedDate() {
        return $this->CardPrintedDate;
    }

    public function setCardPrintedDate($CardPrintedDate) {
        $this->CardPrintedDate = $CardPrintedDate;
        return $this;
    }
    
    public function getCardPrintedIDDate() {
        return $this->CardPrintedIDDate;
    }

    public function setCardPrintedIDDate($CardPrintedIDDate) {
        $this->CardPrintedIDDate = $CardPrintedIDDate;
        return $this;
    }

    
}

