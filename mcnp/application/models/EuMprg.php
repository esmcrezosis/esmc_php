<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuMprg
 *
 * @author user
 */
class Application_Model_EuMprg {

    //put your code here
    protected $id_mprg;
    protected $membre;
    protected $compte;
    protected $credit;
    protected $datedeb;
    protected $nbre_tranche;
    protected $datefin;
    protected $montant;
    protected $mont_echu;
    protected $mont_remb;
    protected $solde;
    protected $periode;
    protected $source;
    protected $date_oper;
    protected $operateur;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid contrat property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid contrat property');
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

    public function getId_mprg() {
        return $this->id_mprg;
    }

    public function setId_mprg($id_mprg) {
        $this->id_mprg = $id_mprg;
        return $this;
    }

    public function getMembre() {
        return $this->membre;
    }

    public function setCode_membre($membre) {
        $this->membre = $membre;
        return $this;
    }

    public function getCompte() {
        return $this->compte;
    }

    public function setCompte($compte) {
        $this->compte = $compte;
        return $this;
    }

    public function getCredit() {
        return $this->credit;
    }

    public function setCredit($credit) {
        $this->credit = $credit;
        return $this;
    }

    public function getDatedeb() {
        return $this->datedeb;
    }

    public function setDatedeb($datedeb) {
        $this->datedeb = $datedeb;
        return $this;
    }

    public function getNbre_tranche() {
        return $this->nbre_tranche;
    }

    public function setNbre_tranche($nbre_tranche) {
        $this->nbre_tranche = $nbre_tranche;
        return $this;
    }

    public function getDatefin() {
        return $this->datefin;
    }

    public function setDatefin($datefin) {
        $this->datefin = $datefin;
        return $this;
    }

    public function getMontant() {
        return $this->montant;
    }

    public function setMontant($montant) {
        $this->montant = $montant;
        return $this;
    }

    public function getMont_echu() {
        return $this->mont_echu;
    }

    public function setMont_echu($mont_echu) {
        $this->mont_echu = $mont_echu;
        return $this;
    }

    public function getMont_remb() {
        return $this->mont_remb;
    }

    public function setMont_remb($mont_remb) {
        $this->mont_remb = $mont_remb;
        return $this;
    }

    public function getSolde() {
        return $this->solde;
    }

    public function setSolde($solde) {
        $this->solde = $solde;
        return $this;
    }

    public function getPeriode() {
        return $this->periode;
    }

    public function setPeriode($periode) {
        $this->periode = $periode;
        return $this;
    }

    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
        return $this;
    }
    
    public function getDate_oper(){
        return $this->date_oper;
    }
    public function setDate_oper($date_oper){
        $this->date_oper = $date_oper;
        return $this;
    }
    
    public function getOperateur(){
        return $this->operateur;
    }
    
    public function setOperateur($operateur){
        $this->operateur = $operateur;
        return $this;
    }

}

?>
