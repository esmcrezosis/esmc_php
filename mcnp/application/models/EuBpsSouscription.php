<?php

class Application_Model_EuBpsSouscription {

    protected $id_bps_souscription;
    protected $bps_demande;
    protected $montant_bps_souscription;
    protected $date_bps_souscription;
    protected $id_mstiers;
	protected $delai_bps_souscription;
	protected $code_smcipn;
	protected $allouer;
    

	
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
	
	

    function getId_bps_souscription() {
        return $this->id_bps_souscription;
    }

    function setId_bps_souscription($id_bps_souscription) {
        $this->id_bps_souscription = $id_bps_souscription;
        return $this;
    }
	
	

    function getBps_demande() {
        return $this->bps_demande;
    }

    function setBps_demande($bps_demande) {
        $this->bps_demande = $bps_demande;
        return $this;
    }
	
	

    function getMontant_bps_souscription() {
        return $this->montant_bps_souscription;
    }

    function setMontant_bps_souscription($montant_bps_souscription) {
        $this->montant_bps_souscription = $montant_bps_souscription;
        return $this;
    }
	

    function getDate_bps_souscription() {
        return $this->date_bps_souscription;
    }

    function setDate_bps_souscription($date_bps_souscription) {
        $this->date_bps_souscription = $date_bps_souscription;
        return $this;
    }
	
	
    public function getId_mstiers() {
        return $this->id_mstiers;
    }

    public function setId_mstiers($id_mstiers) {
        $this->id_mstiers = $id_mstiers;
        return $this;
    }

	
	function getDelai_bps_souscription() {
        return $this->delai_bps_souscription;
    }

    function setDelai_bps_souscription($delai_bps_souscription) {
        $this->delai_bps_souscription = $delai_bps_souscription;
        return $this;
    }
	
	
	public function getCode_smcipn() {
        return $this->code_smcipn;
    }

    public function setCode_smcipn($code_smcipn) {
        $this->code_smcipn = $code_smcipn;
        return $this;
    }
	
	
	public function getAllouer() {
        return $this->allouer;
    }

    public function setAllouer($allouer) {
        $this->allouer = $allouer;
        return $this;
    }
	

}

?>
