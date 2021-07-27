<?php
 
class Application_Model_EuFichierTacheMembreasso {

     //put your code here
     protected $id_fichier_tache_membreasso;
     protected $id_tache_membreasso;
     protected $fichier_tache_membreasso;
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
	 
     public function getId_fichier_tache_membreasso() {
        return $this->id_fichier_tache_membreasso;
     }

     public function setId_fichier_tache_membreasso($id_fichier_tache_membreasso) {
        $this->id_fichier_tache_membreasso = $id_fichier_tache_membreasso;
        return $this;
     }
	
	
     public function getId_tache_membreasso() {
        return $this->id_tache_membreasso;
     }

     public function setId_tache_membreasso($id_tache_membreasso) {
        $this->id_tache_membreasso = $id_tache_membreasso;
        return $this;
     }
	

     public function getFichier_tache_membreasso() {
        return $this->fichier_tache_membreasso;
     }

     public function setFichier_tache_membreasso($fichier_tache_membreasso) {
        $this->fichier_tache_membreasso = $fichier_tache_membreasso;
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
