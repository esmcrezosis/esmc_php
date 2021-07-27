<?php
 
class Application_Model_EuComplementQuittance {

    //put your code here
    protected $id_complement_quittance;
    protected $integrateur_id;
    protected $souscription_id;
    protected $date_complement_quittance;
	

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

	
    public function getId_complement_quittance() {
        return $this->id_complement_quittance;
    }

    public function setId_complement_quittance($id_complement_quittance) {
        $this->id_complement_quittance = $id_complement_quittance;
        return $this;
    }

	
    public function getIntegrateur_id() {
        return $this->integrateur_id;
    }

    public function setIntegrateur_id($integrateur_id) {
        $this->integrateur_id = $integrateur_id;
        return $this;
    }
	
	
    public function getSouscription_id() {
        return $this->souscription_id;
    }

    public function setSouscription_id($souscription_id) {
        $this->souscription_id = $souscription_id;
        return $this;
    }
    
	

    public function getDate_complement_quittance() {
        return $this->date_complement_quittance;
    }

    public function setDate_complement_quittance($date_complement_quittance) {
        $this->date_complement_quittance = $date_complement_quittance;
        return $this;
    }
	
	

}

?>
