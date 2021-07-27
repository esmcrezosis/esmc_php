<?php
class Application_Model_EuProforma {

    protected $code_proforma;
    protected $date_proforma;
    protected $date_livre;
    protected $lieu_livre;
    protected $delai_valid;
    protected $date_paie;
    protected $montant_ht;
    protected $id_besoin;
    protected $code_membre_fournisseur;
    protected $id_utilisateur;
    protected $type_proforma;
	protected $id_taxe;
    
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

    function getCode_proforma(){
        return $this->code_proforma;
    }

    function setCode_proforma($code_proforma) {
        $this->code_proforma = $code_proforma;
        return $this;
    }
	
    function getDate_proforma(){
        return $this->date_proforma;
    }
    function setDate_proforma($date_proforma){
        $this->date_proforma = $date_proforma;
        return $this;
    }
    
    function getDate_livre(){
        return $this->date_livre;
    } 
    function setDate_livre($date_livre){
        $this->date_livre = $date_livre;
        return $this;
    }
	
    function getLieu_livre() {
        return $this->lieu_livre;
    }
    function setLieu_livre($lieu_livre) {
        $this->lieu_livre = (string) $lieu_livre;
        return $this;
    }
	
     function getDelai_valid() {
        return $this->delai_valid;
    }
    function setDelai_valid($delai_valid) {
        $this->delai_valid = $delai_valid;
        return $this;
    }

    function getDate_paie() {
        return $this->date_paie;
    }

    function setDate_paie($date_paie) {
        $this->date_paie = $date_paie;
        return $this;
    }
	
    function getMontant_ht() {
        return $this->montant_ht;
    }
    function setMontant_ht($montant_ht) {
        $this->montant_ht = $montant_ht;
        return $this;
    }
    
    function getId_besoin() {
        return $this->id_besoin;
    }
    function setId_besoin($id_besoin) {
        $this->id_besoin = $id_besoin;
        return $this;
    }
	
    function getCode_membre_fournisseur() {
        return $this->code_membre_fournisseur;
    }
	
    function setCode_membre_fournisseur($code_membre_fournisseur) {
        $this->code_membre_fournisseur = $code_membre_fournisseur;
        return $this;
    }
	
    function getId_utilisateur() {
        return $this->id_utilisateur;
    }
    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
    
    function getType_proforma() {
        return $this->type_proforma;
    }
    function setType_proforma($type_proforma) {
        $this->type_proforma = $type_proforma;
        return $this;
    }
	function getId_taxe() {
        return $this->id_taxe;
    }
    function setId_taxe($id_taxe) {
        $this->id_taxe = $id_taxe;
        return $this;
    }
    
    
}
