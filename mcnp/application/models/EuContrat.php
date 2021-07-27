<?php
class Application_Model_EuContrat {

    protected $id_contrat;
    protected $code_membre;
    protected $date_contrat;
    protected $nature_contrat;
    protected $id_type_contrat;
    protected $id_type_creneau;
    protected $id_type_acteur;
    protected $id_pays;
    protected $id_utilisateur;
	protected $filiere;
    

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid contrat property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid contrat property');
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

 
    function getId_contrat() {
        return $this->id_contrat;
    }

    function setId_contrat($id_contrat) {
        $this->id_contrat = $id_contrat;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre =$code_membre;
        return $this;
    }
    
    function getDate_contrat() {
        return $this->date_contrat;
    }
    function setDate_contrat($date_contrat) {
        $this->date_contrat = $date_contrat;
        return $this;
    }
     
    function getNature_contrat() {
        return $this->nature_contrat;
    }
    function setNature_contrat($nature_contrat) {
        $this->nature_contrat =$nature_contrat;
        return $this;
    }
    
    function getId_type_contrat() {
        return $this->id_type_contrat;
    }
    
    function setId_type_contrat($id_type_contrat) {
        $this->id_type_contrat =$id_type_contrat;
        return $this;
    }
    
    function getId_type_creneau() {
        return $this->id_type_creneau;
    }
    
    function setId_type_creneau($id_type_creneau) {
        $this->id_type_creneau =$id_type_creneau;
        return $this;
    }
    
    
    function getId_type_acteur() {
        return $this->id_type_acteur;
    }
    
    function setId_type_acteur($id_type_acteur) {
        $this->id_type_acteur =$id_type_acteur;
        return $this;
    }
    
    function getId_pays() {
        return $this->id_pays;
    }
    function setId_pays($id_pays) {
        $this->id_pays =$id_pays;
        return $this;
    } 
	
	function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    } 
	
	 function getFiliere() {
        return $this->filiere;
    }

    function setFiliere($filiere) {
        $this->filiere = $filiere;
        return $this;
    }
	
	
	      
}
?>



