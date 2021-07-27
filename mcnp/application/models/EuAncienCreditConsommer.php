<?php
class Application_Model_EuAncienCreditConsommer
{

    protected $id_consommation;
    protected $id_operation;
    protected $id_credit;
    protected $code_membre;
	protected $code_membre_dist;
    protected $code_compte;
    protected $code_produit;
    protected $mont_consommation;
    protected $date_consommation;
    protected $heure_consommation;


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

    function getId_consommation(){
        return $this->id_consommation;
    }
    
    function setId_consommation($id_consommation){
        $this->id_consommation = $id_consommation;
        return $this;
    }
    
    function getId_operation(){
        return $this->id_operation;
    }
    
    function setId_operation($id_operation){
        $this->id_operation = $id_operation;
        return $this;
    }
    
    function getId_credit(){
        return $this->id_credit;
    }
    function setId_credit($id_credit){
        $this->id_credit = $id_credit;
        return $this;
    }
    
    function getCode_produit() {
        return $this->code_produit;
    }

    function setCode_produit($code_produit) {
        $this->code_produit = (string) $code_produit;
        return $this;
    }
    
    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = (string) $code_membre;
        return $this;
    }
	
	function getCode_membre_dist() {
        return $this->code_membre_dist;
    }

    function setCode_membre_dist($code_membre_dist) {
        $this->code_membre_dist = (string) $code_membre_dist;
        return $this;
    }
    
    function getMont_Consommation() {
        return $this->mont_consommation;
    }

    function setMont_consommation($mont_consommation) {
        $this->mont_consommation = $mont_consommation;
        return $this;
    }
    
    function getDate_consommation() {
        return $this->date_consommation;
    }

    function setDate_consommation($date_consommation) {
        $this->date_consommation = $date_consommation;
        return $this;
    }
    
    function getCode_compte(){
        return $this->code_compte;
    }
    
    function setCode_compte($code_compte){
        $this->code_compte = $code_compte;
        return $this;
    }
    
    function getHeure_consommation() {
        return $this->heure_consommation;
    }

    function setHeure_consommation($heure_consommation) {
        $this->heure_consommation = $heure_consommation;
        return $this;
    }
}