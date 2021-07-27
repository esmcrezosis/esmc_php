<?php

class Application_Model_EuSmsNbre {

    //put your code here
    protected $sms_nbre_id;
    protected $sms_nbre_nbre;
    protected $sms_nbre_date;
    protected $sms_nbre_alerte;

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

    public function getSms_nbre_id() {
        return $this->sms_nbre_id;
    }

    public function setSms_nbre_id($sms_nbre_id) {
        $this->sms_nbre_id = $sms_nbre_id;
        return $this;
    }

    public function getSms_nbre_nbre() {
        return $this->sms_nbre_nbre;
    }

    public function setSms_nbre_nbre($sms_nbre_nbre) {
        $this->sms_nbre_nbre = $sms_nbre_nbre;
        return $this;
    }

    public function getSms_nbre_date() {
        return $this->sms_nbre_date;
    }

    public function setSms_nbre_date($sms_nbre_date) {
        $this->sms_nbre_date = $sms_nbre_date;
        return $this;
    }


    public function getSms_nbre_alerte() {
        return $this->sms_nbre_alerte;
    }

    public function setSms_nbre_alerte($sms_nbre_alerte) {
        $this->sms_nbre_alerte = $sms_nbre_alerte;
        return $this;
    }
	
}

?>
