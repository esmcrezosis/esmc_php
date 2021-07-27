<?php
 
class Application_Model_EuApprovisionnement {

    //put your code here
    protected $id_approvisionnement;
    protected $code_membre_apporteur;
	protected $code_membre_beneficiaire;
    protected $date_approvisionnement;
    protected $type_approvisionnement;
    protected $montant_approvisionnement;
	protected $id_canton;

	
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
    
    public function getId_approvisionnement() {
        return $this->id_approvisionnement;
    }

    public function setId_approvisionnement($id_approvisionnement) {
        $this->id_approvisionnement = $id_approvisionnement;
        return $this;
    }

    public function getCode_membre_apporteur() {
        return $this->code_membre_apporteur;
    }

    public function setCode_membre_apporteur($code_membre_apporteur) {
        $this->code_membre_apporteur = $code_membre_apporteur;
        return $this;
    }
	
    public function getCode_membre_beneficiaire() {
        return $this->code_membre_beneficiaire;
    }

    public function setCode_membre_beneficiaire($code_membre_beneficiaire) {
        $this->code_membre_beneficiaire = $code_membre_beneficiaire;
        return $this;
    }
	
    public function getDate_approvisionnement() {
        return $this->date_approvisionnement;
    }

    public function setDate_approvisionnement($date_approvisionnement) {
        $this->date_approvisionnement = $date_approvisionnement;
        return $this;
    }
	
    public function getType_approvisionnement() {
        return $this->type_approvisionnement;
    }

    public function setType_approvisionnement($type_approvisionnement) {
        $this->type_approvisionnement = $type_approvisionnement;
        return $this;
    }
	
	
	public function getMontant_approvisionnement() {
        return $this->montant_approvisionnement;
    }

    public function setMontant_approvisionnement($montant_approvisionnement) {
        $this->montant_approvisionnement = $montant_approvisionnement;
        return $this;
    }
	
	public function getId_canton() {
        return $this->id_canton;
    }

    public function setId_canton($id_canton) {
        $this->id_canton = $id_canton;
        return $this;
    }
	
	
  

}

?>
