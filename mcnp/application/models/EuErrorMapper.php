<?php

class Application_Model_EuErrorMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuError');
        }
        return $this->_dbTable;
    }
	
	

    public function save(Application_Model_EuError $error) {
        $data = array(
          //'id_error' => $error->getId_error(),
          'errors' => $error->getErrors(),
          'type' => $error->getType(),
          'exception' => $error->getException(),
          'message' => $error->getMessage(),
          'traiter' => $error->getTraiter(),
		      'request' => $error->getRequest()
        );

        $this->getDbTable()->insert($data);
    }
	
	
	public function findConuter() {
      $select = $this->getDbTable()->select();
      $select->from($this->getDbTable(), array('MAX(id_error) as count'));
      $result = $this->getDbTable()->fetchAll($select);
      $row = $result->current();
      return $row['count'];
    }
	
	

    public function update(Application_Model_EuError $error) {
        $data = array(
          'errors' => $error->getErrors(),
          'type' => $error->getType(),
          'exception' => $error->getException(),
          'message' => $error->getMessage(),
          'traiter' => $error->getTraiter(),
		      'request' => $error->getRequest()
        );

        $this->getDbTable()->update($data, array('id_error = ?' => $error->getId_error()));
    }

    public function find($id_error, Application_Model_EuError $error) {
        $result = $this->getDbTable()->find($id_error);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $error->setId_error($row->id_error)
                   ->setErrors($row->errors)
                   ->setType($row->type)
                   ->setException($row->exception)
                   ->setMessage($row->message)
                   ->setTraiter($row->traiter)
				           ->setRequest($row->request)
				   ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuError();
            $entry->setId_error($row->id_error)
                  ->setErrors($row->errors)
                  ->setType($row->type)
                  ->setException($row->exception)
                  ->setMessage($row->message)
                  ->setTraiter($row->traiter)
				          ->setRequest($row->request);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_error) {
        $this->getDbTable()->delete(array('id_error = ?' => $id_error));
    }


    public function fetchAllByTraiter($traiter) {
        $select = $this->getDbTable()->select();
        $select->where("traiter = ? ", $traiter);
        $select->order(array("id_error DESC"));
        //$select->limit($limit);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuError();
            $entry->setId_error($row->id_error)
                  ->setErrors($row->errors)
                  ->setType($row->type)
                  ->setException($row->exception)
                  ->setMessage($row->message)
                  ->setTraiter($row->traiter)
                  ->setRequest($row->request);
            $entries[] = $entry;
        }
        return $entries;
    }

}

