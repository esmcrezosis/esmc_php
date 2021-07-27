<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Application_Model_EuDetailKrrMapper
 *
 * @author user
 */
 
class Application_Model_EuDetailKrrMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailKrr');
        }
        return $this->_dbTable;
    }
	
	
	public function find($id_detail_krr, Application_Model_EuDetailKrr $dkrr) {
        $result = $this->getDbTable()->find($id_detail_krr);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $dkrr->setId_detail_krr($row->id_detail_krr)
		     ->setId_krr($row->id_krr)
             ->setId_credit($row->id_credit)
             ->setSource_credit($row->source_credit)
             ->setMont_credit($row->mont_credit)
             ->setAnnuler($row->annuler);
    }
	
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailKrr();
            $entry->setId_detail_krr($row->id_detail_krr)
		          ->setId_krr($row->id_krr)
                  ->setId_credit($row->id_credit)
                  ->setSource_credit($row->source_credit)
                  ->setMont_credit($row->mont_credit)
                  ->setAnnuler($row->annuler);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	public function save(Application_Model_EuDetailKrr $dkrr) {
        $data = array(
		  'id_detail_krr' => $dkrr->getId_detail_krr(),
          'id_krr' => $dkrr->getId_krr(),
          'id_credit' => $dkrr->getId_credit(),
          'source_credit' => $dkrr->getSource_credit(),
          'mont_credit' => $dkrr->getMont_credit(),
          'annuler' => $dkrr->getAnnuler()
        );

        $this->getDbTable()->insert($data);
    }

	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_detail_krr) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
    public function update(Application_Model_EuDetailKrr $dkrr) {
        $data = array(
		  'id_detail_krr' => $dkrr->getId_detail_krr(),
          'id_krr' => $dkrr->getId_krr(),
          'id_credit' => $dkrr->getId_credit(),
          'source_credit' => $dkrr->getSource_credit(),
          'mont_credit' => $dkrr->getMont_credit(),
          'annuler' => $dkrr->getAnnuler()
        );
        $this->getDbTable()->update($data, array('id_detail_krr = ?' => $dkrr->getId_detail_krr()));
    }

    public function delete($id_credit) {
        $this->getDbTable()->delete(array('id_detail_krr = ?' => $id_detail_krr));
    }
	
	
	
	
	
	
	
	
	
	
	
	























}