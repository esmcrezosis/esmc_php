<?php
 
class Application_Model_EuLettreRelance {

     //put your code here
	 protected $id_lettre_relance;
     protected $id_eli;
     protected $libelle;
     protected $description;
     protected $fichier;
     protected $datecreation;
     protected $code_membre;
     protected $id_utilisateur;
     protected $valid;
     protected $etat;
     protected $type_lettre;
	 
	
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
	
     
	
	
	public function getId_lettre_relance() {
        return $this->id_lettre_relance;
    }

    public function setId_lettre_relance($id_lettre_relance) {
        $this->id_lettre_relance = $id_lettre_relance;
        return $this;
    }
    
    public function getId_eli() {
        return $this->id_eli;
    }

    public function setId_eli($id_eli) {
        $this->id_eli = $id_eli;
        return $this;
    }
    
    public function getLibelle() {
        return $this->libelle;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
        return $this;
    }
    
    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }
    
    public function getFichier() {
        return $this->fichier;
    }

    public function setFichier($fichier) {
        $this->fichier = $fichier;
        return $this;
    }
    
    public function getDatecreation() {
        return $this->datecreation;
    }

    public function setDatecreation($datecreation) {
        $this->datecreation = $datecreation;
        return $this;
    }
        
    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
    
    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
		
	public function getValid() {
        return $this->valid;
    }

    public function setValid($valid) {
        $this->valid = $valid;
        return $this;
    }
   
    public function getEtat() {
        return $this->etat;
    }

    public function setEtat($etat) {
        $this->etat = $etat;
        return $this;
    }
        
    public function getType_lettre() {
        return $this->type_lettre;
    }

    public function setType_lettre($type_lettre) {
        $this->type_lettre = $type_lettre;
        return $this;
    }
		

}

?>
