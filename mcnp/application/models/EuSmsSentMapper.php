 <?php

class Application_Model_EuSmsSentMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuSmsSent');
        }
        return $this->_dbTable;
    }


    public function find($NEng, Application_Model_EuSmsSent $smssent) {
        $result = $this->getDbTable()->find($NEng);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $smssent->setNEng($row->neng)
                ->setRecipient($row->recipient)
                ->setSMSBody($row->smsbody)
                ->setTypeExpediteur($row->typeexpediteur)
                ->setDateTime($row->datetime)
                ->setEtat($row->etat)
                ->setMsgId($row->msgid);
				}


    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSmsSent();
             $entry->setNEng($row->neng)
                ->setRecipient($row->recipient)
                ->setSMSBody($row->smsbody)
                ->setTypeExpediteur($row->typeexpediteur)
                ->setDateTime($row->datetime)
                ->setEtat($row->etat)
                ->setMsgId($row->msgid);

            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuSmsSent $smssent) {
        $data = array(
            'NEng' => $smssent->getNEng(),
            'Recipient' => $smssent->getRecipient(),
            'SMSBody' => $smssent->getSMSBody(),
            'TypeExpediteur' => $smssent->getTypeExpediteur(),
            'DateTime' => $smssent->getDateTime(),
            'Etat' => $smssent->getEtat(),
            'MsgId' => $smssent->getMsgId()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuSmsSent $smssent) {
        $data = array(
            'NEng' => $smssent->getNEng(),
            'Recipient' => $smssent->getRecipient(),
            'SMSBody' => $smssent->getSMSBody(),
            'TypeExpediteur' => $smssent->getTypeExpediteur(),
            'DateTime' => $smssent->getDateTime(),
            'Etat' => $smssent->getEtat(),
            'MsgId' => $smssent->getMsgId()
        );
        $this->getDbTable()->update($data, array('neng = ?' => $smssent->getNEng()));
    }

    public function delete($NEng) {
        $this->getDbTable()->delete(array('neng = ?' => $NEng));
    }

    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(neng) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }



///////////////////////////////////////////////////////////////
    public function fetchAllEnvoyer() {
        $select = $this->getDbTable()->select();
        $select->where('etat = ?', 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSmsSent();
             $entry->setNEng($row->neng)
                ->setRecipient($row->recipient)
                ->setSMSBody($row->smsbody)
                ->setTypeExpediteur($row->typeexpediteur)
                ->setDateTime($row->datetime)
                ->setEtat($row->etat)
                ->setMsgId($row->msgid);

            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllEncours() {
        $select = $this->getDbTable()->select();
        $select->where('etat = ?', 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSmsSent();
             $entry->setNEng($row->neng)
                ->setRecipient($row->recipient)
                ->setSMSBody($row->smsbody)
                ->setTypeExpediteur($row->typeexpediteur)
                ->setDateTime($row->datetime)
                ->setEtat($row->etat)
                ->setMsgId($row->msgid);

            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllPasEnvoyer() {
        $select = $this->getDbTable()->select();
        $select->where('etat = ?', 2);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSmsSent();
             $entry->setNEng($row->neng)
                ->setRecipient($row->recipient)
                ->setSMSBody($row->smsbody)
                ->setTypeExpediteur($row->typeexpediteur)
                ->setDateTime($row->datetime)
                ->setEtat($row->etat)
                ->setMsgId($row->msgid);

            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllNull() {
        $select = $this->getDbTable()->select();
        $select->where('etat IS NULL');
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSmsSent();
             $entry->setNEng($row->neng)
                ->setRecipient($row->recipient)
                ->setSMSBody($row->smsbody)
                ->setTypeExpediteur($row->typeexpediteur)
                ->setDateTime($row->datetime)
                ->setEtat($row->etat)
                ->setMsgId($row->msgid);

            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllOPI($opinum = "") {
        $select = $this->getDbTable()->select();
        if($opinum != ""){
        $select->where("smsbody LIKE '%".$opinum."%'");
    }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSmsSent();
             $entry->setNEng($row->neng)
                ->setRecipient($row->recipient)
                ->setSMSBody($row->smsbody)
                ->setTypeExpediteur($row->typeexpediteur)
                ->setDateTime($row->datetime)
                ->setEtat($row->etat)
                ->setMsgId($row->msgid);

            $entries[] = $entry;
        }
        return $entries;
    }

}

?>
