<?php

class Application_Model_EuCommuniqueMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCommunique');
        }
        return $this->_dbTable;
    }
	
	

    public function save(Application_Model_EuCommunique $communique) {
        $data = array(
          'id_communique' => $communique->getId_communique(),
          'titre' => $communique->getTitre(),
          'resume' => $communique->getResume(),
          'description' => $communique->getDescription(),
          'vignette' => $communique->getVignette(),
          'statut' => $communique->getStatut(),
          'liendirect' => $communique->getLiendirect(),
		  'date_creation' => $communique->getDate_creation()
        );

        $this->getDbTable()->insert($data);
    }
	
	
	public function findConuter() {
      $select = $this->getDbTable()->select();
      $select->from($this->getDbTable(), array('MAX(id_communique) as count'));
      $result = $this->getDbTable()->fetchAll($select);
      $row = $result->current();
      return $row['count'];
    }
	
	

    public function update(Application_Model_EuCommunique $communique) {
        $data = array(
          'id_communique' => $communique->getId_communique(),
          'titre' => $communique->getTitre(),
          'resume' => $communique->getResume(),
          'description' => $communique->getDescription(),
          'vignette' => $communique->getVignette(),
          'statut' => $communique->getStatut(),
          'liendirect' => $communique->getLiendirect(),
		  'date_creation' => $communique->getDate_creation()
        );

        $this->getDbTable()->update($data, array('id_communique = ?' => $communique->getId_communique()));
    }

    public function find($id_communique, Application_Model_EuCommunique $communique) {
        $result = $this->getDbTable()->find($id_communique);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $communique->setId_communique($row->id_communique)
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
            $entry = new Application_Model_EuCommunique();
            $entry->setId_communique($row->id_communique)
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

    public function delete($id_communique) {
        $this->getDbTable()->delete(array('id_communique = ?' => $id_communique));
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
            $entry = new Application_Model_EuCommunique();
            $entry->setId_communique($row->id_communique)
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



  
    
    public function fetchAllByHome() {//$limit
        $select = $this->getDbTable()->select();
        $select->where("statut = ? ", 1);
        $select->order(array("date_creation DESC"));
        //$select->limit($limit);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCommunique();
            $entry->setId_communique($row->id_communique)
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

