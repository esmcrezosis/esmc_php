<?php

class Application_Model_EuCategorieVideoMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCategorieVideo');
        }
        return $this->_dbTable;
    }

    public function find($id_categorie_video, Application_Model_EuCategorieVideo $video) {
        $result = $this->getDbTable()->find($id_categorie_video);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $video->setId_categorie_video($row->id_categorie_video)
                ->setLibelle_categorie_video($row->libelle_categorie_video);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCategorieVideo();
            $entry->setId_categorie_video($row->id_categorie_video)
                    ->setLibelle_categorie_video($row->libelle_categorie_video);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuCategorieVideo $video) {
        $data = array(
            'id_categorie_video' => $video->getId_categorie_video(),
            'libelle_categorie_video' => $video->getLibelle_categorie_video()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCategorieVideo $video) {
        $data = array(
            'id_categorie_video' => $video->getId_categorie_video(),
            'libelle_categorie_video' => $video->getLibelle_categorie_video()
        );
        $this->getDbTable()->update($data, array('id_categorie_video = ?' => $video->getId_categorie_video()));
    }

    public function delete($id_categorie_video) {
        $this->getDbTable()->delete(array('id_categorie_video = ?' => $id_categorie_video));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_categorie_video) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

