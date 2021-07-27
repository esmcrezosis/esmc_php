<?php
 
class Application_Model_EuValidTdr {

     //put your code here
	 protected $id_valid_tdr;
     protected $table;
     protected $id_table;
     protected $datecreation;
     protected $attribution_user_group_formulaire_id;
     protected $etat;
     protected $id_utilisateur;
	
	
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
	
     
	
	
	public function getId_valid_tdr() {
        return $this->id_valid_tdr;
    }

    public function setId_valid_tdr($id_valid_tdr) {
        $this->id_valid_tdr = $id_valid_tdr;
        return $this;
    }
    
    public function getTable() {
        return $this->table;
    }

    public function setTable($table) {
        $this->table = $table;
        return $this;
    }
    
    public function getId_table() {
        return $this->id_table;
    }

    public function setId_table($id_table) {
        $this->id_table = $id_table;
        return $this;
    }
        
    public function getDatecreation() {
        return $this->datecreation;
    }

    public function setDatecreation($datecreation) {
        $this->datecreation = $datecreation;
        return $this;
    }

	public function getAttribution_user_group_formulaire_id() {
        return $this->attribution_user_group_formulaire_id;
    }

    public function setAttribution_user_group_formulaire_id($attribution_user_group_formulaire_id) {
        $this->attribution_user_group_formulaire_id = $attribution_user_group_formulaire_id;
        return $this;
    }

    public function getEtat() {
        return $this->etat;
    }

    public function setEtat($etat) {
        $this->etat = $etat;
        return $this;
    }
    
    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
				

}

?>
