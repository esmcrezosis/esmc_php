<?php 
class Application_Model_EuSmsManuelMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuSmsManuel');
        }
        return $this->_dbTable;
    }
 
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_sms_manuel) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function find($num_membre, Application_Model_EuMembre $membre) {
        $result = $this->getDbTable()->find($num_membre);
        if (0 == count($result)) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuSmsManuel();
            $entry->setId_sms_manel(stripslashes (($row->id_sms_manuel)))
                  ->setId_utilisateur(stripslashes (($row->id_utilisateur)))
                  ->setNum_portable(stripslashes (($row->num_portable)))
                  ->setContenu_message($row->contenu_message)
                  ->setDlr_mask($row->dlr_mask)
                  ->setDate_envoi()
                  ->setDlr_url(stripslashes (($row->dlr_url)));
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSmsManuel();
            $entry->setId_sms_manuel(stripslashes (($row->id_sms_manuel)))
                  ->setId_utilisateur(stripslashes (($row->id_utilisateur)))
                  ->setNum_portable(stripslashes (($row->num_portable)))
                  ->setContenu_message($row->contenu_message)
                  ->setDlr_mask($row->dlr_mask)
                  ->setDate_envoi($row->date_envoi)
                  ->setDlr_url(stripslashes (($row->dlr_url)));
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuSmsManuel $smsmanuel) {
        $data = array(
             'id_sms_manuel' => $smsmanuel->getId_sms_manuel(),
             'id_utilisateur' => strtoupper($smsmanuel->getId_utilisateur()),
             'Num_portable' => strtoupper($smsmanuel->getNum_portable()),
             'Contenu_message' => $smsmanuel->getContenu_message(),
             'dlr_mask' => $smsmanuel->getDlr_mask(),
             'date_envoi' => $smsmanuel->getDate_envoi(),
             'dlr_url' => strtoupper($smsmanuel->getDlr_url()));

        $this->getDbTable()->insert($data);
    }
}