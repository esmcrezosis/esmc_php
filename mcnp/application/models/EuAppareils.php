<?php

class Application_Model_EuAppareils {
 

protected $id;
protected $code_membre;
protected $marque_appareil;
protected $modele_appareil;
protected $imei_appareil;
protected $nom_appareil;
protected $mac_appareil;
protected $ip_appareil;
protected $lock_status;
protected $update_time;
 	
    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = "set" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid Appareils property");
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = "get" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid Appareils property");
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = "set" . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
 


    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    function getMarque_appareil() {
        return $this->marque_appareil;
    }

    function setMarque_appareil($marque_appareil) {
        $this->marque_appareil = $marque_appareil;
        return $this;
    }

    function getModele_appareil() {
        return $this->modele_appareil;
    }

    function setModele_appareil($modele_appareil) {
        $this->modele_appareil = $modele_appareil;
        return $this;
    }

    function getImei_appareil() {
        return $this->imei_appareil;
    }

    function setImei_appareil($imei_appareil) {
        $this->imei_appareil = $imei_appareil;
        return $this;
    }

    function getNom_appareil() {
        return $this->nom_appareil;
    }

    function setNom_appareil($nom_appareil) {
        $this->nom_appareil = $nom_appareil;
        return $this;
    }

    function getMac_appareil() {
        return $this->mac_appareil;
    }

    function setMac_appareil($mac_appareil) {
        $this->mac_appareil = $mac_appareil;
        return $this;
    }

    function getIp_appareil() {
        return $this->ip_appareil;
    }

    function setIp_appareil($ip_appareil) {
        $this->ip_appareil = $ip_appareil;
        return $this;
    }

    function getLock_status() {
        return $this->lock_status;
    }

    function setLock_status($lock_status) {
        $this->lock_status = $lock_status;
        return $this;
    }

    function getUpdate_time() {
        return $this->update_time;
    }

    function setUpdate_time($update_time) {
        $this->update_time = $update_time;
        return $this;
    }


 }

