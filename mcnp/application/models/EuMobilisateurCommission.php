<?php

 
class Application_Model_EuMobilisateurCommission  {

    //put your code here
	protected $id_mobilisateur_commission;
    protected $code_membre;
    protected $id_mstiers;
    protected $datecreat;
    protected $payer;
    protected $montant_mstiers;
    protected $montant_commission;
    protected $montant_ban;
    protected $montant_bai;
    protected $montant_opi;
    protected $membreasso_id;


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
	
	
	public function getId_mobilisateur_commission() {
        return $this->id_mobilisateur_commission;
    }

    public function setId_mobilisateur_commission($id_mobilisateur_commission) {
        $this->id_mobilisateur_commission = $id_mobilisateur_commission;
        return $this;
    }
    
    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getId_mstiers() {
        return $this->id_mstiers;
    }

    public function setId_mstiers($id_mstiers) {
        $this->id_mstiers = $id_mstiers;
        return $this;
    }

    public function getDatecreat() {
        return $this->datecreat;
    }

    public function setDatecreat($datecreat) {
        $this->datecreat = $datecreat;
        return $this;
    }

    public function getPayer() {
        return $this->payer;
    }

    public function setPayer($payer) {
        $this->payer = $payer;
        return $this;
    }

    public function getMontant_mstiers() {
        return $this->montant_mstiers;
    }

    public function setMontant_mstiers($montant_mstiers) {
        $this->montant_mstiers = $montant_mstiers;
        return $this;
    }

    public function getMontant_commission() {
        return $this->montant_commission;
    }

    public function setMontant_commission($montant_commission) {
        $this->montant_commission = $montant_commission;
        return $this;
    }

    public function getMontant_ban() {
        return $this->montant_ban;
    }

    public function setMontant_ban($montant_ban) {
        $this->montant_ban = $montant_ban;
        return $this;
    }

    public function getMontant_bai() {
        return $this->montant_bai;
    }

    public function setMontant_bai($montant_bai) {
        $this->montant_bai = $montant_bai;
        return $this;
    }

    public function getMontant_opi() {
        return $this->montant_opi;
    }

    public function setMontant_opi($montant_opi) {
        $this->montant_opi = $montant_opi;
        return $this;
    }

    public function getMembreasso_id() {
        return $this->membreasso_id;
    }

    public function setMembreasso_id($membreasso_id) {
        $this->membreasso_id = $membreasso_id;
        return $this;
    }
	

}

?>
