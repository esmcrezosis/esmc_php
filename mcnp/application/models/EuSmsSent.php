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
class Application_Model_EuSmsSent {

    //put your code here
    protected $NEng;
    protected $Recipient;
    protected $SMSBody;
    protected $TypeExpediteur;
    protected $DateTime;
    protected $Etat;
    protected $MsgId;

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

    public function getTypeExpediteur() {
        return $this->TypeExpediteur;
    }

    public function setTypeExpediteur($TypeExpediteur) {
        $this->TypeExpediteur = $TypeExpediteur;
        return $this;
    }

    public function getDateTime() {
        return $this->DateTime;
    }

    public function setDateTime($DateTime) {
        $this->DateTime = $DateTime;
        return $this;
    }

    public function getEtat() {
        return $this->Etat;
    }

    public function setEtat($Etat) {
        $this->Etat = $Etat;
        return $this;
    }
    
    public function getMsgId() {
        return $this->MsgId;
    }

    public function setMsgId($MsgId) {
        $this->MsgId = $MsgId;
        return $this;
    }
	
    public function exchangeArray($data) {
        $this->NEng = (isset($data['NEng'])) ? $data['NEng'] : NULL;
        $this->DateTime = (isset($data['DateTime'])) ? $data['DateTime'] : '';
        $this->TypeExpediteur = (isset($data['TypeExpediteur'])) ? $data['TypeExpediteur'] : '';
        $this->Recipient = (isset($data['Recipient'])) ? $data['Recipient'] : '';
        $this->SMSBody = (isset($data['SMSBody'])) ? $data['SMSBody'] : '';
        $this->Etat = (isset($data['Etat'])) ? $data['Etat'] : 0;
        $this->MsgId = (isset($data['MsgId'])) ? $data['MsgId'] : '';
        
    }
	
    public function findConuter() {
        $table = new Application_Model_DbTable_EuSmsSent;
        $select = $table->select();
        $select->from($table, array('MAX(neng) as count'));
        $result = $table->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


    public function toArray() {
        $data = array(
            'NEng' => $this->NEng,
            'DateTime' => $this->DateTime,
            'TypeExpediteur' => $this->TypeExpediteur,
            'Recipient' => $this->Recipient,
            'SMSBody' => $this->SMSBody,
            'Etat' => $this->Etat,
            'MsgId' => $this->MsgId
        );
        return $data;
    }

}

?>
