<?php
 
class Application_Model_EuVideoMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuVideo');
        }
        return $this->_dbTable;
    }

    public function find($video_id, Application_Model_EuVideo $video) {
        $result = $this->getDbTable()->find($video_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $video->setVideo_id($row->video_id)
                ->setVideo_libelle($row->video_libelle)
                ->setVideo_description($row->video_description)
                ->setVideo_categorie($row->video_categorie)
                ->setVideo_type($row->video_type)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuVideo();
            $entry->setVideo_id($row->video_id)
	                ->setVideo_libelle($row->video_libelle)
                    ->setVideo_description($row->video_description)
                    ->setVideo_categorie($row->video_categorie)
	                ->setVideo_type($row->video_type)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(video_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuVideo $video) {
        $data = array(
            'video_id' => $video->getVideo_id(),
            'video_libelle' => $video->getVideo_libelle(),
            'video_description' => $video->getVideo_description(),
            'video_categorie' => $video->getVideo_categorie(),
            'video_type' => $video->getVideo_type(),
            'publier' => $video->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuVideo $video) {
        $data = array(
            'video_id' => $video->getVideo_id(),
            'video_libelle' => $video->getVideo_libelle(),
            'video_description' => $video->getVideo_description(),
            'video_categorie' => $video->getVideo_categorie(),
            'video_type' => $video->getVideo_type(),
            'publier' => $video->getPublier()
        );
        $this->getDbTable()->update($data, array('video_id = ?' => $video->getVideo_id()));
    }

    public function delete($video_id) {
        $this->getDbTable()->delete(array('video_id = ?' => $video_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuVideo();
            $entry->setVideo_id($row->video_id)
	                ->setVideo_libelle($row->video_libelle)
                    ->setVideo_description($row->video_description)
                    ->setVideo_categorie($row->video_categorie)
	                ->setVideo_type($row->video_type)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll3($type) {
        $select = $this->getDbTable()->select();
		$select->where("video_type = ? ", $type);
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuVideo();
            $entry->setVideo_id($row->video_id)
	                ->setVideo_libelle($row->video_libelle)
                    ->setVideo_description($row->video_description)
                    ->setVideo_categorie($row->video_categorie)
	                ->setVideo_type($row->video_type)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
}


?>
