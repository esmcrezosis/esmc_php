<?php
 
class Application_Model_EuPhotoGalerieMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPhotoGalerie');
        }
        return $this->_dbTable;
    }

    public function find($id_photo_galerie, Application_Model_EuPhotoGalerie $photo) {
        $result = $this->getDbTable()->find($id_photo_galerie);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $photo->setId_photo_galerie($row->id_photo_galerie)
              ->setId_galerie($row->id_galerie)
              ->setLibelle($row->libelle)
			  ->setPhoto($row->photo)
              ->setStatut($row->statut)
			  ->setDate_photo($row->date_photo);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPhotoGalerie();
            $entry->setId_photo_galerie($row->id_photo_galerie)
                  ->setId_galerie($row->id_galerie)
                  ->setLibelle($row->libelle)
			      ->setPhoto($row->photo)
                  ->setStatut($row->statut)
				  ->setDate_photo($row->date_photo);
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_photo_galerie) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	

    public function save(Application_Model_EuPhotoGalerie $photo) {
        $data = array(
          'id_photo_galerie' => $photo->getId_photo_galerie(),
          'id_galerie' => $photo->getId_galerie(),
          'libelle' => $photo->getLibelle(),
          'photo' => $photo->getPhoto(),
          'statut' => $photo->getStatut(),
		  'date_photo' => $photo->getDate_photo()
        );
        $this->getDbTable()->insert($data);
    }

	
	
    public function update(Application_Model_EuPhotoGalerie $photo) {
      $data = array(
          'id_photo_galerie' => $photo->getId_photo_galerie(),
          'id_galerie' => $photo->getId_galerie(),
          'libelle' => $photo->getLibelle(),
          'photo' => $photo->getPhoto(),
          'statut' => $photo->getStatut(),
		  'date_photo' => $photo->getDate_photo()
      );
      $this->getDbTable()->update($data, array('id_photo_galerie = ?' => $photo->getId_photo_galerie()));
    }
	
	

    public function delete($id_photo_galerie) {
      $this->getDbTable()->delete(array('id_photo_galerie = ?' => $id_photo_galerie));
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
            $entry = new Application_Model_EuPhotoGalerie();
            $entry->setId_photo_galerie($row->id_photo_galerie)
                  ->setId_galerie($row->id_galerie)
                  ->setLibelle($row->libelle)
            ->setPhoto($row->photo)
                  ->setStatut($row->statut)
          ->setDate_photo($row->date_photo);
      $entries = $entry;
        return $entries;
    }



}


?>
