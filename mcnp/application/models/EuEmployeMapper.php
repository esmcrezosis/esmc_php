<?php 
class Application_Model_EuEmployeMapper {

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
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_EuEmploye');
        }
        return $this->_dbTable;
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_employe) as COUNT'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuEmploye();
            $entry->setId_employe($row->id_employe)
	              ->setCode_membre_employeur($row->code_membre_employeur)
	              ->setCode_membre_employe($row->code_membre_employe)
                  ->setDate_declaration($row->date_declaration)
                  ->setCnss($row->cnss)
                  ->setMont_salaire($row->mont_salaire)
                  ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuEmploye $employe) {
        $data = array(
            'id_employe' => $employe->getId_employe(),
            'code_membre_employeur' => $employe->getCode_membre_employeur(),
            'code_membre_employe' => $employe->getCode_membre_employe(),
            'date_declaration' => $employe->getDate_declaration(),
            'cnss' => $employe->getCnss(),
            'mont_salaire' => $employe->getMont_salaire(),
            'id_utilisateur' => $employe->getId_utilisateur(),
            'num_rccm' => $employe->getNum_rccm());

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuEmploye $employe) {
        $data = array(
            'id_employe' => $employe->getId_employe(),
            'code_membre_employeur' => $employe->getCode_membre_employeur(),
            'code_membre_employe' => $employe->getCode_membre_employe(),
            'date_declaration' => $employe->getDate_declaration(),
            'cnss' => $employe->getCnss(),
            'mont_salaire' => $employe->getMont_salaire(),
            'id_utilisateur' => $employe->getId_utilisateur(),
            'num_rccm' => $employe->getNum_rccm());
        $this->getDbTable()->update($data, array('id_employe = ?' =>$employe->getId_employe()));
    }
	
    public function resultfindByCodeMembre($code_membre_employeur) {
            $select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false);
            $select->where("code_membre_employeur = ?",$code_membre_employeur);
            $resultSet = $this->getDbTable()->fetchAll($select);
            $entries = array();
            foreach ($resultSet as $row) {
              $entry = new Application_Model_EuEmploye();
              $entry->setCode_membre_employe($row->code_membre_employe);
              $entries[] = $entry;
            }
            return $entries;
       
    }

}