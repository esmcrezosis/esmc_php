<?php
 
class Application_Model_EuDestinataireMessage {

     //put your code here
     protected $id_destinataire_message;
     protected $id_message;
     protected $code_membre_destinataire;
     protected $etat;
	

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
	 
     public function getId_destinataire_message() {
        return $this->id_destinataire_message;
     }

     public function setId_destinataire_message($id_destinataire_message) {
        $this->id_destinataire_message = $id_destinataire_message;
        return $this;
     }
	
	
     public function getId_message() {
        return $this->id_message;
     }

     public function setId_message($id_message) {
        $this->id_message = $id_message;
        return $this;
     }
	

     public function getCode_membre_destinataire() {
        return $this->code_membre_destinataire;
     }

     public function setCode_membre_destinataire($code_membre_destinataire) {
        $this->code_membre_destinataire = $code_membre_destinataire;
        return $this;
     }
    
     public function getEtat() {
        return $this->etat;
     }

     public function setEtat($etat) {
        $this->etat = $etat;
        return $this;
     }
    
	
	
}

?>
