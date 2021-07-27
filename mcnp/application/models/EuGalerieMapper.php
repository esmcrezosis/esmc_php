<?php
 
class Application_Model_EuGalerieMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuGalerie');
        }
        return $this->_dbTable;
    }

    public function find($id_galerie, Application_Model_EuGalerie $galerie) {
        $result = $this->getDbTable()->find($id_galerie);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $galerie->setId_galerie($row->id_galerie)
                ->setTitre($row->titre)
                ->setResume($row->resume)
                ->setStatut($row->statut)
				->setDate_galerie($row->date_galerie);
        return true;
    }
	
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuGalerie();
            $entry->setId_galerie($row->id_galerie)
                  ->setTitre($row->titre)
                  ->setResume($row->resume)
                  ->setStatut($row->statut)
				  ->setDate_galerie($row->date_galerie);
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_galerie) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	

    public function save(Application_Model_EuGalerie $galerie) {
	    
        $data = array(
          'id_galerie' => $galerie->getId_galerie(),
          'titre' => $galerie->getTitre(),
          'resume' => $galerie->getResume(),
          'statut' => $galerie->getStatut(),
		  'date_galerie' => $galerie->getDate_galerie()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuGalerie $galerie) {
        $data = array(
          'id_galerie' => $galerie->getId_galerie(),
          'titre' => $galerie->getTitre(),
          'resume' => $galerie->getResume(),
          'statut' => $galerie->getStatut(),
		  'date_galerie' => $galerie->getDate_galerie()
        );
        $this->getDbTable()->update($data, array('id_galerie = ?' => $galerie->getId_galerie()));
    }

    public function delete($id_galerie) {
        $this->getDbTable()->delete(array('id_galerie = ?' => $id_galerie));
    }



}


?>
