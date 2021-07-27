<?php
 
class Application_Model_EuFormsBudgetNature {

     //put your code here
	 protected $id_forms_budget_nature;
     protected $id_bps_vendu_achat_vente_reciproque;
     protected $type_budget;
     protected $reference_type_budget;
     protected $code_membre_budget;
     protected $valid_budget;
     protected $rejet;
     protected $montant_budget;
     protected $payer;
     protected $date_budget;
     
	 
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
	
	public function getId_forms_budget_nature() {
        return $this->id_forms_budget_nature;
    }

    public function setId_forms_budget_nature($id_forms_budget_nature) {
        $this->id_forms_budget_nature = $id_forms_budget_nature;
        return $this;
    }
	
	
	public function getId_bps_vendu_achat_vente_reciproque() {
        return $this->id_bps_vendu_achat_vente_reciproque;
    }

    public function setId_bps_vendu_achat_vente_reciproque($id_bps_vendu_achat_vente_reciproque) {
        $this->id_bps_vendu_achat_vente_reciproque = $id_bps_vendu_achat_vente_reciproque;
        return $this;
    }
	
	public function getReference_type_budget() {
        return $this->reference_type_budget;
    }

    public function setReference_type_budget($reference_type_budget) {
        $this->reference_type_budget = $reference_type_budget;
        return $this;
    }
	
	
	public function getCode_membre_budget() {
        return $this->code_membre_budget;
    }

    public function setCode_membre_budget($code_membre_budget) {
        $this->code_membre_budget = $code_membre_budget;
        return $this;
    }
	
		
	public function getType_budget() {
        return $this->type_budget;
    }

    public function setType_budget($type_budget) {
        $this->type_budget = $type_budget;
        return $this;
    }
        
    public function getValid_budget() {
        return $this->valid_budget;
    }

    public function setValid_budget($valid_budget) {
        $this->valid_budget = $valid_budget;
        return $this;
    }
        
    public function getRejet() {
        return $this->rejet;
    }

    public function setRejet($rejet) {
        $this->rejet = $rejet;
        return $this;
    }
	
        
    public function getMontant_budget() {
        return $this->montant_budget;
    }

    public function setMontant_budget($montant_budget) {
        $this->montant_budget = $montant_budget;
        return $this;
    }
        
    public function getPayer() {
        return $this->payer;
    }

    public function setPayer($payer) {
        $this->payer = $payer;
        return $this;
    }
        
    public function getDate_budget() {
        return $this->date_budget;
    }

    public function setDate_budget($date_budget) {
        $this->date_budget = $date_budget;
        return $this;
    }
	
	
	

}

?>
