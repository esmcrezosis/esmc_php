<?php
 
class Application_Model_EuChargePaye  {

    //put your code here
    protected $id_charge_paye;
    protected $date_charge;
    protected $id_charge;
    protected $libelle_charge;
    protected $montant_charge;
    protected $type_doc;
    protected $num_doc;
    protected $code_smcipn;
    protected $code_membre_creancier;
    protected $code_membre_debiteur;
	protected $origine_charge;
	
	
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
	
	

    public function getId_charge_paye() {
      return $this->id_charge_paye;
    }

    public function setId_charge_paye($id_charge_paye) {
        $this->id_charge_paye = $id_charge_paye;
        return $this;
    }
	
    public function getDate_charge() {
        return $this->date_charge;
    }

    public function setDate_charge($date_charge) {
        $this->date_charge = $date_charge;
        return $this;
    }
	
	
    public function getId_charge() {
        return $this->id_charge;
    }

    public function setId_charge($id_charge) {
        $this->id_charge = $id_charge;
        return $this;
    }


    public function getLibelle_charge() {
        return $this->libelle_charge;
    }

    public function setLibelle_charge($libelle_charge) {
        $this->libelle_charge = $libelle_charge;
        return $this;
    }
	
    public function getMontant_charge() {
        return $this->montant_charge;
    }

    public function setMontant_charge($montant_charge) {
        $this->montant_charge = $montant_charge;
        return $this;
    }
	
	
	public function getType_doc() {
        return $this->type_doc;
    }

    public function setType_doc($type_doc) {
        $this->type_doc = $type_doc;
        return $this;
    }
	
	
	public function getNum_doc() {
        return $this->num_doc;
    }

    public function setNum_doc($num_doc) {
        $this->num_doc = $num_doc;
        return $this;
    }
	
	
	public function getCode_smcipn() {
        return $this->code_smcipn;
    }

    public function setCode_smcipn($code_smcipn) {
        $this->code_smcipn = $code_smcipn;
        return $this;
    }
	
	
	public function getCode_membre_creancier() {
        return $this->code_membre_creancier;
    }

    public function setCode_membre_creancier($code_membre_creancier) {
        $this->code_membre_creancier = $code_membre_creancier;
        return $this;
    }
	
	
	public function getCode_membre_debiteur() {
        return $this->code_membre_debiteur;
    }

    public function setCode_membre_debiteur($code_membre_debiteur) {
        $this->code_membre_debiteur = $code_membre_debiteur;
        return $this;
    }
	
	
	
	public function getOrigine_charge() {
        return $this->origine_charge;
    }

    public function setOrigine_charge($origine_charge) {
        $this->origine_charge = $origine_charge;
        return $this;
    }

}

?>
