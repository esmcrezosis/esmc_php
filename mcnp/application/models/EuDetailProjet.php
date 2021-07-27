<?php
 
class Application_Model_EuDetailProjet {

     //put your code here
     protected $detail_projet_id;
     protected $detail_projet_libelle;
     protected $projet_id;
     protected $detail_projet_fichier;
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
	 
     public function getDetail_projet_id() {
        return $this->detail_projet_id;
     }

     public function setDetail_projet_id($detail_projet_id) {
        $this->detail_projet_id = $detail_projet_id;
        return $this;
     }

	
     public function getDetail_projet_libelle() {
        return $this->detail_projet_libelle;
     }

     public function setDetail_projet_libelle($detail_projet_libelle) {
        $this->detail_projet_libelle = $detail_projet_libelle;
        return $this;
     }
	
	
     public function getProjet_id() {
        return $this->projet_id;
     }

     public function setProjet_id($projet_id) {
        $this->projet_id = $projet_id;
        return $this;
     }
	

     public function getDetail_projet_fichier() {
        return $this->detail_projet_fichier;
     }

     public function setDetail_projet_fichier($detail_projet_fichier) {
        $this->detail_projet_fichier = $detail_projet_fichier;
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
