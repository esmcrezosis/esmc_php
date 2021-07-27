<?php

class Application_Model_EuUtiliserMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuUtiliser');
        }
        return $this->_dbTable;
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_utiliser) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function find($id_utiliser, Application_Model_EuUtiliser $just) {
        $result = $this->getDbTable()->find($id_utiliser);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $just->setId_smc($row->id_smc)
                ->setCode_smcipn($row->code_smcipn)
                ->setCode_smcipnp($row->code_smcipnp)
                ->setDate_creation($row->date_creation)
                ->setMontant_allouer($row->montant_allouer)
                ->setId_utiliser($row->id_utiliser);
    }

    public function findBySmcAndSmcipn($id_smc, $code_smcipn) {
        $select = $this->getDbTable()->select();
        $select->where('id_smc = ?', $id_smc)
                ->where('code_smcipn = ?', $code_smcipn)
                ->order('date_creation', 'ASC');
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuUtiliser();
            $entry->setId_smc($row->id_smc)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setCode_smcipnp($row->code_smcipnp)
                    ->setDate_creation($row->date_creation)
                    ->setMontant_allouer($row->montant_allouer)
                    ->setId_utiliser($row->id_utiliser);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuUtiliser();
            $entry->setId_smc($row->id_smc)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setCode_smcipnp($row->code_smcipnp)
                    ->setDate_creation($row->date_creation)
                    ->setMontant_allouer($row->montant_allouer)
                    ->setId_utiliser($row->id_utiliser);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuUtiliser $justif) {
        $data = array(
            'id_smc' => $justif->getId_smc(),
            'code_smcipn' => $justif->getCode_smcipn(),
            'code_smcipnp' => $justif->getCode_smcipnp(),
            'date_creation' => $justif->getDate_creation(),
            'montant_allouer' => $justif->getMontant_allouer(),
            'id_utiliser' => $justif->getId_utiliser()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuUtiliser $justif) {
        $data = array(
            'id_smc' => $justif->getId_smc(),
            'code_smcipn' => $justif->getCode_smcipn(),
            'code_smcipnp' => $justif->getCode_smcipnp(),
            'date_creation' => $justif->getDate_creation(),
            'montant_allouer' => $justif->getMontant_allouer(),
            'id_utiliser' => $justif->getId_utiliser()
        );
        $this->getDbTable()->update($data, array('id_utiliser = ?' => $justif->getId_utiliser()));
    }

    public function delete($id_utiliser) {
        $this->getDbTable()->delete(array('id_utiliser = ?' => $id_utiliser));
    }

}