<?php

/**
 * Description of EuFn
 *
 * @author user
 */
class Application_Model_EuFn {

    //put your code here
    protected $id_fn;
    protected $code_capa;
    protected $type_fn;
    protected $montant;
    protected $entree;
    protected $sortie;
    protected $solde;
    protected $mt_solde;
    protected $date_fn;
    protected $code_smcipn;
    protected $code_domicilier;
    protected $origine_fn;
    
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

    public function getId_fn() {
        return $this->id_fn;
    }

    public function setId_fn($id_fn) {
        $this->id_fn = $id_fn;
        return $this;
    }
    
    public function getCode_capa() {
        return $this->code_capa;
    }

    public function setCode_capa($code_capa) {
        $this->code_capa = $code_capa;
        return $this;
    }

    public function getType_fn() {
        return $this->type_fn;
    }

    public function setType_fn($type_fn) {
        $this->type_fn = $type_fn;
        return $this;
    }
    
    public function getMontant(){
        return $this->montant;
    }
    
    public function setMontant($montant){
        $this->montant = $montant;
        return $this;
    }
    
    public function getEntree(){
        return $this->entree;
    }
    
    public function setEntree($entree){
        $this->entree = $entree;
        return $this;
    }
    
    public function getSortie(){
        return $this->sortie;
    }
    
    public function setSortie($sortie){
        $this->sortie = $sortie;
        return $this;
    }
    
    public function getSolde(){
        return $this->solde;
    }
    
    public function setSolde($solde){
        $this->solde = $solde;
        return $this;
    }
    
    public function getMt_solde(){
        return $this->mt_solde;
    }
    
    public function setMt_solde($mt_solde){
        $this->mt_solde = $mt_solde;
        return $this;
    }
    
    public function getDate_fn(){
        return $this->date_fn;
    }
    
    public function setDate_fn($date_fn){
        $this->date_fn = $date_fn;
        return $this;
    }

    public function getCode_smcipn() {
        return $this->code_smcipn;
    }

    public function setCode_smcipn($code_smcipn) {
        $this->code_smcipn = $code_smcipn;
        return $this;
    }

    public function getCode_domicilier() {
        return $this->code_domicilier;
    }

    public function setCode_domicilier($code_domicilier) {
        $this->code_domicilier = $code_domicilier;
        return $this;
    }

    public function getOrigine_fn() {
        return $this->origine_fn;
    }

    public function setOrigine_fn($origine_fn) {
        $this->origine_fn = $origine_fn;
        return $this;
    }
}

?>
