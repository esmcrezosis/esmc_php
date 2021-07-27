<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuSmsmoneyMapper
 *
 * @author Akamgil
 */
 
class Application_Model_EuAncienSmsmoneyMapper {

    //put your code here
    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (NULL === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_EuAncienSmsmoney');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuAncienSmsmoney $sms) {
        $data = array(
            'neng' => $sms->getNEng(),
            'fromaccount' => $sms->getFromAccount(),
            'destaccount' => $sms->getDestAccount(),
            'creditcode' => $sms->getCreditCode(),
            'creditamount' => $sms->getCreditAmount(),
            'sentto' => $sms->getSentTo(),
            'currencycode' => $sms->getCurrencyCode(),
            'datetime' => $sms->getDateTime(),
            'iddatetime' => $sms->getIDDateTime(),
            'datetimeconsumed' => $sms->getDateTimeConsumed(),
            'iddatetimeconsumed' => $sms->getIDDateTimeConsumed(),
            'destaccount_consumed' => $sms->getDestAccount_Consumed(),
            'id_utilisateur' => $sms->getId_Utilisateur(),
            'code_agence' => $sms->getCode_Agence(),
            'motif' => $sms->getMotif(),
            'num_recu' => $sms->getNum_recu()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAncienSmsmoney $sms) {
        $data = array(
            'neng' => $sms->getNEng(),
            'fromaccount' => $sms->getFromAccount(),
            'destaccount' => $sms->getDestAccount(),
            'creditcode' => $sms->getCreditCode(),
            'creditamount' => $sms->getCreditAmount(),
            'sentto' => $sms->getSentTo(),
            'currencycode' => $sms->getCurrencyCode(),
            'datetime' => $sms->getDateTime(),
            'iddatetime' => $sms->getIDDateTime(),
            'datetimeconsumed' => $sms->getDateTimeConsumed(),
            'iddatetimeconsumed' => $sms->getIDDateTimeConsumed(),
            'destaccount_consumed' => $sms->getDestAccount_Consumed(),
            'id_utilisateur' => $sms->getId_Utilisateur(),
            'code_agence' => $sms->getCode_Agence(),
            'motif' => $sms->getMotif(),
            'num_recu' => $sms->getNum_recu()
        );
        $this->getDbTable()->update($data, array('neng = ?' => $sms->getNEng()));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(neng) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function find($Neng, Application_Model_EuAncienSmsmoney $sms) {
        $result = $this->getDbTable()->find($Neng);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $sms->setNEng($row->neng)
                ->setCreditAmount($row->creditamount)
                ->setFromAccount($row->fromaccount)
                ->setCreditCode($row->creditcode)
                ->setCurrencyCode($row->currencycode)
                ->setSentTo($row->sentto)
                ->setDatetime($row->datetime)
                ->setDatetimeConsumed($row->datetimeconsumed)
                ->setIDDatetime($row->iddatetime)
                ->setIDDatetimeConsumed($row->iddatetimeconsumed)
                ->setDestAccount($row->destaccount)
                ->setDestAccount_Consumed($row->destaccount_consumed)
                ->setCode_Agence($row->code_agence)
                ->setMotif($row->motif)
                ->setId_Utilisateur($row->id_utilisateur)
                ->setNum_recu($row->num_recu);
        return true;
    }

	public function findSMSMoneyByCodeSMS($code_sms, Application_Model_EuAncienSmsmoney $sms) {
        $select = $this->getDbTable()->select();
        $select->where('creditcode LIKE ?', $code_sms)
               ->where('iddatetimeconsumed = 0');
        $results = $this->getDbTable()->fetchAll($select);
        if (0 == count($results)) {
            return false;
        }
        $row = $results->current();
        $sms->setNEng($row->neng)
                ->setCreditAmount($row->creditamount)
                ->setFromAccount($row->fromaccount)
                ->setCreditCode($row->creditcode)
                ->setCurrencyCode($row->currencycode)
                ->setSentTo($row->sentto)
                ->setDatetime($row->datetime)
                ->setDatetimeConsumed($row->datetimeconsumed)
                ->setIDDatetime($row->iddatetime)
                ->setIDDatetimeConsumed($row->iddatetimeconsumed)
                ->setDestAccount($row->destaccount)
                ->setDestAccount_Consumed($row->destaccount_consumed)
                ->setCode_Agence($row->code_agence)
                ->setMotif($row->motif)
                ->setId_Utilisateur($row->id_utilisateur)
                ->setNum_recu($row->num_recu);
        return true;
    }
	
	
    public function findByCreditCode($creditCode) {
        $select = $this->getDbTable()->select();
        $select->where('creditcode LIKE ?', $creditCode)
               ->where('iddatetimeconsumed = ?', 0);
        $results = $this->getDbTable()->fetchAll($select);
        if (count($results) > 0) {
            $row = $results->current();
            $sms = new Application_Model_EuAncienSmsmoney();
            $sms->setNEng($row->neng)
                    ->setCreditAmount($row->creditamount)
                    ->setFromAccount($row->fromaccount)
                    ->setCreditCode($row->creditcode)
                    ->setSentTo($row->sentto)
                    ->setDestAccount($row->destaccount)
                    ->setDatetime($row->datetime)
                    ->setDatetimeConsumed($row->datetimeconsumed)
                    ->setDestAccount_Consumed($row->destaccount_consumed)
                    ->setCurrencyCode($row->currencycode)
                    ->setIDDatetimeConsumed($row->iddatetimeconsumed)
                    ->setIDDatetime($row->iddatetime)
                    ->setId_Utilisateur($row->id_utilisateur)
                    ->setMotif($row->motif)
                    ->setCode_Agence($row->code_agence)
                    ->setNum_recu($row->num_recu);
            return $sms;
        } else {
            return NULL;
        }
    }

    public function findByCreditCode3($creditCode,$pppm) {
		//$liste = array("FCPS","RPGNRPRK8","INRPRK8REAPPRO","MF107","RPGNRPREKIT","RPGR","INRPRE","RPGNRPRE","FS","FL","MFL","INRPRK6REAPPRO","INRPRK8","MF11000","IR","INRPRK7REAPPRO");
		$liste2 = array("CMIT","CAPS","CAPU","CAPUNRPREKITTEC","CMITNRPREKITTEC","CAIPCNRPREKITTEC","CAIPC","CACBPP","CACBPM","CSCOE","FS","FL","MFL","MF11000","FCPS","MF107");
        $select = $this->getDbTable()->select();
        $select->where('creditcode LIKE ?', $creditCode)
               ->where('motif NOT IN (?)', $liste2)
               ->where("motif LIKE '%".$pppm."%'")
			   ->where('iddatetimeconsumed = ?', 0);
        $results = $this->getDbTable()->fetchAll($select);
        if (count($results) > 0) {
            $row = $results->current();
            $sms = new Application_Model_EuAncienSmsmoney();
            $sms->setNEng($row->neng)
                    ->setCreditAmount($row->creditamount)
                    ->setFromAccount($row->fromaccount)
                    ->setCreditCode($row->creditcode)
                    ->setSentTo($row->sentto)
                    ->setDestAccount($row->destaccount)
                    ->setDatetime($row->datetime)
                    ->setDatetimeConsumed($row->datetimeconsumed)
                    ->setDestAccount_Consumed($row->destaccount_consumed)
                    ->setCurrencyCode($row->currencycode)
                    ->setIDDatetimeConsumed($row->iddatetimeconsumed)
                    ->setIDDatetime($row->iddatetime)
                    ->setId_Utilisateur($row->id_utilisateur)
                    ->setMotif($row->motif)
                    ->setCode_Agence($row->code_agence)
                    ->setNum_recu($row->num_recu);
            return $sms;
        } else {
            return NULL;
        }
    }

    public function findByCreditCode4($creditCode) {
        $select = $this->getDbTable()->select();
        $select->where('creditcode LIKE ?', $creditCode)
               ->where('motif = ?', 'ERL')
			   ->where('iddatetimeconsumed = ?', 0);
        $results = $this->getDbTable()->fetchAll($select);
        if (count($results) > 0) {
            $row = $results->current();
            $sms = new Application_Model_EuAncienSmsmoney();
            $sms->setNEng($row->neng)
                    ->setCreditAmount($row->creditamount)
                    ->setFromAccount($row->fromaccount)
                    ->setCreditCode($row->creditcode)
                    ->setSentTo($row->sentto)
                    ->setDestAccount($row->destaccount)
                    ->setDatetime($row->datetime)
                    ->setDatetimeConsumed($row->datetimeconsumed)
                    ->setDestAccount_Consumed($row->destaccount_consumed)
                    ->setCurrencyCode($row->currencycode)
                    ->setIDDatetimeConsumed($row->iddatetimeconsumed)
                    ->setIDDatetime($row->iddatetime)
                    ->setId_Utilisateur($row->id_utilisateur)
                    ->setMotif($row->motif)
                    ->setCode_Agence($row->code_agence)
                    ->setNum_recu($row->num_recu);
            return $sms;
        } else {
            return NULL;
        }
    }
	
	
    public function findByCreditCode5($creditCode) {
		$liste = array("MF107","MF11000","MFL");
        $select = $this->getDbTable()->select();
        $select->where('creditcode LIKE ?', $creditCode)
               ->where('motif IN (?)', $liste)
			   ->where('iddatetimeconsumed = ?', 0);
        $results = $this->getDbTable()->fetchAll($select);
        if (count($results) > 0) {
            $row = $results->current();
            $sms = new Application_Model_EuAncienSmsmoney();
            $sms->setNEng($row->neng)
                    ->setCreditAmount($row->creditamount)
                    ->setFromAccount($row->fromaccount)
                    ->setCreditCode($row->creditcode)
                    ->setSentTo($row->sentto)
                    ->setDestAccount($row->destaccount)
                    ->setDatetime($row->datetime)
                    ->setDatetimeConsumed($row->datetimeconsumed)
                    ->setDestAccount_Consumed($row->destaccount_consumed)
                    ->setCurrencyCode($row->currencycode)
                    ->setIDDatetimeConsumed($row->iddatetimeconsumed)
                    ->setIDDatetime($row->iddatetime)
                    ->setId_Utilisateur($row->id_utilisateur)
                    ->setMotif($row->motif)
                    ->setCode_Agence($row->code_agence)
                    ->setNum_recu($row->num_recu);
            return $sms;
        } else {
            return NULL;
        }
    }
	
	
    public function findByCreditCode6($creditCode) {
		$liste = array("FCPS");
        $select = $this->getDbTable()->select();
        $select->where('creditcode LIKE ?', $creditCode)
               ->where('motif IN (?)', $liste)
			   ->where('iddatetimeconsumed = ?', 0);
        $results = $this->getDbTable()->fetchAll($select);
        if (count($results) > 0) {
            $row = $results->current();
            $sms = new Application_Model_EuAncienSmsmoney();
            $sms->setNEng($row->neng)
                    ->setCreditAmount($row->creditamount)
                    ->setFromAccount($row->fromaccount)
                    ->setCreditCode($row->creditcode)
                    ->setSentTo($row->sentto)
                    ->setDestAccount($row->destaccount)
                    ->setDatetime($row->datetime)
                    ->setDatetimeConsumed($row->datetimeconsumed)
                    ->setDestAccount_Consumed($row->destaccount_consumed)
                    ->setCurrencyCode($row->currencycode)
                    ->setIDDatetimeConsumed($row->iddatetimeconsumed)
                    ->setIDDatetime($row->iddatetime)
                    ->setId_Utilisateur($row->id_utilisateur)
                    ->setMotif($row->motif)
                    ->setCode_Agence($row->code_agence)
                    ->setNum_recu($row->num_recu);
            return $sms;
        } else {
            return NULL;
        }
    }
////////////////////////////////////////////
    public function findByCreditCode2($creditCode) {
        $select = $this->getDbTable()->select();
        $select->where('creditcode LIKE ?', $creditCode);
        $results = $this->getDbTable()->fetchAll($select);
        if (count($results) > 0) {
            $row = $results->current();
            $sms = new Application_Model_EuAncienSmsmoney();
            $sms->setNEng($row->neng)
                    ->setCreditAmount($row->creditamount)
                    ->setFromAccount($row->fromaccount)
                    ->setCreditCode($row->creditcode)
                    ->setSentTo($row->sentto)
                    ->setDestAccount($row->destaccount)
                    ->setDatetime($row->datetime)
                    ->setDatetimeConsumed($row->datetimeconsumed)
                    ->setDestAccount_Consumed($row->destaccount_consumed)
                    ->setCurrencyCode($row->currencycode)
                    ->setIDDatetimeConsumed($row->iddatetimeconsumed)
                    ->setIDDatetime($row->iddatetime)
                    ->setId_Utilisateur($row->id_utilisateur)
                    ->setMotif($row->motif)
                    ->setCode_Agence($row->code_agence)
                    ->setNum_recu($row->num_recu);
            return $sms;
        } else {
            return NULL;
        }
    }
	
    public function findByCreditCode9($creditCode, $motif) {
		//$liste = array("fcps");
        $select = $this->getDbTable()->select();
        $select->where('creditcode = ?', $creditCode)
               ->where('motif = ? ', $motif)
			   ->where('iddatetimeconsumed = ?', 0);
        $results = $this->getDbTable()->fetchAll($select);
        if (count($results) > 0) {
            $row = $results->current();
            $sms = new Application_Model_EuAncienSmsmoney();
            $sms->setNEng($row->neng)
                    ->setCreditAmount($row->creditamount)
                    ->setFromAccount($row->fromaccount)
                    ->setCreditCode($row->creditcode)
                    ->setSentTo($row->sentto)
                    ->setDestAccount($row->destaccount)
                    ->setDatetime($row->datetime)
                    ->setDatetimeConsumed($row->datetimeconsumed)
                    ->setDestAccount_Consumed($row->destaccount_consumed)
                    ->setCurrencyCode($row->currencycode)
                    ->setIDDatetimeConsumed($row->iddatetimeconsumed)
                    ->setIDDatetime($row->iddatetime)
                    ->setId_Utilisateur($row->id_utilisateur)
                    ->setMotif($row->motif)
                    ->setCode_Agence($row->code_agence)
                    ->setNum_recu($row->num_recu);
            return $sms;
        } else {
            return NULL;
        }
    }
	
	
}

?>
