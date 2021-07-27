<?php

class Application_Model_EuCreditConsommerMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCreditConsommer');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuCreditConsommer $ccons) {
        $data = array(
            'id_consommation' => $ccons->getId_consommation(),
            'id_operation' => $ccons->getId_operation(),
            'id_credit' => $ccons->getId_credit(),
            'code_membre' => $ccons->getCode_membre(),
			'code_membre_morale' => $ccons->getCode_membre_morale(),
            'code_membre_dist' => $ccons->getCode_membre_dist(),
            'code_compte' => $ccons->getCode_compte(),
            'code_produit' => $ccons->getCode_produit(),
            'mont_consommation' => $ccons->getMont_Consommation(),
            'date_consommation' => $ccons->getDate_consommation(),
            'heure_consommation' => $ccons->getHeure_consommation(),
			'bon_id' => $ccons->getBon_id(),
			'type_produit' => $ccons->getType_produit(),
			'code_type_credit' => $ccons->getCode_type_credit()
			
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCreditConsommer $ccons) {
        $data = array(
            'id_consommation' => $ccons->getId_consommation(),
            'id_operation' => $ccons->getId_operation(),
            'id_credit' => $ccons->getId_credit(),
            'code_membre' => $ccons->getCode_membre(),
			'code_membre_morale' => $ccons->getCode_membre_morale(),
            'code_membre_dist' => $ccons->getCode_membre_dist(),
            'code_compte' => $ccons->getCode_compte(),
            'code_produit' => $ccons->getCode_produit(),
            'mont_consommation' => $ccons->getMont_Consommation(),
            'date_consommation' => $ccons->getDate_consommation(),
            'heure_consommation' => $ccons->getHeure_consommation(),
			'bon_id' => $ccons->getBon_id(),
			'type_produit' => $ccons->getType_produit(),
			'code_type_credit' => $ccons->getCode_type_credit()
        );
        $this->getDbTable()->update($data, array('id_consommation = ?' => $ccons->getId_consommation()));
    }

    public function find($id_consommation, Application_Model_EuCreditConsommer $cconso) {
        $result = $this->getDbTable()->find($id_consommation);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $cconso->setId_consommation($row->id_consommation)
                ->setId_operation($row->id_operation)
                ->setId_credit($row->id_credit)
                ->setCode_membre($row->code_membre)
				->setCode_membre_morale($row->code_membre_morale)
                ->setCode_membre_dist($row->code_membre_dist)
                ->setCode_compte($row->code_compte)
                ->setCode_produit($row->code_produit)
                ->setMont_consommation($row->mont_consommation)
                ->setDate_consommation($row->date_consommation)
                ->setHeure_consommation($row->heure_consommation)
				->setBon_id($row->bon_id)
				->setType_produit($row->type_produit)
				->setCode_type_credit($row->code_type_credit)
				;
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCreditConsommer();
            $entry->setId_consommation($row->id_consommation)
                  ->setId_operation($row->id_operation)
                  ->setId_credit($row->id_credit)
                  ->setCode_membre($row->code_membre)
			      ->setCode_membre_morale($row->code_membre_morale)
                  ->setCode_membre_dist($row->code_membre_dist)
                  ->setCode_compte($row->code_compte)
                  ->setCode_produit($row->code_produit)
                  ->setMont_consommation($row->mont_consommation)
                  ->setDate_consommation($row->date_consommation)
                  ->setHeure_consommation($row->heure_consommation)
			      ->setBon_id($row->bon_id)
				  ->setType_produit($row->type_produit)
				  ->setCode_type_credit($row->code_type_credit);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByCompte($compte) {
        $select = $this->getDbTable()->select();
        $select->where('num_compte NOT LIKE ?', $compte);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCreditConsommer();
            $entry->setId_consommation($row->id_consommation)
                  ->setId_operation($row->id_operation)
                  ->setId_credit($row->id_credit)
                  ->setCode_membre($row->code_membre)
			      ->setCode_membre_morale($row->code_membre_morale)
                  ->setCode_membre_dist($row->code_membre_dist)
                  ->setCode_compte($row->code_compte)
                  ->setCode_produit($row->code_produit)
                  ->setMont_consommation($row->mont_consommation)
                  ->setDate_consommation($row->date_consommation)
                  ->setHeure_consommation($row->heure_consommation)
				  ->setBon_id($row->bon_id)
				  ->setType_produit($row->type_produit)
				  ->setCode_type_credit($row->code_type_credit);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_consommation) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function delete($id_consommation) {
        $this->getDbTable()->delete(array('id_consommation = ?' => $id_consommation));
    }

}
