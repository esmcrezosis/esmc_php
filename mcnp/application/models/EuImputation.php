<?php
 
class Application_Model_EuImputation  {
    //put your code here
    protected $id_imputation;
    protected $num_compte_debit1;
    protected $num_compte_credit1;
	protected $num_compte_debit2;
    protected $num_compte_credit2;
    protected $libelle_imputation;
    protected $montant_imputation;
    protected $date_imputation;
    protected $date_creation;
    protected $id_utilisateur;
    protected $type_operation;
	protected $id_traitement;
	
	
    public function __construct(array $options = NULL) {
        if(is_array($options)) {
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
	

    public function getId_imputation() {
      return $this->id_imputation;
    }

    public function setId_imputation($id_imputation) {
        $this->id_imputation = $id_imputation;
        return $this;
    }
	

    public function getNum_compte_debit1() {
        return $this->num_compte_debit1;
    }

    public function setNum_compte_debit1($num_compte_debit1) {
        $this->num_compte_debit1 = $num_compte_debit1;
        return $this;
    }
	
    public function getNum_compte_credit1() {
        return $this->num_compte_credit1;
    }

    public function setNum_compte_credit1($num_compte_credit1) {
        $this->num_compte_credit1 = $num_compte_credit1;
        return $this;
    }
	
	
	 public function getNum_compte_debit2() {
        return $this->num_compte_debit2;
    }

    public function setNum_compte_debit2($num_compte_debit2) {
        $this->num_compte_debit2 = $num_compte_debit2;
        return $this;
    }
	
    public function getNum_compte_credit2() {
        return $this->num_compte_credit2;
    }

    public function setNum_compte_credit2($num_compte_credit2) {
        $this->num_compte_credit2 = $num_compte_credit2;
        return $this;
    }
	

    public function getLibelle_imputation() {
        return $this->libelle_imputation;
    }

    public function setLibelle_imputation($libelle_imputation) {
        $this->libelle_imputation = $libelle_imputation;
        return $this;
    }
	
    public function getMontant_imputation() {
        return $this->montant_imputation;
    }

    public function setMontant_imputation($montant_imputation) {
        $this->montant_imputation = $montant_imputation;
        return $this;
    }
	
	
	public function getDate_imputation() {
        return $this->date_imputation;
    }

    public function setDate_imputation($date_imputation) {
        $this->date_imputation = $date_imputation;
        return $this;
    }
	
	
	public function getDate_creation() {
        return $this->date_creation;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }
	
	
	public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
	
	
	public function getType_operation() {
        return $this->type_operation;
    }

    public function setType_operation($type_operation) {
        $this->type_operation = $type_operation;
        return $this;
    }
	
	
	public function getId_traitement() {
        return $this->id_traitement;
    }

    public function setId_traitement($id_traitement) {
        $this->id_traitement = $id_traitement;
        return $this;
    }
	

}

?>
