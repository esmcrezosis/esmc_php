<?php

class Application_Model_EuPartenaireMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPartenaire');
        }
        return $this->_dbTable;
    }
	
	

    public function save(Application_Model_EuPartenaire $partenaire) {
        $data = array(
          'id_partenaire' => $partenaire->getId_partenaire(),
          'titre' => $partenaire->getTitre(),
          'resume' => $partenaire->getResume(),
          'description' => $partenaire->getDescription(),
          'vignette' => $partenaire->getVignette(),
          'statut' => $partenaire->getStatut(),
          'liendirect' => $partenaire->getLiendirect(),
		  'date_creation' => $partenaire->getDate_creation()
        );

        $this->getDbTable()->insert($data);
    }
	
	
	public function findConuter() {
      $select = $this->getDbTable()->select();
      $select->from($this->getDbTable(), array('MAX(id_partenaire) as count'));
      $result = $this->getDbTable()->fetchAll($select);
      $row = $result->current();
      return $row['count'];
    }
	
	

    public function update(Application_Model_EuPartenaire $partenaire) {
        $data = array(
          'id_partenaire' => $partenaire->getId_partenaire(),
          'titre' => $partenaire->getTitre(),
          'resume' => $partenaire->getResume(),
          'description' => $partenaire->getDescription(),
          'vignette' => $partenaire->getVignette(),
          'statut' => $partenaire->getStatut(),
          'liendirect' => $partenaire->getLiendirect(),
		  'date_creation' => $partenaire->getDate_creation()
        );

        $this->getDbTable()->update($data, array('id_partenaire = ?' => $partenaire->getId_partenaire()));
    }

    public function find($id_partenaire, Application_Model_EuPartenaire $partenaire) {
        $result = $this->getDbTable()->find($id_partenaire);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $partenaire->setId_partenaire($row->id_partenaire)
                   ->setTitre($row->titre)
                   ->setResume($row->resume)
                   ->setDescription($row->description)
                   ->setVignette($row->vignette)
                   ->setStatut($row->statut)
                   ->setLiendirect($row->liendirect)
				   ->setDate_creation($row->date_creation)
				   ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartenaire();
            $entry->setId_partenaire($row->id_partenaire)
                  ->setTitre($row->titre)
                  ->setResume($row->resume)
                  ->setDescription($row->description)
                  ->setVignette($row->vignette)
                  ->setStatut($row->statut)
                  ->setLiendirect($row->liendirect)
				  ->setDate_creation($row->date_creation);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_partenaire) {
        $this->getDbTable()->delete(array('id_partenaire = ?' => $id_partenaire));
    }


    public function fetchAllByOne()
    {
        $select = $this->getDbTable()->select();
    $select->where("statut = ? ", 1);
    $select->order(array("RAND()"));
    $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuPartenaire();
            $entry->setId_partenaire($row->id_partenaire)
                  ->setTitre($row->titre)
                  ->setResume($row->resume)
                  ->setDescription($row->description)
                  ->setVignette($row->vignette)
                  ->setStatut($row->statut)
                  ->setLiendirect($row->liendirect)
          ->setDate_creation($row->date_creation);
      $entries = $entry;
        return $entries;
    }



  
    
    public function fetchAllByHome($limit) {
        $select = $this->getDbTable()->select();
        $select->where("statut = ? ", 1);
        $select->order("rand()");
        $select->limit($limit);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartenaire();
            $entry->setId_partenaire($row->id_partenaire)
                  ->setTitre($row->titre)
                  ->setResume($row->resume)
                  ->setDescription($row->description)
                  ->setVignette($row->vignette)
                  ->setStatut($row->statut)
                  ->setLiendirect($row->liendirect)
          ->setDate_creation($row->date_creation);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByAll() {
        $select = $this->getDbTable()->select();
        $select->where("statut = ? ", 1);
        //$select->order("rand()");
        //$select->limit($limit);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartenaire();
            $entry->setId_partenaire($row->id_partenaire)
                  ->setTitre($row->titre)
                  ->setResume($row->resume)
                  ->setDescription($row->description)
                  ->setVignette($row->vignette)
                  ->setStatut($row->statut)
                  ->setLiendirect($row->liendirect)
          ->setDate_creation($row->date_creation);
            $entries[] = $entry;
        }
        return $entries;
    }


}

