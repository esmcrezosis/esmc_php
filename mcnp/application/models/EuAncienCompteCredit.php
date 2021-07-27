<?php

class Application_Model_EuAncienCompteCredit {
    protected $id_credit;
    protected $montant_credit;
    protected $code_membre;
    protected $code_produit;
    protected $montant_place;
    protected $datefin;
    protected $datedeb;
    protected $duree_credit;
    protected $periode;
    protected $source;
    protected $date_octroi;
    protected $compte_source;
    protected $krr;
    protected $renouveller;
    protected $bnp;
    protected $code_compte;
    protected $id_operation;
    protected $domicilier;
    protected $code_bnp;
    protected $affecter;
    protected $prk;
    protected $code_type_credit;
    protected $solde;
    protected $nbre_renouvel;
	protected $desactiver;
	protected $nature;
	

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

    function getMontant_credit() {
        return $this->montant_credit;
    }

    function setMontant_credit($montant_credit) {
        $this->montant_credit = $montant_credit;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    function getCode_produit() {
        return $this->code_produit;
    }

    function setCode_produit($code_produit) {
        $this->code_produit = $code_produit;
        return $this;
    }

    function getMontant_place() {
        return $this->montant_place;
    }

    function setMontant_place($montant_place) {
        $this->montant_place = $montant_place;
        return $this;
    }

    function getDatefin() {
        return $this->datefin;
    }

    function setDatefin($datefin) {
        $this->datefin = $datefin;
        return $this;
    }

    function getDatedeb() {
        return $this->datedeb;
    }

    function setDatedeb($datedeb) {
        $this->datedeb = $datedeb;
        return $this;
    }

    function getDuree_credit() {
        return $this->duree_credit;
    }

    function setDuree_credit($duree_credit) {
        $this->duree_credit = $duree_credit;
        return $this;
    }

    function getPeriode() {
        return $this->periode;
    }

    function setPeriode($periode) {
        $this->periode = $periode;
        return $this;
    }

    function getSource() {
        return $this->source;
    }

    function setSource($source) {
        $this->source = $source;
        return $this;
    }

    function getDate_octroi() {
        return $this->date_octroi;
    }

    function setDate_octroi($date_octroi) {
        $this->date_octroi = $date_octroi;
        return $this;
    }

    function getCompte_source() {
        return $this->compte_source;
    }

    function setCompte_source($compte_source) {
        $this->compte_source = $compte_source;
        return $this;
    }

    function getKrr() {
        return $this->krr;
    }

    function setKrr($krr) {
        $this->krr = $krr;
        return $this;
    }

    function getRenouveller() {
        return $this->renouveller;
    }

    function setRenouveller($renouveller) {
        $this->renouveller = $renouveller;
        return $this;
    }

    function getBnp() {
        return $this->bnp;
    }

    function setBnp($bnp) {
        $this->bnp = $bnp;
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

    function getDomicilier() {
        return $this->domicilier;
    }

    function setDomicilier($domicilier) {
        $this->domicilier = $domicilier;
        return $this;
    }

    function getCode_bnp() {
        return $this->code_bnp;
    }

    function setCode_bnp($code_bnp) {
        $this->code_bnp = $code_bnp;
        return $this;
    }

    function getAffecter() {
        return $this->affecter;
    }

    function setAffecter($affecter) {
        $this->affecter = $affecter;
        return $this;
    }

    function getPrk() {
        return $this->prk;
    }

    function setPrk($prk) {
        $this->prk = $prk;
        return $this;
    }

    function getCode_type_credit() {
        return $this->code_type_credit;
    }

    function setCode_type_credit($code_type_credit) {
        $this->code_type_credit = $code_type_credit;
        return $this;
    }


    function getSolde() {
        return $this->solde;
    }

    function setSolde($solde) {
        $this->solde = $solde;
        return $this;
    }

    function getNbre_renouvel() {
        return $this->nbre_renouvel;
    }

    function setNbre_renouvel($nbre_renouvel) {
      $this->nbre_renouvel = $nbre_renouvel;
      return $this;
    }
	
	function getDesactiver() {
      return $this->desactiver;
    }

    function setDesactiver($desactiver) {
      $this->desactiver = $desactiver;
      return $this;
    }
	
	
	function getNature() {
      return $this->nature;
    }

    function setNature($nature) {
      $this->nature = $nature;
      return $this;
    }
	
	
	
	
	
	
	
	
	
}

