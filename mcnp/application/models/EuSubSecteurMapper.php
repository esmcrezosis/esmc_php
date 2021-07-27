<?php

class Application_Model_EuSubSecteurMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuSubSecteur');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuSubSecteur $secteur) {
        $data = array(
          'id_sub_secteur' => $secteur->getId_sub_secteur(),
          'nom_sub_secteur' => $secteur->getNom_sub_secteur(),
          'code_secteur' => $secteur->getCode_secteur(),
          'code_agence' => $secteur->getCode_agence()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuSubSecteur $secteur) {
        $data = array(
          'id_sub_secteur' => $secteur->getId_sub_secteur(),
          'nom_sub_secteur' => $secteur->getNom_sub_secteur(),
          'code_secteur' => $secteur->getCode_secteur(),
          'code_agence' => $secteur->getCode_agence()
        );

        $this->getDbTable()->update($data, array('id_sub_secteur = ?' => $secteur->getId_sub_secteur()));
    }

    public function find($id_sub_secteur, Application_Model_EuSubSecteur $secteur) {
        $result = $this->getDbTable()->find($id_sub_secteur);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $secteur->setId_sub_secteur($row->id_sub_secteur)
                ->setNom_sub_secteur($row->nom_sub_secteur)
                ->setCode_secteur($row->code_secteur)
                ->setCode_agence($row->code_agence);
    }

    
    public function findConuter() {
           $select = $this->getDbTable()->select();
           $select->from($this->getDbTable(), array('MAX(id_sub_secteur) as count'));
           $result = $this->getDbTable()->fetchAll($select);
           $row = $result->current();
           return $row['count'];
    }
    

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSubSecteur();
            $entry->setId_sub_secteur($row->id_sub_secteur)
                  ->setNom_sub_secteur($row->nom_sub_secteur)
                  ->setCode_secteur($row->code_secteur)
                  ->setCode_agence($row->code_agence);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_secteur) {
           $this->getDbTable()->delete(array('id_sub_secteur = ?' => $id_sub_secteur));
    }

}

