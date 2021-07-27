<?php
 
class Application_Model_EuFormsDetailBudgetNature {

     //put your code here
	 protected $id_forms_detail_budget_nature;
     protected $id_forms_budget_nature;
     protected $bps_demande;
     protected $qte_budget_nature;
     protected $prix_unitaire_budget_nature;
     protected $disponible_budget_nature;
	 protected $total_budget_nature;
     
	 
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
	
	public function getId_forms_detail_budget_nature() {
        return $this->id_forms_detail_budget_nature;
    }

    public function setId_forms_detail_budget_nature($id_forms_detail_budget_nature) {
        $this->id_forms_detail_budget_nature = $id_forms_detail_budget_nature;
        return $this;
    }
	
	
	public function getId_forms_budget_nature() {
        return $this->id_forms_budget_nature;
    }

    public function setId_forms_budget_nature($id_forms_budget_nature) {
        $this->id_forms_budget_nature = $id_forms_budget_nature;
        return $this;
    }
	
	public function getBps_demande() {
        return $this->bps_demande;
    }

    public function setBps_demande($bps_demande) {
        $this->bps_demande = $bps_demande;
        return $this;
    }
	
		
	
	public function getQte_budget_nature() {
        return $this->qte_budget_nature;
    }

    public function setQte_budget_nature($qte_budget_nature) {
        $this->qte_budget_nature = $qte_budget_nature;
        return $this;
    }
	
	
	public function getPrix_unitaire_budget_nature() {
        return $this->prix_unitaire_budget_nature;
    }

    public function setPrix_unitaire_budget_nature($prix_unitaire_budget_nature) {
        $this->prix_unitaire_budget_nature = $prix_unitaire_budget_nature;
        return $this;
    }
	
	
	public function getDisponible_budget_nature() {
        return $this->disponible_budget_nature;
    }

    public function setDisponible_budget_nature($disponible_budget_nature) {
        $this->disponible_budget_nature = $disponible_budget_nature;
        return $this;
    }
	
	
	public function getTotal_budget_nature() {
        return $this->total_budget_nature;
    }

    public function setTotal_budget_nature($total_budget_nature) {
        $this->total_budget_nature = $total_budget_nature;
        return $this;
    }
	
	
	
	

}

?>
