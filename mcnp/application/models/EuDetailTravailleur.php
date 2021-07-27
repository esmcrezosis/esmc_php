<?php
 
class Application_Model_EuDetailTravailleur {

     //put your code here
     protected $detail_travailleur_id;
     protected $detail_travailleur_libelle;
     protected $travailleur_id;
     protected $detail_travailleur_fichier;
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
	 
     public function getDetail_travailleur_id() {
        return $this->detail_travailleur_id;
     }

     public function setDetail_travailleur_id($detail_travailleur_id) {
        $this->detail_travailleur_id = $detail_travailleur_id;
        return $this;
     }

	
     public function getDetail_travailleur_libelle() {
        return $this->detail_travailleur_libelle;
     }

     public function setDetail_travailleur_libelle($detail_travailleur_libelle) {
        $this->detail_travailleur_libelle = $detail_travailleur_libelle;
        return $this;
     }
	
	
     public function getTravailleur_id() {
        return $this->travailleur_id;
     }

     public function setTravailleur_id($travailleur_id) {
        $this->travailleur_id = $travailleur_id;
        return $this;
     }
	

     public function getDetail_travailleur_fichier() {
        return $this->detail_travailleur_fichier;
     }

     public function setDetail_travailleur_fichier($detail_travailleur_fichier) {
        $this->detail_travailleur_fichier = $detail_travailleur_fichier;
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
