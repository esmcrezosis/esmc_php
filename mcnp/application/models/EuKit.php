<?php
 
class Application_Model_EuKit {

     //put your code here
	 protected $id_kit;
     protected $code_membre;
     protected $membreasso_id;
     protected $automatique;
     protected $date_kit;
     protected $materiel_kit;
     protected $livrer;
     protected $etat;
     protected $type_kit;
     protected $licence;
     protected $observation;
     protected $qte_kit;
     
	 
	
     public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
     }

     public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Inlivrer membre property');
        }
        $this->$method($value);
     }

     public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Inlivrer membre property');
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
	
     
	
	
	public function getId_kit() {
        return $this->id_kit;
    }

    public function setId_kit($id_kit) {
        $this->id_kit = $id_kit;
        return $this;
    }
    
    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
    
    public function getMembreasso_id() {
        return $this->membreasso_id;
    }

    public function setMembreasso_id($membreasso_id) {
        $this->membreasso_id = $membreasso_id;
        return $this;
    }
    
    public function getAutomatique() {
        return $this->automatique;
    }

    public function setAutomatique($automatique) {
        $this->automatique = $automatique;
        return $this;
    }
        
    public function getDate_kit() {
        return $this->date_kit;
    }

    public function setDate_kit($date_kit) {
        $this->date_kit = $date_kit;
        return $this;
    }
            
    public function getMateriel_kit() {
        return $this->materiel_kit;
    }

    public function setMateriel_kit($materiel_kit) {
        $this->materiel_kit = $materiel_kit;
        return $this;
    }
		
	public function getLivrer() {
        return $this->livrer;
    }

    public function setLivrer($livrer) {
        $this->livrer = $livrer;
        return $this;
    }
   
    public function getEtat() {
        return $this->etat;
    }

    public function setEtat($etat) {
        $this->etat = $etat;
        return $this;
    }
        
    public function getType_kit() {
        return $this->type_kit;
    }

    public function setType_kit($type_kit) {
        $this->type_kit = $type_kit;
        return $this;
    }
        
    public function getLicence() {
        return $this->licence;
    }

    public function setLicence($licence) {
        $this->licence = $licence;
        return $this;
    }
        
    public function getObservation() {
        return $this->observation;
    }

    public function setObservation($observation) {
        $this->observation = $observation;
        return $this;
    }
        
    public function getQte_kit() {
        return $this->qte_kit;
    }

    public function setQte_kit($qte_kit) {
        $this->qte_kit = $qte_kit;
        return $this;
    }
		

}

?>
