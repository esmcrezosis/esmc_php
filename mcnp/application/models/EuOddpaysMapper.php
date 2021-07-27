<?php

class Application_Model_EuOddpaysMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuOddpays');
        }
        return $this->_dbTable;
    }
  
  

    public function save(Application_Model_EuOddpays $oddpays) {
        $data = array(
          'id_odd_pays' => $oddpays->getId_odd_pays(),
          'titre' => $oddpays->getTitre(),
          'resume' => $oddpays->getResume(),
          'description' => $oddpays->getDescription(),
          'vignette' => $oddpays->getVignette(),
          'statut' => $oddpays->getStatut(),
          'liendirect' => $oddpays->getLiendirect(),
          'id_pays' => $oddpays->getId_pays(),
      'date_creation' => $oddpays->getDate_creation()
        );

        $this->getDbTable()->insert($data);
    }
  
  
  public function findConuter() {
      $select = $this->getDbTable()->select();
      $select->from($this->getDbTable(), array('MAX(id_odd_pays) as count'));
      $result = $this->getDbTable()->fetchAll($select);
      $row = $result->current();
      return $row['count'];
    }
  
  

    public function update(Application_Model_EuOddpays $oddpays) {
        $data = array(
          'id_odd_pays' => $oddpays->getId_odd_pays(),
          'titre' => $oddpays->getTitre(),
          'resume' => $oddpays->getResume(),
          'description' => $oddpays->getDescription(),
          'vignette' => $oddpays->getVignette(),
          'statut' => $oddpays->getStatut(),
          'liendirect' => $oddpays->getLiendirect(),
          'id_pays' => $oddpays->getId_pays(),
      'date_creation' => $oddpays->getDate_creation()
        );

        $this->getDbTable()->update($data, array('id_odd_pays = ?' => $oddpays->getId_odd_pays()));
    }

    public function find($id_odd_pays, Application_Model_EuOddpays $oddpays) {
        $result = $this->getDbTable()->find($id_odd_pays);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $oddpays->setId_odd_pays($row->id_odd_pays)
                   ->setTitre($row->titre)
                   ->setResume($row->resume)
                   ->setDescription($row->description)
                   ->setVignette($row->vignette)
                   ->setStatut($row->statut)
                   ->setLiendirect($row->liendirect)
           ->setDate_creation($row->date_creation)
                   ->setId_pays($row->id_pays)
           ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOddpays();
            $entry->setId_odd_pays($row->id_odd_pays)
                  ->setTitre($row->titre)
                  ->setResume($row->resume)
                  ->setDescription($row->description)
                  ->setVignette($row->vignette)
                  ->setStatut($row->statut)
                  ->setLiendirect($row->liendirect)
                   ->setId_pays($row->id_pays)
          ->setDate_creation($row->date_creation);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_odd_pays) {
        $this->getDbTable()->delete(array('id_odd_pays = ?' => $id_odd_pays));
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
            $entry = new Application_Model_EuOddpays();
            $entry->setId_odd_pays($row->id_odd_pays)
                  ->setTitre($row->titre)
                  ->setResume($row->resume)
                  ->setDescription($row->description)
                  ->setVignette($row->vignette)
                  ->setStatut($row->statut)
                  ->setLiendirect($row->liendirect)
                   ->setId_pays($row->id_pays)
          ->setDate_creation($row->date_creation);
      $entries = $entry;
        return $entries;
    }



  
    
    public function fetchAllByHome($limit) {
        $select = $this->getDbTable()->select();
        $select->where("statut = ? ", 1);
        $select->order(array("id_odd_pays ASC"));
        //$select->order("rand()");
        $select->limit($limit);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOddpays();
            $entry->setId_odd_pays($row->id_odd_pays)
                  ->setTitre($row->titre)
                  ->setResume($row->resume)
                  ->setDescription($row->description)
                  ->setVignette($row->vignette)
                  ->setStatut($row->statut)
                  ->setLiendirect($row->liendirect)
                   ->setId_pays($row->id_pays)
          ->setDate_creation($row->date_creation);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByAll() {
        $select = $this->getDbTable()->select();
        $select->where("statut = ? ", 1);
        $select->order(array("id_odd_pays ASC"));
        //$select->limit($limit);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOddpays();
            $entry->setId_odd_pays($row->id_odd_pays)
                  ->setTitre($row->titre)
                  ->setResume($row->resume)
                  ->setDescription($row->description)
                  ->setVignette($row->vignette)
                  ->setStatut($row->statut)
                  ->setLiendirect($row->liendirect)
                   ->setId_pays($row->id_pays)
          ->setDate_creation($row->date_creation);
            $entries[] = $entry;
        }
        return $entries;
    }


}

