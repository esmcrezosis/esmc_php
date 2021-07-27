<?php

class Application_Model_EuFactureSmcipnMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFactureSmcipn');
        }
        return $this->_dbTable;
    }

    public function find($code_facture, Application_Model_EuFactureSmcipn $facture) {
        $result = $this->getDbTable()->find($code_facture);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $facture->setCode_facture($row->code_facture)
                ->setCode_membre_morale($row->code_membre_morale)
                ->setDate_facture($row->date_facture)
                ->setMont_facture($row->mont_facture)
                ->setEtat_facture($row->etat_facture)
                ->setType_facture($row->type_facture)
                ->setCode_smcipn($row->code_smcipn)
                ->setId_utilisateur($row->id_utilisateur);
    }

    public function findtotal($code_facture) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('mont_facture'));
        $select->where('code_facture = ?', $code_facture);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['mont_facture'];
    }

    public function findnumclt($code_facture) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('code_membre_morale'));
        $select->where('code_facture = ?', $code_facture);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['code_membre_morale'];
    }

    public function findtotalbysmcipn($code_smcipn) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(mont_facture) as mont_facture'));
        $select->where('code_smcipn = ?', $code_smcipn);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['mont_facture'];
    }
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFactureSmcipn();
            $entry->setCode_facture($row->code_facture)
                    ->setCode_membre_morale($row->code_membre_morale)
                    ->setDate_facture($row->date_facture)
                    ->setMont_facture($row->mont_facture)
                    ->setEtat_facture($row->etat_facture)
                    ->setType_facture($row->type_facture)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuFactureSmcipn $facture) {
        $data = array(
            'code_facture' => $facture->getCode_facture(),
            'code_membre_morale' => $facture->getCode_membre_morale(),
            'date_facture' => $facture->getDate_facture(),
            'mont_facture' => $facture->getMont_facture(),
            'etat_facture' => $facture->getEtat_facture(),
            'type_facture' => $facture->getType_facture(),
            'code_smcipn' => $facture->getCode_smcipn(),
            'id_utilisateur' => $facture->getId_utilisateur()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFactureSmcipn $facture) {
        $data = array(
            'code_facture' => $facture->getCode_facture(),
            'code_membre_morale' => $facture->getCode_membre_morale(),
            'date_facture' => $facture->getDate_facture(),
            'mont_facture' => $facture->getMont_facture(),
            'etat_facture' => $facture->getEtat_facture(),
            'type_facture' => $facture->getType_facture(),
            'code_smcipn' => $facture->getCode_smcipn(),
            'id_utilisateur' => $facture->getId_utilisateur()
        );
        $this->getDbTable()->update($data, array('code_facture = ?' => $facture->getCode_facture()));
    }

    public function delete($code_facture) {
        $this->getDbTable()->delete(array('code_facture = ?' => $code_facture));
    }

}
?>

