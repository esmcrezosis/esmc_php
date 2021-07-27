<?php

class Application_Model_EuSecteurMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuSecteur');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuSecteur $secteur) {
        $data = array(
            'code_secteur' => $secteur->getCode_secteur(),
            'nom_secteur' => $secteur->getNom_secteur(),
            'date_creation' => $secteur->getDate_creation(),
            'id_pays' => $secteur->getId_pays(),
            'id_region' => $secteur->getId_region(),
			'id_prefecture' => $secteur->getId_prefecture(),
			'code_membre' => $secteur->getCode_membre()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuSecteur $secteur) {
        $data = array(
            'code_secteur' => $secteur->getCode_secteur(),
            'nom_secteur' => $secteur->getNom_secteur(),
            'date_creation' => $secteur->getDate_creation(),
            'id_pays' => $secteur->getId_pays(),
            'id_region' => $secteur->getId_region(),
			'id_prefecture' => $secteur->getId_prefecture(),
			'code_membre' => $secteur->getCode_membre()
        );

        $this->getDbTable()->update($data, array('code_secteur = ?' => $secteur->getCode_secteur()));
    }

    public function find($code_secteur, Application_Model_EuSecteur $secteur) {
        $result = $this->getDbTable()->find($code_secteur);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $secteur->setCode_secteur($row->code_secteur)
                ->setNom_secteur($row->nom_secteur)
                ->setDate_creation($row->date_creation)
                ->setId_region($row->id_region)
				->setId_prefecture($row->id_prefecture)
                ->setId_pays($row->id_pays)
				->setCode_membre($row->code_membre)
				;
    }

    public function findByZone($code_zone) {
        $select = $this->getDbTable()->select();
        $select->where('code_zone = ?', $code_zone);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuSecteur();
            $entry->setCode_secteur($row->code_secteur)
                    ->setNom_secteur($row->nom_secteur)
                    ->setDate_creation($row->date_creation)
                    ->setId_region($row->id_region)
                    ->setId_pays($row->id_pays)
					->setId_prefecture($row->id_prefecture)
					->setCode_membre($row->code_membre);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getLastCodeSectByZone($id_pays, $id_region) {
        $select = $this->getDbTable()->select();
        $select->setIntegrityCheck(false);
        if ($id_region != '') {
           $select->from($this->getDbTable(), array('code_secteur as code'))
                  ->join('eu_region', 'eu_region.id_region = eu_secteur.id_region')
                  ->join('eu_pays', 'eu_pays.id_pays = eu_region.id_pays')
                  ->where('eu_secteur.id_region = ?',$id_region);
        } elseif ($id_pays != '') {
           $select->from($this->getDbTable(), array('MAX(code_secteur) as code'))
                   ->join('eu_pays', 'eu_pays.id_pays = eu_secteur.id_pays')
                   ->where('eu_secteur.id_pays = ?', $id_pays);
        }
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            return $row['code'];
        }
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSecteur();
            $entry->setCode_secteur($row->code_secteur)
                    ->setNom_secteur($row->nom_secteur)
                    ->setDate_creation($row->date_creation)
                    ->setId_region($row->id_region)
					->setId_prefecture($row->id_prefecture)
                    ->setId_pays($row->id_pays)
					->setCode_membre($row->code_membre);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_secteur) {
        $this->getDbTable()->delete(array('code_secteur = ?' => $code_secteur));
    }

}

