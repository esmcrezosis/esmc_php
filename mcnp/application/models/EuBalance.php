<?php

/**
 * Description of EuBalance
 *
 * @author user
 */
class Application_Model_EuBalance {

    //put your code here
    protected $id_balance;
    protected $solde_debiteur1;
    protected $solde_crediteur1;
    protected $montant_versement;
	protected $montant_transfertrecu;
    protected $montant_cheque;
	protected $montant_opi;
	protected $montant_transfertemis;
	protected $solde_debiteur2;
    protected $solde_crediteur2;
	protected $montant_dat;
	protected $montant_decouvert;
	protected $solde_disponible1;
	protected $solde_disponible2;
	protected $date_balance;
	protected $date_balance_effective;
	protected $code_banque;
	protected $date_creation;
	protected $type_compte;

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
	
    public function getId_balance() {
        return $this->id_balance;
    }

    public function setId_balance($id_balance) {
        $this->id_balance = $id_balance;
        return $this;
    }
	
    public function getSolde_debiteur1() {
        return $this->solde_debiteur1;
    }

    public function setSolde_debiteur1($solde_debiteur1) {
        $this->solde_debiteur1 = $solde_debiteur1;
        return $this;
    }
    
    public function getSolde_crediteur1() {
        return $this->solde_crediteur1;
    }

    public function setSolde_crediteur1($solde_crediteur1) {
        $this->solde_crediteur1 = $solde_crediteur1;
        return $this;
    }
	
	
    public function getMontant_versement() {
        return $this->montant_versement;
    }

    public function setMontant_versement($montant_versement) {
        $this->montant_versement = $montant_versement;
        return $this;
    }

    public function getMontant_transfertrecu() {
        return $this->montant_transfertrecu;
    }

    public function setMontant_transfertrecu($montant_transfertrecu) {
        $this->montant_transfertrecu = $montant_transfertrecu;
        return $this;
    }
	
	public function getMontant_cheque() {
        return $this->montant_cheque;
    }

    public function setMontant_cheque($montant_cheque) {
        $this->montant_cheque = $montant_cheque;
        return $this;
    }
	
	public function getMontant_opi() {
        return $this->montant_opi;
    }

    public function setMontant_opi($montant_opi) {
        $this->montant_opi = $montant_opi;
        return $this;
    }
	
	public function getMontant_transfertemis() {
        return $this->montant_transfertemis;
    }

    public function setMontant_transfertemis($montant_transfertemis) {
        $this->montant_transfertemis = $montant_transfertemis;
        return $this;
    }
	
	
	
	public function getSolde_debiteur2() {
      return $this->solde_debiteur2;
    }

    public function setSolde_debiteur2($solde_debiteur2) {
        $this->solde_debiteur2 = $solde_debiteur2;
        return $this;
    }
	
	public function getSolde_crediteur2() {
      return $this->solde_crediteur2;
    }

    public function setSolde_crediteur2($solde_crediteur2) {
        $this->solde_crediteur2 = $solde_crediteur2;
        return $this;
    }
	
	public function getMontant_dat() {
      return $this->montant_dat;
    }

    public function setMontant_dat($montant_dat) {
        $this->montant_dat = $montant_dat;
        return $this;
    }
	
	public function getMontant_decouvert() {
      return $this->montant_decouvert;
    }

    public function setMontant_decouvert($montant_decouvert) {
        $this->montant_decouvert = $montant_decouvert;
        return $this;
    }
    
	public function getSolde_disponible1() {
      return $this->solde_disponible1;
    }

    public function setSolde_disponible1($solde_disponible1) {
        $this->solde_disponible1 = $solde_disponible1;
        return $this;
    }
	
	public function getSolde_disponible2() {
      return $this->solde_disponible2;
    }

    public function setSolde_disponible2($solde_disponible2) {
        $this->solde_disponible2 = $solde_disponible2;
        return $this;
    }
   
    public function getDate_balance() {
      return $this->date_balance;
    }

    public function setDate_balance($date_balance) {
        $this->date_balance = $date_balance;
        return $this;
    }
	
	public function getDate_balance_effective() {
      return $this->date_balance_effective;
    }

    public function setDate_balance_effective($date_balance_effective) {
        $this->date_balance_effective = $date_balance_effective;
        return $this;
    }
	
   
    public function getCode_banque() {
      return $this->code_banque;
    }

    public function setCode_banque($code_banque) {
        $this->code_banque = $code_banque;
        return $this;
    }
	
	public function getDate_creation() {
      return $this->date_creation;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }
	
	public function getType_compte() {
      return $this->type_compte;
    }

    public function setType_compte($type_compte) {
      $this->type_compte = $type_compte;
      return $this;
    }
	
	
	
	

}

?>
