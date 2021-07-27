<?php

class Application_Model_EuSmsConnexion {

    //put your code here
    protected $sms_connexion_id;
    protected $sms_connexion_code_envoi;
    protected $sms_connexion_code_recu;
    protected $sms_connexion_code_membre;
    protected $sms_connexion_utilise;
    protected $sms_connexion_date;

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

    public function getSms_connexion_id() {
        return $this->sms_connexion_id;
    }

    public function setSms_connexion_id($sms_connexion_id) {
        $this->sms_connexion_id = $sms_connexion_id;
        return $this;
    }

    public function getSms_connexion_code_membre() {
        return $this->sms_connexion_code_membre;
    }

    public function setSms_connexion_code_membre($sms_connexion_code_membre) {
        $this->sms_connexion_code_membre = $sms_connexion_code_membre;
        return $this;
    }

    public function getSms_connexion_code_recu() {
        return $this->sms_connexion_code_recu;
    }

    public function setSms_connexion_code_recu($sms_connexion_code_recu) {
        $this->sms_connexion_code_recu = $sms_connexion_code_recu;
        return $this;
    }


    public function getSms_connexion_code_envoi() {
        return ($this->sms_connexion_code_envoi);
    }

    public function setSms_connexion_code_envoi($sms_connexion_code_envoi) {
        $this->sms_connexion_code_envoi = ($sms_connexion_code_envoi);
        return $this;
    }

    public function getSms_connexion_utilise() {
        return $this->sms_connexion_utilise;
    }

    public function setSms_connexion_utilise($sms_connexion_utilise) {
        $this->sms_connexion_utilise = $sms_connexion_utilise;
        return $this;
    }


    public function getSms_connexion_date() {
        return $this->sms_connexion_date;
    }

    public function setSms_connexion_date($sms_connexion_date) {
        $this->sms_connexion_date = $sms_connexion_date;
        return $this;
    }




}

?>
