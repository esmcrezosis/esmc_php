<?php
class Application_Model_EuDetailCompteMf107 {

    protected $id_detail_compte_mf107;
    protected $code_compte;
    protected $date_detail;
    protected $montant_rep;
    protected $cumul;
    protected $numident;
    protected $pourcentage;
    protected $id_utilisateur;
    protected $etat_detail_compte;
    protected $creditcode;


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
	
	function getId_detail_compte_mf107() {
        return $this->id_detail_compte_mf107;
    }

    function setId_detail_compte_mf107($id_detail_compte_mf107) {
        $this->id_detail_compte_mf107 = $id_detail_compte_mf107;
        return $this;
    }
	
	function getCode_compte() {
        return $this->code_compte;
    }

    function setCode_compte($code_compte) {
        $this->code_compte = $code_compte;
        return $this;
    }

	function getDate_detail() {
        return $this->date_detail;
    }

    function setDate_detail($date_detail) {
        $this->date_detail = $date_detail;
        return $this;
    }
	
	function getMontant_rep() {
        return $this->montant_rep;
    }

    function setMontant_rep($montant_rep) {
        $this->montant_rep = $montant_rep;
        return $this;
    }
	function getCumul() {
        return $this->cumul;
    }

    function setCumul($cumul) {
        $this->cumul = $cumul;
        return $this;
    }
    
	function getNumident() {
        return $this->numident;
    }

    function setNumident($numident) {
        $this->numident = $numident;
        return $this;
    }
	
	function getPourcentage() {
        return $this->pourcentage;
    }

    function setPourcentage($pourcentage) {
        $this->pourcentage = $pourcentage;
        return $this;
    }
	function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
	
	function getEtat_detail_compte() {
        return $this->etat_detail_compte;
    }

    function setEtat_detail_compte($etat_detail_compte) {
        $this->etat_detail_compte = $etat_detail_compte;
        return $this;
    }
	
	function getCreditcode() {
        return $this->creditcode;
    }

    function setCreditcode($creditcode) {
        $this->creditcode = $creditcode;
        return $this;
    }	

}
?>