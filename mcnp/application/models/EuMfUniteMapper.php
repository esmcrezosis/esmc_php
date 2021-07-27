<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuMprgMapper
 *
 * @author user
 */
class Application_Model_EuMfUniteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuMfUnite');
        }
        return $this->_dbTable;
    }

    public function find($id_mf,$code_unite,Application_Model_EuMfUnite $mfu) {
        $result = $this->getDbTable()->find($id_mf,$code_unite);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $mfu->setId_mf($row->id_mf)
            ->setCode_unite($row->code_unite)
            ->setDate_mf_unite($row->date_mf_unite)
        ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMf();
            $entry->setId_mf($row->id_mf)
                  ->setCode_unite($row->code_unite)
                  ->setDate_mf_unite($row->date_mf_unite);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuMfUnite $mfu) {
        $data = array(
          'id_mf' => $mfu->getId_mf(),
          'code_unite' => $mfu->getCode_unite(),
          'date_mf_unite' => $mfu->getDate_mf_unite()
        );

        $this->getDbTable()->insert($data);
    }
	
	
    public function update(Application_Model_EuMfUnite $mfu) {
        $data = array(
          'id_mf' => $mfu->getId_mf(),
          'code_unite' => $mfu->getCode_unite(),
          'date_mf_unite' => $mfu->getDate_mf_unite()
        );
        $this->getDbTable()->update($data, array('id_mf = ?'=>$mfu->getId_mf(),'code_unite = ?' => $mfu->getCode_unite()));
    }

	
    public function delete($id_mf,$code_unite) {
           $this->getDbTable()->delete(array('id_mf = ?' => $id_mf,'code_unite = ?' => $code_unite));
    }

}

?>
