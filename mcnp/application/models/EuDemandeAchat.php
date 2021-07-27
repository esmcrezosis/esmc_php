<?php
 
class Application_Model_EuDemandeAchat {

    //put your code here
	protected $id_demande_achat;
	protected $libelle_demande_achat;
    protected $montant_demande_achat;
    protected $reference_demande_achat;
	protected $type_demande_achat;
    protected $code_membre;
    protected $valider_down;
    protected $valider_up;
	protected $date_demande;
	//protected $allocation_budgetaire;
	protected $credit_deja_consomme;
	protected $disponibilite_demande;
	protected $rejet;
	protected $livrer;
    
	
     public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
     }

     public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
        }
        $this->$method($value);
     }

     public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
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
	
	
	
	public function getId_demande_achat() {
        return $this->id_demande_achat;
    }
	

    public function setId_demande_achat($id_demande_achat) {
        $this->id_demande_achat = $id_demande_achat;
        return $this;
    }
	
	
	public function getLibelle_demande_achat() {
        return $this->libelle_demande_achat;
    }
	

    public function setLibelle_demande_achat($libelle_demande_achat) {
        $this->libelle_demande_achat = $libelle_demande_achat;
        return $this;
    }
	
	

    
    public function getMontant_demande_achat() {
        return $this->montant_demande_achat;
    }
	

    public function setMontant_demande_achat($montant_demande_achat) {
        $this->montant_demande_achat = $montant_demande_achat;
        return $this;
    }
	

    public function getReference_demande_achat() {
        return $this->reference_demande_achat;
    }

    public function setReference_demande_achat($reference_demande_achat) {
        $this->reference_demande_achat = $reference_demande_achat;
        return $this;
    }
	
	public function getType_demande_achat() {
        return $this->type_demande_achat;
    }

    public function setType_demande_achat($type_demande_achat) {
        $this->type_demande_achat = $type_demande_achat;
        return $this;
    }
	
	
    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
	

    public function getValider_down() {
        return $this->valider_down;
    }

    public function setValider_down($valider_down) {
        $this->valider_down = $valider_down;
        return $this;
    }
	
    public function getValider_up() {
        return $this->valider_up;
    }

    public function setValider_up($valider_up) {
        $this->valider_up = $valider_up;
        return $this;
    }
	
	
	public function getDate_demande() {
        return $this->date_demande;
    }

    public function setDate_demande($date_demande) {
        $this->date_demande = $date_demande;
        return $this;
    }
	
	/*
	public function getAllocation_budgetaire() {
        return $this->allocation_budgetaire;
    }

    public function setAllocation_budgetaire($allocation_budgetaire) {
        $this->allocation_budgetaire = $allocation_budgetaire;
        return $this;
    }
	*/
	
	
	public function getCredit_deja_consomme() {
        return $this->credit_deja_consomme;
    }

    public function setCredit_deja_consomme($credit_deja_consomme) {
        $this->credit_deja_consomme = $credit_deja_consomme;
        return $this;
    }
	
	
	public function getDisponibilite_demande() {
        return $this->disponibilite_demande;
    }

    public function setDisponibilite_demande($disponibilite_demande) {
        $this->disponibilite_demande = $disponibilite_demande;
        return $this;
    }
	
	
	public function getRejet() {
        return $this->rejet;
    }

    public function setRejet($rejet) {
        $this->rejet = $rejet;
        return $this;
    }
	
	public function getLivrer() {
        return $this->livrer;
    }

    public function setLivrer($livrer) {
        $this->livrer = $livrer;
        return $this;
    }
    

}

?>
