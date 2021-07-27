<?php

/**
 * Description of EuOperation
 *
 * @author user
 */
class Application_Model_EuSmc {

    //put your code here
    protected $id_smc;
    protected $type_smc;
    protected $source_credit;
    protected $montant;
    protected $entree;
    protected $sortie;
    protected $solde;
    protected $montant_solde;
    protected $id_credit;
    protected $date_smc;
    protected $code_capa;
    protected $code_smcipn;
    protected $code_smcipnp;
    protected $code_domicilier;
    protected $origine_smc;

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

    public function getId_smc() {
        return $this->id_smc;
    }

    public function setId_smc($id_smc) {
        $this->id_smc = $id_smc;
        return $this;
    }

    public function getCode_capa() {
        return $this->code_capa;
    }

    public function setCode_capa($code_capa) {
        $this->code_capa = $code_capa;
        return $this;
    }

    public function getId_credit() {
        return $this->id_credit;
    }

    public function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }

    public function getSource_credit() {
        return $this->source_credit;
    }

    public function setSource_credit($source_credit) {
        $this->source_credit = $source_credit;
        return $this;
    }

    public function getMontant() {
        return $this->montant;
    }

    public function setMontant($montant) {
        $this->montant = $montant;
        return $this;
    }

    public function getEntree() {
        return $this->entree;
    }

    public function setEntree($entree) {
        $this->entree = $entree;
        return $this;
    }

    public function getSortie() {
        return $this->sortie;
    }

    public function setSortie($sortie) {
        $this->sortie = $sortie;
        return $this;
    }

    public function getSolde() {
        return $this->solde;
    }

    public function setSolde($solde) {
        $this->solde = $solde;
        return $this;
    }

    public function getMontant_solde() {
        return $this->montant_solde;
    }

    public function setMontant_solde($montant_solde) {
        $this->montant_solde = $montant_solde;
        return $this;
    }

    public function getType_smc() {
        return $this->type_smc;
    }

    public function setType_smc($type_smc) {
        $this->type_smc = $type_smc;
        return $this;
    }

    public function getDate_smc() {
        return $this->date_smc;
    }

    public function setDate_smc($date_smc) {
        $this->date_smc = $date_smc;
        return $this;
    }

    public function getCode_smcipn() {
        return $this->code_smcipn;
    }

    public function setCode_smcipn($code_smcipn) {
        $this->code_smcipn = $code_smcipn;
        return $this;
    }

    public function getCode_smcipnp() {
        return $this->code_smcipnp;
    }

    public function setCode_smcipnp($code_smcipnp) {
        $this->code_smcipnp = $code_smcipnp;
        return $this;
    }

    public function getCode_domicilier() {
        return $this->code_domicilier;
    }

    public function setCode_domicilier($code_domicilier) {
        $this->code_domicilier = $code_domicilier;
        return $this;
    }

    public function getOrigine_smc() {
        return $this->origine_smc;
    }

    public function setOrigine_smc($origine_smc) {
        $this->origine_smc = $origine_smc;
        return $this;
    }

}

?>
