<?php
 
class Application_Model_EuDetailOffreurProjet {

     //put your code here
     protected $id_detail_offreur_projet;
     protected $souscription_id;
     protected $offreur_projet_id;
     protected $date_detail_offreur_projet;
	

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
	 
     public function getId_detail_offreur_projet() {
        return $this->id_detail_offreur_projet;
     }

     public function setId_detail_offreur_projet($id_detail_offreur_projet) {
        $this->id_detail_offreur_projet = $id_detail_offreur_projet;
        return $this;
     }

	
     public function getSouscription_id() {
        return $this->souscription_id;
     }

     public function setSouscription_id($souscription_id) {
        $this->souscription_id = $souscription_id;
        return $this;
     }
	
	
     public function getOffreur_projet_id() {
        return $this->offreur_projet_id;
     }

     public function setOffreur_projet_id($offreur_projet_id) {
        $this->offreur_projet_id = $offreur_projet_id;
        return $this;
     }
	

     public function getDate_detail_offreur_projet() {
        return $this->date_detail_offreur_projet;
     }

     public function setDate_detail_offreur_projet($date_detail_offreur_projet) {
        $this->date_detail_offreur_projet = $date_detail_offreur_projet;
        return $this;
     }
	
	
}

?>
