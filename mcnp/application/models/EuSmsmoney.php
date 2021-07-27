<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuSmsmoney
 *
 * @author Akamgil
 */
class Application_Model_EuSmsmoney {

    //put your code here
    protected $NEng;
    protected $FromAccount;
    protected $DestAccount;
    protected $CreditCode;
    protected $CreditAmount;
    protected $SentTo;
    protected $CurrencyCode;
    protected $DateTime;
    protected $IDDateTime;
    protected $DateTimeConsumed;
    protected $IDDateTimeConsumed;
    protected $DestAccount_Consumed;
    protected $Id_Utilisateur;
    protected $Code_Agence;
    protected $Motif;
    protected $num_recu;

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

    public function getFromAccount() {
        return $this->FromAccount;
    }

    public function setFromAccount($fromAccount) {
        $this->FromAccount = $fromAccount;
        return $this;
    }

    public function getDestAccount() {
        return $this->DestAccount;
    }

    public function setDestAccount($destAccount) {
        $this->DestAccount = $destAccount;
        return $this;
    }

    public function getCreditCode() {
        return $this->CreditCode;
    }

    public function setCreditCode($creditCode) {
        $this->CreditCode = $creditCode;
        return $this;
    }

    public function getCreditAmount() {
        return $this->CreditAmount;
    }

    public function setCreditAmount($creditAmount) {
        $this->CreditAmount = $creditAmount;
        return $this;
    }

    public function getSentTo() {
        return $this->SentTo;
    }

    public function setSentTo($sentTo) {
        $this->SentTo = $sentTo;
        return $this;
    }

    public function getCurrencyCode() {
        return $this->CurrencyCode;
    }

    public function setCurrencyCode($currencyCode) {
        $this->CurrencyCode = $currencyCode;
        return $this;
    }

    public function getDateTime() {
        return $this->DateTime;
    }

    public function setDatetime($dateTime) {
        $this->DateTime = $dateTime;
        return $this;
    }

    public function getIDDateTime() {
        return $this->IDDateTime;
    }

    public function setIDDatetime($iDDateTime) {
        $this->IDDateTime = $iDDateTime;
        return $this;
    }

    public function getDateTimeConsumed() {
        return $this->DateTimeConsumed;
    }

    public function setDatetimeConsumed($dateTimeConsumed) {
        $this->DateTimeConsumed = $dateTimeConsumed;
        return $this;
    }

    public function getIDDateTimeConsumed() {
        return $this->IDDateTimeConsumed;
    }

    public function setIDDatetimeConsumed($iDDateTimeConsumed) {
        $this->IDDateTimeConsumed = $iDDateTimeConsumed;
        return $this;
    }

    public function getDestAccount_Consumed() {
        return $this->DestAccount_Consumed;
    }

    public function setDestAccount_Consumed($destAccount_Consumed) {
        $this->DestAccount_Consumed = $destAccount_Consumed;
        return $this;
    }

    public function getId_Utilisateur() {
        return $this->Id_Utilisateur;
    }

    public function setId_Utilisateur($Id_Utilisateur) {
        $this->Id_Utilisateur = $Id_Utilisateur;
        return $this;
    }

    public function getCode_Agence() {
        return $this->Code_Agence;
    }

    public function setCode_Agence($Code_Agence) {
        $this->Code_Agence = $Code_Agence;
        return $this;
    }

    public function getMotif() {
           return $this->Motif;
    }

    public function setMotif($Motif) {
           $this->Motif = $Motif;
           return $this;
    }
    
     public function getNum_recu() {
        return $this->num_recu;
    }

    public function setNum_recu($num_recu) {
        $this->num_recu = $num_recu;
        return $this;
    }

}

?>
