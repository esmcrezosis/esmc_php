<?php
class Application_Model_EuCompteCredit {

    protected $id_credit;
	protected $id_operation;
	protected $code_membre;
	protected $code_produit;
	protected $code_compte;
	protected $montant_place;
    protected $montant_credit;
	protected $datefin;
    protected $datedeb;
	protected $source;
	protected $date_octroi;
	protected $compte_source;
	protected $krr;
	protected $renouveller;
	protected $bnp;
	protected $domicilier;
	protected $code_bnp;
	protected $affecter;
	protected $code_type_credit;
	protected $prk;
	protected $nbre_renouvel;
	protected $type_recurrent;
	protected $type_produit;
	protected $duree;
	protected $frequence_cumul;
	protected $id_bps;
    

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
	
	
	function getId_operation() {
      return $this->id_operation;
    }

    function setId_operation($id_operation) {
      $this->id_operation = $id_operation;
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
	
	function getCode_compte() {
        return $this->code_compte;
    }

    function setCode_compte($code_compte) {
        $this->code_compte = $code_compte;
        return $this;
    }
	
	function getMontant_place() {
        return $this->montant_place;
    }

    function setMontant_place($montant_place) {
        $this->montant_place = $montant_place;
        return $this;
    }
	
	
    function getMontant_credit() {
        return $this->montant_credit;
    }

    function setMontant_credit($montant_credit) {
        $this->montant_credit = $montant_credit;
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
	
	function getCode_type_credit() {
        return $this->code_type_credit;
    }

    function setCode_type_credit($code_type_credit) {
        $this->code_type_credit = $code_type_credit;
        return $this;
    }
	
	function getPrk() {
        return $this->prk;
    }

    function setPrk($prk) {
      $this->prk = $prk;
      return $this;
    }


    function getNbre_renouvel() {
      return $this->nbre_renouvel;
    }

    function setNbre_renouvel($nbre_renouvel) {
      $this->nbre_renouvel = $nbre_renouvel;
      return $this;
    }
	
	function getType_recurrent() {
      return $this->type_recurrent;
    }

    function setType_recurrent($type_recurrent) {
      $this->type_recurrent = $type_recurrent;
      return $this;
    }
	
	function getType_produit() {
      return $this->type_produit;
    }

    function setType_produit($type_produit) {
      $this->type_produit = $type_produit;
      return $this;
    }
	
	
	function getDuree() {
      return $this->duree;
    }

    function setDuree($duree) {
      $this->duree = $duree;
      return $this;
    }
	
	function getFrequence_cumul() {
      return $this->frequence_cumul;
    }

    function setFrequence_cumul($frequence_cumul) {
      $this->frequence_cumul = $frequence_cumul;
      return $this;
    }
	
	function getId_bps() {
      return $this->id_bps;
    }

    function setId_bps($id_bps) {
      $this->id_bps = $id_bps;
      return $this;
    }
	
	
	
	
}

