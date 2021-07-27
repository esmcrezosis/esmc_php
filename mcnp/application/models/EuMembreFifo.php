<?php
 
class Application_Model_EuMembreFifo {

     //put your code here
	 protected $id_membre_fifo;
     protected $code_membre_benef;
     protected $desactiver;
     protected $motif_desactivation;
     protected $substituer;
     protected $motif_substitution;
	 protected $code_membre_substituer;
	 protected $utilisateur;
	 protected $valider;
    
	
	
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
	
	
	public function getId_membre_fifo() {
        return $this->id_membre_fifo;
    }
	

    public function setId_membre_fifo($id_membre_fifo) {
        $this->id_membre_fifo = $id_membre_fifo;
        return $this;
    }

    
    public function getCode_membre_benef() {
        return $this->code_membre_benef;
    }
	

    public function setCode_membre_benef($code_membre_benef) {
        $this->code_membre_benef = $code_membre_benef;
        return $this;
    }
	

    public function getDesactiver() {
        return $this->desactiver;
    }

    public function setDesactiver($desactiver) {
        $this->desactiver = $desactiver;
        return $this;
    }
	
    public function getMotif_desactivation() {
        return $this->motif_desactivation;
    }

    public function setMotif_desactivation($motif_desactivation) {
        $this->motif_desactivation = $motif_desactivation;
        return $this;
    }
	

    public function getSubstituer() {
        return $this->substituer;
    }

    public function setSubstituer($substituer) {
        $this->substituer = $substituer;
        return $this;
    }
	
    public function getMotif_substitution() {
        return $this->motif_substitution;
    }

    public function setMotif_substitution($motif_substitution) {
        $this->motif_substitution = $motif_substitution;
        return $this;
    }
	
	
	public function getCode_membre_substituer() {
        return $this->code_membre_substituer;
    }

    public function setCode_membre_substituer($code_membre_substituer) {
        $this->code_membre_substituer = $code_membre_substituer;
        return $this;
    }
	
	
	public function getUtilisateur() {
        return $this->utilisateur;
    }

    public function setUtilisateur($utilisateur) {
        $this->utilisateur = $utilisateur;
        return $this;
    }
	
	
	public function getValider() {
        return $this->valider;
    }

    public function setValider($valider) {
        $this->valider = $valider;
        return $this;
    }
    

}

?>
