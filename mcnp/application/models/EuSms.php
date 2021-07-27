<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuSms
 *
 * @author user
 */
class Application_Model_EuSms {

    //put your code here
    protected $NEng;
    protected $Nom;
    protected $Prenom;
    protected $Societe;
    protected $Recipient;
    protected $SMSBody;
    protected $DecodeString;
    protected $TypeDestinataire;
    protected $DateEnvoi;
    protected $DateTime;
    protected $IDDateTime;
    protected $IDDateEnvoi;
    protected $HeureEnvoi;
    protected $IDHeureEnvoi;
    protected $Etat;
    protected $Retries;
    protected $EnvoyePar;
    protected $EnvoyeLe;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid smsmoney property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid smsmoney property');
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

    public function getNEng() {
        return $this->NEng;
    }

    public function setNEng($NEng) {
        $this->NEng = $NEng;
        return$this;
    }

    public function getNom() {
        return $this->Nom;
    }

    public function setNom($Nom) {
        $this->Nom = $Nom;
        return $this;
    }

    public function getPrenom() {
        return $this->Prenom;
    }

    public function setPrenom($Prenom) {
        $this->Prenom = $Prenom;
        return $this;
    }

    public function getSociete() {
        return $this->Societe;
    }

    public function setSociete($Societe) {
        $this->Societe = $Societe;
        return $this;
    }

    public function getRecipient() {
        return $this->Recipient;
    }

    public function setRecipient($Recipient) {
        $this->Recipient = $Recipient;
        return $this;
    }

    public function getSMSBody() {
        return $this->SMSBody;
    }

    public function setSMSBody($SMSBody) {
        $this->SMSBody = $SMSBody;
        return $this;
    }

    public function getDecodeString() {
        return $this->DecodeString;
    }

    public function setDecodeString($DecodeString) {
        $this->DecodeString = $DecodeString;
        return $this;
    }

    public function getTypeDestinataire() {
        return $this->TypeDestinataire;
    }

    public function setTypeDestinataire($TypeDestinataire) {
        $this->TypeDestinataire = $TypeDestinataire;
        return $this;
    }

    public function getDateEnvoi() {
        return $this->DateEnvoi;
    }

    public function setDateEnvoi($DateEnvoi) {
        $this->DateEnvoi = $DateEnvoi;
        return $this;
    }

    public function getDateTime() {
        return $this->DateTime;
    }

    public function setDateTime($DateTime) {
        $this->DateTime = $DateTime;
        return $this;
    }

    public function getHeureEnvoi() {
        return $this->HeureEnvoi;
    }

    public function setHeureEnvoi($HeureEnvoi) {
        $this->HeureEnvoi = $HeureEnvoi;
        return $this;
    }

    public function getIDHeureEnvoi() {
        return $this->IDHeureEnvoi;
    }

    public function setIDHeureEnvoi($IDHeureEnvoi) {
        $this->IDHeureEnvoi = $IDHeureEnvoi;
        return $this;
    }

    public function getIDDateEnvoi() {
        return $this->IDDateEnvoi;
    }

    public function setIDDateEnvoi($IDDateEnvoi) {
        $this->IDDateEnvoi = $IDDateEnvoi;
        return $this;
    }

    public function getIDDateTime() {
        return $this->IDDateTime;
    }

    public function setIDDatetime($IDDateTime) {
        $this->IDDateTime = $IDDateTime;
        return $this;
    }

    public function getEtat() {
        return $this->Etat;
    }

    public function setEtat($Etat) {
        $this->Etat = $Etat;
        return $this;
    }

    public function getRetries() {
        return $this->Retries;
    }

    public function setRetries($Retries) {
        $this->Retries = $Retries;
        return $this;
    }

    public function getEnvoyePar() {
        return $this->EnvoyePar;
    }

    public function setEnvoyePar($EnvoyePar) {
        $this->EnvoyePar = $EnvoyePar;
        return $this;
    }

    public function getEnvoyeLe() {
        return $this->EnvoyeLe;
    }

    public function setEnvoyeLe($EnvoyeLe) {
        $this->EnvoyeLe = $EnvoyeLe;
        return $this;
    }
    
    public function exchangeArray($data) {
        $this->NEng = (isset($data['NEng'])) ? $data['NEng'] : NULL;
        $this->DateEnvoi = (isset($data['DateEnvoi'])) ? $data['DateEnvoi'] : '';
        $this->DateTime = (isset($data['DateTime'])) ? $data['DateTime'] : '';
        $this->HeureEnvoi = (isset($data['HeureEnvoi'])) ? $data['HeureEnvoi'] : '';
        $this->IDHeureEnvoi = (isset($data['IDHeureEnvoi'])) ? $data['IDHeureEnvoi'] : 0;
        $this->DecodeString = (isset($data['DecodeString'])) ? $data['DecodeString'] : '';
        $this->TypeDestinataire = (isset($data['TypeDestinataire'])) ? $data['TypeDestinataire'] : '';
        $this->Recipient = (isset($data['Recipient'])) ? $data['Recipient'] : '';
        $this->Nom = (isset($data['Nom'])) ? $data['Nom'] : '';
        $this->Prenom = (isset($data['Prenom'])) ? $data['Prenom'] : '';
        $this->Societe = (isset($data['Societe'])) ? $data['Societe'] : '';
        $this->Retries = (isset($data['Retries'])) ? $data['Retries'] : '';
        $this->EnvoyeLe = (isset($data['EnvoyeLe'])) ? $data['EnvoyeLe'] : '';
        $this->EnvoyePar = (isset($data['EnvoyePar'])) ? $data['EnvoyePar'] : '';
        $this->IDDateTime = (isset($data['IDDateTime'])) ? $data['IDDateTime'] : 0;
        $this->IDDateEnvoi = (isset($data['IDDateEnvoi'])) ? $data['IDDateEnvoi'] : 0;
        $this->SMSBody = (isset($data['SMSBody'])) ? $data['SMSBody'] : '';
        $this->Etat = (isset($data['Etat'])) ? $data['Etat'] : 0;
        
    }
	
    public function findConuter() {
        $table = new Application_Model_DbTable_EuSms;
        $select = $table->select();
        $select->from($table, array('MAX(neng) as count'));
        $result = $table->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


    public function toArray() {
        $data = array(
            'neng' => $this->NEng,
            'dateenvoi' => $this->DateEnvoi,
            'datetime' => $this->DateTime,
            'heureenvoi' => $this->HeureEnvoi,
            'idheureenvoi' => $this->IDHeureEnvoi,
            'decodestring' => $this->DecodeString,
            'typedestinataire' => $this->TypeDestinataire,
            'recipient' => $this->Recipient,
            'nom' => $this->Nom,
            'prenom' => $this->Prenom,
            'societe' => $this->Societe,
            'retries' => $this->Retries,
            'envoyele' => $this->EnvoyeLe,
            'envoyepar' => $this->EnvoyePar,
            'iddatetime' => $this->IDDateTime,
            'iddateenvoi' => $this->IDDateEnvoi,
            'smsbody' => $this->SMSBody,
            'etat' => $this->Etat
        );
        return $data;
    }

}

?>
