<?php

/**
 * Description of EuCapa
 *
 * @author user
 */
class Application_Model_EuCapa {

    //put your code here
    protected $code_capa;
    protected $code_membre;
    protected $type_capa;
    protected $montant_capa;
    protected $montant_utiliser;
    protected $montant_solde;
    protected $date_capa;
    protected $heure_capa;
    protected $id_operation;
    protected $code_compte;
    protected $etat_capa;
    protected $code_produit;
    protected $origine_capa;

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

    public function getCode_capa() {
        return $this->code_capa;
    }

    public function setCode_capa($code_capa) {
        $this->code_capa = $code_capa;
        return $this;
    }
    

    public function getId_operation() {
        return $this->id_operation;
    }

    public function setId_operation($id_operation) {
        $this->id_operation = $id_operation;
        return $this;
    }
    
    public function getType_capa() {
        return $this->type_capa;
    }

    public function setType_capa($type_capa) {
        $this->type_capa = $type_capa;
        return $this;
    }

    public function getDate_capa() {
        return $this->date_capa;
    }

    public function setDate_capa($date_capa) {
        $this->date_capa = $date_capa;
        return $this;
    }

    public function getHeure_capa() {
        return $this->heure_capa;
    }

    public function setHeure_capa($heure_capa) {
        $this->heure_capa = $heure_capa;
        return $this;
    }

    public function getMontant_capa() {
        return $this->montant_capa;
    }

    public function setMontant_capa($montant_capa) {
        $this->montant_capa = $montant_capa;
        return $this;
    }

    public function getMontant_utiliser() {
        return $this->montant_utiliser;
    }

    public function setMontant_utiliser($montant_utiliser) {
        $this->montant_utiliser = $montant_utiliser;
        return $this;
    }

    public function getMontant_solde() {
        return $this->montant_solde;
    }

    public function setMontant_solde($montant_solde) {
        $this->montant_solde = $montant_solde;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
    
    public function getCode_compte(){
        return $this->code_compte;
    }
    
    public function setCode_compte($code_compte){
        $this->code_compte = $code_compte;
        return $this;
    }
    
    public function getEtat_capa(){
        return $this->etat_capa;
    }
    
    public function setEtat_capa($etat_capa){
        $this->etat_capa = $etat_capa;
        return $this;
    }
    
    public function getCode_produit(){
        return $this->code_produit;
    }
    
    public function setCode_produit($code_produit){
        $this->code_produit = $code_produit;
        return $this;
    }
    
    public function getOrigine_capa(){
        return $this->origine_capa;
    }
    
    public function setOrigine_capa($origine_capa){
        $this->origine_capa = $origine_capa;
        return $this;
    }

}

?>
