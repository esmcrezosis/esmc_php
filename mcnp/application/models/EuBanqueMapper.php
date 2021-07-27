<?php

class Application_Model_EuBanqueMapper {

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
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_EuBanque');
        }
        return $this->_dbTable;
    }

    public function find($code_banque, Application_Model_EuBanque $banque) {
        $result = $this->getDbTable()->find($code_banque);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $banque->setCode_banque($row->code_banque)
                ->setLibelle_banque($row->libelle_banque)
                ->setCompte_banque($row->compte_banque)
                ->setIban_banque($row->iban_banque)
                ->setType_banque($row->libelle_banque)
                ->setId_pays($row->id_pays)
				->setCode_membre_morale($row->code_membre_morale)
				;
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBanque();
            $entry->setCode_banque($row->code_banque)
                    ->setLibelle_banque($row->libelle_banque)
                ->setCompte_banque($row->compte_banque)
                ->setIban_banque($row->iban_banque)
                ->setType_banque($row->libelle_banque)
                ->setId_pays($row->id_pays)
				->setCode_membre_morale($row->code_membre_morale)
				;
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuBanque $banque) {
        $data = array(
            'code_banque' => $banque->getCode_banque(),
            'libelle_banque' => $banque->getLibelle_banque(),
            'compte_banque' => $banque->getCompte_banque(),
            'iban_banque' => $banque->getIban_banque(),
            'type_banque' => $banque->getType_banque(),
            'id_pays' => $banque->getId_pays(),
			'code_membre_morale' => $banque->getCode_membre_morale()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBanque $banque) {
        $data = array(
            'code_banque' => $banque->getCode_banque(),
            'libelle_banque' => $banque->getLibelle_banque(),
            'compte_banque' => $banque->getCompte_banque(),
            'iban_banque' => $banque->getIban_banque(),
            'type_banque' => $banque->getType_banque(),
            'id_pays' => $banque->getId_pays(),
			'code_membre_morale' => $banque->getCode_membre_morale()
        );
        $this->getDbTable()->update($data, array('code_banque = ?' => $banque->getCode_banque()));
    }

    public function delete($code_banque) {
        $this->getDbTable()->delete(array('code_banque = ?' => $code_banque));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(code_banque) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


    public function fetchAllByPays($id_pays = 0) {
        $select = $this->getDbTable()->select();
        if($id_pays > 0){
        $select->where("id_pays = ? ", $id_pays);
        }else{
        $select->where("id_pays = ? ", 0);
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBanque();
            $entry->setCode_banque($row->code_banque)
                  ->setLibelle_banque($row->libelle_banque)
                  ->setCompte_banque($row->compte_banque)
                  ->setIban_banque($row->iban_banque)
                  ->setType_banque($row->libelle_banque)
                  ->setId_pays($row->id_pays)
				  ->setCode_membre_morale($row->code_membre_morale)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }


}
?>

