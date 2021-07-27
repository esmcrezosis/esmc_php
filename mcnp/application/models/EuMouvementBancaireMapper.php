<?php
class Application_Model_EuMouvementBancaireMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuMouvementBancaire');
        }
        return $this->_dbTable;
    }

    public function find($id_mouvement_bancaire, Application_Model_EuMouvementBancaire $mb) {
        $result = $this->getDbTable()->find($id_mouvement_bancaire);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $mb->setId_mouvement_bancaire($row->id_mouvement_bancaire)
           ->setType_mouvement($row->type_mouvement)
           ->setMontant_mouvement($row->montant_mouvement)
           ->setDate_mouvement($row->date_mouvement)
           ->setDate_emission($row->date_emission)
		   ->setCode_banque($row->code_banque)
		   ->setType_compte($row->type_compte)
		   ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMouvementBancaire();
            $entry->setId_mouvement_bancaire($row->id_mouvement_bancaire)
                  ->setType_mouvement($row->type_mouvement)
                  ->setMontant_mouvement($row->montant_mouvement)
                  ->setDate_mouvement($row->date_mouvement)
                  ->setDate_emission($row->date_emission)
		          ->setCode_banque($row->code_banque)
				  ->setType_compte($row->type_compte);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findConuter() {
       $select = $this->getDbTable()->select();
       $select->from($this->getDbTable(), array('COUNT(id_mouvement_bancaire) as count'));
       $result = $this->getDbTable()->fetchAll($select);
       $row = $result->current();
       return $row['count'];
    }

    public function save(Application_Model_EuMouvementBancaire $mb) {
        $data = array(
          'id_mouvement_bancaire' => $mb->getId_mouvement_bancaire(),
          'type_mouvement' => $mb->getType_mouvement(),
          'montant_mouvement' => $mb->getMontant_mouvement(),
          'date_mouvement' => $mb->getDate_mouvement(),
          'date_emission' => $mb->getDate_emission(),
		  'code_banque' => $mb->getCode_banque(),
		  'type_compte' => $mb->getType_compte()
		  
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuMouvementBancaire $mb) {
        $data = array(
          'id_mouvement_bancaire' => $mb->getId_mouvement_bancaire(),
          'type_mouvement' => $mb->getType_mouvement(),
          'montant_mouvement' => $mb->getMontant_mouvement(),
          'date_mouvement' => $mb->getDate_mouvement(),
          'date_emission' => $mb->getDate_emission(),
		  'code_banque' => $mb->getCode_banque(),
		  'type_compte' => $mb->getType_compte()
        );
        $this->getDbTable()->update($data, array('id_mouvement_bancaire = ?' => $mb->getId_mouvement_bancaire()));
    }

	
    public function delete($id_mouvement_bancaire) {
        $this->getDbTable()->delete(array('id_mouvement_bancaire = ?' => $id_mouvement_bancaire));
    }

}
