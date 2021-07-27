<?php
 
class Application_Model_EuAlerteMessage {

     //put your code here
     protected $id_alerte_message;
     protected $id_message;
     protected $id_sms_sent;
	

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
	 
     public function getId_alerte_message() {
        return $this->id_alerte_message;
     }

     public function setId_alerte_message($id_alerte_message) {
        $this->id_alerte_message = $id_alerte_message;
        return $this;
     }
	
	
     public function getId_message() {
        return $this->id_message;
     }

     public function setId_message($id_message) {
        $this->id_message = $id_message;
        return $this;
     }
	

     public function getId_sms_sent() {
        return $this->id_sms_sent;
     }

     public function setId_sms_sent($id_sms_sent) {
        $this->id_sms_sent = $id_sms_sent;
        return $this;
     }
    
    
	
	
}

?>
