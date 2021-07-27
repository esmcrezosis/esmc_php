<?php
 
class Application_Model_EuZppeMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuZppe');
        }
        return $this->_dbTable;
    }

    public function find($zppe_id, Application_Model_EuZppe $zppe) {
        $result = $this->getDbTable()->find($zppe_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $zppe->setZppe_id($row->zppe_id)
                ->setZppe_libelle($row->zppe_libelle)
                ->setZppe_description($row->zppe_description)
                ->setZppe_resume($row->zppe_resume)
                ->setZppe_vignette($row->zppe_vignette)
                ->setZppe_login($row->zppe_login)
                ->setZppe_password($row->zppe_password)
                ->setZppe_date_genere($row->zppe_date_genere)
                ->setZppe_portable($row->zppe_portable)
                ->setZppe_email($row->zppe_email)
                ->setZppe_code_membre($row->zppe_code_membre)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		//$select->order("zppe_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuZppe();
            $entry->setZppe_id($row->zppe_id)
	                ->setZppe_libelle($row->zppe_libelle)
                    ->setZppe_description($row->zppe_description)
                    ->setZppe_resume($row->zppe_resume)
					->setZppe_vignette($row->zppe_vignette)
					->setZppe_login($row->zppe_login)
					->setZppe_password($row->zppe_password)
                ->setZppe_date_genere($row->zppe_date_genere)
                ->setZppe_portable($row->zppe_portable)
                ->setZppe_email($row->zppe_email)
                ->setZppe_code_membre($row->zppe_code_membre)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(zppe_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuZppe $zppe) {
        $data = array(
            'zppe_id' => $zppe->getZppe_id(),
            'zppe_libelle' => $zppe->getZppe_libelle(),
            'zppe_description' => $zppe->getZppe_description(),
            'zppe_resume' => $zppe->getZppe_resume(),
            'zppe_vignette' => $zppe->getZppe_vignette(),
            'zppe_login' => $zppe->getZppe_login(),
            'zppe_password' => $zppe->getZppe_password(),
            'zppe_date_genere' => $zppe->getZppe_date_genere(),
            'zppe_portable' => $zppe->getZppe_portable(),
            'zppe_email' => $zppe->getZppe_email(),
            'zppe_code_membre' => $zppe->getZppe_code_membre(),
            'publier' => $zppe->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuZppe $zppe) {
        $data = array(
            'zppe_id' => $zppe->getZppe_id(),
            'zppe_libelle' => $zppe->getZppe_libelle(),
            'zppe_description' => $zppe->getZppe_description(),
            'zppe_resume' => $zppe->getZppe_resume(),
            'zppe_vignette' => $zppe->getZppe_vignette(),
            'zppe_login' => $zppe->getZppe_login(),
            'zppe_password' => $zppe->getZppe_password(),
            'zppe_date_genere' => $zppe->getZppe_date_genere(),
            'zppe_portable' => $zppe->getZppe_portable(),
            'zppe_email' => $zppe->getZppe_email(),
            'zppe_code_membre' => $zppe->getZppe_code_membre(),
            'publier' => $zppe->getPublier()
        );
        $this->getDbTable()->update($data, array('zppe_id = ?' => $zppe->getZppe_id()));
    }

    public function delete($zppe_id) {
        $this->getDbTable()->delete(array('zppe_id = ?' => $zppe_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order("zppe_libelle ASC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuZppe();
            $entry->setZppe_id($row->zppe_id)
	                ->setZppe_libelle($row->zppe_libelle)
                    ->setZppe_description($row->zppe_description)
                    ->setZppe_resume($row->zppe_resume)
					->setZppe_vignette($row->zppe_vignette)
					->setZppe_login($row->zppe_login)
					->setZppe_password($row->zppe_password)
                ->setZppe_date_genere($row->zppe_date_genere)
                ->setZppe_portable($row->zppe_portable)
                ->setZppe_email($row->zppe_email)
                ->setZppe_code_membre($row->zppe_code_membre)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


	
	
}


?>
