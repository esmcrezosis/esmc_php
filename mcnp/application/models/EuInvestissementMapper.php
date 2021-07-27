<?php

class Application_Model_EuInvestissementMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuInvestissement');
        }
        return $this->_dbTable;
    }

    public function findConuter() {
	
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_investissement) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
		
    }

    public function save(Application_Model_EuInvestissement $inves) {
        $data = array(
            'id_investissement' => $inves->getId_investissement(),
            'montant_budget' => $inves->getMontant_budget(),
            'cat_objet' => $inves->getCat_objet(),
            'date_investissement' => $inves->getDate_investissement(),
            'code_smcipn' => $inves->getCode_smcipn(),
            'id_utilisateur' => $inves->getId_utilisateur(),
            'id_besoin' => $inves->getId_besoin()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuInvestissement $inves) {
        $data = array(
            'id_investissement' => $inves->getId_investissement(),
            'montant_budget' => $inves->getMontant_budget(),
            'cat_objet' => $inves->getCat_objet(),
            'date_investissement' => $inves->getDate_investissement(),
            'code_smcipn' => $inves->getCode_smcipn(),
            'id_utilisateur' => $inves->getId_utilisateur(),
            'id_besoin' => $inves->getId_besoin()
        );

        $this->getDbTable()->update($data, array('id_investissement = ?' => $inves->getId_investissement()));
    }

    public function find($id_investissement, Application_Model_EuInvestissement $inves) {
        $result = $this->getDbTable()->find($id_investissement);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $inves->setId_investissement($row->id_investissement)
                ->setMontant_budget($row->montant_budget)
                ->setCat_objet($row->cat_objet)
                ->setDate_investissement($row->date_investissement)
                ->setCode_smcipn($row->code_smcipn)
                ->setId_utilisateur($row->id_utilisateur)
                ->setId_besoin($row->id_besoin);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuInvestissement();
            $entry->setId_investissement($row->id_investissement)
                    ->setMontant_budget($row->montant_budget)
                    ->setCat_objet($row->cat_objet)
                    ->setDate_investissement($row->date_investissement)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setId_besoin($row->id_besoin);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_investissement) {
        $this->getDbTable()->delete(array('id_investissement = ?' => $id_investissement));
    }

}

?>
