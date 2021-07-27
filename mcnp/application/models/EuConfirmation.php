<?php

class Application_Model_EuConfirmation {
 

protected $id_confirmation;
protected $code_membre;
protected $code_operateur;
protected $nom_operateur;
protected $data_text;
protected $data_json;
protected $activite;
protected $status;
protected $date_creation;
protected $date_confirmation;
protected $texte_confirmation;
protected $page;
protected $code_sms;
protected $nom_appareil;
protected $imei_appareil;
protected $numero_appareil;
protected $mac_appareil;
protected $ip_appareil;
protected $type_confirmation;
 	
    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = "set" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid Confirmation property");
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = "get" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid Confirmation property");
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
 


    function getId_confirmation() {
        return $this->id_confirmation;
    }

    function setId_confirmation($id_confirmation) {
        $this->id_confirmation = $id_confirmation;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    function getCode_operateur() {
        return $this->code_operateur;
    }

    function setCode_operateur($code_operateur) {
        $this->code_operateur = $code_operateur;
        return $this;
    }

    function getNom_operateur() {
        return $this->nom_operateur;
    }

    function setNom_operateur($nom_operateur) {
        $this->nom_operateur = $nom_operateur;
        return $this;
    }

    function getData_text() {
        return $this->data_text;
    }

    function setData_text($data_text) {
        $this->data_text = $data_text;
        return $this;
    }

    function getData_json() {
        return $this->data_json;
    }

    function setData_json($data_json) {
        $this->data_json = $data_json;
        return $this;
    }

    function getActivite() {
        return $this->activite;
    }

    function setActivite($activite) {
        $this->activite = $activite;
        return $this;
    }

    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    function getDate_creation() {
        return $this->date_creation;
    }

    function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
        return $this;
    }

    function getDate_confirmation() {
        return $this->date_confirmation;
    }

    function setDate_confirmation($date_confirmation) {
        $this->date_confirmation = $date_confirmation;
        return $this;
    }

    function getTexte_confirmation() {
        return $this->texte_confirmation;
    }

    function setTexte_confirmation($texte_confirmation) {
        $this->texte_confirmation = $texte_confirmation;
        return $this;
    }

    function getPage() {
        return $this->page;
    }

    function setPage($page) {
        $this->page = $page;
        return $this;
    }

    function getCode_sms() {
        return $this->code_sms;
    }

    function setCode_sms($code_sms) {
        $this->code_sms = $code_sms;
        return $this;
    }

    function getNom_appareil() {
        return $this->nom_appareil;
    }

    function setNom_appareil($nom_appareil) {
        $this->nom_appareil = $nom_appareil;
        return $this;
    }

    function getImei_appareil() {
        return $this->imei_appareil;
    }

    function setImei_appareil($imei_appareil) {
        $this->imei_appareil = $imei_appareil;
        return $this;
    }

    function getNumero_appareil() {
        return $this->numero_appareil;
    }

    function setNumero_appareil($numero_appareil) {
        $this->numero_appareil = $numero_appareil;
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

    function getType_confirmation() {
        return $this->type_confirmation;
    }

    function setType_confirmation($type_confirmation) {
        $this->type_confirmation = $type_confirmation;
        return $this;
    }


 }

